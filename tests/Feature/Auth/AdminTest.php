<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLoginWithCorrectCredentialsInAdminConsole()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'type' => 'admin'
        ]);

        $this->be($user);

        $response = $this->get('/admin');

        $response->assertViewIs('admin');
        $this->assertAuthenticatedAs($user);

    }

    public function testUserCanNotLoginWithInCorrectCredentialsInAdminConsole()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'type' => 'user'
        ]);

        $this->be($user);

        $response = $this->get('/admin');

        $response->assertRedirect('home');
        $this->assertAuthenticatedAs($user);

    }
}
