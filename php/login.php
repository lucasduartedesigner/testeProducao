<?php
session_start();
require 'conn.php'; // Inclua o arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        // Criptografa a senha com MD5 para comparação
        $passwordMd5 = md5($password);

        // Consulta SQL para verificar o usuário e senha
        $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $passwordMd5);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há algum resultado na consulta
        if ($result->num_rows > 0) {
            // Login bem-sucedido
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("Location: dashboard.php"); // Redireciona para o dashboard
            exit();
        } else {
            $error = "Usuário ou senha inválidos!";
        }
    } else {
        $error = "Usuário ou senha vazios!";
    }
}
?>