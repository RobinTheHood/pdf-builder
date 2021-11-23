<?php

use RobinTheHood\PdfBuilder\Classes\Tests\PdfBuilderTest;

require_once 'includes/application_top.php';
require_once DIR_FS_DOCUMENT_ROOT . '/vendor-no-composer/autoload.php';

restore_error_handler();
restore_exception_handler();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

$pdfBuilderTest = new PdfBuilderTest();
$pdfBuilderTest->test1();
