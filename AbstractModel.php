<?php

class AbstractModel
{
    protected $_data = [];

    public function __construct(array $_data = [])
    {
        $this->_data = $_data;
    }

    public function getData($index = '')
    {
        if ($index === '') {
            return $this->_data;
        }

        return isset($this->_data[$index]) ? $this->_data[$index] : null;
    }

    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);
        switch ($action) {
            case 'get' :
                if ($arguments) {
                    return $this->getData($arguments[0]);
                }

                $key = strtolower(substr($name, 3));
                return $this->getData($key);
            case 'set' :

                $key = $arguments[0];
                $value = $arguments[1];
                $this->_data[$key] = $value;
                break;
            default :
                return false;
        }
    }
}