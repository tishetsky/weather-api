<?php


namespace Client;


use Processor\AbstractProcessor;


class BaseApiClient extends \Base\BaseObject
{
    protected $key;
    protected $url;
    protected $latitude;
    protected $longitude;
    protected $headers = [];
    protected $processor;

    protected function buildUrl() {
        return $this->options['api_url'];
    }

    public function setCoords($coords, $longitude = null)
    {
        if (!is_array($coords) && !$coords = explode(',', $coords)) {
            $coords = [$coords, $longitude];
        }

        [$this->latitude, $this->longitude] = $coords;
    }

    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    public function addHeader(string $header, string $value = null)
    {
        $this->headers[] = $value ? "{$header}: {$value}" : $header;
    }

    public function getResponse()
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->buildUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $result = curl_exec($ch);

        if ($result === false) {
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("curl error #{$errno} {$error}", $errno);
        }

        curl_close($ch);

        if ($this->processor instanceof AbstractProcessor) {
            $result = $this->processor->process($result, $this);
        }

        return $result;
    }

    public function setProcessor(AbstractProcessor $processor)
    {
        $this->processor = $processor;
    }

    public function restructureArray(array $array)
    {
        return $array;
    }

    public function getOption(string $name)
    {
        return $this->options[$name] ?? null;
    }
}
