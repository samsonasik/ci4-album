<?php namespace Album\Infrastructure\Persistence;

use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\Model;

/**
 * @internal
 * @property Model $model
 */
trait DMLPersistence
{
	public function save(array $data = null): bool
	{
		try
		{
			return $this->model->save(new $this->model->returnType($data));
		}
		catch (DataException $e)
		{
			return false;
		}
	}
}
