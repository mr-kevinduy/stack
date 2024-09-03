<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\Application\Repositories\Eloquent\PostRepositoryEloquent;
use Tests\TestCase;

class PostRepositoryEloquentTest extends TestCase
{
    use RefreshDatabase;

    protected $postRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postRepository = new PostRepositoryEloquent(new Post);
    }

    /**
     * Unit test can create a post.
     */
    public function test_it_can_create_a_post(): void
    {
        $data = [
            'title' => 'Test Post',
            'content' => 'This is a test content.',
        ];

        $post = $this->postRepository->create($data);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * Unit test can get post list.
     */
    public function test_it_can_get_post_list(): void
    {
        Post::factory()->count(3)->create();

        $posts = $this->postRepository->list(20);

        $this->assertCount(3, $posts);
    }

    /**
     * Unit test can update the post.
     */
    public function test_it_can_update_a_post(): void
    {
        $post = Post::factory()->create();

        $data = ['title' => 'Updated title'];

        $updatedPost = $this->postRepository->save($data, $post->id);

        $this->assertEquals('Updated title', $updatedPost->title);
        $this->assertDatabaseHas('posts', $data);
    }

    /**
     * Unit test can delete the post.
     */
    public function test_it_can_delete_a_post(): void
    {
        $post = Post::factory()->create();

        $result = $this->postRepository->delete($post->id);

        $this->assertTrue((boolean)$result);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
