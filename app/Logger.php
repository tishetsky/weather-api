<?php


class Logger
{
    protected static $instance;
    protected $messages = [];

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new static;
        }

        return self::$instance;
    }

    public function addMessage(string $message)
    {
        $this->messages[] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }
}
