<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceDownloadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_request_invoice_pdf_and_get_attachment()
    {
        // create a user to act as
        $user = User::factory()->create();
        $this->actingAs($user);

        // create minimal client and service records
        $client = Client::create([
            'name'    => 'Test Client',
            'email'   => 'client@example.com',
            'contact' => '0771234567',
        ]);

        $service = Service::create([
            'name'  => 'Test Service',
            'price' => 100.00,
        ]);

        $response = $this->post(route('invoice.download'), [
            'client_id'  => $client->id,
            'services'   => [$service->id],
            'cashGiven'  => 150,
        ]);

        // should return a PDF download
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $disposition = $response->headers->get('content-disposition');
        $this->assertStringContainsString('attachment', $disposition);
        $this->assertStringContainsString('invoice_', $disposition);
    }
}
