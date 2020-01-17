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
            $hits = json_decode($contact['hits']);
            $result = [];
            $translatedNamesBefore = [];
            foreach ($names as $key => $name) {
                $source = detectContactLanguage($name);
                $target = $source == 'en' ? 'ar' : 'en';
                if (!$name)
                    continue;
                /*CHECK IF NAME TRANSLATED BEFORE*/
                if (array_key_exists($name, $translatedNamesBefore)) {
                    $translatedName =  $translatedNamesBefore[$name];

                } else {
                    $translatedName  = $this->translate->setSource($source)->setTarget($target)->translate($name);
                    $translatedNamesBefore[$name] = $translatedName;
                }
                $result[] = $translatedName;

                /* INCREMENT HITS BY 1*/
                $hit = $hits[$key] + 1;

                $newHits[] = $hit;
            }

            $contact->update(['translated_names' => $result, 'hits' => $newHits]);
        }
    }
}
