<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Tests;

use RobinTheHood\PdfBuilder\Classes\Templates\Letter;
use RobinTheHood\PdfBuilder\Classes\Templates\Bill;
use RobinTheHood\PdfBuilder\Classes\Templates\ComponentTest;

class PdfBuilderTest
{
    public function test2(): void
    {
        $letter = new Letter();
        $letter->render();
    }

    public function test3(): void
    {
        $letter = new Bill();
        $letter->render();
    }

    public function test4(): void
    {
        $letter = new ComponentTest();
        $letter->render();
    }
}
