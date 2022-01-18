<?php

require_once ('AbstractModel.php');

class Repository
{
    public function save(string $file, AbstractModel $model)
    {
        $fileData = file_get_contents($file);
        $className = get_class($model);
        $data = json_decode($fileData, true);
        $lastId = 1;
        $modelData = $model->getData();

        if (isset($modelData['id'])) {
            unset($modelData['id']);
        }

        if (array_key_exists($className, $data)) {
            foreach($data[$className] as $key => $value) {
                if ($key == $model->getId()) {
                    $lastId = $key;
                    break;
                } else {
                    $lastId++;
                }
            }
        }

        $data[$className][$lastId] = $modelData;
        $newFileData = json_encode($data);
        file_put_contents($file, $newFileData);
        return true;
    }

    public function delete(string $file, AbstractModel $model)
    {
        $fileData = file_get_contents($file);
        $className = get_class($model);
        $data = json_decode($fileData, true);

        foreach ($data[$className] as $key => $origData) {
            $flag = false;
            foreach ($origData as $singleKey => $singleValue) {
                if ($model->getData($singleKey) && $model->getData($singleKey) == $singleValue) {
                    $flag = true;
                } else {
                    $flag = false;
                }
            }
            if ($flag) {
                unset($data[$className][$key]);
            }
        }

        $newFileData = json_encode($data);
        file_put_contents($file, $newFileData);
        return true;
    }

    public function getList(string $file, AbstractModel $model)
    {
        $fileData = file_get_contents($file);
        $className = get_class($model);
        $fileData = json_decode($fileData, true);

        $result = [];
        foreach ($fileData[$className] as $key => $data) {

            $data['id'] = $key;
            $tmpModel = new $model();
            $tmpModel->setData($data);
            $result[$key] = $tmpModel;
        }
        return $result;
    }

    public function getById(string $file, AbstractModel $model, $id)
    {
        $data = $this->getList($file, $model);
        return (isset($data[$id])) ? $data[$id] : false;
    }
}