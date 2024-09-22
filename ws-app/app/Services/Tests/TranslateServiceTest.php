<?php

namespace App\Services\Tests;

use App\Services\TranslateService\TranslateService;

// // Service Provider
// use App\Services\Translate\TranslateServiceFactory;
// $this->app->bind(TranslateService::class, function ($app) {
//     return TranslateServiceFactory::make(config('services.translation.default'));
// });

class TranslateServiceTest
{
    private $translateService;

    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function translate(Request $request)
    {
        $translations = $this->translateService->translate(
            $request->input('text'),
            $request->input('sourceLanguage'),
            $request->input('targetLanguage'),
        );

        return response()->json([
            'translations' => $translations,
        ]);
    }
}
