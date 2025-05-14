<?php
// class SimpleLoginSystem
class SimpleLoginSystem 
{
    // variables
    var $aExistedMembers; // Existed members array
    var $sDbName;
    var $sDbUser;
    var $sDbPass;
    //
    // constructor
    function SimpleLoginSystem() 
    {
        $this->aExistedMembers = array(
        'User1' => 'd8578edf8458ce06fbc5bb76a58c5ca4',
        'User2' => 'd8578edf8458ce06fbc5bb76a58c5ca4',
        'User3' => 'd8578edf8458ce06fbc5bb76a58c5ca4'
    );
    }
    function getLoginBox($sucursal) 
    {
        ob_start();
        require_once('login_form.php');
        $sLoginForm = ob_get_clean();
        $sLogoutForm = '<div style="color:#CCCCCC"><a href="'.$_SERVER['PHP_SELF'].'?logout=1&id=' . $sucursal . '">Salir</a></div>';
        if ((int)$_REQUEST['logout'] == 1) 
        {
            if (isset($_COOKIE['member_name']) && isset($_COOKIE['member_pass']))
            $this->simple_logout($sucursal);
        }
        if ($_REQUEST['username'] && $_REQUEST['password'] && $_REQUEST['nombre']) 
        {
            if ($this->check_login($_REQUEST['username'], MD5($_REQUEST['password']))) 
            {
                $this->sDbName = 'alfombra_datos';
                $this->sDbUser = 'alfombra_user';
                $this->sDbPass = 'fcastagnola2000';
                $vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);
                //select the database
                mysql_select_db($this->sDbName);
                $vRes = mysql_query("SELECT * FROM `s_chat_messages` where user='" . $_REQUEST['nombre'] ."' and estado=0 ORDER BY `id` ASC");
                if (mysql_num_rows($vRes)>0) 
                {
                    return '<div style="color:#222222">El nombre ya se est&aacute; utilizando. Agregue su apellido u otro dato para identificarse.' . $sLoginForm. '</div>';
                }else{
                    $this->simple_login($_REQUEST['username'], $_REQUEST['password'],$_REQUEST['nombre'],$sucursal);
                    return '<div style="color:#222222">Hola ' . $_REQUEST['nombre'] . '! ' . $sLogoutForm . '</div>';
                }
            } 
            else 
            {
                return '<div style="color:#222222">Ususario o Contraseña incorrecta.' . $sLoginForm. '</div>';
            }
        } 
        else
        {
            if ($_COOKIE['member_name'] && $_COOKIE['member_pass']) 
            {
                if ($this->check_login($_COOKIE['member_name'], $_COOKIE['member_pass'])) 
                {
                    return '<div style="color:#222222">Hola ' . $_COOKIE['member_apo'] . '! ' . $sLogoutForm . '</div>';
                }
            }
            return $sLoginForm;
        }
    }

    function simple_login($sName, $sPass, $sNombre,$sucursal) 
    {
        $this->simple_logout($sucursal);
        //$sMd5Password = MD5($sPass);
        $sMd5Password = $sPass;
        $iCookieTime = time() + 24*60*60*30;
        setcookie("member_name", $sName, $iCookieTime, '/');
        $_COOKIE['member_name'] = $sName;
        setcookie("member_pass", $sMd5Password, $iCookieTime, '/');
        $_COOKIE['member_pass'] = $sMd5Password;
        setcookie("member_apo", $sNombre, $iCookieTime, '/');
        $_COOKIE['member_apo'] = $sNombre;
    }
    
    function simple_logout($sucursal) 
    {   
	$this->sDbName = 'alfombra_datos';
        $this->sDbUser = 'alfombra_user';
        $this->sDbPass = 'fcastagnola2000';
        $vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);
        //select the database
        mysql_select_db($this->sDbName);
        //returning the last 15 messages
    	mysql_query("Update `s_chat_messages` SET estado=1 where `user`='" . $_COOKIE['member_apo'] . "' and estado=0");
        //mysql_query("Update `s_chat_messages` SET estado=1 where `user`='" . $_COOKIE['member_apo'] . "' and `id_sucursal`=" . $sucursal . " and estado=0");
	
        setcookie('member_name', '', time() - 96 * 3600, '/');
        setcookie('member_pass', '', time() - 96 * 3600, '/');
        setcookie('member_apo', '', time() - 96 * 3600, '/');
        unset($_COOKIE['member_name']);
        unset($_COOKIE['member_pass']);
        unset($_COOKIE['member_apo']);
    }
    function check_login($sName, $sPass) 
    {
        return true;
    }
}
?>