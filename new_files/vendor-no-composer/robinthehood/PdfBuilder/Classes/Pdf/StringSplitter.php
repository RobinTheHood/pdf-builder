<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Pdf;

class StringSplitter
{
    /**
     * @var String fontFamily
     */
    private $fontFamily = 'DejaVu';

    /**
     * @var StringSplitter $stringSplitter
     */
    private static $stringSplitter = null;

    /**
     * @var Pdf pdf
     */
    private $pdf = null;

    private function __construct()
    {
        $this->pdf = new Pdf();
        $this->pdf->AddFont($this->fontFamily, '', 'DejaVuSansCondensed.ttf', true);
        $this->pdf->AddFont($this->fontFamily, 'B', 'DejaVuSansCondensed-Bold.ttf', true);
    }

    public static function getStringSplitter(): StringSplitter
    {
        if (!self::$stringSplitter) {
            self::$stringSplitter = new StringSplitter();
        }
        return self::$stringSplitter;
    }

    public function splitByLength(string $string, float $maxLength, string $fontFamily, string $fontStyle, float $fontSize): array
    {
        $this->pdf->SetFont($fontFamily, $fontStyle, $fontSize);

        preg_match_all("/[\S]+|\n/", $string, $words);
        $words = $words[0];

        // Teile Wörter die länger sind als $maxLength;
        foreach ($words as $word) {
            $lineLength = $this->pdf->GetStringWidth($word);
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

            $lineLength = $this->pdf->GetStringWidth($line . $word);
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
