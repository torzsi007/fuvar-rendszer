<?php

namespace Tests\Feature;

use App\Models\Fuvarozo;
use App\Models\Munka;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FuvarozoTest extends TestCase
{
    use RefreshDatabase;

    public function test_fuvarozo_can_update_status()
    {
        $fuvarozo = Fuvarozo::factory()->create(['role' => 'fuvarozo']);
        $munka = Munka::factory()->create([
            'fuvarozo_id' => $fuvarozo->id,
            'statusz' => 'kiosztva'
        ]);

        $this->actingAs($fuvarozo);

        $response = $this->patch("/fuvarozo/munkak/{$munka->id}/status", [
            'statusz' => 'folyamatban'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('munkas', [
            'id' => $munka->id,
            'statusz' => 'folyamatban'
        ]);
    }

    public function test_fuvarozo_cannot_update_other_munka()
    {
        $fuvarozo1 = Fuvarozo::factory()->create(['role' => 'fuvarozo']);
        $fuvarozo2 = Fuvarozo::factory()->create(['role' => 'fuvarozo']);

        $munka = Munka::factory()->create([
            'fuvarozo_id' => $fuvarozo1->id
        ]);

        $this->actingAs($fuvarozo2);

        $response = $this->patch("/fuvarozo/munkak/{$munka->id}/status", [
            'statusz' => 'folyamatban'
        ]);

        $response->assertStatus(403);
    }

    public function test_only_admin_can_assign_munka()
    {
        $admin = Fuvarozo::factory()->create(['role' => 'admin']);
        $fuvarozo = Fuvarozo::factory()->create(['role' => 'fuvarozo']);
        $munka = Munka::factory()->create();

        $this->actingAs($admin);

        $response = $this->post("/admin/munkak/{$munka->id}/assign", [
            'fuvarozo_id' => $fuvarozo->id
        ]);

        $response->assertRedirect('/admin/munkak');
        $this->assertDatabaseHas('munkas', [
            'id' => $munka->id,
            'fuvarozo_id' => $fuvarozo->id
        ]);
    }
}
