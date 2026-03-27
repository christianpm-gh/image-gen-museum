<?php

namespace App\Http\Controllers;

use App\Models\Exhibition;
use App\Models\MuseumRoom;
use Illuminate\Contracts\View\View;

class MuseumController extends Controller
{
    public function index(): View
    {
        return view('museum.index', [
            'rooms' => MuseumRoom::query()
                ->with(['exhibitions.catalogImages'])
                ->orderBy('sort_order')
                ->get(),
            'tickets' => request()->user()->tickets()->with('order')->take(3)->get(),
            'recentMemories' => request()->user()->memoryGenerations()->with('ticket')->take(3)->get(),
        ]);
    }

    public function showRoom(MuseumRoom $museumRoom): View
    {
        $museumRoom->load(['exhibitions.catalogImages']);

        return view('museum.room', [
            'room' => $museumRoom,
        ]);
    }

    public function showExhibition(Exhibition $exhibition): View
    {
        $exhibition->load(['museumRoom', 'catalogImages']);

        return view('museum.exhibition', [
            'exhibition' => $exhibition,
        ]);
    }
}
