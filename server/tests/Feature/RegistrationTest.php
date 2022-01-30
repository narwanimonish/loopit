<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\VerifyEmailQueued;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_registration()
    {
        $password = $this->faker->password(8, 12);
        $user = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
            'name' => $this->faker->name(),
        ];

        $response = $this->postJson(route('user.register'), $user);

        $response->assertStatus(201);
    }

    public function test_user_details_stored_in_db()
    {
        $password = $this->faker->password(8, 12);
        $user = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
            'name' => $this->faker->name(),
        ];

        $this->postJson(route('user.register'), $user);

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);

        $this->assertDatabaseCount('users', 1);
    }

    public function test_user_registration_mail()
    {
        Notification::fake();
        Notification::assertNothingSent();

        $password = $this->faker->password(8, 12);
        $user = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
            'name' => $this->faker->name(),
        ];
        $response = $this->postJson(route('user.register'), $user);

        $user = $response->json('data');
        $user = User::find($user['id']);
        Notification::assertSentTo($user, VerifyEmailQueued::class);
    }

    public function test_registration_response_msg()
    {
        $password = $this->faker->password(8, 12);
        $user = [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
            'name' => $this->faker->name(),
        ];

        $response = $this->postJson(route('user.register'), $user);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'data', 'message'])
                ->where('success', true)
                ->where('message', __('auth.registered'));
        });
    }
}
