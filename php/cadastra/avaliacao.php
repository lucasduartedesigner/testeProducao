<?php

session_start();

require '../../conn/conn.php'; // Conexão com o banco de dados

function converteDataHoraParaMySQL($dataHora) {
    // Usa DateTime para criar a data e hora no formato MySQL
    $dataObj = DateTime::createFromFormat('d/m/Y H:i', $dataHora);
    if ($dataObj) {
        return $dataObj->format('Y-m-d H:i:s'); // Converte para o formato MySQL
    }
    return null; // Retorna null se o formato estiver incorreto
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codcurso = $_POST['codcurso'];
    $periodo = $_POST['periodo'];
    $semestre = $_POST['semestre'];
    $codturma = "MED" . str_pad($_POST['periodo'], 2, "0", STR_PAD_LEFT);
    $data_inicio = converteDataHoraParaMySQL($_POST['data_inicio']);
    $data_fim = converteDataHoraParaMySQL($_POST['data_fim']);
    
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($codcurso) && !empty($periodo) && !empty($semestre) && !empty($codturma) && 
        !empty($data_inicio) && !empty($data_fim) && !empty($descricao) && !empty($status)) {

        // Verifica se o registro já existe com base na descrição
        $sql = "SELECT * FROM avaliacao WHERE descricao = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $descricao);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Problema já existente
            $_SESSION['msg'] = "Avaliação escolhido já existente.";
            header("Location: ../../avaliacao.php"); // Redireciona para o avaliacao
            exit();        
        } else {
            // Prepara a inserção no banco com os novos campos
            $sql = "INSERT INTO avaliacao (codcurso, periodo, semestre, codturma, data_inicio, data_fim, descricao, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $codcurso, $periodo, $semestre, $codturma, $data_inicio, $data_fim, $descricao, $status);

            // Executa e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Cadastro realizado com sucesso!";
                header("Location: ../../avaliacao.php"); // Redireciona para o avaliacao
                exit();  
            } else {
                $_SESSION['msg'] = "Erro ao registrar avaliação." . $stmt->error;
                header("Location: ../../avaliacao.php"); // Redireciona para o avaliacao
                exit(); 
            }
        }
    } else {
        $_SESSION['msg'] = "Todos os campos são obrigatórios!";
        header("Location: ../../avaliacao.php"); // Redireciona para o avaliacao
        exit();
    }
}
?>
