<?php

namespace App\Application\Repositories\Eloquent;

use App\Application\Contracts\Repositories\PostRepository;
use App\Models\Post;

class PostRepositoryEloquent extends AbstractRepositoryEloquent implements PostRepository
{
    public function __construct(Post $post)
    {
        parent::__construct($post);
    }
}
