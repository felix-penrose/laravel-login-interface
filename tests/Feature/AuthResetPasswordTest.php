<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthResetPasswordTest extends TestCase
{
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
}
