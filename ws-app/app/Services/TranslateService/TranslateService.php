<?php

namespace App\Services\TranslateService;

interface TranslateService
{
    public function translate(string $text, ?string $sourceLanguage, string $targetLanguage, ?array $options): array;
}
