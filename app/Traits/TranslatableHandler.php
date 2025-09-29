<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



trait TranslatableHandler
{
/**
 * Translates the given 
 */
    public function saveModelTranslation(Model $model, $data) :void
    {
  
        // get support Language 
        $languageKeys = collect(LaravelLocalization::getSupportedLocales() )->keys()->toArray();

        // filter data and get the tranlation data only  
        $translateData = array_filter($data, function($v) use ($languageKeys) {
            return in_array($v, $languageKeys);
        }, ARRAY_FILTER_USE_KEY);

        // save translate data 
        foreach($translateData as $key => $transData){
            $transData['locale'] = $key;  // save data languuage in locale
            $transData[$model->getTranslationForeignKey()] = $model->id; // save id in model translate

            if($model->trans->where('locale', $key)->first() == null){
                $model->trans()->create($transData); //save data translate
            }
            else{
                $model->trans->where('locale', $key)->first()->update($transData); //update data translate
            }
        }
    }

}