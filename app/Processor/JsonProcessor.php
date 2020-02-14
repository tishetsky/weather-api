<?php


namespace Processor;


class JsonProcessor extends AbstractProcessor
{
    protected $filetype = 'json';

    protected function fromArray(array $array): string
    {
        return json_encode($array, JSON_PRETTY_PRINT);
    }
}
