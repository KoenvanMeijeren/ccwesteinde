<?php


namespace App\services\parsers;

use App\contracts\Parser;

class CsvParser implements Parser
{
    const OPTION_CONTAINS_HEADER = true;
    const OPTION_CONTAINS_NO_HEADER = false;

    /**
     * Shall the header line be skipped?
     *
     * @var bool
     */
    private $_skipHeaderLine;

    /**
     * Set the skipHeaderLine bool.
     *
     * @param bool $skipHeaderLine Shall the header line be skipped?
     */
    public function __construct(bool $skipHeaderLine)
    {
        $this->_skipHeaderLine = $skipHeaderLine;
    }

    /**
     * Parse the csv input into an array.
     *
     * @param string $input The input to be parsed.
     *
     * @return array
     */
    public function parse(string $input): array
    {
        $parsedLines = [];

        foreach (explode(PHP_EOL, $input) as $line) {
            if ($this->_skipHeaderLine === self::OPTION_CONTAINS_HEADER) {
                continue;
            }

            $parsedLines[] = str_getcsv($line);
        }

        return $parsedLines;
    }
}
