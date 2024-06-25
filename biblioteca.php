
<?php
session_start();
require_once('conexion.php');

// Definición de libros (simulación de una base de datos)
$libros = array(
    array(
        'id' => 1,
        'titulo' => 'Cien años de soledad',
        'autor' => 'Gabriel García Márquez',
        'genero' => 'Drama',
        'descripcion' => 'La novela narra la historia de la familia Buendía a lo largo de varias generaciones en el pueblo ficticio de Macondo.',
        'imagen' => 'https://example.com/cien_anios_de_soledad.jpg'
    ),
    array(
        'id' => 2,
        'titulo' => 'El código Da Vinci',
        'autor' => 'Dan Brown',
        'genero' => 'Misterio',
        'descripcion' => 'El profesor de simbología Robert Langdon se ve envuelto en una serie de misterios relacionados con obras de arte y mensajes ocultos.',
        'imagen' => 'https://example.com/el_codigo_da_vinci.jpg'
    ),
    array(
        'id' => 3,
        'titulo' => 'Orgullo y prejuicio',
        'autor' => 'Jane Austen',
        'genero' => 'Romance',
        'descripcion' => 'La historia de Elizabeth Bennet y su relación con el apuesto y rico Sr. Darcy.',
        'imagen' => 'https://example.com/orgullo_y_prejuicio.jpg'
    ),
    array(
        'id' => 4,
        'titulo' => 'El psicoanalista',
        'autor' => 'John Katzenbach',
        'genero' => 'Thriller psicológico',
        'descripcion' => 'El psicoanalista es un thriller psicológico que cuenta la historia de un psicoanalista que se convierte en víctima de un siniestro juego de venganza.',
        'imagen' => 'https://example.com/el_psicoanalista.jpg'
    ),
    array(
        'id' => 5,
        'titulo' => 'Sherlock Holmes',
        'autor' => 'Arthur Conan Doyle',
        'genero' => 'Detectivesco',
        'descripcion' => 'Colección de relatos sobre las aventuras del famoso detective Sherlock Holmes y su fiel compañero, el Dr. Watson.',
        'imagen' => 'https://example.com/sherlock_holmes.jpg'
    )
);

// Función para guardar el pedido en la sesión
function guardarPedido($libro) {
    $_SESSION['pedido_libro'] = $libro;
}

// Filtrar libros si se envió un formulario de búsqueda
if (isset($_GET['buscar_nombre']) || isset($_GET['buscar_genero'])) {
    $buscar_nombre = isset($_GET['buscar_nombre']) ? $_GET['buscar_nombre'] : '';
    $buscar_genero = isset($_GET['buscar_genero']) ? $_GET['buscar_genero'] : '';

    // Filtrar por nombre y/o género
    $libros_filtrados = array();
    foreach ($libros as $libro) {
        if ((empty($buscar_nombre) || stripos($libro['titulo'], $buscar_nombre) !== false)
            && (empty($buscar_genero) || $libro['genero'] == $buscar_genero)) {
            $libros_filtrados[] = $libro;
        }
    }
} else {
    // Mostrar todos los libros si no hay búsqueda
    $libros_filtrados = $libros;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Lista de Libros</title>
</head>
<body>

    <h1>Biblioteca - Lista de Libros</h1>

    <!-- Formulario de búsqueda -->
    <form class="busqueda" action="biblioteca.php" method="get">
        <label for="buscar_nombre">Buscar por nombre:</label>
        <input type="text" id="buscar_nombre" name="buscar_nombre">
        
        <label for="buscar_genero">Buscar por género:</label>
        <select id="buscar_genero" name="buscar_genero">
            <option value="">Todos los géneros</option>
            <option value="Drama">Drama</option>
            <option value="Misterio">Misterio</option>
            <option value="Romance">Romance</option>
            <option value="Thriller psicológico">Thriller psicológico</option>
            <option value="Detectivesco">Detectivesco</option>
            <!-- Añadir más opciones de género según sea necesario -->
        </select>
        
        <button type="submit">Buscar</button>
    </form>

    <!-- Lista de libros filtrados -->
    <?php foreach ($libros_filtrados as $libro): ?>
        <div class="libro">
            <img src="<?php echo $libro['imagen']; ?>" alt="<?php echo $libro['titulo']; ?>">
            <h2><?php echo $libro['titulo']; ?></h2>
            <p>Autor: <?php echo $libro['autor']; ?></p>
            <p>Género: <?php echo $libro['genero']; ?></p>
            <p><?php echo $libro['descripcion']; ?></p>
            <form action="pedido_confirmado.php" method="post">
                <input type="hidden" name="id_libro" value="<?php echo $libro['id']; ?>">
                <input type="hidden" name="titulo" value="<?php echo $libro['titulo']; ?>">
                <input type="hidden" name="descripcion" value="<?php echo $libro['descripcion']; ?>">
                <button type="submit" name="pedir_libro">Pedir libro</button>
            </form>
        </div>
    <?php endforeach; ?>

</body>
</html>
