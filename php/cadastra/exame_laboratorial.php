<?php

session_start();

require '../../conn/conn.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descricao = $_POST['descricao'];
    $gabarito = 1;
    $status = 1;
    $valor = $_POST['valor'];

    // var_dump($_POST);

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($descricao) && isset($gabarito) && isset($status) && isset($valor)) {

        // Verifica se o registro já existe com base na descrição
        $sql = "SELECT * FROM exame_laboratorial WHERE descricao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $descricao);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Problema já existente
            $_SESSION['msg'] = "Exame laboratorial já existente.";
            header("Location: ../../exame_laboratorial.php"); // Redireciona para o exame_laboratorial
            exit();        
        } else {
            // Prepara a inserção no banco com os novos campos
            $sql = "INSERT INTO exame_laboratorial (descricao, gabarito, status, valor) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $descricao, $gabarito, $status, $valor);

            // Executa e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Cadastro realizado com sucesso!";
                header("Location: ../../exame_laboratorial.php"); // Redireciona para o exame_laboratorial
                exit();  
            } else {
                $_SESSION['msg'] = "Erro ao registrar exame." . $stmt->error;
                header("Location: ../../exame_laboratorial.php"); // Redireciona para o exame_laboratorial
                exit(); 
            }
        }
    } else {
        $_SESSION['msg'] = "Todos os campos são obrigatórios!";
        header("Location: ../../exame_laboratorial.php"); // Redireciona para o exame_laboratorial
        exit();
    }
}
?>
