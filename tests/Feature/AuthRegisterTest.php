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
            'First Name',
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
        $email = 'john@testing.com';

        $response = $this->post('/register', [
            'first_name' => 'John',
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals($email, $user->email);
        $this->assertTrue(Hash::check($password, $user->password));

        $response->assertRedirect(RouteServiceProvider::PROFILE);
    }



    /** @test */
    public function a_user_cannot_register_with_invalid_email()
    {
        $password = 'Testing123!#';
        $email = 'john@example.com';

        $response = $this->from('/register')->post('/register', [
            'first_name' => 'John',
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
        ]);

        $this->assertCount(0, User::all());
        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('first_name'));
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertGuest();
    }
}
