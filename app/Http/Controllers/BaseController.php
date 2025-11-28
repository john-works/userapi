<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 6/10/2018
 * Time: 04:20
 */


namespace App\Http\Controllers;

class BaseController extends Controller {

    protected $active_module;

    public function __construct($active_module) {
        $this->active_module = $active_module;
    }


}