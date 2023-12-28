<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Container;

class ContainerValue
{
    public const UNIT_UNCHANGED = 0;
    public const UNIT_PIXEL = 1;
    public const UNIT_PERCENT = 2;
    public const UNIT_AUTO = 3;

    private $value = 0;
    private $isSet = false;
    private $unit = self::UNIT_PIXEL;

    public function getValue(): float
    {
        return $this->value;
    }

    public function getUnit(): float
    {
        return $this->unit;
    }

    public function isSet(): bool
    {
        return $this->isSet;
    }

    public function set(float $value, $unit = self::UNIT_PIXEL): void
    {
        $this->setValue($value);
        $this->setUnit($unit);
    }

    public function setValue(float $value): void
    {
        $this->value = $value;
        $this->isSet = true;
    }

    public function setUnit(int $unit): void
    {
        $this->unit = $unit;
    }

    public function copy(): ContainerValue
    {
        $containerValue = new ContainerValue();
        $containerValue->value = $this->value;
        $containerValue->isSet = $this->isSet;
        $containerValue->unit = $this->unit;
        return $containerValue;
    }
}
