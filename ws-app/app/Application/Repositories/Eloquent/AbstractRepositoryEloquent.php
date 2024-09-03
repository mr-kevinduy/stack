<?php

namespace App\Application\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use App\Application\Repositories\AbstractRepository;

abstract class AbstractRepositoryEloquent extends AbstractRepository
{
    public function __construct(protected ?Model $model = null) {}

    /**
     * Scope query for get record list.
     *
     * @param  array  $columns
     * @param  array  $sorts
     * @return mixed
     */
    public function listScope($columns = ['*'], $sorts = [])
    {
        $query = $this->model
            ->select($columns ?? ['*']);

        if (!empty($sorts)) {
            foreach ($sorts as $key => $value) {
                $query->orderBy($key, $value);
            }
        }

        return $query;
    }

    /**
     * Get list records.
     *
     * @param  integer|null  $limit
     * @param  array   $columns
     * @param  array   $sorts
     * @param  boolean $paginate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list($limit = 10, $columns = ['*'], $sorts = [], $paginate = true)
    {
        $query = $this->listScope($columns, $sorts);

        if (is_null($limit)) {
            return $query->get();
        }

        if (!$paginate) {
            return $query->limit($limit)->get();
        }

        return $query->paginate($limit);
    }

    /**
     * Get by id.
     *
     * @param  mixed  $id
     * @param  array|string  $columns
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel|null)
     */
    public function getById($id, $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Get by id or fail.
     *
     * @param  mixed  $id
     * @param  array|string  $columns
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel)
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<TModel>
     */
    public function getByIdOrFail($id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

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
    public function getByWhere($wheres = [], $columns = ['*'], $onlyFirst = false)
    {
        $query = $this->model
            ->select($columns)
            ->where($wheres);

        if ($onlyFirst) {
            return $query->first();
        }

        return $query->get();
    }

    /**
     * Create new or update data by id.
     *
     * @param  array  $data
     * @param  array|int|string|null  $id
     * @return Model
     */
    public function save(array $data = [], array|int|string|null $id = null)
    {
        if (is_array($id) && ! empty($id)) {
            return $this->model->updateOrCreate($id, $data);
        }

        return $this->model->updateOrCreate(['id' => $id], $data);
    }

    /**
     * Create data
     *
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update data
     *
     * @param  array  $data
     * @param  string  $id
     * @return bool
     */
    public function update(array $data, int|string $id)
    {
        return $this->model->where('id', $id)->update($data);
    }

    /**
     * Delete by id.
     *
     * @param  string  $id
     * @return bool|null
     *
     * @throws \LogicException
     */
    public function delete(int|string $id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Many delete with ids.
     *
     * @param  \Illuminate\Support\Collection|array|int|string  $ids
     * @return int      Total records was deleted.
     */
    public function manyDelete($ids)
    {
        return $this->model->destroy($ids);
    }
}
