<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredentialsInAdminConsole()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'type' => 'user'
        ]);

        $this->be($user);

        $response = $this->get('/home');

        $response->assertViewIs('home');
        $this->assertAuthenticatedAs($user);

    }

    public function testUserCanNotLoginWithInCorrectCredentialsInAdminConsole()
    {

        $response = $this->get('/home');

        $response->assertRedirect('login');

    }
}
