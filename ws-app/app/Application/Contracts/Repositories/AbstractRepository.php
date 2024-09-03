<?php

namespace App\Application\Contracts\Repositories;

interface AbstractRepository
{
    /**
     * Get list records.
     *
     * @param  integer|null  $limit
     * @param  array   $columns
     * @param  array   $sorts
     * @param  boolean $paginate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list($limit = 10, $columns = ['*'], $sorts = [], $paginate = true);

    /**
     * Get by id.
     *
     * @param  mixed  $id
     * @param  array|string  $columns
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel|null)
     */
    public function getById($id, $columns = ['*']);

    /**
     * Get by id or fail.
     *
     * @param  mixed  $id
     * @param  array|string  $columns
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel)
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<TModel>
     */
    public function getByIdOrFail($id, $columns = ['*']);

    /**
     * Get by multi where conditions.
     *
     * @param  array  $wheres
     * @param  array|string  $columns
     * @param  bool  $onlyFirst
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel)
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<TModel>
     */
    public function getByWhere($wheres = [], $columns = ['*'], $onlyFirst = false);

    /**
     * Create new or update data by id.
     *
     * @param  array  $data
     * @param  array|int|string|null  $id
     * @return Model
     */
    public function save(array $data = [], array|int|string|null $id = null);

    /**
     * Create data
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function create(array $data);

    /**
     * Update data
     *
     * @param  array  $data
     * @param  string  $id
     * @return bool
     */
    public function update(array $data, int|string $id);

    /**
     * Delete by id.
     *
     * @param  string  $id
     * @return bool|null
     *
     * @throws \LogicException
     */
    public function delete(int|string $id);

    /**
     * Many delete with ids.
     *
     * @param  \Illuminate\Support\Collection|array|int|string  $ids
     * @return int      Total records was deleted.
     */
    public function manyDelete($ids);
}
