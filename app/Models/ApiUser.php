<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/17/2019
 * Time: 00:05
 */


namespace app\Models;


class ApiUser {

    public $id = "";
    public $username = "";
    public $firstName = "";
    public $lastName = "";
    public $otherName = "";
    public $email = "";
    public $phone = "";
    public $createdBy = "";
    public $orgCode = "";
    public $orgName = "";
    public $orgEdUsername = "";
    public $roleCode = "";
    public $roleName = "";
    public $roleLetterMovement = "";
    public $lmsRole = null;
    public $departmentId = "";
    public $departmentCode = "";
    public $departmentName = "";
    public $departmentHeadUsername = "";
    public $departmentHeadFullName = "";
    public $regionalOfficeCode = "";
    public $regionalOfficeName = "";
    public $categoryCode = "";
    public $category = "";
    public $createdAt = "";

    public $fullName = "";

    public $staffNumber = "";
    public $designation = "";

    public $designationId = "";
    public $designationTitle = "";

    public $dateOfBirth = "";
    public $contractStartDate = "";
    public $contractExpiryDate = "";

    public $unitCode = "";
    public $unitName = "";
    public $is_admin = "";
    public $is_out_of_office_delegate_user ;
    public $trusted_devices;
    public $token;

}