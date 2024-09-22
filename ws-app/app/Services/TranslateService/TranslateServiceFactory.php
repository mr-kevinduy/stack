<?php

namespace App\Services\TranslateService;

use Exception;

class TranslateServiceFactory
{
    public static function make(string $provider): TranslateService
    {
        switch ($provider) {
            case 'aws':
                return new AwsTranslateService();

            case 'deepl':
                return new DeeplTranslateService();

            case 'google':
                return new GoogleTranslateService();

            default:
                throw new Exception("Invalid translation provider");

        }
    }
}
