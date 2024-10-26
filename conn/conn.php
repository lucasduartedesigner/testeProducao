<?php
    $servername = "localhost"; // geralmente 'localhost'
    $username = "seu_usuario";
    $password = "sua_senha";
    $dbname = "nome_do_banco";

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
?>
