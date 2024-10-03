<?php

namespace Tests\Feature;

use App\Models\Epresence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EpresenceApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        User::factory()->create([
            'email' => 'bayu@email.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'bayu@email.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['token']]);
    }

    public function test_login_with_invalid_credentials()
    {
        User::factory()->create([
            'email' => 'bayu@email.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'bayu@email.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson(['message' => 'Invalid login credentials']);
    }

    public function test_insert_absence_with_valid_token()
    {
        $user = User::factory()->create([
            'email' => 'bayu@email.com',
            'password' => Hash::make('password'),
        ]);

        $tokenResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $tokenResponse['data']['token'];

        $response = $this->postJson('/api/epresence', [
            'type' => 'IN',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Presence data inserted']);
    }

    public function test_insert_absence_without_token()
    {
        $response = $this->postJson('/api/epresence', [
            'type' => 'IN',
        ]);

        $response->assertStatus(401);
    }

    public function test_approve_presence_by_correct_supervisor()
    {
        $supervisor = User::factory()->create([
            'npp' => '11111',
            'npp_supervisor' => null,
        ]);

        $user = User::factory()->create([
            'npp_supervisor' => $supervisor->npp,
        ]);

        $presence = Epresence::factory()->create([
            'id_users' => $user->id,
            'type' => 'IN',
            'is_approve' => false,
        ]);

        $tokenResponse = $this->postJson('/api/login', [
            'email' => $supervisor->email,
            'password' => 'password',
        ]);

        $token = $tokenResponse['data']['token'];

        $response = $this->postJson("/api/epresence/{$presence->id}/approve", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Presence data approved']);
    }

    public function test_approve_presence_by_unauthorized_supervisor()
    {
        $supervisor1 = User::factory()->create([
            'npp' => '11111',
            'npp_supervisor' => null,
        ]);
        $supervisor2 = User::factory()->create([
            'npp' => '22222',
            'npp_supervisor' => null,
        ]);

        $user = User::factory()->create([
            'npp_supervisor' => $supervisor1->npp,
        ]);

        $presence = Epresence::factory()->create([
            'id_users' => $user->id,
            'type' => 'IN',
            'is_approve' => false,
        ]);

        $tokenResponse = $this->postJson('/api/login', [
            'email' => $supervisor2->email,
            'password' => 'password',
        ]);

        $token = $tokenResponse['data']['token'];

        $response = $this->postJson("/api/epresence/{$presence->id}/approve", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(403)
            ->assertJson(['message' => 'Unauthorized. You are not the supervisor of this user']);
    }
}
