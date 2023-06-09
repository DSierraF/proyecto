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
      <li><a href="ver.php" id="current">Pendientes</a></li>
      <li><a href="fin.php">Finalizadas</a></li>
    </ul>
  </div>
  <div id="content-wrap">
    <div id="content">
      <div id="main">
      <h1>Comandas pendientes:</h1>
    <form method="post">
        <ul>
            <?php
            $directorio = 'docs/';
            $directorioFinalizados = 'finalizados/';
            $archivos = glob($directorio . '*.txt');

            if (empty($archivos)) {
                echo '<li>No hay archivos de texto en la carpeta.</li>';
            } else {
                foreach ($archivos as $archivo) {
                    echo '<li>';
                    echo '<input type="checkbox" name="archivos[]" value="' . $archivo . '">';
                    echo '<strong>' . basename($archivo) . ':</strong><br>';
                    echo '<pre>' . file_get_contents($archivo) . '</pre>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
        <button type="submit" name="mover" onclick="return confirm('¿Estás seguro de que deseas mover los archivos seleccionados?')">Mover a "Finalizados"</button>
 

    <?php
    if (isset($_POST['mover'])) {
        if (isset($_POST['archivos'])) {
            $archivos_seleccionados = $_POST['archivos'];
            foreach ($archivos_seleccionados as $archivo) {
                if (file_exists($archivo)) {
                    $nombreArchivo = basename($archivo);
                    $destino = $directorioFinalizados . $nombreArchivo;
                    if (rename($archivo, $destino)) {
                        echo '<p>El archivo "' . $nombreArchivo . '" ha sido movido a la carpeta "finalizados".</p>';
                    } else {
                        echo '<p>Ocurrió un error al mover el archivo "' . $nombreArchivo . '".</p>';
                    }
                }
            }

            $archivos = glob($directorio . '*.txt');
        }
    }
    ?>
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
