<?php

class DataObject
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function __get(string $name)
    {
        return (isset($this->data[$name])) ? $this->data[$name] : null;
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public function __unset(string $name): void
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }
}