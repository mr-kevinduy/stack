<?php

namespace Tests\Unit;

use Tests\TestCase;
// use PHPUnit\Framework\TestCase;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Application\Contracts\Repositories\PostRepository;
use App\Application\Services\PostService;
use App\Models\Post;

class PostServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $postService;

    protected $postRepository;

    /**
     * Set up.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepository = Mockery::mock(PostRepository::class);
        $this->postService = new PostService($this->postRepository);
    }

    /**
     * Unit test can create the post.
     */
    public function test_it_can_create_post()
    {
        $data = [
            'title' => 'Test Title',
            'content' => 'Test Content'
        ];

        $this->postRepository
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn(new Post($data));

        $post = $this->postService->createPost($data);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals('Test Title', $post->title);
    }
}
