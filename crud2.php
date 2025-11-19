<?php
$conexion = mysqli_connect("localhost", "root", "", "empresa");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        switch ($_POST['accion']) {
            case 'crear':
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];
                $sql = "INSERT INTO empleados (nombre, direccion, telefono) VALUES ('$nombre', '$direccion', '$telefono')";
                mysqli_query($conexion, $sql);
                break;
            case 'actualizar':
                $clave = $_POST['clave'];
                $nombre = $_POST['nombre'];
                $direccion = $_POST['direccion'];
                $telefono = $_POST['telefono'];
                $sql = "UPDATE empleados SET nombre='$nombre', direccion='$direccion', telefono='$telefono' WHERE clave=$clave";
                mysqli_query($conexion, $sql);
                break;
            case 'eliminar':
                $clave = $_POST['clave'];
                $sql = "DELETE FROM empleados WHERE clave=$clave";
                mysqli_query($conexion, $sql);
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Empleados</title>
    <style>
        body { background-color: white; font-family: Arial; }
        .container { width: 80%; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .form-group { margin: 10px 0; }
        input[type="text"] { padding: 5px; width: 200px; }
        .btn { padding: 5px 10px; background-color: #008CBA; color: white; border: none; cursor: pointer; }
        .btn-danger { background-color: #f44336; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Gestión de Empleados</h2>
        
        <!-- Formulario para crear/actualizar -->
        <form method="POST">
            <input type="hidden" name="accion" value="crear">
            <input type="hidden" name="clave" id="clave">
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
                <label>Dirección:</label>
                <input type="text" name="direccion" id="direccion" required>
            </div>
            <div class="form-group">
                <label>Teléfono:</label>
                <input type="text" name="telefono" id="telefono" required>
            </div>
            <button type="submit" class="btn">Guardar</button>
        </form>

        <!-- Tabla de empleados -->
        <table>
            <tr>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            <?php
            $resultado = mysqli_query($conexion, "SELECT * FROM empleados");
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>";
                echo "<td>" . $fila['clave'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['direccion'] . "</td>";
                echo "<td>" . $fila['telefono'] . "</td>";
                echo "<td>
                    <form method='POST' style='display:inline'>
                        <input type='hidden' name='accion' value='eliminar'>
                        <input type='hidden' name='clave' value='" . $fila['clave'] . "'>
                        <button type='submit' class='btn btn-danger'>Eliminar</button>
                    </form>
                    <button onclick='editar(" . json_encode($fila) . ")' class='btn'>Editar</button>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>

    <script>
    function editar(empleado) {
        document.getElementById('clave').value = empleado.clave;
        document.getElementById('nombre').value = empleado.nombre;
        document.getElementById('direccion').value = empleado.direccion;
        document.getElementById('telefono').value = empleado.telefono;
        document.querySelector('input[name="accion"]').value = 'actualizar';
    }
    </script>
</body>
</html>