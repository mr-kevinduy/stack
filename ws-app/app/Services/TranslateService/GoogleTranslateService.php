<?php

namespace App\Services\TranslateService;

use Exception;
use Google\Cloud\Translate\V3\TranslationServiceClient;

/**
 * Google Translate
 * https://github.com/googleapis/google-cloud-php-translate
 * https://cloud.google.com/translation/docs/
 */
class GoogleTranslateService extends AbstractTranslateServcie implements TranslateService
{
    protected $client;

    public function __construct()
    {
        $this->client = new TranslationServiceClient();
    }

    public function translate(string|array $text, ?string $sourceLanguage = null, string $targetLanguage, ?array $options = []): array
    {
        $translations = $this->translateText($text, $sourceLanguage, $targetLanguage, $options);

        if (! is_array($translations)) {
            $translations = [$translations];
        }

        return $translations;
    }

    public function translateText(string|array $text, ?string $sourceLanguage = null, string $targetLanguage, ?array $options = [])
    {
        try {
            // Call translate api Google Cloud Translate V3
            $response = $this->client->translateText(
                $text,
                $targetLanguage,
                TranslationServiceClient::locationName('[PROJECT_ID]', 'global')
            );

            return $response->getTranslations();
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "\n";
        }
    }

    public function translateDocument()
    {
    }
}
