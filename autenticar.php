<?php
session_start();
include 'db.php';

if (isset($_POST['correo']) && isset($_POST['password'])) {
  $correo = $_POST['correo'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['id'] = $row['id'];
    $_SESSION['nombre'] = $row['nombre'];
    $_SESSION['rol'] = $row['rol'];

    // Redirigir al usuario a una página específica según su rol
    if ($_SESSION['rol'] == 'encargado') {
      header("Location: gestion_proyectos.php");
    } elseif ($_SESSION['rol'] == 'estudiante') {
      header("Location: proyectos.php");
    } else {
      header("Location: index.php");
    }
    exit;
  } else {
    echo "Credenciales incorrectas";
  }
  $conn->close();
}
?>