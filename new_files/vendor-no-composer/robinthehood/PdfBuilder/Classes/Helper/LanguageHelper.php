<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Helper;

class LanguageHelper
{
    public static function loadLanguageFile($language, $file)
    {
        // Versuche zuerst die Sprachdatei aus dem Template zu laden.
        $templateLangPath = DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/lang/' . $language . '/' . $file;
        if (\file_exists($templateLangPath)) {
            require_once $templateLangPath;
            return;
        }

        // Exsistiert die Sprachdatei im Template nicht, lade die Datei aus dem Lang-Ordner.
        $langPath = DIR_FS_CATALOG . 'lang/' . $language . '/' . $file;
        if (\file_exists($langPath)) {
            require_once $langPath;
        }
    }
}