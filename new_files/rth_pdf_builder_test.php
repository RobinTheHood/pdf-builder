<?php

use RobinTheHood\PdfBuilder\Classes\Tests\PdfBuilderTest;
use RobinTheHood\PdfBuilder\Classes\Tests\ContainerTest;

require_once 'includes/application_top.php';
require_once DIR_WS_CLASSES . 'order.php';
require_once DIR_FS_INC . 'xtc_format_price_order.inc.php';
require_once DIR_FS_INC . 'xtc_get_attributes_model.inc.php';
require_once DIR_FS_DOCUMENT_ROOT . '/vendor-no-composer/autoload.php';

restore_error_handler();
restore_exception_handler();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);

$pdfBuilderTest = new PdfBuilderTest();
$pdfBuilderTest->test3();

//$containerTest = new ContainerTest();
//$containerTest->test1();
