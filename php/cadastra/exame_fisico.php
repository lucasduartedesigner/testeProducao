<?php

session_start();

require '../../conn/conn.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descricao = $_POST['descricao'];
    $gabarito = 1;
    $status = 1;
    $cod_tipo = 1;
    $top_position = $_POST['top_position'];
    $left_position = $_POST['left_position'];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($descricao) && isset($gabarito) && isset($status) && isset($cod_tipo) &&
        !empty($top_position) && !empty($left_position)) {

        // Verifica se o registro já existe com base na descrição
        $sql = "SELECT * FROM exame_fisico WHERE descricao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $descricao);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Problema já existente
            $_SESSION['msg'] = "Exame físico já existente.";
            header("Location: ../../exame_fisico.php"); // Redireciona para o exame_fisico
            exit();        
        } else {
            // Prepara a inserção no banco com os novos campos
            $sql = "INSERT INTO exame_fisico (descricao, gabarito, cod_status, cod_tipo, top_position, left_position) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siiiss", $descricao, $gabarito, $status, $cod_tipo, $top_position, $left_position);

            // Executa e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Cadastro realizado com sucesso!";
                header("Location: ../../exame_fisico.php"); // Redireciona para o exame_fisico
                exit();  
            } else {
                $_SESSION['msg'] = "Erro ao registrar exame." . $stmt->error;
                header("Location: ../../exame_fisico.php"); // Redireciona para o exame_fisico
                exit(); 
            }
        }
    } else {
        $_SESSION['msg'] = "Todos os campos são obrigatórios!";
        header("Location: ../../exame_fisico.php"); // Redireciona para o exame_fisico
        exit();
    }
}
?>
