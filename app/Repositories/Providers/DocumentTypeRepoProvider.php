<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 2/9/2018
 * Time: 02:14
 */


namespace app\Repositories\Providers;


use Illuminate\Support\ServiceProvider;

class DocumentTypeRepoProvider extends ServiceProvider {

    public function register() {

        $this->app->bind(
            'App\Repositories\Contracts\DocumentTypeRepoInterface',
            'App\Repositories\Eloquent\DocumentTypeRepo'
        );

    }

}