<?php

session_start();

require '../../conn/conn.php'; // conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $status = 1;


    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($nome)) {
        // Criptografa a senha com MD5 para comparação
        $senhaMd5 = md5($senha);

        // Consulta SQL para verificar o usuário e senha
        $sql = "SELECT * FROM pessoa WHERE nome = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login bem-sucedido
            $_SESSION['msg'] = "Nivel de acesso já existente";
            header("Location: ../../nivel_acesso.php"); // Redireciona para o nivel_acesso
            exit();        
        } else {
            // Prepara a inserção no banco
            $sql = "INSERT INTO nivel_acesso (nome, status) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $nome, $status);
            // Executa e verifica se a inserção foi bem-sucedida

            if ($stmt->execute()) {
            $_SESSION['msg'] = "Cadastro realizado com sucesso!";
            header("Location: ../../nivel_acesso.php"); // Redireciona para o nivel_acesso
            exit();  
            } else {
            $_SESSION['msg'] = "Erro ao registrar usuário:";
            header("Location: ../../nivel_acesso.php"); // Redireciona para o nivel_acesso
            exit(); 
            }
        }

    } else {
        $error = "Todos os campos são obrigatórios!";
    }     
}
?>