<?php

session_start();

require '../../conn/conn.php'; // conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $matricula = $_POST['matricula'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $matricula = $_POST['matricula'];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($matricula) && !empty($senha) && !empty($cpf) && !empty($email) && !empty($matricula)) {
        // Criptografa a senha com MD5 para comparação
        $senhaMd5 = md5($senha);

        // Consulta SQL para verificar o usuário e senha
        $sql = "SELECT * FROM pessoa WHERE matricula = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $matricula, $senhaMd5);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login bem-sucedido
            $_SESSION['msg'] = "Usuário já existente";
            $_SESSION['matricula'] = $matricula;
            header("Location: index.php"); // Redireciona para o index
            exit();        
        } else {
            // Prepara a inserção no banco
            $sql = "INSERT INTO pessoa (nome, senha, cpf, email, matricula) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nome, $senhaMd5, $cpf, $email, $matricula);
        }
    } else {
        $error = "Todos os campos são obrigatórios!";
    }

     // Executa e verifica se a inserção foi bem-sucedida
     if ($stmt->execute()) {
        echo "Usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar usuário: " . $stmt->error;
    }
}
?>