<?php
namespace App\Contracts;

interface MainRepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findOrFail($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

    public function where($whereArr, $first = false, $columns = array('*'), $pluckColumn = null);

    public function model();

    public function firstOrCreate($insertDataArray,$key,$value);

    public function updateOrCreate($updateDataArray,$key,$value);
}
