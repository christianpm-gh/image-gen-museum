<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\TicketStatus;
use App\Enums\TicketType;
use App\Models\CatalogImage;
use App\Models\Exhibition;
use App\Models\MuseumRoom;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class MemoryAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_signed_memory_form_opens_with_valid_token(): void
    {
        [$user, $ticket, $plainToken] = $this->makeIssuedTicket();

        $url = URL::temporarySignedRoute('memories.create', now()->addHour(), [
            'ticket' => $ticket,
            'token' => $plainToken,
        ]);

        $this->actingAs($user)
            ->get($url)
            ->assertOk()
            ->assertSee('Crear recuerdo');
    }

    public function test_standard_ticket_rejects_two_reference_images(): void
    {
        [$user, $ticket, $plainToken, $catalogImages] = $this->makeIssuedTicket();

        $this->actingAs($user)
            ->from('/')
            ->post(route('memories.store', $ticket), [
                'token' => $plainToken,
                'emotion_text' => 'Sentí una mezcla intensa de calma, nostalgia y amplitud azul.',
                'catalog_image_ids' => $catalogImages->pluck('id')->all(),
            ])
            ->assertRedirect('/')
            ->assertSessionHasErrors('catalog_image_ids');
    }

    /**
     * @return array{0: User, 1: Ticket, 2: string, 3: \Illuminate\Support\Collection<int, CatalogImage>}
     */
    protected function makeIssuedTicket(): array
    {
        $user = User::factory()->create();
        $room = MuseumRoom::factory()->create();
        $exhibition = Exhibition::factory()->for($room)->create();
        $catalogImages = collect([
            CatalogImage::factory()->for($exhibition)->create(),
            CatalogImage::factory()->for($exhibition)->create(),
        ]);

        $order = Order::factory()->for($user)->create([
            'ticket_type' => TicketType::Standard,
            'status' => OrderStatus::Completed,
        ]);

        $ticket = Ticket::factory()->for($order)->for($user)->create([
            'ticket_type' => TicketType::Standard,
            'status' => TicketStatus::Issued,
        ]);

        $plainToken = 'TOKEN-VALIDO-1234';

        $ticket->accessToken()->create([
            'token_hash' => hash('sha256', $plainToken),
            'expires_at' => now()->addDay(),
        ]);

        return [$user, $ticket, $plainToken, $catalogImages];
    }
}
