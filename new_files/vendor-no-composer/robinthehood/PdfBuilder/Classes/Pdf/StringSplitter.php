<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class StringSplitter
{
    public static function splitByLength(Pdf $pdf, string $string, float $maxLength): array
    {
        preg_match_all("/[\S]+|\n/", $string, $words);
        $words = $words[0];

        // Teile Wörter die länger sind als $maxLength;
        foreach ($words as $word) {
            $lineLength = $pdf->GetStringWidth($word);
            if ($lineLength < $maxLength) {
                $parts[] = ['space' => ' ', 'word' => $word];
            } else {
                $maxCount = (int) (strlen($word) / $lineLength * $maxLength);
                $word1 = substr($word, 0, $maxCount);
                $word2 = substr($word, $maxCount);
                $parts[] = ['space' => '-', 'word' => $word1];
                $parts[] = ['space' => ' ', 'word' => $word2];
            }
        }

        $lines = [];
        $line = '';
        foreach ($parts as $part) {
            $word = $part['word'];
            $space = $part['space'];

            if ($word == "\n") {
                $lines[] = trim($line);
                $line = '';
                continue;
            }

            $lineLength = $pdf->GetStringWidth($line . $word);
            if ($lineLength < $maxLength) {
                $line .= $word . $space;
            } else {
                $lines[] = trim($line);
                $line = $word . $space;
            }
        }
        $lines[] = trim($line);
        return $lines;
    }
}
