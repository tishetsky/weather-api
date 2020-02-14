<?php


namespace Processor;


class XmlProcessor extends AbstractProcessor
{
    protected $filetype = 'xml';

    protected function fromArray(array $array): string
    {
        self::arrayToXml($array, $xmle);

        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xmle->asXML());

        return $dom->saveXML();
    }

    private static function arrayToXml(array $array, & $xmle)
    {
        if (!$xmle instanceof \SimpleXMLElement) {
            $xmle = new \SimpleXMLElement('<?xml version="1.0"?><data></data>');
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key;
                }

                $node = $xmle->addChild($key);
                self::arrayToXml($value, $node);
            } else {
                $xmle->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}
