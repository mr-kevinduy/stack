<?php

namespace Tests\Feature\Api\V1;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use App\Models\Post;
use App\Models\User;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    protected $apiEndpoint = '/api/v1';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    /**
     * Feature test it can get post list.
     */
    public function test_it_can_get_posts(): void
    {
        Post::factory()->count(3)->create();

        $response = $this->getJson($this->apiEndpoint.'/posts');

        dd($response); die();

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}
