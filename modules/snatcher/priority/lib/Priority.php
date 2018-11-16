<?php

namespace modules\snatcher\priority\lib;

use core\db\Db;
use core\FilterGenerator;
use core\utils\Utils;

class Priority
{
    private $table = 'tbl_priority';

    public function order($selectionAlias, $objects)
    {
        if(!count($objects))
            return $objects;
        return $this->orderAction($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $selectionAlias, $objects);
    }

    private function orderAction($url, $selectionAlias, $objects)
    {
        $orderDbArray = Db::getMysql()->rowsAssoc("
            SELECT objectId from ".$this->table." WHERE url = '".$this->adaptUrl($url)."'
                AND selectionAlias = '".$selectionAlias."' ORDER BY priority ASC
        ");

        $orderArray = array();
        $newObjectsData = array();
        $idField = $this->getIdField($objects);

        $idArray = array();
        if(is_object($objects))
            $idArray = $objects->getIdArray();
        if(is_array($objects))
            foreach ($objects as $el)
                $idArray[] = array($idField=>$el->id);
        if(!count($objects))
            throw new \Exception('Cant identify idArray field in '.__CLASS__);

        foreach ($idArray as $el){
            $dbKey = array_search( array('objectId'=>$el[$idField]), $orderDbArray );
            if($dbKey)
                $orderArray[$dbKey] = $el;
            else
                $newObjectsData[] = $el;
        }

        ksort($orderArray);
        $orderArray = array_merge($newObjectsData, $orderArray);
        $orderString = Utils::getCountableObjectPropertiesString($orderArray, $idField);
        if(strlen($orderString))
            $objects = $this->orderByString($objects, $orderString);

        return $objects;
    }

    public function orderByString($objects, $orderString)
    {
        if(is_array($objects)){
            if(empty($objects))
                return $objects;

            $array = array();
            foreach (explode(',', $orderString) as $id){
                foreach ($objects as $object)
                    if($object->id == $id)
                        $findedObject = $object;
                $array[] = $findedObject;
            }
            return $array;
        }

        if(is_object($objects)){
            $idField = $this->getIdField($objects);
            return $objects->setFilters(new FilterGenerator())
                            ->setSubquery('AND `'.$idField.'` IN ('.$orderString.')')
                            ->setOrderBy(' FIELD ('.$idField.','.$orderString.') ASC');
        }
        throw new \Exception('Objects should be instance of array or Object in '.__CLASS__);
    }

    private function getIdField($objects)
    {
        if(method_exists($objects, 'getConfig'))
            return $objects->getConfig()->getIdField();
        if(is_object($objects))
            $current = $objects->current();
        if(is_array($objects))
            $current = array_shift($objects);
        if(!$current)
            throw new \Exception('Cant identify id field in '.__CLASS__);
        return $current->getConfig()->getIdField();
    }

    private function adaptUrl($url)
    {
        $url = str_replace('http://', '', $url);
        return rtrim(Utils::ragp($url), '/');
    }

    public function set($url, $selectionAlias, $objectConfig, $data)
    {
        foreach($data as $objectId=>$priority){
            $exist = Db::getMysql()->rows(
                "SELECT id FROM `?s` WHERE
                    `url` = '?s' AND `selectionAlias` = '?s' AND `objectConfig` = '?s' AND `objectId` = ?d",
                array($this->table, $this->adaptUrl($url), $selectionAlias, $objectConfig, $objectId)
            );

            $array  = array();
            if(!empty($exist) && is_numeric($exist[0]['id']))
                $query = "UPDATE ".$this->table." SET priority = ".$priority." WHERE id = ".$exist[0]['id'];
            else{
                $query = "INSERT INTO ".$this->table." (url, selectionAlias, objectConfig, objectId, priority)
                    VALUES ('?s', '?s', '?s', ?d, ?d)
                ";
                $array = array($this->adaptUrl($url), $selectionAlias, $objectConfig, $objectId, $priority);
            }
            $res = Db::getMysql()->query($query, $array);
        }
        return $res;
    }
}