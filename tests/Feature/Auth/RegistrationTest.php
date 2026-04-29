<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
    ]);

    $response = $this->actingAs($admin)->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'role' => 'staff',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticatedAs($admin);
    $response->assertRedirect(route('users.index', absolute: false));
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'role' => 'staff',
    ]);
});
