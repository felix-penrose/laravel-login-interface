<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthRegisterTest extends TestCase
{
    use RefreshDatabase;

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



    /** @test */
    public function a_user_can_register()
    {
        $password = 'Testing123!#';

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@testing.com',
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@testing.com', $user->email);
        $this->assertTrue(Hash::check($password, $user->password));

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

}
