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
            header("Location: ../../cadastro.php"); // Redireciona para o cadastro
            exit();        
        } else {
            // Prepara a inserção no banco
            $sql = "INSERT INTO pessoa (nome, senha, cpf, email, matricula) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nome, $senhaMd5, $cpf, $email, $matricula);
            // Executa e verifica se a inserção foi bem-sucedida

            if ($stmt->execute()) {
            $_SESSION['msg'] = "Cadastro realizado com sucesso!";
            header("Location: ../../cadastro.php"); // Redireciona para o cadastro
            exit();  
            } else {
            $_SESSION['msg'] = "Erro ao registrar usuário:";
            header("Location: ../../cadastro.php"); // Redireciona para o cadastro
            exit(); 
            }
        }

    } else {
        $error = "Todos os campos são obrigatórios!";
    }

     
}
?>