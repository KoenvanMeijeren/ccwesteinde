<?php


namespace App\contracts;

interface Parser
{
    public function parse(string $input): array;
}
