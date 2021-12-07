<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Elements;

use RobinTheHood\PdfBuilder\Classes\Container\Container;
use RobinTheHood\PdfBuilder\Classes\Libs\Code128;

class Barcode extends Container
{
    /**
     * @var string $data
     */
    private $data = '';

    public function __construct()
    {
        parent::__construct();
        $this->setContainerRenderer(new BarcodeRenderer());
    }

    public function getData(): string
    {
        return $this->data;
    }

    public function setData(string $data): void
    {
        $this->data = $data;
    }

    public function getCode(): string
    {
        $code128 = new Code128();
        $code128->setData($this->data);
        return $code128->getCode();
    }
}
