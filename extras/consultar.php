<?php
$servername = "localhost";
$database = "extra";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['delete'])) {
    $consultaId = $_POST['consulta_id'];
    $deleteQuery = "DELETE FROM imc WHERE id = $consultaId";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Consulta eliminada exitosamente.";
    } else {
        echo "Error al eliminar la consulta: " . mysqli_error($conn);
    }
}
if (isset($_POST['edit'])) {
    $consultaId = $_POST['consulta_id'];
    $newWeight = $_POST['new_weight'];

    $updateQuery = "UPDATE imc SET peso = $newWeight WHERE id = $consultaId";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Peso actualizado exitosamente.";
    } else {
        echo "Error al actualizar el peso: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de IMC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0 auto; /* Agrega margen automático para centralizar */
            max-width: 800px; /* Limita el ancho del contenido */
        }

        /* Resto de estilos... */

        .data-entry {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        /* Botones... */
    </style>
</head>
<body>
    <h1>Consulta de IMC</h1>

    <div class="output-container">
        <?php
        // Resto del código PHP
        ?>
    </div>
    
    <a href="principal.html">Volver</a>
        <?php
        $sql = "SELECT * FROM imc";

        echo "<b>Database Output</b><br><br>";

        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $consultaId = $row["id"];
                $field1name = $row["peso"];
                $field2name = $row["estatura"];
                $field3name = $row["valorimc"];
                $field4name = $row["estatus"];
                
                echo '<div class="data-entry">';
                echo '<strong>Peso:</strong> ' . $field1name . '<br>';
                echo '<strong>Estatura:</strong> ' . $field2name . '<br>';
                echo '<strong>Valor IMC:</strong> ' . $field3name . '<br>';
                echo '<strong>Estatus:</strong> ' . $field4name . '<br>';
                echo '<form method="post">';
                echo '<input type="hidden" name="consulta_id" value="' . $consultaId . '">';
                echo '<button class="delete-button" name="delete">Eliminar Consulta</button>';
                echo '</form>';
                echo '<form method="post">';
                echo '<input type="hidden" name="consulta_id" value="' . $consultaId . '">';
                echo '<label for="new_weight">Nuevo Peso:</label>';
                echo '<input type="number" step="0.01" name="new_weight" required>';
                echo '<button class="edit-button" name="edit">Editar Peso</button>';
                echo '</form>';
                echo '</div>';


echo '<form method="post">';
echo '<input type="hidden" name="consulta_id" value="' . $consultaId . '">';
echo '<label for="new_height">Nueva Estatura:</label>';
echo '<input type="number" step="0.01" name="new_height" required>';
echo '<button class="edit-button" name="edit_height">Editar Estatura</button>';
echo '</form>';
            }
            $result->free();
        }
        
        if (isset($_POST['edit'])) {
            $consultaId = $_POST['consulta_id'];
            $newWeight = $_POST['new_weight'];
            $newHeight = $field2name; // Keep the current height
            $newHeightInMeters = $newHeight / 10; // Convert height to meters
            $newIMC = calculateIMC($newWeight, $newHeightInMeters); // Calculate new IMC
            $newStatus = determineStatus($newIMC); // Determine new status
        
            $updateQuery = "UPDATE imc SET peso = $newWeight, valorimc = $newIMC, estatus = '$newStatus' WHERE id = $consultaId";
            if (mysqli_query($conn, $updateQuery)) {
                echo "Peso, IMC y estado actualizados exitosamente.";
            } else {
                echo "Error al actualizar el peso, IMC y estado: " . mysqli_error($conn);
            }
        }
        
        if (isset($_POST['edit_height'])) {
            $consultaId = $_POST['consulta_id'];
            $newHeight = $_POST['new_height'];
            $newWeight = $field1name; // Keep the current weight
            $newHeightInMeters = $newHeight / 100; // Convert height to meters
            $newIMC = calculateIMC($newWeight, $newHeightInMeters); // Calculate new IMC
            $newStatus = determineStatus($newIMC); // Determine new status
        
            $updateQuery = "UPDATE imc SET estatura = $newHeight, valorimc = $newIMC, estatus = '$newStatus' WHERE id = $consultaId";
            if (mysqli_query($conn, $updateQuery)) {
                echo "Estatura, IMC y estado actualizados exitosamente.";
            } else {
                echo "Error al actualizar la estatura, IMC y estado: " . mysqli_error($conn);
            }
        }
        mysqli_close($conn);

        function calculateIMC($weight, $height) {
            return $weight / ($height * $height);
        }




        function determineStatus($imc) {
            if ($imc < 18.5) {
                return 'Bajo de Peso';
            } elseif ($imc < 24.9) {
                return 'Normal';
            } elseif ($imc < 29.9) {
                return 'Sobrepeso';
            } else {
                return 'Obeso';
            }
        }
        ?>
    </div>
    
    
    <a href="principal.html">Volver</a>
</body>
</html>