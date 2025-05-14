<meta http-equiv="refresh" content="5">
<?php
$sucursal=$_GET['id'];
require_once('inc/chat_inc.php');
$oSimpleChat = new SimpleChat();
echo $oSimpleChat->getMessages($sucursal);
//echo($sucursal);
?>