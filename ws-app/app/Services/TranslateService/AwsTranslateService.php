<?php

namespace App\Services\TranslateService;

use Aws\Exception\AwsException;
use Aws\Translate\TranslateClient;

class AwsTranslateService extends AbstractTranslateService implements TranslateService
{
    protected $client;

    public function __construct()
    {
        $this->client = new TranslateClient([
            'profile' => config('services.translation.aws.profile'),
            'region' => config('services.translation.aws.region'),
            'version' => config('services.translation.aws.version')
        ]);
    }

    public function translate(string $text, ?string $sourceLanguage = null, string $targetLanguage, ?array $options = []): array
    {
        $translations = $this->translateText($text, $sourceLanguage, $targetLanguage, $options);

        if (! is_array($translations)) {
            $translations = [$translations];
        }

        return $translations;
    }

    public function translateText(string $text, ?string $sourceLanguage = null, string $targetLanguage, ?array $options = [])
    {
        try {
            // Call translate api AWS SDK
            $response = $this->client->translateText([
                'SourceLanguageCode' => $sourceLanguage,
                'TargetLanguageCode' => $targetLanguage,
                'Text' => $text,
            ]);

            return $response;
        } catch (AwsException $e) {
            echo $e->getMessage();
            echo "\n";
        }
    }

    public function translateDocument()
    {
    }
}
