<?php
session_start();
require_once('conexion.php');

// Verificar si se recibió el formulario de pedido
if (isset($_POST['pedir_libro'])) {
    $id_libro = $_POST['id_libro'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    // Preparar la consulta SQL para insertar el libro en la base de datos
    $fecha_pedido = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual
    $query = "INSERT INTO libros (id_libro, titulo, descripcion, fecha_pedido) 
              VALUES (:id_libro, :titulo, :descripcion, :fecha_pedido)";

    try {
        // Preparar la consulta
        $stmt = $pdo->prepare($query);

        // Bind de parámetros
        $stmt->bindParam(':id_libro', $id_libro, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':fecha_pedido', $fecha_pedido, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

    } catch (PDOException $e) {
        // Verificar si el error es debido a la violación de una clave única
        if ($e->errorInfo[1] === 1062) {
            echo "<script>alert('El libro no esta disponible.');</script>";
        } else {
            die("Error al confirmar el pedido: " . $e->getMessage());
        }
    }
} else {
    echo "No se recibió ningún pedido de libro.";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #b09e99;
            margin: 0;
            padding: 20px;
        }

        .libro {
            background-color: #fee9e1;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            max-width: 600px;
            margin: 20px auto;
        }

        .libro h2 {
            font-size: 1.5rem;
            margin-top: 0;
        }

        .libro p {
            margin-top: 5px;
        }
        .in-container form input[type="submit"]:hover {
            background-color: #64b6ac;
        }
        
    </style>
</head>
<body>

    <h1>Pedido Confirmado</h1>

    <div class="libro">
        <h2><?php echo $titulo; ?></h2>
        <p>ID del libro: <?php echo $id_libro; ?></p>
        <p>Descripción: <?php echo $descripcion; ?></p>
        <a href="biblioteca.php">Volver</a>
    </div>

</body>
</html>
