<?php

namespace App\Application\Repositories\Eloquent;

use App\Application\Contracts\Repositories\UserRepository;
use App\Models\User;

class UserRepositoryEloquent extends AbstractRepositoryEloquent implements UserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
