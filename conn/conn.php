<?php
    $servername = "localhost"; // geralmente 'localhost'
    $username = "root";
    $password = "";
    $dbname = "testeProducao";

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }
?>
