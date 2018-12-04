<?php
namespace modules\snatcher\lib;

use core\Noop;
use core\utils\Utils;
use modules\snatcher\priority\lib\Priority;
use modules\snatcher\selection\Selection;

class Snatcher
{
    private static $instance = null;
    private $sessionKey = 'snatcher',
            $touchUrlAttempt = 'touchUrlAttempt',
            $selection;

    private function __construct(){}

    protected function __clone(){}

    static public function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function setSelection(Selection $selection)
    {
        $this->selection = $selection;
        $_SESSION[$this->sessionKey][$this->selection->getAlias()] = array(
            'objectConfig' => $this->selection->getObjectConfig()
        );
        return $this;
    }

    public function setObjectIdsToSession($alias, $objects)
    {
        if(is_array($objects)){
            $object = Utils::getFirstArrayEl($objects);
            $ids = Utils::getCountableObjectPropertiesString($objects, 'id');
        }
        else{
            $object = $objects->current();
            $ids = $objects->getIdStringInModuleObjects();
        }

        if ($this->checkAlias($alias)) {
            $this->checkObjectConfig($alias, $object);
            $_SESSION[$this->sessionKey][$alias]['ids'] = $ids;
        }

        return $this;
    }

    private function checkAlias($alias)
    {
        if (isset($_SESSION[$this->sessionKey][$alias]) && is_array($_SESSION[$this->sessionKey][$alias]))
            return true;
        return false;
    }

    public function checkObjectConfig($alias, $object)
    {
        if ($_SESSION[$this->sessionKey][$alias]['objectConfig'] === get_class($object->getConfig()))
            return $this;
        throw new \Exception('ObjectConfig ' . $_SESSION[$this->sessionKey][$alias]['objectConfig'] . ' != ' . $object->getConfig() . ' in ' . __CLASS__);
    }

    public function getObjects($url)
    {
        $res = $this->touchUrl($url);
        if ($res) {
            $configClass = $this->selection->getObjectConfig();
            $config = new $configClass();
            $objectsClass = $config->getObjectsClass();

            if(!isset($_SESSION[$this->sessionKey][$this->selection->getAlias()]['ids']))
                return new Noop();

            $idsString = $_SESSION[$this->sessionKey][$this->selection->getAlias()]['ids'];

            $categoryMemberConfig = null;

            if(Utils::getConstructorParameters($objectsClass, 'configObject')){
                $categoryMemberConfigClass = $this->selection->getCategoryMemberConfig();
                $categoryMemberConfig = new $categoryMemberConfigClass();
            }

            $objects = (new $objectsClass($categoryMemberConfig))->setSubquery('AND `id` IN (?s)', $idsString);

            $objects = (new Priority())->orderByString($objects, $idsString);

            unset($_SESSION[$this->sessionKey]);
            return $objects;
        }
    }

    private function touchUrl($url)
    {
        $_SESSION[$this->sessionKey][$this->touchUrlAttempt] = true;

        $opts = array('http' => array('header' => 'Cookie: '.$_SERVER['HTTP_COOKIE']."\r\n"));
        $context = stream_context_create($opts);
        session_write_close(); // unlock the file
        $contents = file_get_contents($url, false, $context);
        session_start(); // Lock the file

        unset($_SESSION[$this->sessionKey][$this->touchUrlAttempt]);

        if (!$contents)
            throw new \Exception('Cant get contents of '.$url.' in '. __CLASS__);

//        for testing:
//        echo $contents;
//        var_dump($_SESSION);
//        die();

        return $contents;
    }

    public function isTouchUrlAttempt()
    {
        return isset($_SESSION[$this->sessionKey][$this->touchUrlAttempt])
            &&
            $_SESSION[$this->sessionKey][$this->touchUrlAttempt]===true;
    }
}
