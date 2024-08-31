<?php
include 'db.php';

$sql = "SELECT * FROM modalidades_titulacion";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo "<h2>" . $row['nombre'] . "</h2>";
    echo "<p>" . $row['descripcion'] . "</p>";
    echo "<p>" . $row['guia'] . "</p>";
  }
} else {
  echo "No hay modalidades de titulación disponibles";
}
$conn->close();
?>