<?php
include 'db.php';

$sql = "SELECT * FROM proyectos";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<h2>" . $row['titulo'] . "</h2>";
    echo "<p>" . $row['resumen'] . "</p>";
    echo "<a href='" . $row['archivo'] . "'>Descargar Archivo</a>";
  }
} else {
  echo "No hay proyectos disponibles";
}
$conn->close();
?>