<?php

namespace App\Application\Services;

use App\Application\Contracts\Repositories\PostRepository;

class PostService extends AbstractService
{
    public function __construct(PostRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get post list.
     *
     * @return Post
     */
    public function getPostList()
    {
        return $this->repository->list(2, null, null, true);
    }

    /**
     * Get post by id.
     *
     * @param  int|string  $id
     * @return Post
     */
    public function getPostById($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Create new post.
     *
     * @param  array  $data
     * @return Post
     */
    public function createPost(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update post by id.
     *
     * @param  string|int  $id
     * @param  array  $data
     * @return Post
     */
    public function updatePost(string|int $id, array $data)
    {
        return $this->repository->save($data, $id);
    }

    /**
     * Delete post.
     *
     * @param  string|int  $id
     * @return Post
     */
    public function deletePost(string|int $id)
    {
        return $this->repository->delete($id);
    }
}
