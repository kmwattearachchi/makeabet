<?php

namespace App\Repositories;

use Exception;
use App\Contracts\MainRepositoryInterface;
use Illuminate\Contracts\Container\Container as App;

abstract class MainRepository implements MainRepositoryInterface
{
    /**
     * @var App
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();


    /**
     * @return mixed
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        return $this->model = $model;
    }


    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        try{
            return $this->model->create($data);
        }catch (Exception $e){
            error_log($e->getMessage());
        }
    }

    /**
     * @param array $data values to be updated
     * @param mixed $id comparing value
     * @param string $attribute column name
     * @return mixed
     */
    public function update(array $data, $id, $attribute="id")
    {
        $this->model->where($attribute, '=', $id)->update($data);
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, $columns = array('*'))
    {
        return $this->model->findOrFail($id, $columns);
    }

    public function where($whereArr, $first = false, $columns = array('*'), $pluckColumn = null)
    {
        if($first) {
            return $this->model->select($columns)->where($whereArr)->first();
        }elseif($pluckColumn) {
            return $this->model->select($columns)->where($whereArr)->pluck($pluckColumn);
        }else {
            return $this->model->select($columns)->where($whereArr)->get();
        }

    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Begin querying a model with eager loading.
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function firstOrCreate($insertDataArray,$key,$value)
    {
        return $this->model->firstOrCreate([$key => $value ], $insertDataArray);
    }

    public function updateOrCreate($updateDataArray,$key,$value)
    {
        $objet = $this->model->where($key, $value)->first();

        if ($objet !== null) {
            $objet->update($updateDataArray);
        } else {
            array_push($updateDataArray,[$key=>$value]);
            $this->firstOrCreate($updateDataArray,$key,$value);
        }
        return $this->model->where($key, $value)->first();
    }
}
