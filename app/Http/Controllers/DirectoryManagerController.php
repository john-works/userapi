<?php

namespace App\Http\Controllers;

use app\Helpers\AppConstants;
use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use simple_html_dom;
use simple_html_dom_node;

require  __DIR__.'/../../Helpers/simple_html_dom.php';

class DirectoryManagerController extends Controller
{
    protected $folderContents = [];

    public function getDirectoryStructure(){

        $backPaths = $this->getBackPaths('E:\SERVER_DOCUMENTS');

        $dir = Storage::disk('partitionE')->getDriver()->getAdapter()->applyPathPrefix('/');
        $directoryContent = $this->listFolderFiles($dir,[]);

        $active_module = AppConstants::$ACTIVE_MOD_DOC_LIBRARY;
        return view('documenttypes/directory_manager',compact('active_module','directoryContent','backPaths'));

    }

    function listFolderFiles($dir,array $container){

        $directoryIterator = new DirectoryIterator($dir);

        foreach ($directoryIterator as $fileInfo) {

            if (!$fileInfo->isDot()) {

                if ($fileInfo->isDir()) {
                    $folder = [];
                    $folder['name'] = $fileInfo->getFilename();
                    $folder['path'] = $fileInfo->getPathName();
                    $childrenContainer = $this->listFolderFiles($fileInfo->getPathname(),[]);
                    $folder['children'] = $childrenContainer;
                    $container[] = $folder;
                }else{
                    $file = [];
                    $file['name'] = $fileInfo->getFilename();
                    $file['extension'] = $fileInfo->getExtension();
                    $file['path'] = $fileInfo->getPath();
                    $container[] = $file;
                }
            }

        }

        return $container;

    }

    public function openDirectory(Request $request){

        $directory = $request['directory'];
        $backPaths = $this->getBackPaths($directory);

        $directoryWithOutRoot = str_replace('E:\SERVER_DOCUMENTS','',$directory);
        $directoryFormatted = str_replace('\\','/',$directoryWithOutRoot);

        $dir = Storage::disk('partitionE')->getDriver()->getAdapter()->applyPathPrefix($directoryFormatted);
        $directoryContent = $this->listFolderFiles($dir,[]);

        $active_module = AppConstants::$ACTIVE_MOD_DOC_LIBRARY;
        return view('documenttypes/directory_manager',compact('active_module','directoryContent','backPaths'));

    }

    private function getBackPaths($directory) {

        $pathResponse = [];
        $backPaths = explode('\\',$directory);
        $counter = 0;
        $fullPath = '';
        foreach ($backPaths as $path){

            $label = $counter <= 1 ? 'Root' : ucwords($path);
            $currentPath = [];
            $fullPath = $counter == 0 ? $fullPath.$path : $fullPath.'/'.$path;
            $currentPath['path'] = $fullPath;
            $currentPath['label'] = $label;

            if($counter != 0){
                $pathResponse[] = $currentPath;
            }

            $counter++;
        }

        return $pathResponse;

    }



    public function showForm(){

        $html = new simple_html_dom();
        $dir = Storage::disk('partitionE')->getDriver()->getAdapter()->applyPathPrefix('/Appraisal/PPDA Audit Claim Form.htm');
//        $dir = Storage::disk('partitionE')->getDriver()->getAdapter()->applyPathPrefix('/Appraisal/User Data.html');
        $html->load_file($dir);
        $form = $html->find('form')[0];
        $form->action = '/form_submission';
        $form->method = 'post';

        $formHtml = str_get_html($form);
        $lastChild =  $formHtml->childNodes(0)->lastChild();
        $lastChild->innertext  = $lastChild.str_get_html($this->htmlToGenerateSaveButton());
        $formHtml->save();
        $form->innertext = $formHtml;

        $html->save();


        return view('documenttypes.form_templates',compact('html'));

    }

    /**
     * @return string
     */
    private function htmlToGenerateSaveButton() {

        return <<<'TAG'
                <br>
                <div style="width: 100%"> 
                    <button type="submit" style="background-color:rgba(19,32,161,0.87);
                        padding: 10px;border: none;color: white;margin-top: 10px;margin-bottom: 10px">
                        Save Document
                    </button>
                </div>
TAG;

    }

}
