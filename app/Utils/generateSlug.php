<?php

namespace App\Utils;

use Normalizer;

return function (string $text): string {
    // Garantir que o título está em UTF-8
    $normalizadeText = mb_convert_encoding($text, 'UTF-8', 'UTF-8');

    // Normalizar a string para a forma D (NFD) do Unicode (equivalente a decompor acentos e caracteres especiais)
    $normalizadeText = Normalizer::normalize($normalizadeText, Normalizer::FORM_D);

    // Remover os caracteres diacríticos (acentos, cedilhas, etc.)
    $cleanedText = preg_replace('/\pM/u', '', $normalizadeText);

    // Converter a string para minúsculas
    $lowercaseText = strtolower($cleanedText);

    // Remover os caracteres não alfanuméricos (exceto espaços e hífens)
    $alphaNumericText = preg_replace('/[^\w\s-]/', '', $lowercaseText);

    // Substituir os espaços por hífens
    $slug = preg_replace('/[\s-]+/', '-', $alphaNumericText);

    // Remover os hífens duplicados
    $slug = preg_replace('/-+/', '-', $slug);

    // Remover os hífens no início e no final da string
    $slug = trim($slug, '-');

    return $slug;
};
