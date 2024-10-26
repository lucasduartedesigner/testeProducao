<?php
session_start();
require '../../conn/conn.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'];
    $disparador = $_POST['disparador'];
    $identificacao = $_POST['identificacao'];
    $desc_hda = $_POST['desc_hda'];
    $desc_hpp = $_POST['desc_hpp'];
    $desc_hs = $_POST['desc_hs'];
    $desc_hpf = $_POST['desc_hpf'];
    $arquivo = $_POST['arquivo'];
    $diagnostico = $_POST['diagnostico'];

    // Verifica se todos os campos obrigatórios foram preenchidos
    if (!empty($nome) && !empty($disparador) && !empty($identificacao) && !empty($desc_hda) && !empty($desc_hpp) 
        && !empty($desc_hs) && !empty($desc_hpf) && !empty($arquivo) && !empty($diagnostico)) {

        // Verifica se o registro já existe com base em um campo específico
        $sql = "SELECT * FROM problema WHERE nome = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Usuário já existente
            $_SESSION['msg'] = "Problema escolhido já existente.";
            header("Location: ../../problema.php"); // Redireciona para o problema
            exit();        
        } else {
            // Prepara a inserção no banco com os novos campos
            $sql = "INSERT INTO problema (nome, disparador, identificacao, desc_hda, desc_hpp, desc_hs, desc_hpf, arquivo, diagnostico) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssss", $nome, $disparador, $identificacao, $desc_hda, $desc_hpp, $desc_hs, $desc_hpf, $arquivo, $diagnostico);

            // Executa e verifica se a inserção foi bem-sucedida
            if ($stmt->execute()) {
                $_SESSION['msg'] = "Cadastro realizado com sucesso!";
                header("Location: ../../problema.php"); // Redireciona para o problema
                exit();  
            } else {
                $_SESSION['msg'] = "Erro ao registrar situação problema. " . $stmt->error;
                header("Location: ../../problema.php"); // Redireciona para o problema
                exit(); 
            }
        }
    } else {
        $_SESSION['msg'] = "Todos os campos são obrigatórios!";
        header("Location: ../../problema.php"); // Redireciona para o problema
        exit();
    }
}
?>
