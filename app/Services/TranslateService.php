<?php

namespace App\Services;

use App\Contact;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateService
{
    private $model;
    private $translate;

    /**
     * TranslateService constructor.
     * @param $model
     * @param $translate
     */
    public function __construct(Contact $model, GoogleTranslate $translate)
    {
        $this->model = $model;
        $this->translate = $translate;
    }

    public function translate()
    {
        $contacts = $this->model->get();
        foreach ($contacts as $contact) {
            $names = json_decode($contact['names']);
            $result = [];
            foreach ($names as $name) {
                $source = detectIfContactIsArabic($name);
                $target = $source == 'en' ? 'ar' : 'en';
                if (!$name)
                    continue;
                $translatedName = $this->translate->setSource($source)->setTarget($target)->translate($name);
                if (array_key_exists($translatedName, $result)) {
                    $hit = $result[$translatedName] + 1;
                    $result[$translatedName] = $hit;
                } else {
                    $result[$translatedName] = 1;
                }
            }
            $names = array_keys($result);
            $contact->update(['names' => $names, 'hits' => array_values($result)]);
        }
    }
}
