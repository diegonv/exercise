<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Faker\Factory;
use App\Posts;

class PostsTest extends TestCase
{
    use DatabaseMigrations;
    //use RefreshDatabase;
    protected $faker;
    
    
    public function setUp() {
        parent::setUp();
        $this->faker = Factory::create();

        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'secret'),
            'type' => 'admin'
        ]);

        $this->be($user);
    }

    public function test_can_create_post() {
        $data = [
            'title' => $this->faker->sentence,
            'subtitle' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];
        $this->post(route('posts.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHome()
    {
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
    }

    public function testCanCreatePost() {
        $data = [
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(5),
            'content' => $this->faker->text(1500),
            'user_id' => Auth::id(),
        ];
        $this->post(route('posts.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function testCanDeletePost() {
        $post = factory(Posts::class)->create();
        $this->delete(route('posts.destroy', $post->id))
            ->assertStatus(204);
    }

    public function testTryDeleteNoNExistPost() {
        $post = factory(Posts::class)->create();
        $this->delete(route('posts.destroy', 999))
            ->assertStatus(404);
    }

    public function testCanUpdatePost() {
        $post = factory(Posts::class)->create();
        $data = [
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(5),
            'content' => $this->faker->text(1500),
        ];

        $this->put(route('posts.update', $post->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function testCanViewAllPost() {
        $posts = factory(Posts::class, 2)->create()->map(function ($post) {
            return $post->only(['id', 'title', 'content']);
        });

        $this->get(route('posts.index'), array('HTTP_X-Requested-With' => 'XMLHttpRequest'))
             ->assertSuccessful()
             ->assertJson($posts->toArray())
             ->assertJsonStructure([
                '*' => [ 'id', 'title','subtitle', 'content' ],
             ]);;

    }
    
}
