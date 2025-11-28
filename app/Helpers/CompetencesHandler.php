<?php
/**
 * Created by Leontymo Developers.
 * User: timothy kasaga
 * Date: 6/16/2018
 * Time: 11:53
 */


namespace app\Helpers;


class CompetencesHandler {

    public static function getCompetenceByStaffCategory($staffCategory){

        if($staffCategory == AppConstants::$STAFF_CAT_L4_L6){

            $competenceData = CompetencesHandler::getOfficersAndSeniorOfficersCompetences();

        }else if($staffCategory == AppConstants::$STAFF_CAT_L2_L4){

            $competenceData = CompetencesHandler::getDirectorCompetences();

        }else{

            $competenceData = CompetencesHandler::getSupportStaffCompetences();

        }

        return $competenceData;

    }

    private static function getOfficersAndSeniorOfficersCompetences() {

        $competenceCategory1 = [
            ["categoryCode"=>"001","count"=>"1.0","max_rating"=>"25","competence"=>"Knowledge"],
            ["categoryCode"=>"001","count"=>"1.1","max_rating"=>"13","competence"=>"Application of Technical & Professional Knowledge"],
            ["categoryCode"=>"001","count"=>"1.2","max_rating"=>"12","competence"=>"Translating theoretical knowledge into practice"],
        ];

        $competenceCategory2 = [
            ["categoryCode"=>"002","count"=>"2.0","max_rating"=>"20","competence"=>"Motivation to Work"],
            ["categoryCode"=>"002","count"=>"2.1","max_rating"=>"6","competence"=>"Highly self-motivated"],
            ["categoryCode"=>"002","count"=>"2.2","max_rating"=>"5","competence"=>"Attends regularly and is a good time manager"],
            ["categoryCode"=>"002","count"=>"2.3","max_rating"=>"5","competence"=>"Copes well with heavy workload"],
            ["categoryCode"=>"002","count"=>"2.4","max_rating"=>"4","competence"=>"Attitude towards work"],
        ];

        $competenceCategory3 = [
            ["categoryCode"=>"003","count"=>"3.0","max_rating"=>"20","competence"=>"Communication Skills"],
            ["categoryCode"=>"003","count"=>"3.1","max_rating"=>"10","competence"=>"Oral Communication and in writing"],
            ["categoryCode"=>"003","count"=>"3.2","max_rating"=>"10","competence"=>"Report writing"],
        ];

        $competenceCategory4 = [
            ["categoryCode"=>"004","count"=>"4.0","max_rating"=>"15","competence"=>"Team Work"],
            ["categoryCode"=>"004","count"=>"4.1","max_rating"=>"5","competence"=>"Encourages  and supports joint decision making"],
            ["categoryCode"=>"004","count"=>"4.2","max_rating"=>"4","competence"=>"Listens to and supports others"],
            ["categoryCode"=>"004","count"=>"4.3","max_rating"=>"3","competence"=>"Anticipates  and resolves conflict"],
            ["categoryCode"=>"004","count"=>"4.4","max_rating"=>"3","competence"=>"Open ,honest, and harmonious working relationship with colleagues"],
        ];

        $competenceCategory5 = [
            ["categoryCode"=>"005","count"=>"5.0","max_rating"=>"10","competence"=>"Customer and Business focus"],
            ["categoryCode"=>"005","count"=>"5.1","max_rating"=>"6","competence"=>"Care for  internal and External Customers"],
            ["categoryCode"=>"005","count"=>"5.2","max_rating"=>"4","competence"=>"Economical in use of resources"],
        ];

        $competenceCategory6 = [
            ["categoryCode"=>"006","count"=>"6.0","max_rating"=>"10","competence"=>"Confidentiality and Reliability"],
            ["categoryCode"=>"006","count"=>"6.1","max_rating"=>"6","competence"=>"Very responsible and can be entrusted with any work"],
            ["categoryCode"=>"006","count"=>"6.2","max_rating"=>"4","competence"=>"Always appreciates and observes the Oath of Secrecy"],
        ];

        $competenceData = [$competenceCategory1, $competenceCategory2, $competenceCategory3,$competenceCategory4,$competenceCategory5,$competenceCategory6];

        return $competenceData;

    }

    private static function getSupportStaffCompetences() {

        $competenceCategory1 = [
            ["categoryCode"=>"001","count"=>"1.0","max_rating"=>"30","competence"=>"Performance of activities"],
            ["categoryCode"=>"001","count"=>"1.1","max_rating"=>"10","competence"=>"Amount of work completed"],
            ["categoryCode"=>"001","count"=>"1.2","max_rating"=>"10","competence"=>"Quality of work"],
            ["categoryCode"=>"001","count"=>"1.3","max_rating"=>"5","competence"=>"Satisfies needs of internal and external customers"],
            ["categoryCode"=>"001","count"=>"1.4","max_rating"=>"5","competence"=>"Always ready to put in extra effort/time"],
        ];

        $competenceCategory2 = [
            ["categoryCode"=>"002","count"=>"2.0","max_rating"=>"30","competence"=>"Team work"],
            ["categoryCode"=>"002","count"=>"2.1","max_rating"=>"5","competence"=>"Portrays a good image of the organisation"],
            ["categoryCode"=>"002","count"=>"2.2","max_rating"=>"10","competence"=>"Works well with colleagues"],
            ["categoryCode"=>"002","count"=>"2.3","max_rating"=>"10","competence"=>"Proactive in finding solutions on specific tasks"],
            ["categoryCode"=>"002","count"=>"2.4","max_rating"=>"5","competence"=>"Receives Instructions & seeks clarity as necessary"],
        ];

        $competenceCategory3 = [
            ["categoryCode"=>"003","count"=>"3.0","max_rating"=>"20","competence"=>"Enthusiasm and drive"],
            ["categoryCode"=>"003","count"=>"3.1","max_rating"=>"10","competence"=>"Highly self motivated"],
            ["categoryCode"=>"003","count"=>"3.2","max_rating"=>"3","competence"=>"Flexible"],
            ["categoryCode"=>"003","count"=>"3.3","max_rating"=>"5","competence"=>"Able to multi-task"],
            ["categoryCode"=>"003","count"=>"3.4","max_rating"=>"2","competence"=>"Copes well under pressure"],
        ];

        $competenceCategory4 = [
            ["categoryCode"=>"004","count"=>"4.0","max_rating"=>"10","competence"=>"Honesty and integrity"],
            ["categoryCode"=>"004","count"=>"4.1","max_rating"=>"10","competence"=>"Dependable and can be trusted"],
        ];

        $competenceCategory5 = [
            ["categoryCode"=>"005","count"=>"5.0","max_rating"=>"10","competence"=>"Personal appearance"],
            ["categoryCode"=>"005","count"=>"5.1","max_rating"=>"10","competence"=>"Personal appearance"],
        ];

        $competenceData = [$competenceCategory1, $competenceCategory2, $competenceCategory3,$competenceCategory4,$competenceCategory5];

        return $competenceData;

    }

    private static function getDirectorCompetences() {

        $competenceCategory1 = [
            ["categoryCode"=>"001","count"=>"1.0","max_rating"=>"20","competence"=>"Planning and organizing work"],
            ["categoryCode"=>"001","count"=>"1.1","max_rating"=>"4","competence"=>"Highly organized, prioritises work"],
            ["categoryCode"=>"001","count"=>"1.2","max_rating"=>"4","competence"=>"Translate vision to action"],
            ["categoryCode"=>"001","count"=>"1.3","max_rating"=>"4","competence"=>"Delegates effectively and monitors progress"],
            ["categoryCode"=>"001","count"=>"1.4","max_rating"=>"4","competence"=>"Goals set for staff and self are realistic"],
            ["categoryCode"=>"001","count"=>"1.5","max_rating"=>"4","competence"=>"Manages and monitors progress against targets"],
        ];

        $competenceCategory2 = [
            ["categoryCode"=>"002","count"=>"2.0","max_rating"=>"20","competence"=>"Leadership skills"],
            ["categoryCode"=>"002","count"=>"2.1","max_rating"=>"4","competence"=>"Always makes clear decisions and clarifies deadlines"],
            ["categoryCode"=>"002","count"=>"2.2","max_rating"=>"3","competence"=>"Gives clear constructive feedback and motivates staff"],
            ["categoryCode"=>"002","count"=>"2.3","max_rating"=>"3","competence"=>"Develop self and others (Mentoring)"],
            ["categoryCode"=>"002","count"=>"2.4","max_rating"=>"3","competence"=>"Skills and Knowledge transfer"],
            ["categoryCode"=>"002","count"=>"2.5","max_rating"=>"4","competence"=>"Generally has good people management skills"],
            ["categoryCode"=>"002","count"=>"2.6","max_rating"=>"3","competence"=>"Observes confidentiality and is very responsible and can be trusted with any work"],
        ];

        $competenceCategory3 = [
            ["categoryCode"=>"003","count"=>"3.0","max_rating"=>"20","competence"=>"Performance of activities"],
            ["categoryCode"=>"003","count"=>"3.1","max_rating"=>"4","competence"=>"Amount of work completed, accuracy and attention to detail e.g. reports"],
            ["categoryCode"=>"003","count"=>"3.2","max_rating"=>"2","competence"=>"Always ready to put in extra effort to meet deadlines without adversely affecting other tasks"],
            ["categoryCode"=>"003","count"=>"3.3","max_rating"=>"4","competence"=>"Understanding and creative application of technical and professional knowledge, skills and experience appropriate to the job"],
            ["categoryCode"=>"003","count"=>"3.4","max_rating"=>"3","competence"=>"Take initiative in areas of responsibility"],
            ["categoryCode"=>"003","count"=>"3.5","max_rating"=>"2","competence"=>"Manage pressure/stress positively"],
            ["categoryCode"=>"003","count"=>"3.6","max_rating"=>"3","competence"=>"Good judgment skills whereby sound and logical reasons are used in arriving at decisions and actions avoiding emotions to interfere with reasoning"],
            ["categoryCode"=>"003","count"=>"3.7","max_rating"=>"2","competence"=>"Attitude towards work"],
        ];

        $competenceCategory4 = [
            ["categoryCode"=>"004","count"=>"4.0","max_rating"=>"15","competence"=>"Team Based Performance"],
            ["categoryCode"=>"004","count"=>"4.1","max_rating"=>"4","competence"=>"Develops cohesive approaches to work"],
            ["categoryCode"=>"004","count"=>"4.2","max_rating"=>"2","competence"=>"Encourages and supports joint decision making and problem solving"],
            ["categoryCode"=>"004","count"=>"4.3","max_rating"=>"3","competence"=>"Work load sharing"],
            ["categoryCode"=>"004","count"=>"4.4","max_rating"=>"2","competence"=>"Promotes knowledge and information sharing"],
            ["categoryCode"=>"004","count"=>"4.5","max_rating"=>"2","competence"=>"Good at listening to and engaging team members"],
            ["categoryCode"=>"004","count"=>"4.6","max_rating"=>"2","competence"=>"Honest and harmonious in relationships with colleagues"],
        ];

        $competenceCategory5 = [
            ["categoryCode"=>"006","count"=>"5.0","max_rating"=>"10","competence"=>"Innovation, Creativity, enthusiasm and drive"],
            ["categoryCode"=>"006","count"=>"5.1","max_rating"=>"10","competence"=>"Able to think radically and present new ideas. Highly self motivated. Anxious to make progress in the face of difficulties and ability to work under pressure"],
        ];

        $competenceCategory6 = [
            ["categoryCode"=>"007","count"=>"6.0","max_rating"=>"15","competence"=>"Communication skills"],
            ["categoryCode"=>"007","count"=>"6.1","max_rating"=>"15","competence"=>"Presents information clearly and concisely orally and in writing"],
        ];

        $competenceData = [$competenceCategory1, $competenceCategory2, $competenceCategory3, $competenceCategory4,$competenceCategory5,$competenceCategory6];

        return $competenceData;
    }

}