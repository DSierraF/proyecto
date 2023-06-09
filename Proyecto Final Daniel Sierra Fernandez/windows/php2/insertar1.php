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
  <script type="text/javascript">
    function valida(correcto) 
      {
        if (correcto.nombre.value.length==0) {
          alert("Debe rellenar todos los campos");
          return false;
        }
        if (correcto.cantidad.value.length==0) {
          alert("Debe rellenar todos los campos");
          return false;
        }
        if (correcto.precio.value.length==0) {
          alert("Debe rellenar todos los campos");
          return false;
        }
        if (correcto.tipoprod.value.length==0) {
          alert("Debe rellenar todos los campos");
          return false;
        }
        else {
          return true;
        }
    
      }
    
    </script>
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
      <li><a href="prin.php">Inicio</a></li>
	  <?php
      if($_SESSION['tipo_usuario']=='gerente'){
        echo"<li><a href='gerente.php' id='current'>Menú de gerente</a></li>";
      }
?>
      <li><a href="cerrar.php">Cerrar sesión</a></li>
      
    </ul>
  </div>
  <div id="content-wrap">
    <div id="content">
      <div id="main">
        <form action="insertar2.php" method="post" onsubmit="return valida(this)">
          <p>Nombre: <input type="text" name="nombre"></p> 				
          <p>Cantidad: <input type="number" name="cantidad"></p>
          <p>Precio: <input type="number" step=0.01 name="precio"></p> 
          <p>Tipo de producto: 
          <input type="radio" name="tipoprod" value="1"> Bebida
          <input type="radio" name="tipoprod" value="2"> Primero
                  <input type="radio" name="tipoprod" value="3"> Segundo
          <input type="radio" name="tipoprod" value="4"> Postre</p>
          <input type="submit" name="enviar" value="Enviar">
          <input type="reset" value="Borrar">
  </form>
      </div>
    </div>
  </div>
  <div id="footer">
    <p> &copy; 2023 <strong>Daniel Sierra Fernández</strong> | design by: <a href="#"><strong>styleshout</strong></a> | Valid <a href="http://jigsaw.w3.org/css-validator/check/referer"><strong>CSS</strong></a> | <a href="http://validator.w3.org/check/referer"><strong>XHTML</strong></a> </p>
  </div>
</div>
</body>
</html>