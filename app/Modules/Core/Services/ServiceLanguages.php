<?php
namespace App\Modules\Core\Services;

use Illuminate\Support\Facades\Validator;

abstract class ServiceLanguages extends Service {
    protected $_rulesTranslations = [];

    protected function validate($data) {
        $translationData = isset($data["translations"]) ? $data["translations"] : null;
        $this->validateData($data);

        if($translationData != null) {
            $this->validateDataTranslations($translationData);
        }
    }

    private function validateData($data, $rules = null) {
        if($rules == null) {
            $rules = $this->_rules;
        }

        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            $this->_errors->merge($validator->errors());
            return;
        }
    }

    private function validateDataTranslations($data) {
        foreach($data as $translation) {
            $this->validateDataTranslation($translation);
        }
    }

    private function validateDataTranslation($data) {
        return $this->validateData($data, $this->_rulesTranslations);
    }
}