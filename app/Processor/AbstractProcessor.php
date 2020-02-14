<?php


namespace Processor;


use Client\BaseApiClient;


abstract class AbstractProcessor extends \Base\BaseObject
{
    protected $filetype = null;

    abstract protected function fromArray(array $array): string;

    public function process(string $string, BaseApiClient $apiClient): string
    {
        $result = $string;

        if ($array = $this->toArray($string)) {
            $array = $apiClient->restructureArray($array);
            $array = $this->reorderFields($array, $apiClient->getOption('response_fields'));
            $result = $this->fromArray($array);

            if (!empty($this->options['write_file'])) {
                $this->toFile($result);
            }
        }

        return $result;
    }

    protected function reorderFields(array $array, array $responseFields = [])
    {
        if (empty($responseFields)) {
            return $array;
        }

        $newArray = [];

        foreach ($this->fieldsOrder as $key) {
            if (!isset($array[$key])) {
                $key = $responseFields[$key];
                if (!isset($array[$key])) {
                    continue;
                }
            }

            $newArray[$key] = $array[$key];
        }

        return array_merge($newArray, $array);
    }

    protected function toArray(string $string): array
    {
        if ($array = json_decode($string, true)) {
            return $array;
        }

        if ($array = (array) simplexml_load_string($string, null, LIBXML_NOCDATA)) {
            return $array;
        }

        return [];
    }

    protected function toFile(string $string)
    {
        $datadir = $this->options['datadir'] ?? null;

        if (empty($datadir)) {
            throw new \Exception("Datadir is not set in " . self::class);
        }

        if (!is_writable($datadir)) {
            throw new \Exception("Directory {$datadir} is not writable");
        }

        $filepath = $this->getFilePath($datadir);

        if (!file_put_contents($filepath, $string)) {
            throw new \Exception("Failed to write data to {$filepath}");
        }

        \Logger::getInstance()->addMessage(sprintf("%s: Wrote to %s",static::class, $filepath));

        return $filepath;
    }

    protected function getFilePath(string $dirname)
    {
        $filename = $this->options['filename'] ?? date('Y-m-d His');

        return sprintf('%s%s%s.%s', $dirname, DIRECTORY_SEPARATOR, $filename, $this->filetype);
    }
}
