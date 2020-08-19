<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function reset_password_route_has_correct_fields()
    {
        $response = $this->get('/password/reset');

        $response->assertSeeInOrder([
            'Reset Password',
            'E-Mail Address',
            'Send Password Reset Link',
        ]);
        $response->assertSuccessful();
        $response->assertViewIs('auth.passwords.email');
    }


    /** @test */
    public function user_receives_an_email_with_a_password_reset_link()
    {
        Notification::fake();

        $user = factory(User::class)->create();

        $response = $this->post('/password/email', [
            'email' => $user->email,
        ]);

        $this->assertNotNull($token = DB::table('password_resets')->first());

        Notification::assertSentTo($user, ResetPassword::class, function ($notification, $channels) use ($token) {
            return Hash::check($notification->token, $token->token) === true;
        });
    }


    /** @test */
    public function user_does_not_receive_email_when_not_registered()
    {
        Notification::fake();

        $response = $this->from('/password/reset')->post('/password/email', [
            'email' => 'nobody@example.com',
        ]);

        $response->assertRedirect('/password/reset');
        $response->assertSessionHasErrors('email');

        Notification::assertNotSentTo(factory(User::class)->make(['email' => 'nobody@example.com']), ResetPassword::class);
    }
}
