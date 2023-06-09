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



    $id_plato=$_POST['id'];
	$nombre=$_POST['nombre'];

	$sqlid= "SELECT * FROM almacen WHERE id='$id_plato'";
	$resultid=mysqli_query($conexion, $sqlid);
	$rowid=mysqli_fetch_assoc($resultid);

		if (strlen($id_plato)>0) {
		    $borrarid = "DELETE FROM almacen WHERE id=$id_plato";
		    if (mysqli_query($conexion,$borrarid)) {
			    print("Plato borrado con éxito");
			    mysqli_close($conexion);
			    }
			}

        $sqlnomb= "SELECT * FROM almacen WHERE nombre='$nombre'";
        $resultnomb=mysqli_query($conexion, $sqlnomb);
        $rownomb=mysqli_fetch_assoc($resultnomb);
            if (strlen($nombre)>0) {
                $borrarnomb = "DELETE FROM almacen WHERE nombre='$nombre'";
                if (mysqli_query($conexion,$borrarnomb)) {
                    print("Plato borrado con éxito");
                    mysqli_close($conexion);
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