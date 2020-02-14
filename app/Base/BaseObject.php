<?php


namespace Base;


class BaseObject
{
    protected $options = [];

    public function __construct(array $config)
    {
        $this->setOptions($config);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function __get(string $name)
    {
        if (isset($this->name)) {
            return $this->name;
        }

        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        $nameSnakeCase = self::snakeCase($name);
        if ($name != $nameSnakeCase && $option = $this->$nameSnakeCase) {
            return $option;
        }

        return null;
    }

    public static function snakeCase(string $input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}
