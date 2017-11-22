<?php
/**
 * LoginManager.php
 */

namespace SoftnCMS\models\managers;

use SoftnCMS\models\tables\User;
use SoftnCMS\util\database\DBAbstract;

/**
 * Class LoginManager
 * @author Nicolás Marulanda P.
 */
class LoginManager {
    
    /**
     * @param User $user
     * @param bool $rememberMe
     *
     * @return bool
     */
    public static function login($user, $rememberMe) {
        //TODO: Corregir: obtener conexion
        $usersManager = new UsersManager(DBAbstract::getNewInstance());
        $searchUser   = $usersManager->searchByLoginAndPassword($user->getUserLogin(), $user->getUserPassword());
        
        if (empty($searchUser)) {
            return FALSE;
        }
        
        $_SESSION[SESSION_USER] = $searchUser->getId();
        
        if ($rememberMe) {
            setcookie(COOKIE_USER_REMEMBER, $searchUser->getID(), COOKIE_EXPIRE, '/');
        }
        
        return TRUE;
    }
    
    /**
     * Método que comprueba si ha iniciado sesión.
     * @return bool Si es FALSE, el usuario no tiene un sesión activa
     * ni tiene la opción de recordar sesión.
     */
    public static function isLogin() {
        if (!isset($_SESSION[SESSION_USER]) && !isset($_COOKIE[COOKIE_USER_REMEMBER])) {
            return FALSE;
        }
        
        if (!isset($_SESSION[SESSION_USER]) && isset($_COOKIE[COOKIE_USER_REMEMBER])) {
            $_SESSION[SESSION_USER] = $_COOKIE[COOKIE_USER_REMEMBER];
        }
        
        return self::checkSession();
    }
    
    /**
     * Método que comprueba si el valor de la variable de sesión corresponde
     * a un usuario valido.
     * @return bool
     */
    public static function checkSession() {
        //TODO: Corregir: obtener conexion
        $usersManager = new UsersManager(DBAbstract::getNewInstance());
        $session      = self::getSession();
        
        if ($session == 0 || $usersManager->searchById($session) === FALSE) {
            unset($_SESSION[SESSION_USER]);
            
            return FALSE;
        }
        
        return TRUE;
    }
    
    /**
     * Método que obtiene el identificador del usuario en sesión.
     * @return int
     */
    public static function getSession() {
        return isset($_SESSION[SESSION_USER]) ? $_SESSION[SESSION_USER] : 0;
    }
}
