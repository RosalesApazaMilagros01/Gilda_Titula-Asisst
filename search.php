<?php
session_start();
include 'db.php';

if (isset($_GET['search']) && isset($_GET['search_by'])) {
  $search = $_GET['search'];
  $search_by = $_GET['search_by'];

  // Consulta SQL dinámica según el campo de búsqueda
  switch ($search_by) {
    case 'titulo':
      $sql = "SELECT * FROM proyectos WHERE titulo LIKE '%$search%'";
      break;
    case 'resumen':
      $sql = "SELECT * FROM proyectos WHERE resumen LIKE '%$search%'";
      break;
    case 'id':
      $sql = "SELECT * FROM proyectos WHERE id LIKE '%$search%'";
      break;
    case 'año':
      $sql = "SELECT * FROM proyectos WHERE año LIKE '%$search%'";
      break;
    default:
      header("Location: index.php");
      exit;
  }

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    echo "<h2>Resultados de la búsqueda:</h2>";
    while($row = $result->fetch_assoc()) {
      echo "<h3>" . $row['titulo'] . "</h3>";
      echo "<p>" . $row['resumen'] . "</p>";
      echo "<p>ID del Proyecto: " . $row['id'] . "</p>";
      echo "<p>Año: " . $row['año'] . "</p>";
      echo "<a href='archivos/" . $row['archivo'] . "'>Descargar Archivo</a>";
    }
  } else {
    echo "<h2>No se encontraron resultados para la búsqueda.</h2>";
  }
  $conn->close();
} else {
  header("Location: index.php");
  exit;
}
?>