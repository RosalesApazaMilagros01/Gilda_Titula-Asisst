<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<style>

#search-section {
  margin-top: 20px;
}

#search-section form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

#search-section label {
  margin-bottom: 10px;
}

#search-section input[type="text"] {
  width: 50%;
  height: 30px;
  padding: 10px;
  margin-bottom: 20px;
}

#search-section input[type="submit"] {
  width: 50%;
  height: 30px;
  background-color: #333;
  color: #fff;
  border: none;
  cursor: pointer;
}

#search-section input[type="submit"]:hover {
  background-color: #444;
}
</style>
  
</head>
<body>
<?php
session_start();
include 'db.php';

if (isset($_SESSION['id']) && isset($_SESSION['rol'])) {
  $userId = $_SESSION['id'];
  $userRole = $_SESSION['rol'];

  if ($userRole != 'encargado') {
    header("Location: index.php");
    exit;
  }

  // Código para gestionar proyectos
  if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion == 'subir') {
      // Código para subir el proyecto
      $titulo = $_POST['titulo'];
      $resumen = $_POST['resumen'];
      $archivo = $_FILES['archivo']['name'];
      $tmp_name = $_FILES['archivo']['tmp_name'];

      // Verificar si el archivo es un PDF
      $file_type = pathinfo($archivo, PATHINFO_EXTENSION);
      if ($file_type != 'pdf') {
        echo "Solo se permiten archivos PDF.";
        exit;
      }

      // Mover el archivo subido al directorio de archivos
      $upload_dir = 'archivos/';
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      move_uploaded_file($tmp_name, $upload_dir . $archivo);

      // Insertar el proyecto en la base de datos
      $sql = "INSERT INTO proyectos (titulo, resumen, archivo, carrera, año) VALUES ('$titulo', '$resumen', '$archivo', 'Ingeniería en Sistemas', 2023)";
      $conn->query($sql);

    } elseif ($accion == 'editar') {
      // Código para editar el proyecto
      $idProyecto = $_POST['id'];
      $titulo = $_POST['titulo'];
      $resumen = $_POST['resumen'];

      $sql = "UPDATE proyectos SET titulo = '$titulo', resumen = '$resumen' WHERE id = '$idProyecto'";
      $conn->query($sql);

    } elseif ($accion == 'eliminar') {
      // Código para eliminar el proyecto
      $idProyecto = $_POST['id'];

      $sql = "DELETE FROM proyectos WHERE id = '$idProyecto'";
      $conn->query($sql);

      // Eliminar el archivo asociado al proyecto
      $archivo = $_POST['archivo'];
      unlink('archivos/' . $archivo);
    }
  }
} else {
  header("Location: index.php");
  exit;
}
$conn->close();
?>

<?php if ($userRole == 'encargado') { ?>
  <section id="gestion-proyectos">
    <h2>Gestión de Proyectos</h2>
    <form action="gestion_proyectos.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="accion" value="subir">
      <label for="titulo">Título del Proyecto:</label>
      <input type="text" id="titulo" name="titulo"><br><br>
      <label for="resumen">Resumen del Proyecto:</label>
      <textarea id="resumen" name="resumen"></textarea><br><br>
      <label for="archivo">Archivo del Proyecto:</label>
      <input type="file" id="archivo" name="archivo"><br><br>
      <input type="submit" value="Subir Proyecto">
    </form>

    <h2>Editar Proyecto</h2>
    <form action="gestion_proyectos.php" method="post">
      <input type="hidden" name="accion" value="editar">
      <label for="id">ID del Proyecto:</label>
      <input type="text" id="id" name="id"><br><br>
      <label for="titulo">Título del Proyecto:</label>
      <input type="text" id="titulo" name="titulo"><br><br>
      <label for="resumen">Resumen del Proyecto:</label>
      <textarea id="resumen" name="resumen"></textarea><br><br>
      <input type="submit" value="Editar Proyecto">
    </form>

    <h2>Eliminar Proyecto</h2>
    <form action="gestion_proyectos.php" method="post">
      <input type="hidden" name="accion" value="eliminar">
      <label for="id">ID del Proyecto:</label>
      <input type="text" id="id" name="id"><br><br>
      <label for="archivo">Archivo del Proyecto:</label>
      <input type="text" id="archivo" name="archivo"><br><br>
      <input type="submit" value="Eliminar Proyecto">
    </form>
  </section>
<?php } ?>

<section id="search-section">
  <h2>Buscar Proyectos</h2>
  <form action="search.php" method="get">
    <label for="search">Buscar por:</label>
    <select id="search_by" name="search_by">
      <option value="titulo">Título</option>
      <option value="resumen">Resumen</option>
      <option value="id">ID del Proyecto</option>
      <option value="año">Año</option>
    </select><br><br>
    <label for="search">Ingrese el valor a buscar:</label>
    <input type="text" id="search" name="search"><br><br>
    <input type="submit" value="Buscar">
  </form>
</section>
</body>
</html>