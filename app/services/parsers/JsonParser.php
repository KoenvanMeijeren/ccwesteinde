<?php


namespace App\services\parsers;

use App\contracts\Parser;

class JsonParser implements Parser
{
    /**
     * Parse the input into json.
     *
     * @param mixed $input The input to be encoded.
     *
     * @return string
     */
    public function encode($input)
    {
        $encoded = json_encode($input);
        return is_string($encoded) ? $encoded : '';
    }

    /**
     * Parse the json input into mixed.
     *
     * @param string $input The input to be parsed.
     *
     * @return array
     */
    public function parse(string $input): array
    {
        return json_decode($input, true);
    }
}
