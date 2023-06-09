<?php
session_start();
session_unset($_SESSION['nombre']);
session_unset($_SESSION['tipo_usuario']);
session_destroy();
header('Location: ../php2');
?>