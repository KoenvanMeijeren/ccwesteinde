<?php


namespace App\services\parsers;

class ParserFactory
{
    /**
     * Create a new JsonParser().
     *
     * @return JsonParser
     */
    public function createJsonParser(): JsonParser
    {
        return new JsonParser();
    }

    /**
     * Create a new CsvParser().
     *
     * @param bool $skipHeaderLine Shall the header be skipped?
     *
     * @return CsvParser
     */
    public function createCsvParser(bool $skipHeaderLine): CsvParser
    {
        return new CsvParser($skipHeaderLine);
    }
}
