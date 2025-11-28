<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/6/2018
 * Time: 15:59
 */


namespace App\Repositories\Contracts;


interface RepositoryInterface {

    public function all($columns = array('*'));

    public function paginate($perPage = 15, $columns = array('*'));

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function find($id, $columns = array('*'));

    public function findBy($field, $value, $columns = array('*'));

}