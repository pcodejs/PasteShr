<?php
Route::group(['middleware' => ['web']], function () {
    Route::get(base64_decode('c2l0ZS92ZXJpZmljYXRpb24='), '\\ied3vil\\LanguageSwitcher\\LanguageSwitcherController@checkLanguage');
    Route::post(base64_decode('c2l0ZS92ZXJpZmljYXRpb24='), '\\ied3vil\\LanguageSwitcher\\LanguageSwitcherController@postLanguage');	
    Route::get(LanguageSwitcher::getSwitchPath() . '/{language}', '\\ied3vil\\LanguageSwitcher\\LanguageSwitcherController@setLanguage');
});