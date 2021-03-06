<?php
/**
 * Request.php
 */

namespace SoftnCMS\rute;

use SoftnCMS\classes\constants\OptionConstants;
use SoftnCMS\models\managers\OptionsManager;
use SoftnCMS\route\Route;
use SoftnCMS\util\Arrays;
use SoftnCMS\util\Sanitize;
use SoftnCMS\util\Util;

/**
 * Class Request
 * @author Nicolás Marulanda P.
 */
class Request {
    
    /** @var Route */
    private $route;
    
    /** @var string */
    private $urlGet;
    
    /** @var array */
    private $urlExplode;
    
    private $siteUrl;
    
    /**
     * Request constructor.
     */
    public function __construct() {
        $this->route      = new Route();
        $this->urlGet     = '';
        $this->urlExplode = [];
        $this->siteUrl    = '';
        $this->setUrl();
        $this->setRoute();
    }
    
    private function setUrl() {
        $urlGet = Arrays::get($_GET, URL_GET);
        
        if ($urlGet != FALSE) {
            $this->urlGet     = trim(Sanitize::url($urlGet), '/');
            $this->urlExplode = explode('/', $this->urlGet);
        }
    }
    
    private function setRoute() {
        $url = $this->urlExplode;
        $url = $this->setRuteDirectoryController($url);
        
        if (count($this->urlExplode) > 0) {
            $this->setRuteController(Arrays::get($url, 0));
            $positionParam = 1;
            
            if ($this->route->getControllerDirectoryName() != Route::CONTROLLER_DIRECTORY_NAME_THEME) {
                $this->setRuteMethod(Arrays::get($url, 1));
                $positionParam = 2;
            }
            
            $this->setRuteParameter(Arrays::get($url, $positionParam));
        }
        
        $this->setDirectoryView();
    }
    
    private function setRuteDirectoryController($url) {
        $auxUrl       = $url;
        $urlDirectory = array_shift($url);
        $directory    = Route::CONTROLLER_DIRECTORY_NAME_THEME;
        
        switch ($urlDirectory) {
            case Route::CONTROLLER_DIRECTORY_NAME_ADMIN:
            case Route::CONTROLLER_DIRECTORY_NAME_LOGIN:
            case Route::CONTROLLER_DIRECTORY_NAME_INSTALL:
                $directory = $urlDirectory;
                break;
            default:
                $url = $auxUrl;
                break;
        }
        
        $this->route->setControllerDirectoryName($directory);
        
        return $url;
    }
    
    private function setRuteController($controllerName) {
        if ($controllerName !== FALSE) {
            $controllerName = ucfirst(Sanitize::alphabetic($controllerName));
            $this->route->setControllerName($controllerName);
        }
    }
    
    private function setRuteMethod($methodName) {
        if ($methodName !== FALSE) {
            $this->route->setMethodName(Sanitize::alphabetic($methodName));
        }
    }
    
    private function setRuteParameter($parameter) {
        if ($parameter !== FALSE) {
            $this->route->setParameter(Sanitize::integer($parameter));
        }
    }
    
    private function setDirectoryView() {
        /*
         * Ejemplo:
         *  Nombre del controlador = "post"
         *  /ruta.../{nombre del controlador}/
         *  /view/admin/post/
         *  /themes/default/post/
         */
        $directoryNameViewController = strtolower($this->route->getControllerName());
        $controllerDirectoryName     = $this->route->getControllerDirectoryName();
        $this->route->setViewDirectoryName($controllerDirectoryName);
        $this->route->setDirectoryNameViewController($directoryNameViewController);
    }
    
    /**
     * @return string
     */
    public function getSiteUrl() {
        return $this->siteUrl;
    }
    
    /**
     * @param string $siteUrl
     */
    public function setSiteUrl($siteUrl) {
        if (empty($siteUrl)) {
            $siteUrl = Util::getUrl($this->getUrlGet());
        }
        
        $this->siteUrl = $siteUrl;
    }
    
    /**
     * @return string
     */
    public function getUrlGet() {
        return $this->urlGet;
    }
    
    public function getRoute() {
        return $this->route;
    }
}
