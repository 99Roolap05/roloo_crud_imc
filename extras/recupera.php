
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular y Guardar IMC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        
        .output-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        
        .success-message {
            color: #4caf50;
            margin-bottom: 20px;
        }
        
        .error-message {
            color: #f44336;
            margin-bottom: 20px;
        }
        
        a {
            color: #333;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
        }
        
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Calcular y Guardar IMC</h1>

    <div class="output-container">
        <?php 
        $peso = $_GET['peso'];
        $estatura = $_GET['estatura'];
        
        echo "Tu peso es ", $peso;
        echo "<br>Tu estatura es ", $estatura;

      
       $imc = $peso / ($estatura * $estatura);

        echo "<br>Tu IMC es ", number_format($imc, 1);

        $estatus = "";
        if ($imc < 18.5) {
            $estatus = "Bajo de peso";
        } elseif ($imc < 25) {
            $estatus = "Normal";
        } else {
            $estatus = "Sobrepeso";
        }
        
        echo "<br>Tu ESTATUS ES ", $estatus;

        $sql = "INSERT INTO imc (peso, estatura, valorimc, estatus) VALUES ('$peso', '$estatura', '$imc', '$estatus')";
        if (mysqli_query($conn, $sql)) {
            echo '<p class="success-message">Registro guardado exitosamente</p>';
        } else {
            echo '<p class="error-message">Error: ' . $sql . '<br>' . mysqli_error($conn) . '</p>';
        }
        mysqli_close($conn);
        ?>
    </div>
    
    <a href="principal.html">Volver</a>
</body>
</html>