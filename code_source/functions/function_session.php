<?php


require_once './functions/function_user.php';
require_once './functions/function_order.php';
require_once './functions/function_cap.php';

/**
 * @var string la clé utilisé pour identifier l'utilisateur par sa session
 */
define('SESSION_KEY_ID_USER', 'idUser');
define('SESSION_KEY_ID_ORDER', 'idOrder');
define('SESSION_KEY_ID_CAP', 'idCap');

/**
 * Recherche l'utilisateur dans la session
 * @author Arthur Jegge
 *
 * @return EUser|false  l'utilisateur si identifié, autrement false
 */
function GetUserFromSession()
{
    if (!StartSession()) {
        return false;
    }
    if (isset($_SESSION[SESSION_KEY_ID_USER])) {
        return getDataUserById(intval($_SESSION[SESSION_KEY_ID_USER]));
    }
    return false;
}

function GetOrderFromSession()
{
    if (!StartSession()) {
        return false;
    }
    if (isset($_SESSION[SESSION_KEY_ID_ORDER])) {
        return getDataOrderById(intval($_SESSION[SESSION_KEY_ID_ORDER]));
    }
    return false;
}

function GetCapFromSession()
{
    if (!StartSession()) {
        return false;
    }
    if (isset($_SESSION[SESSION_KEY_ID_CAP])) {
        return getCapById(intval($_SESSION[SESSION_KEY_ID_CAP]));
    }
    return false;
}

/**
 * Démarre une session
 * @author Arthur Jegge
 * 
 * @return bool true si la session est démarrée, autrement false
 */
function StartSession()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return true;
    } else if (session_status() === PHP_SESSION_DISABLED) {
        return false;
    } else if (session_status() === PHP_SESSION_NONE) {
        session_start();
        return true;
    }
}

/**
 * Détruit une session
 * @author Arthur Jegge
 *
 * @return void
 */
function DestroySession()
{
    StartSession();
    $_SESSION = [];
    session_destroy();
}
