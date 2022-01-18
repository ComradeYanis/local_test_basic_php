<?php

require_once('DataObject.php');

abstract class AbstractModel
{
    protected DataObject $dataObject;

    public function __construct(DataObject $dataObject = null)
    {
        if (!$dataObject) {
            $dataObject = new DataObject();
        }

        $this->dataObject = $dataObject;
    }

    public function getData($index = '')
    {
        if ($index === '') {
            return $this->dataObject->getData();
        }

        return $this->dataObject->$index;
    }

    public function __get(string $name)
    {
        return $this->getData($name);
    }

    public function __set(string $name, $value): void
    {
        $this->dataObject->$name = $value;
    }

    public function __unset(string $name): void
    {
        if ($this->dataObject->$name !== null) {
            $this->dataObject->__unset($name);
        }
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

                $key = strtolower(substr($name, 3));

                if ($key == 'data' && count($arguments) == 2) {
                    $key = $arguments[0];
                    $value = $arguments[1];
                } else {
                    $value = array_shift($arguments);
                }
                if (is_array($value)) {
                    foreach ($value as $valueKey => $valueData) {
                        $this->dataObject->$valueKey = $valueData;
                    }
                } else {
                    $this->dataObject->$key = $value;
                }
                break;
            default :
                return false;
        }
    }
}