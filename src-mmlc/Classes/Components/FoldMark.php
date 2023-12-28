<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Components;

use RobinTheHood\PdfBuilder\Classes\Container\Container;

class FoldMark extends Container
{
    public function __construct()
    {
        parent::__construct();
        $this->setContainerRenderer(new FoldMarkRenderer());
    }
}
