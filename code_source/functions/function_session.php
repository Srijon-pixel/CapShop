<?php


require_once './functions/function_user.php';
require_once './functions/function_order.php';
require_once './functions/function_cap.php';

/**
 * @var string les clés utilisé pour identifier l'utilisateur par sa session
 */
define('SESSION_KEY_ID_USER', 'idUser');
define('SESSION_KEY_ID_ORDER', 'idOrder');
define('SESSION_KEY_ID_CAP', 'idCap');


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


function DestroySession()
{
    StartSession();
    $_SESSION = [];
    session_destroy();
}
