<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/6/2018
 * Time: 16:01
 */


namespace App\Repositories\Contracts;


use App\User;

interface UserRepoInterface {

    public function createUser(User $user);
    public function nonExistentUsername($username);
    public function users();
    public function findUser($userId);
    public function accountWithEmailExists($email);
    public function updateUser(User $user);
    public function deleteUser($userId);

}