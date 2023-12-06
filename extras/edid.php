<?php
$servername = "localhost";
$database = "extra";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $newPeso = $_POST['new_peso'];
    $newEstatura = $_POST['new_estatura'];

    $updateQuery = "UPDATE imc SET peso='$newPeso', estatura='$newEstatura' WHERE id=$id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Registro actualizado exitosamente.";
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
</head>
<body>
    <h2>Editar Registro</h2>
    <?php
    if (isset($_GET['id'])) {
        $idToEdit = $_GET['id'];
        $editQuery = "SELECT * FROM imc WHERE id = $idToEdit";
        $editResult = mysqli_query($conn, $editQuery);
        $editData = mysqli_fetch_assoc($editResult);
        ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo $idToEdit; ?>">
            Peso: <input type="text" name="new_peso" value="<?php echo $editData['peso']; ?>"><br>
            Estatura: <input type="text" name="new_estatura" value="<?php echo $editData['estatura']; ?>"><br>
            <input type="submit" value="Actualizar">
        </form>

        <?php
    } else {
        echo "No se proporcionó un ID válido para editar.";
    }
    ?>

    <br>
    <a href="javascript:void(0);" onclick="window.close();">Cerrar</a>
</body>
</html>
