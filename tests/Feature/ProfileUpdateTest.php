<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    public $base_url = '/u/profile';


    /** @test */
    public function a_logged_in_user_can_fetch_details()
    {
        $user = $this->log_in_user();

        // fetch user detals after login
        $response = $this->getJson($this->base_url);

        $response->assertStatus(200);
        $response->assertJson([
            'first_name' => $user->first_name,
            'email' => $user->email,
        ]);
    }



    /** @test */
    public function a_user_can_update_their_details()
    {
        $user = $this->log_in_user();

        $user_update = [
            'first_name' => 'Bobby',
            'last_name' => 'Tester',
            'email' => 'bobby@tester.com',
            'username' => 'bobby.tester',
            'personal_site' => 'https://foo.bar.com',
            'location' => 'England',
            'instagram_username' => 'IGTester',
            'twitter_username' => 'TWTester',
        ];

        $response = $this->putJson($this->base_url, $user_update);

        $response->assertStatus(200);
        $response->assertJson($user_update);

        $this->assertNotEquals($user->first_name, $response['first_name']);
        $this->assertNotEquals($user->last_name, $response['last_name']);
        $this->assertNotEquals($user->email, $response['email']);
        $this->assertNotEquals($user->username, $response['username']);
        $this->assertNotEquals($user->personal_site, $response['personal_site']);
        $this->assertNotEquals($user->location, $response['location']);
        $this->assertNotEquals($user->instagram_username, $response['instagram_username']);
        $this->assertNotEquals($user->twitter_username, $response['twitter_username']);
    }




    /** @test */
    public function a_user_can_delete_their_account()
    {
        $user = $this->log_in_user();

        $response = $this->deleteJson($this->base_url);

        // dump(User::all());

        $this->assertCount(0, User::all());
        $response->assertRedirect('/');
        $this->assertGuest();
    }



    /**
     * Log in a user, so we can perform actions when authenticated
     *
     * @return collection
     */
    public function log_in_user()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'testing'),
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        return $user;
    }
}
