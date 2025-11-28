<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 6/1/2019
 * Time: 08:46
 */


namespace app\Models;


class ApiFormCompetenceAssessment {

    public $id;
    public $competenceCategoryId;
    public $competenceId;
    public $maximumRating;
    public $appraiseeRating;
    public $appraiserRating;
    public $agreedRating;

}