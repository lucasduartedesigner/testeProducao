<?php

session_start();

require '../conn/conn.php'; // conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula = $_POST['matricula'];
    $senha = $_POST['senha'];

    if (!empty($matricula) && !empty($senha)) {
        // Criptografa a senha com MD5 para comparação
        $senhaMd5 = md5($senha);

        // Consulta SQL para verificar o usuário e senha
        $sql = "SELECT * FROM pessoa WHERE matricula = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $matricula, $senhaMd5);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há algum resultado na consulta
        if ($result->num_rows > 0) {
            // Login bem-sucedido
            $_SESSION['loggedin'] = true;
            $_SESSION['matricula'] = $matricula;
            header("Location: ../dashboard.php"); // Redireciona para o dashboard
            exit();
        } else {
            $error = "Usuário ou senha inválidos!";
        }
    } else {
        $error = "Usuário ou senha vazios!";
    }
}
?>