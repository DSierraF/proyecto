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
        <?php

    $conexion = mysqli_connect("localhost", "root", "css99");
    mysqli_select_db($conexion, "restaurante") or die("No se puede seleccionar la base de datos");
    $compnomb = "SELECT * FROM almacen WHERE nombre='$_POST[nombre]' ";


    $resultadocor = $conexion-> query($compnomb);
    $contarnomb = mysqli_num_rows($resultadocor);

    if ($contarnomb>0) {
    print("Este producto ya existe");
    print("<br><br>");
    print("<b><a href='insertar1.php'>Vuelve a intentarlo con otro</a></b>");
    print("<br>");
    }
    else {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $precio = $_POST['precio'];
    $tipoprod = $_POST['tipoprod'];

    $query = "INSERT INTO almacen VALUES (NULL, '$nombre', '$cantidad', '$precio', '$tipoprod')";
        if (mysqli_query($conexion, $query)) {
            print("Cuenta creada correctamente.");
        }
        else {
            print("Fallo al crear la cuenta: ". $query . "<br>" . mysqli_error($conexion));
        }
    }
mysqli_close($conexion);
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