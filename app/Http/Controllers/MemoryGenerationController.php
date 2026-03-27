<?php

namespace App\Http\Controllers;

use App\Enums\MemoryGenerationStatus;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreMemoryGenerationRequest;
use App\Jobs\ProcessMemoryGenerationJob;
use App\Models\CatalogImage;
use App\Models\MemoryGeneration;
use App\Models\Ticket;
use App\Services\TicketAccessValidator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MemoryGenerationController extends Controller
{
    public function index(): View
    {
        return view('memories.index', [
            'memories' => request()->user()->memoryGenerations()->with('ticket')->paginate(12),
        ]);
    }

    public function create(Ticket $ticket, TicketAccessValidator $validator): View
    {
        abort_unless($ticket->user_id === request()->user()->id, 403);

        $token = request()->query('token', '');
        $validator->validateOrFail(request()->user(), $ticket, (string) $token);

        return view('memories.create', [
            'ticket' => $ticket->load('order'),
            'catalogImages' => CatalogImage::query()
                ->with('exhibition.museumRoom')
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->groupBy(fn (CatalogImage $image) => $image->exhibition->title),
            'token' => (string) $token,
        ]);
    }

    public function store(
        StoreMemoryGenerationRequest $request,
        Ticket $ticket,
        TicketAccessValidator $validator
    ) {
        abort_unless($ticket->user_id === $request->user()->id, 403);

        $validator->validateOrFail($request->user(), $ticket, $request->string('token')->toString());

        $selectedIds = collect($request->input('catalog_image_ids', []))
            ->map(fn (mixed $id) => (int) $id)
            ->unique()
            ->values();

        $activeSelectedCount = CatalogImage::query()
            ->whereIn('id', $selectedIds)
            ->where('is_active', true)
            ->count();

        if ($activeSelectedCount !== $ticket->requiredCatalogImages()) {
            throw ValidationException::withMessages([
                'catalog_image_ids' => 'Solo puedes seleccionar imágenes activas del catálogo y respetar el límite de tu ticket.',
            ]);
        }

        $memoryGeneration = DB::transaction(function () use ($request, $ticket, $selectedIds) {
            $lockedTicket = Ticket::query()->with('accessToken')->lockForUpdate()->findOrFail($ticket->id);

            if ($lockedTicket->status !== TicketStatus::Issued) {
                abort(422, 'Este ticket ya inició o completó una generación.');
            }

            $lockedTicket->update([
                'status' => TicketStatus::Reserved,
                'reserved_at' => now(),
            ]);

            return MemoryGeneration::create([
                'user_id' => $request->user()->id,
                'ticket_id' => $lockedTicket->id,
                'status' => MemoryGenerationStatus::Queued,
                'emotion_text' => $request->string('emotion_text')->trim()->toString(),
                'selected_catalog_image_ids' => $selectedIds->all(),
                'queued_at' => now(),
            ]);
        });

        ProcessMemoryGenerationJob::dispatch($memoryGeneration->id);

        return redirect()
            ->route('memories.show', $memoryGeneration)
            ->with('status', 'Tu recuerdo visual ya está en cola de generación.');
    }

    public function show(MemoryGeneration $memoryGeneration): View
    {
        abort_unless($memoryGeneration->user_id === request()->user()->id, 403);

        $memoryGeneration->load('ticket');

        $selectedCatalogImages = CatalogImage::query()
            ->with('exhibition.museumRoom')
            ->whereIn('id', $memoryGeneration->selectedCatalogImageIds())
            ->get();

        return view('memories.show', [
            'memory' => $memoryGeneration,
            'selectedCatalogImages' => $selectedCatalogImages,
        ]);
    }
}
