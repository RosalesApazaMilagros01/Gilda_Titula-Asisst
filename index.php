<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Titulación Gilda</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <nav>
      <ul>
        <?php if (!isset($_SESSION['id'])) { ?>
          <li><a href="login.html">Iniciar Sesión</a></li>
        <?php } else { ?>
          <li><a href="index.php">Inicio</a></li>
          <?php if ($_SESSION['rol'] == 'encargado') { ?>
            <li><a href="gestion_proyectos.php">Gestión de Proyectos</a></li>
          <?php } ?>
          <li><a href="proyectos.php">Repositorio de Proyectos</a></li>
          <li><a href="logout.php">Cerrar Sesión</a></li>
        <?php } ?>
      </ul>
    </nav>
  </header>
  <main>
    <!-- Contenido principal -->
    <?php if (isset($_SESSION['id'])) { ?>
      <section id="user-section">
        <h2>Hola, <?php echo $_SESSION['nombre']; ?></h2>
        <p>Estás conectado como <?php echo $_SESSION['rol']; ?>.</p>
      </section>
    <?php } else { ?>
      <section id="welcome">
        <h1>Bienvenido al Sistema de Titulación Gilda</h1>
        <p>Este sistema está diseñado para facilitar el proceso de titulación para los egresados del Instituto Gilda Liliana Ballivián Rosado.</p>
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

  </main>
  <script src="script.js"></script>
</body>
</html>