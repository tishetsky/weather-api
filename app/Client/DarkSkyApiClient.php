<?php


namespace Client;


class DarkSkyApiClient extends BaseApiClient
{
    protected $urlTemplate;

    public function buildUrl()
    {
        return strtr($this->api_url, [
            ':key' => $this->api_key,
            ':latitude' => $this->latitude,
            ':longitude' => $this->longitude,
        ]);
    }

    public function restructureArray(array $array)
    {
        foreach ($array['currently'] as $key => $value) {
            $array[$key] = $value;
        }

        unset($array['currently']);

        return $array;
    }
}
