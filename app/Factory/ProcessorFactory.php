<?php


namespace Factory;


class ProcessorFactory
{
    public static function make(string $name, array $config): \Processor\AbstractProcessor
    {
        $name = strtolower($name);
        $className = '\\Processor\\'.ucfirst($name).'Processor';

        $config = $config['formats'][$name] ?? [];

        if (class_exists($className)) {
            return new $className($config);
        }

        throw new \Exception("Processor {$name} is not implemented");
    }
}
