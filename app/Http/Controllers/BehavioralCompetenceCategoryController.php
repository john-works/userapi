<?php

namespace App\Http\Controllers;

use app\Helpers\AppConstants;
use app\Helpers\DataLoader;
use app\Helpers\Security;
use app\Helpers\SharedCommons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class BehavioralCompetenceCategoryController extends Controller
{

    public function all($deleteMessage = null){

        try{

            $token = Cookie::get(Security::$COOKIE_TOKEN);

            $resp = DataLoader::getBehaviorCompetenceCategories($token);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
            }
            $categories = $resp->result;

            $resp1 = DataLoader::getOrganizations();
            $resp2 = DataLoader::getEmployeeCategories();

            $organizations = $resp1->statusCode != AppConstants::$STATUS_CODE_SUCCESS ? [] : $resp1->result;
            $employeeCategories = $resp2->statusCode != AppConstants::$STATUS_CODE_SUCCESS ? [] : $resp2->result;

            $user = session(Security::$SESSION_USER);

            return view('behavioral-competences.behavioral-competences-cat-list',compact('categories','user','organizations','employeeCategories','deleteMessage'));

        }catch (\Exception $exception){

            return $this->redirectBackToFormWithError(AppConstants::generalError($exception->getMessage()));

        }

    }


    public function save(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'competence_category' => 'required|min:2',
                'max_rating' => 'required|numeric'
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'category' => $request['competence_category'],
                    'max_rating' => $request['max_rating']
                ];

            $resp = DataLoader::saveBehavioralCompetenceCategory($data);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY SAVED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function update(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'competence_category' => 'required|min:2',
                'max_rating' => 'required|numeric',
                'record_id' => 'required',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'category' => $request['competence_category'],
                    'max_rating' => $request['max_rating'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveBehavioralCompetenceCategory($data,true,$identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function delete(Request $request){

        try{

            $identifier = $request['id'];

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteBehavioralCompetenceCategoryByAdmin([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
            }

            /*
             * Return to the form create page with a success message
             * */
            $successMessage = "COMPETENCE CATEGORY SUCCESSFULLY DELETED";
            return $this->all($successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Competence Category With Error. ".AppConstants::generalError($exception->getMessage());
            return $this->redirectBackToFormWithError($errorMessage);

        }


    }


    /**
     * @param $error
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBackToFormWithError($error) {

        return redirect()->back()->withErrors(SharedCommons::customFormError($error))->withInput();

    }


    public function getCompetenceCategoryCompetences($id, $deletionMessage = null){

        try{

            $resp = DataLoader::getBehavioralCompetencesForACompetenceCategory($id);
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->redirectBackToFormWithError($resp->statusDescription);
            }
            $competences = $resp->result;

            $user = session(Security::$SESSION_USER);
            $competenceCategoryId = $id;

            return view('behavioral-competences.behavioral-competences-list',compact('competences','user','competenceCategoryId','deletionMessage'));

        }catch (\Exception $exception){

            return $this->redirectBackToFormWithError(AppConstants::generalError($exception->getMessage()));

        }

    }


    public function saveCompetence(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'competence' => 'required|min:2',
                'rating' => 'required|numeric',
                'competence_category_id' => 'required',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'competence' => $request['competence'],
                    'maximum_score' => $request['rating'],
                    'category_code' => $request['competence_category_id'],
                ];

            $resp = DataLoader::saveBehavioralCompetence($data);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY SAVED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function updateCompetence(Request $request){

        try{

            //check if request us ajax
            if(!$request->ajax()){
                return response()->json(['error' => [AppConstants::$MSG_BAD_REQUEST_JSON_EXPECTED]], 403);
            }

            //validate request
            $validator = Validator::make($request->all(), [
                'competence' => 'required|min:2',
                'rating' => 'required|numeric',
                'competence_category_id' => 'required',
                'record_id' => 'required',
            ]);

            //failed validation
            if (!$validator->passes()) {
                return response()->json(['error'=>$validator->errors()->all()]);
            }

            //send request to API
            $data =
                [
                    'competence' => $request['competence'],
                    'maximum_score' => $request['rating'],
                    'category_code' => $request['competence_category_id'],
                ];

            $identifier = $request['record_id'];
            $resp = DataLoader::saveBehavioralCompetence($data,true,$identifier);

            // Error occurred on sending the request
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return response()->json(['error' => [$resp->statusDescription]]);
            }

            $successMessage = "RECORD SUCCESSFULLY UPDATED";
            return response()->json(['success' => $successMessage]);

        }catch (\Exception $exception){
            return response()->json(['error' => [AppConstants::generalError($exception->getMessage())]]);
        }

    }


    public function deleteCompetence(Request $request){

        try{

            $identifier = $request['id'];
            $categoryId = $request['categoryId'];

            /*
             * Send request to the API
             * */
            $resp = DataLoader::deleteBehavioralCompetenceByAdmin([],$identifier);

            /*
             * Error occurred on sending the request
             * */
            if($resp->statusCode != AppConstants::$STATUS_CODE_SUCCESS){
                return $this->getCompetenceCategoryCompetences($categoryId,$resp->statusDescription);
            }

            /*
             * Return to the form create page with a success message
             * */
            $successMessage = "COMPETENCE SUCCESSFULLY DELETED";
            return $this->getCompetenceCategoryCompetences($categoryId,$successMessage);


        }catch (\Exception $exception){

            /*
             * We should log the error message we have got
             * */
            $errorMessage = "Failed To Delete Competence With Error. ".AppConstants::generalError($exception->getMessage());
            return $this->getCompetenceCategoryCompetences($categoryId,$errorMessage);

        }

    }


}
