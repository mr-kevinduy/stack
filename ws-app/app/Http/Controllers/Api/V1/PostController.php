<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Responses\ApiResponse;
use App\Http\Resources\PostResource;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Application\Services\PostService;

class PostController extends V1Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;

        // Authorize user to post resource (viewAny, view, create, update, delete)
        $this->authorizeResource(Post::class);
    }

    public function store(StorePostRequest $request)
    {
        // Authorize user to create post.
        // $this->authorize('create', Post::class);

        $post = $this->postService->createPost($request->validated());

        return ApiResponse::success(payload: new PostResource($post));
    }

    public function index()
    {
        // Authorize user to view any posts.
        // $this->authorize('viewAny', Post::class);

        $posts = $this->postService->getPostList();

        return ApiResponse::success(
            PostResource::collection($posts)
        );
    }

    public function show(Post $post)
    {
        // Authorize user to view the specific post.
        // $this->authorize('view', $post);

        return ApiResponse::success(
            new PostResource($post)
        );
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        // Authorize user to update the post.
        // $this->authorize('update', $post);

        // Update date
        $post = $this->postService->updatePost($post, $request->validated());

        return ApiResponse::success(
            new PostResource($post)
        );
    }

    public function destroy(Post $post)
    {
        // Authorize user to delete the post.
        // $this->authorize('delete', $post);

        $this->postService->deletePost($post);

        return ApiResponse::success(
            statusCode: 204
        );
    }
}
