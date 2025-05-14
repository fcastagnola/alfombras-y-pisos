<?php
Include 'pages/mydbconn.php';
?>
<div class="contact-f0rm1">
    <div class="box-rela1">
        <div class="ctvert1">
            <h3>Ejecutivo On-Line</h3>
        </div>
        <div class="contact-form1" style="background-image: url(images/new-fondo.jpg);">
            <div class="title-form1">
                <h2>&iquest; En qu&eacute; podemos ayudarte?</h2>
            </div>
            <div>
                <iframe src="messenger/messages.php?id=<?php echo($sucursal);?>" style="width: 790px; height: 410px;"  name="formularios"></iframe>
            </div>
            <div>
                <iframe src="messenger/main.php?id=<?php echo($sucursal);?>"  style="width: 240px; height: 410px;" name="formularios1"></iframe>
            </div>
        </div>
    </div>
</div>
