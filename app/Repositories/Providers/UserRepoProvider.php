<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/6/2018
 * Time: 16:04
 */


namespace app\Repositories\Providers;

use Illuminate\Support\ServiceProvider;

class UserRepoProvider extends ServiceProvider {

    public function register() {

        $this->app->bind(
            'App\Repositories\Contracts\UserRepoInterface',
            'App\Repositories\Eloquent\UserRepo'
        );

    }

}