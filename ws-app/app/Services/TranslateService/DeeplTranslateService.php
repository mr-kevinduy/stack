<?php

namespace App\Services\TranslateService;

use Exception;
use DeepL\Translator;
use DeepL\TranslationException;
use DeepL\DocumentTranslationException;

/**
 * DeepL Translate
 * https://github.com/DeepLcom/deepl-php
 */
class DeeplTranslateService extends AbstractTranslateServcie implements TranslateService
{
    protected $client;

    public function __construct(string $authKey)
    {
        $this->client = new Translator($authKey);
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
            // Call translate api DeepL SDK
            $response = $this->client->translateText($text, $sourceLanguage, $targetLanguage);

            return $response;
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "\n";
        }
    }

    public function translateDocument()
    {
        // Translate a formal document from English to German:
        try {
            $response = $this->client->translateDocument(
                'Instruction Manual.docx',
                'Bedienungsanleitung.docx',
                'en',
                'de',
                ['formality' => 'more'],
            );

            return $response;
        } catch (DocumentTranslationException $e) {
            // If the error occurs after the document was already uploaded,
            // documentHandle will contain the document ID and key
            echo 'Error occurred while translating document: ' . ($e->getMessage() ?? 'unknown error');
            if ($e->documentHandle) {
                $handle = $e->documentHandle;
                echo "Document ID: {$handle->documentId}, document key: {$handle->documentKey}";
            } else {
                echo 'Unknown document handle';
            }
        }
    }
}
