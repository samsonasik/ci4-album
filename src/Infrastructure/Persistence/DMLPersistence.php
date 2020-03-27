<?php namespace Album\Infrastructure\Persistence;

use CodeIgniter\Model;

/**
 * @internal
 * @property Model $model
 */
trait DMLPersistence
{
	public function save(array $data = null): bool
	{
		return $this->model instanceof Model && $this->model->save(new $this->model->returnType($data));
	}
}
