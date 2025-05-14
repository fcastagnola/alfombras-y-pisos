<?php
// set error reporting level
$sucursal=$_GET['id'];
if (version_compare(phpversion(), "5.3.0", ">=") == 1)
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
    error_reporting(E_ALL & ~E_NOTICE);
require_once('inc/login_inc.php');
require_once('inc/chat_inc.php');
// initialization of login system and generation code
$oSimpleLoginSystem = new SimpleLoginSystem();
$oSimpleChat = new SimpleChat();
// draw login box
echo $oSimpleLoginSystem->getLoginBox($sucursal);
// draw chat application
$sChatResult = '<div style="color:#CCCCCC">Necesita loguearse antes de usarlo.</div>';
if ($_COOKIE['member_name'] && $_COOKIE['member_pass']) 
{
    if ($oSimpleLoginSystem->check_login($_COOKIE['member_name'], $_COOKIE['member_pass'])) 
    {
        $sChatResult = $oSimpleChat->acceptMessages($sucursal);
    }
}
echo $sChatResult;
?>