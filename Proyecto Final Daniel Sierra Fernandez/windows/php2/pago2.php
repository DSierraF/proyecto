<?php 
session_start();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Siefer restaurante</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="images/Enlighten.css" type="text/css" />
</head>
<body>
<div id="wrap">
  <div id="header">
    <div id="logo-box">
      <h1 id="logo">Siefer</h1>
      <h2 id="slogan">La grandeza de la simplicidad</h2>
    </div>
    <div class="headerphoto"></div>
  </div>
  <div id="menu">
    <ul>
      <li><a href="prin.php" id="current">Inicio</a></li>
<?php
      if($_SESSION['tipo_usuario']=='gerente'){
        echo"<li><a href='gerente.php'>Menú de gerente</a></li>";
      }
?>
      <li><a href="cerrar.php">Cerrar sesión</a></li>
      
    </ul>
  </div>
  <div id="content-wrap">
    <div id="content">
      <div id="main">
        <?php
            $total = $_SESSION['total'];
            echo("<form action='pago2.php' class='cent' method='post'  style='text-align: center;'>");
            if($_POST['submit1']=='Efectivo'){
              echo('<p>Has elegido: Pago en efectivo. Acerquese a caja y realice el pago de: <b>'.$total.' €</b></p>');
            }
            if($_POST['submit']=='Tarjeta'){
                echo('<p>Has elegido: Pago con tarjeta. Acerque la tarjeta para realizar el pago de: <b>'.$total.' €</b></p>');
                echo("<img class='pago' src='images/pago.gif'><br>");
                echo("<input type='submit' name='submit' value='Pagar'>");

              }elseif ($_POST['submit']=='Pagar'){
                echo('<p>Pago completado con exito, tenga un buen dia</p>');
                echo("<img class='pago' src='images/completado.gif'>");
                

              }
              echo('</form>');
        ?>
      </div>
    </div>
  </div>
  <div id="footer">
    <p> &copy; 2023 <strong>Daniel Sierra Fernández</strong> | design by: <a href="#"><strong>styleshout</strong></a> | Valid <a href="http://jigsaw.w3.org/css-validator/check/referer"><strong>CSS</strong></a> | <a href="http://validator.w3.org/check/referer"><strong>XHTML</strong></a> </p>
  </div>
</div>
</body>
</html>