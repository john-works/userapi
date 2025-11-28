<?php

namespace App;

use app\Helpers\AppConstants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    protected $fillable = [];

    public function academicBackgrounds(){
        return $this->hasMany('App\AcademicBackground');
    }

    public function keyDuties(){
        return $this->hasMany('App\KeyDuty');
    }

    public function additionalAssignments(){
        return $this->hasMany('App\AdditionalAssignment');
    }

    public function assignments(){
        return $this->hasMany('App\Assignment');
    }

    public function competences(){
        return $this->hasMany('App\Competence');
    }

    public function workflow(){
        return $this->hasOne('App\Workflow');
    }

    public function getDobAttribute($value) {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function performanceGaps(){
        return $this->hasMany('App\PerformanceGap');
    }

    public function performanceChallenges(){
        return $this->hasMany('App\PerformanceChallenge');
    }

    public function performanceAppraiserComment(){
        return $this->hasOne('App\PerformanceAppraiserComment');
    }

    public function sectiong(){
        return $this->hasOne('App\Sectiong');
    }

    public function sectionh(){
        return $this->hasOne('App\Sectionh');
    }

    public function sectioni(){
        return $this->hasOne('App\Sectioni');
    }

    public function sectionj(){
        return $this->hasOne('App\Sectionj');
    }

    public function sectionk(){
        return $this->hasOne('App\Sectionk');
    }

    public function sectionl(){
        return $this->hasMany('App\Sectionl');
    }

    public function sectionm(){
        return $this->hasOne('App\Sectionm');
    }

    public function sectionn(){
        return $this->hasOne('App\Sectionn');
    }

    public function assignmentsSummary(){
        return $this->hasOne('App\AssignmentsSummary');
    }

    public function addAssignmentsSummary(){
        return $this->hasOne('App\AddAssignmentsSummary');
    }

    public function competenceSummary(){
        return $this->hasOne('App\CompetenceSummary');
    }

    public function directorsAndManagersCompetences(){
        return $this->hasMany('App\DirectorsAndManagersCompetence');
    }

    public function supportStaffCompetences(){
        return $this->hasMany('App\SupportStaffCompetence');
    }

    public function officersCompetences(){
        return $this->hasMany('App\OfficersCompetence');
    }

}
