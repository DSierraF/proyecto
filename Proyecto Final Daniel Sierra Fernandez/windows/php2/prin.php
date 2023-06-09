<?php 
session_start();
session_unset($_SESSION['total']);

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
                    
        if (isset($_POST['submit'])) {
            $selectedItems = $_POST['pedir'];
        
            if (!empty($selectedItems)) {
                $fechaHora = date("Y-m-d_H-i-s"); // Obtener la fecha y hora actual
                $nombreArchivo = "pedido_" . $fechaHora . ".txt"; // Nombre del archivo con la fecha y hora
        
                $rutaArchivo = "docs/" . $nombreArchivo; // Ruta del archivo
        
                $archivo = fopen($rutaArchivo, "w");
                $precioTotal = 0;
        
                $conexion = mysqli_connect("localhost", "root", "css99");
                mysqli_select_db($conexion, "restaurante") or die("No se puede seleccionar la base de datos");
        
                $error = false;
                $error1 = false; // Variable para controlar si se ha seleccionado una cantidad mayor a la disponible
        
                foreach ($selectedItems as $item) {
                    $index = $item - 1; // Restar 1 para obtener el índice correcto
                    $nombre = $_POST['nomb'][$index];
                    $cantidad = $_POST['cant'][$index];
                    $precio = $_POST['prec1'][$index];
        
                    // Verificar si no se ha seleccionado ninguna cantidad
                    if (empty($cantidad)) {
                        $error = true;
                        break; // Salir del bucle si no se ha seleccionado cantidad
                    }
        
                    // Verificar si la cantidad seleccionada es mayor a la disponible en la base de datos
                    $query = "SELECT cantidad FROM almacen WHERE nombre = '$nombre'";
                    $result = mysqli_query($conexion, $query);
                    $row = mysqli_fetch_assoc($result);
                    $cantidadDisponible = $row['cantidad'];
        
                    if ($cantidad > $cantidadDisponible) {
                        $error1 = true;
                        break; // Salir del bucle si se encuentra una cantidad mayor a la disponible
                    }
        
                    $subtotal = $cantidad * $precio;
                    $precioTotal += $subtotal;
        
                    $linea = $nombre . "\t x" . $cantidad . " - " . $precio . "€, Subtotal: " . $subtotal . "€" . PHP_EOL;
                    fwrite($archivo, $linea);
        
                    // Restar la cantidad seleccionada de la base de datos
                    $restarCantidad = "UPDATE almacen SET cantidad = cantidad - $cantidad WHERE nombre = '$nombre'";
                    mysqli_query($conexion, $restarCantidad);
                }
        
                fwrite($archivo, "Precio total: " . $precioTotal . "€" . PHP_EOL);
                fclose($archivo);
        
                $query2 = "INSERT INTO ventas values(NULL, '$nombreArchivo', '$precioTotal', CURRENT_DATE )";
                $result2 = mysqli_query($conexion, $query2);
                
        
        
        
                if ($error) {
                    unlink($nombreArchivo); // Eliminar el archivo creado en caso de error
                    echo "<script>alert('No se ha seleccionado una cantidad para el producto $nombre.')</script>";
                } else {
                    if ($error1) {
                        unlink($nombreArchivo); // Eliminar el archivo creado en caso de error
                        echo "<script>alert('Se ha seleccionado una cantidad mayor a la disponible de $nombre.')</script>";
                    }else{
                        echo "El archivo $nombreArchivo se ha creado correctamente con los productos seleccionados.";
        
                    }
                }
            } else {
                echo "No se ha seleccionado ningún producto.";
            }
        }
        ?>
        
        
            <form action="pago1.php" class="cent" method="post">
                <table>
                    <tr>
                        <td>CARTA:</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Bebida:</td>
                        <td></td>
                    </tr>
                    <?php
                    $conexion = mysqli_connect("localhost", "root", "css99");
                    mysqli_select_db($conexion, "restaurante") or die("No se puede seleccionar la base de datos");
        
                    $alm = "SELECT * FROM almacen WHERE tipo_id = 1";
                    $resultado = mysqli_query($conexion, $alm);
        
                    if (mysqli_num_rows($resultado) > 0) {
                        $checkboxValue = 1; // Valor inicial del checkbox
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            print("<tr>");
                            print("<td></td>");
                            print("<td><input type='text' value='" . $row['nombre'] . "' name='nomb[]' readonly></td>");
                            print("<td><input type='text' value='" . $row['cantidad'] . "' name='canti[]' readonly></td>");
                            print("<td><input type='hidden' value='" . $row['precio'] . "' name='prec1[]'>" . $row['precio'] . "€</td>");
                            print("<td><input type='number' name='cant[]'></td>");
                            print("<td><input type='checkbox' name='pedir[]' value='" . $checkboxValue . "'></td>");
                            print("</tr>");
        
                            $checkboxValue++; // Incrementar el valor del checkbox
                        }
                    }
                    ?>
                    <tr>
                        <td>Primero:</td>
                    </tr>
                    <?php
                    $alm = "SELECT * FROM almacen WHERE tipo_id = 2";
                    $resultado = mysqli_query($conexion, $alm);
        
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            print("<tr>");
                            print("<td></td>");
                            print("<td><input type='text' value='" . $row['nombre'] . "' name='nomb[]' readonly></td>");
                            print("<td><input type='text' value='" . $row['cantidad'] . "' name='canti[]' readonly></td>");
                            print("<td><input type='hidden' value='" . $row['precio'] . "' name='prec1[]'>" . $row['precio'] . "€</td>");
                            print("<td><input type='number' name='cant[]'></td>");
                            print("<td><input type='checkbox' name='pedir[]' value='" . $checkboxValue . "'></td>");
                            print("</tr>");
        
                            $checkboxValue++; // Incrementar el valor del checkbox
                        }
                    }
                    ?>
                    <tr>
                        <td>Segundo:</td>
                    </tr>
                    <?php
                    $alm = "SELECT * FROM almacen WHERE tipo_id = 3";
                    $resultado = mysqli_query($conexion, $alm);
        
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            print("<tr>");
                            print("<td></td>");
                            print("<td><input type='text' value='" . $row['nombre'] . "' name='nomb[]' readonly></td>");
                            print("<td><input type='text' value='" . $row['cantidad'] . "' name='canti[]' readonly></td>");
                            print("<td><input type='hidden' value='" . $row['precio'] . "' name='prec1[]'>" . $row['precio'] . "€</td>");
                            print("<td><input type='number' name='cant[]'></td>");
                            print("<td><input type='checkbox' name='pedir[]' value='" . $checkboxValue . "'></td>");
                            print("</tr>");
        
                            $checkboxValue++; // Incrementar el valor del checkbox
                        }
                    }
                    ?>
                    <tr>
                        <td>Postre:</td>
                    </tr>
                    <?php
                    $alm = "SELECT * FROM almacen WHERE tipo_id = 4";
                    $resultado = mysqli_query($conexion, $alm);
        
                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            print("<tr>");
                            print("<td></td>");
                            print("<td><input type='text' value='" . $row['nombre'] . "' name='nomb[]' readonly></td>");
                            print("<td><input type='text' value='" . $row['cantidad'] . "' name='canti[]' readonly></td>");
                            print("<td><input type='hidden' value='" . $row['precio'] . "' name='prec1[]'>" . $row['precio'] . "€</td>");
                            print("<td><input type='number' name='cant[]'></td>");
                            print("<td><input type='checkbox' name='pedir[]' value='" . $checkboxValue . "'></td>");
                            print("</tr>");
        
                            $checkboxValue++; // Incrementar el valor del checkbox
                        }
                    }
                    ?>
                    <tr>
                        <td><input type="submit" name="submit" value="Enviar"></td>
                    </tr>
                </table>
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