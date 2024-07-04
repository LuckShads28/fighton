<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test untuk register user berhasil
     */
    public function test_register_pass(): void
    {
        $user_test_data = [
            "nickname" => "luckshad",
            "email" => "luckshad@gmail.com",
            "password" => "12345678",
            "confirm_password" => "12345678"
        ];

        $this->post("/register", $user_test_data)->assertRedirect('/');
        $this->assertDatabaseHas('users', ['nickname' => 'luckshad']);

        $user = User::where("nickname", $user_test_data['nickname']);
        $user->delete();
    }

    /**
     * Test untuk register user gagal
     */
    public function test_register_failed(): void
    {
        $user_test_data = [
            "nickname" => "luckshad",
            "email" => "luckshad@gmail.com",
            "password" => "123",
            "confirm_password" => "321"
        ];

        $response = $this->post("/register", $user_test_data)->assertRedirect('/');
        $response->assertSessionHasErrors();
    }

    /**
     * Test untuk login berhasil
     */
    public function test_login_success(): void
    {
        $user_test_data = [
            "email" => "gun@guntur.com",
            "password" => "12345678",
        ];

        $response = $this->post('/login', $user_test_data)->assertRedirect('/');
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test untuk login gagal (salah password)
     */
    public function test_login_failed(): void
    {
        $user_test_data = [
            "email" => "gun@guntur.com",
            "password" => "87654321",
        ];

        $response = $this->post('/login', $user_test_data)->assertRedirect('/');
        $response->assertSessionHasErrors();
    }

    /**
     * Test update data profile
     */
    public function test_update_data_profile(): void
    {
        # ubah role ke initiator
        $user = User::firstWhere("nickname", "testing");
        $user->update([
            "role" => "Initiator"
        ]);

        $response = $this->actingAs($user)->put('/profile/' . $user->id, [
            "nickname" => "testing",
            "role" => "Controller"
        ])->assertRedirect('/profile');

        $response->assertSessionHasNoErrors();
    }
}
