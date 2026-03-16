<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('Test User', $user->name);
        $this->assertSame('test@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'Test User',
                'email' => $user->email,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertNotNull($user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
        $this->assertNull($user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->delete('/profile', [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('userDeletion', 'password')
            ->assertRedirect('/profile');

        $this->assertNotNull($user->fresh());
    }

    public function test_profile_fields_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'bio' => 'This is my bio',
                'location' => 'New York, USA',
                'phone' => '+1234567890',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $user->refresh();

        $this->assertSame('John Doe', $user->name);
        $this->assertSame('john@example.com', $user->email);
        $this->assertSame('This is my bio', $user->bio);
        $this->assertSame('New York, USA', $user->location);
        $this->assertSame('+1234567890', $user->phone);
    }

    public function test_user_preferences_can_be_created_and_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->patch('/profile/preferences', [
                'timezone' => 'America/New_York',
                'email_notifications_enabled' => false,
                'email_summary_enabled' => true,
                'email_summary_frequency' => 'daily',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $preferences = $user->preferences()->first();

        $this->assertNotNull($preferences);
        $this->assertSame('America/New_York', $preferences->timezone);
        $this->assertFalse($preferences->email_notifications_enabled);
        $this->assertTrue($preferences->email_summary_enabled);
        $this->assertSame('daily', $preferences->email_summary_frequency);
    }

    public function test_user_preferences_can_be_updated(): void
    {
        $user = User::factory()->create();
        $user->preferences()->create([
            'timezone' => 'UTC',
            'email_notifications_enabled' => true,
            'email_summary_enabled' => true,
            'email_summary_frequency' => 'weekly',
        ]);

        $response = $this
            ->actingAs($user)
            ->patch('/profile/preferences', [
                'timezone' => 'Europe/London',
                'email_notifications_enabled' => false,
                'email_summary_enabled' => false,
                'email_summary_frequency' => 'monthly',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $preferences = $user->preferences()->first();

        $this->assertSame('Europe/London', $preferences->timezone);
        $this->assertFalse($preferences->email_notifications_enabled);
        $this->assertFalse($preferences->email_summary_enabled);
        $this->assertSame('monthly', $preferences->email_summary_frequency);
    }

    public function test_profile_edit_loads_preferences(): void
    {
        $user = User::factory()->create();
        $user->preferences()->create([
            'timezone' => 'Asia/Tokyo',
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/profile');

        $response->assertOk();
        $this->assertInstanceOf(\App\Models\User::class, $response->viewData('user'));
        $this->assertNotNull($response->viewData('preferences'));
    }
}
