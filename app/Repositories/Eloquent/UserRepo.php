<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/6/2018
 * Time: 16:02
 */


namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\UserRepoInterface;
use App\User;

class UserRepo extends Repository implements UserRepoInterface {

    function model() {
        return 'App\User';
    }

    public function createUser(User $user) {
        return $user->save();
    }

    public function nonExistentUsername($username) {

        $user = $this->findBy('username',$username);
        return $user == null ? $username : $this->nonExistentUsername($username.random_int(0,99));

    }

    public function users() {
        return $this->all();
    }

    public function findUser($userId) {
        return $this->find($userId);
    }

    public function accountWithEmailExists($email) {
        return $this->findBy('email',$email);
    }

    public function updateUser(User $user) {
        $user->save();
    }

    public function deleteUser($userId) {
       $this->delete($userId);
    }

}