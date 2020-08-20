<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_route_has_correct_fields()
    {
        $response = $this->get('/login');

        $response->assertSeeInOrder([
            'E-Mail Address',
            'Password',
            'Remember Me',
        ]);
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }


    /** @test */
    public function user_cannot_view_a_login_form_when_authenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect(RouteServiceProvider::PROFILE);
    }


    /** @test */
    public function user_can_login_with_correct_credentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'testing'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect(RouteServiceProvider::PROFILE);
        $this->assertAuthenticatedAs($user);
    }


    /** @test */
    public function user_cannot_login_with_incorrect_password()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('password'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }


    /** @test */
    public function test_remember_me_functionality()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => Hash::make($password = 'password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);

        $response->assertRedirect(RouteServiceProvider::PROFILE);

        // check the cookie is valid
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));

        $this->assertAuthenticatedAs($user);
    }
}
