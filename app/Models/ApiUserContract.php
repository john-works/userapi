<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 6/8/2019
 * Time: 09:52
 */


namespace app\Models;


class ApiUserContract {


    public $id;
    public $username;
    public $contractReference;
    public $startDate;
    public $expiryDate;
    public $createdBy;

}