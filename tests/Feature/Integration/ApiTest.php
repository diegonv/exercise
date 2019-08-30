<?php

namespace Tests\Feature\Integration;

use App\User;
use App\Posts;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        
        Passport::actingAs(
            factory(User::class)->create()
        );
        

    }

    public function tearDown()
    {
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
        parent::tearDown();
    }
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPostsList()
    {
        $response = $this->json('GET', 'api/posts');
        $response->assertStatus(200);
    }

    public function testCanCreatePost()
    {
        $data = [
            'title' => 'test',
            'subtitle' => 'test',
            'content' => 'test',
        ];
        $this->post(route('posts.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function testCanNotCreatePost()
    {
        $data = [
            'title' => 'test',
            'subtitle' => 'test',
        ];
        $this->post(route('posts.store'), $data)
            ->assertStatus(400);
    }


    public function testCanDeletePost()
    {
        $post = factory(Posts::class)->create();
        $this->delete(route('posts.destroy', $post->id))
            ->assertStatus(204);
    }

    public function testTryDeleteNoNExistPost()
    {
        $post = factory(Posts::class)->create();
        $this->delete(route('posts.destroy', 999))
            ->assertStatus(404);
    }

    public function testCanUpdatePost()
    {
        $post = factory(Posts::class)->create();
        $data = [
            'title' => 'test',
            'subtitle' => 'test',
            'content' => 'test',
        ];

        $this->put(route('posts.update', $post->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testCanNotUpdatePostValidationFail()
    {
        $post = factory(Posts::class)->create();
        $data = [
            'title' => 'test',
            'content' => 'test',
        ];

        $this->put(route('posts.update', $post->id), $data)
            ->assertStatus(400);
    }

    public function testCanNotUpdatePostNotFound()
    {
        $post = factory(Posts::class)->create();
        $data = [
            'title' => 'test',
            'subtitle' => 'test',
            'content' => 'test',
        ];

        $this->put(route('posts.update', 9999), $data)
            ->assertStatus(404);
    }
}
