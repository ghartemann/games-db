<?php

namespace App\Service;

class Slugify
{
    public function generate(string $input): string
    {
        // changing "the" position
        if (str_contains($input, '(The)')) {
            $input = str_replace('(The)', '', $input);
            $input = 'The ' . $input;
        }

        $input = trim($input);

        $search = [
            'à',
            'é',
            'è',
            'ç',
            'ù',
            "'",
            '(',
            ')',
            '!',
            '?',
            ':',
            ',',
            ' ',
        ];

        $replace = [
            'a',
            'e',
            'e',
            'c',
            'u',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '-',
        ];

        // replacing all funky characters with normal ones
        $input = strtolower(str_replace($search, $replace, $input));

        // deleting double dashes
        while (str_contains($input, '--')) {
            str_replace('--', '-', $input);
        }

        return $input;
    }
}
