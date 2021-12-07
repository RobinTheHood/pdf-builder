<?php

declare(strict_types=1);

namespace RobinTheHood\PdfBuilder\Classes\Libs;

/**
 *
 * @package     Barcode Creator
 * @copyright   (c) 2021 Robin Wieschendorf
 * @copyright   (c) 2011 emberlabs.org
 * @license     http://opensource.org/licenses/mit-license.php The MIT License
 *
 */

class Code128
{
    public const TYPE_AUTO = 0; // Automatically detect the best code
    public const TYPE_A = 1;    // ASCII 00-95 (0-9, A-Z, Control codes, and some special chars)
    public const TYPE_B = 2;    // ASCII 32-127 (0-9, A-Z, a-z, special chars)
    public const TYPE_C = 3;

    /**
     * @var string data - to be set
     */
    private $data = '';

    /**
     * Sub Type encoding
     * @var int (should be a class constant)
     */
    private $type = self::TYPE_AUTO;

    private static $barMap = [
        11011001100, 11001101100, 11001100110, 10010011000, 10010001100, // 4 (end)
        10001001100, 10011001000, 10011000100, 10001100100, 11001001000, // 9
        11001000100, 11000100100, 10110011100, 10011011100, 10011001110, // 14
        10111001100, 10011101100, 10011100110, 11001110010, 11001011100, // 19
        11001001110, 11011100100, 11001110100, 11101101110, 11101001100, // 24
        11100101100, 11100100110, 11101100100, 11100110100, 11100110010, // 29
        11011011000, 11011000110, 11000110110, 10100011000, 10001011000, // 34
        10001000110, 10110001000, 10001101000, 10001100010, 11010001000, // 39
        11000101000, 11000100010, 10110111000, 10110001110, 10001101110, // 44
        10111011000, 10111000110, 10001110110, 11101110110, 11010001110, // 49
        11000101110, 11011101000, 11011100010, 11011101110, 11101011000, // 54
        11101000110, 11100010110, 11101101000, 11101100010, 11100011010, // 59
        11101111010, 11001000010, 11110001010, 10100110000, 10100001100, // 64
        10010110000, 10010000110, 10000101100, 10000100110, 10110010000, // 69
        10110000100, 10011010000, 10011000010, 10000110100, 10000110010, // 74
        11000010010, 11001010000, 11110111010, 11000010100, 10001111010, // 79
        10100111100, 10010111100, 10010011110, 10111100100, 10011110100, // 84
        10011110010, 11110100100, 11110010100, 11110010010, 11011011110, // 89
        11011110110, 11110110110, 10101111000, 10100011110, 10001011110, // 94
        10111101000, 10111100010, 11110101000, 11110100010, 10111011110, // 99
        10111101110, 11101011110, 11110101110, 11010000100, 11010010000, // 104
        11010011100, 1100011101011 // 106 (last char, also one bit longer)
    ];

    /**
     * This map takes the charset from subtype A and PHP will index the array
     * natively to the matching code from the barMap.
     * @var array $mapA
     */
    private static $mapA = [
        ' ', '!', '"', '#', '$', '%', '&', "'", '(', ')', // 9 (end)
        '*', '+', ',', '-', '.', '/', '0', '1', '2', '3', // 19
        '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', // 29
        '>', '?', '@', 'A', 'B', 'C', 'D', 'E', 'F', 'G', // 39
        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', // 49
        'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '[', // 59
        '\\', ']', '^', '_', // 63 (We're going into the weird bytes next)

        // Hex is a little more concise in this context
        "\x00", "\x01", "\x02", "\x03", "\x04", "\x05", // 69
        "\x06", "\x07", "\x08", "\x09", "\x0A", "\x0B", // 75
        "\x0C", "\x0D", "\x0E", "\x0F", "\x10", "\x11", // 81
        "\x12", "\x13", "\x14", "\x15", "\x16", "\x17", // 87
        "\x18", "\x19", "\x1A", "\x1B", "\x1C", "\x1D", // 93
        "\x1E", "\x1F", // 95

        // Now for system codes
        'FNC_3', 'FNC_2', 'SHIFT_B', 'CODE_C', 'CODE_B', // 100
        'FNC_4', 'FNC_1', 'START_A', 'START_B', 'START_C', // 105
        'STOP', // 106
    ];

    /**
     * Same idea from MapA applied here to B.
     * @var array $mapB
     */
    private static $mapB = [
        ' ', '!', '"', '#', '$', '%', '&', "'", '(', ')', // 9 (end)
        '*', '+', ',', '-', '.', '/', '0', '1', '2', '3', // 19
        '4', '5', '6', '7', '8', '9', ':', ';', '<', '=', // 29
        '>', '?', '@', 'A', 'B', 'C', 'D', 'E', 'F', 'G', // 39
        'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', // 49
        'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '[', // 59
        '\\', ']', '^', '_', '`', 'a', 'b', 'c', 'd', 'e', // 69
        'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', // 79
        'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', // 89
        'z', '{', '|', '}', '~', "\x7F", // 95

        // Now for system codes
        'FNC_3', 'FNC_2', 'SHIFT_A', 'CODE_C', 'FNC_4', // 100
        'CODE_A', 'FNC_1', 'START_A', 'START_B', 'START_C', // 105
        'STOP', // 106
    ];

    /**
     * Map C works a little different. The index is the value when the mapping
     * occors.
     * @var array $mapC
     */
    private static $mapC = [
        100 => 'CODE_B', 'CODE_A', 'FNC_1', 'START_A', 'START_B',
        'START_C', 'STOP', // 106
    ];

    /**
     * Set the data
     *
     * @param mixed data - (int or string) Data to be encoded
     * @return instance of \emberlabs\Barcode\BarcodeInterface
     * @return throws \OverflowException
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Set the subtype
     * Defaults to Autodetect
     * @param int type - Const flag for the type
     */
    public function setSubType(int $type): void
    {
        if ($type == self::TYPE_A) {
            $this->type == self::TYPE_A;
        } elseif ($type == self::TYPE_B) {
            $this->type == self::TYPE_B;
        } elseif ($type == self::TYPE_C) {
            $this->type == self::TYPE_C;
        }
        $this->type == self::TYPE_AUTO;
    }

    /**
     * Get they key (value of the character)
     * @return int - pattern
     */
    private function getKey(string $char): int
    {
        switch ($this->type) {
            case self::TYPE_A:
                return array_search($char, self::$mapA);
                break;

            case self::TYPE_B:
                return array_search($char, self::$mapB);
                break;

            case self::TYPE_C:
                $charInt = (int) $char;
                if (strlen($char) == 2 && $charInt <= 99 && $charInt >= 0) {
                    return $charInt;
                }

                return array_search($char, self::$mapC);
                break;

            default:
                $this->resolveSubtype();
                return $this->getKey($char); // recursion!
                break;
        }
    }

    /**
     * Get the bar
     * @return int - pattern
     */
    private function getBar($char): int
    {
        $key = $this->getKey($char) ?? 0;
        //$key = $key !== false ? $key : 0;
        return self::$barMap[$key];
    }

    /**
     * Resolve subtype
     * @todo - Do some better charset checking and enforcement
     * @return void
     */
    private function resolveSubtype(): void
    {
        if ($this->type != self::TYPE_AUTO) {
            //return $this->type;
        }

        if (is_numeric($this->data)) { // If it is purely numeric, this is easy
            $this->type = self::TYPE_C;
        } elseif (strtoupper($this->data) == $this->data) { // Are there only capitals?
            $this->type = self::TYPE_A;
        } else {
            $this->type = self::TYPE_B;
        }
    }

    /**
     * Get the name of a start char fr te current subtype
     * @return string
     */
    private function getStartChar(): string
    {
        $this->resolveSubtype();

        switch ($this->type) {
            case self::TYPE_A:
                return 'START_A';
                break;
            case self::TYPE_B:
                return 'START_B';
                break;
            case self::TYPE_C:
                return 'START_C';
                break;
        }
    }

    public function getCode(): string
    {
        $this->resolveSubtype();
        $charAry = str_split($this->data);

        if ($this->type == self::TYPE_C) {
            $charAry = $this->convertArrayToTypeC($charAry);
        }

        // Add the start
        array_unshift($charAry, $this->getStartChar());

        // Checksum collector
        $checkSumCollector = $this->getKey($this->getStartChar());

        $resultCode = '';
        foreach ($charAry as $index => $char) {
            $code = $this->getBar($char);
            $checkSumCollector += $this->getKey($char) * $index; // $index will be 0 for our first
            $resultCode .= $code;
        }

        $resultCode .= self::$barMap[$checkSumCollector % 103];
        $resultCode .= self::$barMap[106]; // STOP.

        return $resultCode;
    }

    private function convertArrayToTypeC(array $charArray): array
    {
        if (sizeof($charArray) % 2) {
            array_unshift($charArray, '0');
        }

        $pairs = '';
        $newArray = [];
        foreach ($charArray as $k => $char) {
            if (($k % 2) == 0 && $k != 0) {
                $newArray[] = $pairs;
                $pairs = '';
            }
            $pairs .= $char;
        }

        $newAry[] = $pairs;
        return $newAry;
    }
}
