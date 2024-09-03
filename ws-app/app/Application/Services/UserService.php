<?php

namespace App\Application\Services;

use App\Application\Contracts\Repositories\UserRepository;

class UserService extends AbstractService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get user list.
     *
     * @return User
     */
    public function getUserList()
    {
        return $this->repository->list(2, null, null, true);
    }

    /**
     * Get user detail.
     *
     * @return User
     */
    public function getUserDetail($id)
    {
        return $this->repository->getByIdOrFail($id);
    }

    /**
     * Get user by wheres.
     *
     * @return User
     */
    public function getUser(array $wheres = [])
    {
        return $this->repository->getByWhere(
            wheres: $wheres,
            onlyFirst: true
        );
    }
}
