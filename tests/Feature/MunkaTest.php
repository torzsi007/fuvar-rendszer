<?php

namespace Tests\Feature;

use App\Models\Fuvarozo;
use App\Models\Munka;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MunkaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_munka()
    {
        $admin = Fuvarozo::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->post('/admin/munkak', [
            'kiindulo_cim' => 'Budapest, Kossuth tér 1',
            'erkezesi_cim' => 'Debrecen, Piac utca 5',
            'cimzett_nev' => 'Kiss János',
            'cimzett_telefon' => '+36301234567',
        ]);

        $response->assertRedirect('/admin/munkak');
        $this->assertDatabaseHas('munkas', [
            'cimzett_nev' => 'Kiss János',
        ]);
    }

    public function test_fuvarozo_cannot_access_admin_pages()
    {
        $fuvarozo = Fuvarozo::factory()->create(['role' => 'fuvarozo']);
        $this->actingAs($fuvarozo);

        $response = $this->get('/admin/munkak');
        $response->assertStatus(403);
    }

    public function test_fuvarozo_can_view_own_munkak()
    {
        $fuvarozo = Fuvarozo::factory()->create(['role' => 'fuvarozo']);
        $munka = Munka::factory()->create(['fuvarozo_id' => $fuvarozo->id]);

        $this->actingAs($fuvarozo);
        $response = $this->get('/fuvarozo/dashboard');

        $response->assertStatus(200);
        $response->assertSee($munka->cimzett_nev);
    }
}
