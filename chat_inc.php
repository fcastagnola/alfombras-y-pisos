<?php
// simple chat class
class SimpleChat 
{
    // DB variables
    var $sDbName;
    var $sDbUser;
    var $sDbPass;
    // constructor
    function SimpleChat() 
    {
        //mysql_connect("localhost","username","password");
        $this->sDbName = 'alfombra_datos';
        $this->sDbUser = 'alfombra_user';
        $this->sDbPass = 'fcastagnola2000';
    }
    // adding to DB table posted message
    function acceptMessages($sucursal) 
    {
        if ($_COOKIE['member_name']) 
        {
            if(isset($_POST['s_say']) && $_POST['s_message']) 
            {
                $sUsername = $_COOKIE['member_name'];
                $sUser = $_COOKIE['member_apo'];
                //the host, name, and password for your mysql
                $vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);
                //select the database
                mysql_select_db($this->sDbName);
                $sMessage = mysql_real_escape_string($_POST['s_message']);
                if ($sMessage != '') 
                {
                    mysql_query("INSERT INTO `s_chat_messages` SET `user`='{$sUser}', `message`='{$sMessage}', `when`=UNIX_TIMESTAMP(), `id_sucursal`={$sucursal}");
                    //echo("INSERT INTO `s_chat_messages` SET `user`='{$sUser}', `message`='{$sMessage}', `when`=UNIX_TIMESTAMP(), `id_sucursal`={$sucursal}");
                }
                mysql_close($vLink);
            }
        }
        ob_start();
        //require_once('chat_input.php?id='<?php echo($sucursal);
        ?>
        <link type="text/css" rel="stylesheet" href="styles.css" />
        <form class="submit_form" method="post" action="main.php?id=<?php echo($sucursal)?>">
        <div><input type="text" name="s_message" /><input type="submit" value="Enviar" name="s_say" /></div>
        </form>
        <div style="color:#222222">Escriba su consulta.</div>
        <?php
        $sShoutboxForm = ob_get_clean();
        return $sShoutboxForm;
    }
    
    function getMessages($sucursal) 
    {
        $vLink = mysql_connect("localhost", $this->sDbUser, $this->sDbPass);
        //select the database
        mysql_select_db($this->sDbName);
        //returning the last 15 messages
        //$vRes = mysql_query("SELECT * FROM `s_chat_messages` where id_sucursal=$sucursal and user='" . $_COOKIE['member_apo'] ."' and estado=0 ORDER BY `id` ASC");
        $vRes = mysql_query("SELECT * FROM `s_chat_messages` where user='" . $_COOKIE['member_apo'] ."' and estado=0 ORDER BY `id` ASC");
        //echo("SELECT * FROM `s_chat_messages` where user='" . $_COOKIE['member_apo'] ."' and estado=0 ORDER BY `id` ASC");
        $sMessages = '';
        // collecting list of messages
        if ($vRes) 
        {
            $sMessages .= '<div class="message">';
            while($aMessages = mysql_fetch_array($vRes)) 
            {
                $sWhen = date("H:i:s", $aMessages['when']);
                if($aMessages['user2']!="Sucursal")
                {
                    $sMessages .= $aMessages['user2'] . '<span>(' . $sWhen . ')</span>: ' . $aMessages['message'] . '<br>';
                }
                else
                {
                    $sMessages .= $aMessages['user'] . '<span>(' . $sWhen . ')</span>: ' . $aMessages['message'] . '<br>';
                }
            }
            $sMessages .= '</div>';
        } 
        else 
        {
            $sMessages = 'DB error, create SQL table before';
        }
        mysql_close($vLink);
        ob_start();
        require_once('chat_begin.html');
        echo $sMessages;
        require_once('chat_end.html');
        return ob_get_clean();
    }
}
?>