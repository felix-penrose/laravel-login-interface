<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthRegisterTest extends TestCase
{
    /** @test */
    public function register_route_has_correct_fields()
    {
        $response = $this->get('/register');

        $response->assertSeeInOrder([
            'Name',
            'E-Mail Address',
            'Password',
            'Confirm Password',
        ]);
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }
}
