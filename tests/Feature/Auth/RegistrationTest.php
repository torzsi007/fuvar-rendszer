<?php

namespace Tests\Feature\Auth;

use App\Models\Fuvarozo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        // Redirectel login-ra
        $response->assertRedirect('/login');
        
        // Ellenőrizzük, hogy létrejött-e a felhasználó
        $this->assertDatabaseHas('fuvarozos', [
            'email' => 'test@example.com',
            'role' => 'fuvarozo', // Alapértelmezett
        ]);
    }

    public function test_new_users_default_to_fuvarozo_role(): void
    {
        $response = $this->post('/register', [
            'name' => 'Another User',
            'email' => 'another@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            // Nincs role mező - alapértelmezetten fuvarozó legyen
        ]);

        $response->assertRedirect('/login');
        
        $this->assertDatabaseHas('fuvarozos', [
            'email' => 'another@example.com',
            'role' => 'fuvarozo', // Alapértelmezett
        ]);
    }
    
    public function test_cannot_register_with_duplicate_email(): void
    {
        // Először létrehozunk egy felhasználót
        Fuvarozo::create([
            'name' => 'Existing User',
            'email' => 'existing@example.com',
            'password' => bcrypt('password'),
            'role' => 'fuvarozo',
        ]);
        
        // Ugyanazzal az emaillel próbálunk regisztrálni
        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'existing@example.com', // Már létező email
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        
        $response->assertSessionHasErrors('email');
    }
}
