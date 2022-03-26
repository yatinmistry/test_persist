<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    const UPLOAD_FOLDER = "uploads";
    public $validationErrors = [];
    /**
     * @var UploadedFile
     */
    public $importFile;

    public function rules()
    {
        return [
            [['importFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx, xls'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filePath = self::UPLOAD_FOLDER. '' . $this->importFile->baseName . '.' . $this->importFile->extension;
            $this->importFile->saveAs($filePath);

            // Load Excel Sheet Data
            $data = \moonland\phpexcel\Excel::import($filePath);

            $this->validateBulkImortData($data);

            return $data;
        } else {
            return false;
        }
    }

    private function checkDuplicateInUploadedSheet($currentKey, $currentRow, $uploadedData){

        $duplicateErrorMsg = "Duplicate Entry in Excel Sheet";
        foreach ($uploadedData as $key => $uploadedDataRow) {
            if($key == $currentKey){
                continue;
            }

            foreach ($currentRow as $field => $value){
                    if($uploadedDataRow[$field] == $value){

                        if (isset($this->validationErrors[$key][$field])) {
                            array_push($this->validationErrors[$key][$field],$duplicateErrorMsg);
                        }else{
                            $this->validationErrors[$key][$field] = [$duplicateErrorMsg];
                        }

                    }
            }
        }

    }

    public function validateBulkImortData($uploadedData){

        if($uploadedData && is_array($uploadedData)) {
            foreach ($uploadedData as $key=>$row) {
                $model = new RouterDetails();
                $model->attributes = $row;
                $validationErrors[$key] = "";
                if (!$model->validate()) {
                    $this->validationErrors[$key] = $model->errors;
                }
                $this->checkDuplicateInUploadedSheet($key,$row,$uploadedData);
            }
        }

        return $this->validationErrors ? false : true;
    }

    public function getRowError($key,$field) {
        $error = "";
        if(isset($this->validationErrors[$key][$field])){
            $error = "<span class='error-msg'>".implode(", ",array_unique($this->validationErrors[$key][$field]))."</span>";
        }
        return $error;
    }

    public function isDuplicateError($key) {
//        echo "<pre>";
//        print_r($this->validationErrors[$key]);
//        exit;
        if(isset($this->validationErrors[$key])){
            $errors = json_encode($this->validationErrors[$key]);
//            echo $errors;exit;
            if(false !== strpos($errors,"Duplicate")){
                return true;
            }
        }
        return false;
    }
}