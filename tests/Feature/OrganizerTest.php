<?php

namespace Tests\Feature;

use App\Models\Organizer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Str;

class OrganizerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_organizer(): void
    {
        $user = User::firstWhere("nickname", "gun");

        $fake_logo_img = UploadedFile::fake()->image('logo.png');
        $fake_banner_img = UploadedFile::fake()->image('banner.png');

        $new_organizer_data = [
            'name' => 'organizer testing',
            'description' => 'ini testing organizer',
            'contact' => '0812345678',
            'logo_img' => $fake_logo_img,
            'banner_img' => $fake_banner_img
        ];

        $this->actingAs($user)->post('/organizer', $new_organizer_data)->assertRedirectToRoute('organizer.index');

        $this->assertDatabaseHas('organizers', ['name' => 'organizer testing']);
    }

    public function test_update_organizer(): void
    {
        $user = User::firstWhere("nickname", "gun");

        $old_organizer_data = Organizer::firstWhere("name", "organizer testing");

        $updated_organizer_data = [
            'name' => 'organizer testing updated',
            'description' => 'ini testing organizer',
            'contact' => '0812345678',
        ];

        $this->actingAs($user)->put('/organizer/' . $old_organizer_data->id, $updated_organizer_data)
            ->assertRedirectToRoute('organizer_dashboard', Str::slug($updated_organizer_data['name']));

        $this->assertDatabaseHas('organizers', ['name' => 'organizer testing updated']);
        $this->assertDatabaseMissing('organizers', ['name' => 'organizer testing']);
    }

    public function test_remove_organizer(): void
    {
        $user = User::firstWhere("nickname", "gun");

        $organizer_data = Organizer::firstWhere("name", "organizer testing updated");

        $this->actingAs($user)
            ->delete('/organizer/' . $organizer_data->id)
            ->assertRedirectToRoute('organizer.index');

        $this->assertDatabaseMissing('organizers', ['id' => $organizer_data->id]);
    }
}
