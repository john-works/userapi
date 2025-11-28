<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 5/31/2019
 * Time: 20:13
 */


namespace app\Models;


class ApiFormCompetence {

    public $id;
    public $appraisalCompetenceCategoryId;
    public $competence;
    public $rank;
    public $rating;

    /*
     * These are used only when the user has already filled in the scores, i.e on updating,
     * we populate them on fetching the form in case of update
     * */
    public $scoreAppraiseeRating;
    public $scoreAppraiserRating;
    public $scoreAgreedRating;
    public $scoreRecordId;

}