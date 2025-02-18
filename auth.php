<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Configura la conexión a la base de datos
        $servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "juguetes_sonrisas"; // Usa comillas invertidas en el nombre de la base de datos

        // Crea la conexión a la base de datos
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        if ($_POST['action'] === 'login') {
            $user = $_POST['username'];
            $pass = $_POST['password'];

            // Usar consultas preparadas para evitar inyecciones SQL
            $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $query->bind_param("s", $user);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                // Comparar las contraseñas con password_verify si usas hash
                if (password_verify($pass, $row['password'])) {
                    echo "Inicio de sesión exitoso.";
                } else {
                    echo "Usuario o contraseña incorrectos.";
                }
            } else {
                echo "Usuario o contraseña incorrectos.";
            }

        } elseif ($_POST['action'] === 'register') {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $confirmPass = $_POST['confirm_password'];

            // Verificar que las contraseñas coinciden
            if ($pass === $confirmPass) {
                // Usar password_hash para guardar la contraseña de forma segura
                $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

                // Usar consultas preparadas para evitar inyecciones SQL
                $query = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $query->bind_param("ss", $user, $hashedPass);

                if ($query->execute()) {
                    echo "Usuario registrado con éxito.";
                } else {
                    echo "Error al registrar usuario: " . $conn->error;
                }
            } else {
                echo "Las contraseñas no coinciden.";
            }
        }

        // Cerrar la conexión
        $conn->close();
    }
}
?>
