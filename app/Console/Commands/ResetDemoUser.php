<?php

namespace App\Console\Commands;

use App\Models\MemoryGeneration;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketAccessToken;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetDemoUser extends Command
{
    protected $signature = 'museum:reset-demo-user {email=demo@example.com}';

    protected $description = 'Limpia el historial del usuario demo sin eliminar la cuenta.';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->components->warn("No se encontró un usuario demo con el correo {$email}.");

            return self::SUCCESS;
        }

        $ticketIds = Ticket::query()
            ->where('user_id', $user->id)
            ->pluck('id');

        $counts = [
            'sessions' => DB::table('sessions')->where('user_id', $user->id)->count(),
            'memories' => MemoryGeneration::query()->where('user_id', $user->id)->count(),
            'orders' => Order::query()->where('user_id', $user->id)->count(),
            'tickets' => $ticketIds->count(),
            'tokens' => TicketAccessToken::query()->whereIn('ticket_id', $ticketIds)->count(),
        ];

        DB::transaction(function () use ($user, $ticketIds): void {
            DB::table('sessions')->where('user_id', $user->id)->delete();
            MemoryGeneration::query()->where('user_id', $user->id)->delete();
            TicketAccessToken::query()->whereIn('ticket_id', $ticketIds)->delete();
            Ticket::query()->whereIn('id', $ticketIds)->delete();
            Order::query()->where('user_id', $user->id)->delete();
            $user->forceFill(['name' => 'MusIAum Demo'])->save();
        });

        $this->components->info("Usuario demo limpio: {$email}");
        $this->line("Órdenes eliminadas: {$counts['orders']}");
        $this->line("Tickets eliminados: {$counts['tickets']}");
        $this->line("Tokens eliminados: {$counts['tokens']}");
        $this->line("Recuerdos eliminados: {$counts['memories']}");
        $this->line("Sesiones eliminadas: {$counts['sessions']}");

        return self::SUCCESS;
    }
}
