<?php
session_start();

// Inicializar arreglo si no existe
if (!isset($_SESSION['personas'])) {
    $_SESSION['personas'] = [];
}

// CREAR
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['accion'] == "crear") {
    $nueva = [
        'nombre'    => $_POST['nombre'],
        'direccion' => $_POST['direccion'],
        'telefono'  => $_POST['telefono']
    ];
    $_SESSION['personas'][] = $nueva;
}

// ACTUALIZAR
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['accion'] == "actualizar") {
    $indice = $_POST['indice'];
    $_SESSION['personas'][$indice]['nombre']    = $_POST['nombre'];
    $_SESSION['personas'][$indice]['direccion'] = $_POST['direccion'];
    $_SESSION['personas'][$indice]['telefono']  = $_POST['telefono'];
}

// ELIMINAR
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['accion'] == "eliminar") {
    $indice = $_POST['indice'];
    unset($_SESSION['personas'][$indice]);
    $_SESSION['personas'] = array_values($_SESSION['personas']); // Reindexar
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #eafaf1; /* verde pastel */
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            text-align: center;
            color: #2d7a4f; /* verde oscuro */
        }
        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background: #f9c1d9; /* rosa pastel */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        form input {
            width: 95%;
            padding: 10px;
            border: 1px solid #2d7a4f;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        button {
            padding: 10px 20px;
            background-color: #2d7a4f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #195c37;
        }
        a {
            color: #c2185b;
            font-weight: bold;
            text-decoration: none;
        }
        a:hover {
            color: #ff4081;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #2d7a4f;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #f9c1d9;
        }
        tr:nth-child(even) {
            background: #d1f0d6;
        }
    </style>
</head>
<body>

    <h1>CRUD</h1>

    <form method="POST">
        <input type="hidden" name="accion" id="accion" value="crear">
        <input type="hidden" name="indice" id="indice">

        <label>Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label>Dirección:</label>
        <input type="text" name="direccion" id="direccion">

        <label>Teléfono:</label>
        <input type="text" name="telefono" id="telefono">

        <button type="submit">Guardar</button>
    </form>

    <h2>Lista de Personas</h2>

    <table>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($_SESSION['personas'] as $i => $p): ?>
        <tr>
            <td><?= $p['nombre'] ?></td>
            <td><?= $p['direccion'] ?></td>
            <td><?= $p['telefono'] ?></td>
            <td>
                <button onclick='editar(<?= json_encode($p) ?>, <?= $i ?>)'>✏️ Editar</button>

                <form method="POST" style="display:inline">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="indice" value="<?= $i ?>">
                    <button style="background:#c2185b;">🗑️ Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

    <script>
    function editar(persona, indice) {
        document.getElementById('nombre').value = persona.nombre;
        document.getElementById('direccion').value = persona.direccion;
        document.getElementById('telefono').value = persona.telefono;
        document.getElementById('indice').value = indice;
        document.getElementById('accion').value = 'actualizar';
    }
    </script>

</body>
</html>
