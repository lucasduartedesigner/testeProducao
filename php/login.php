<?php

session_start();

// Conexão com o banco de dados
require '../conn/conn.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") 
{
    $matricula = $_POST['matricula'];
    $senha     = $_POST['senha'];

    if (!empty($matricula) && !empty($senha)) 
    {
        // Criptografa a senha com MD5 para comparação
        $senhaMd5 = md5($senha);

        // Consulta SQL para verificar o usuário e senha
        $sql = "SELECT * FROM pessoa WHERE matricula = ? AND senha = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $matricula, $senhaMd5);

        $stmt->execute();

        $result = $stmt->get_result();

        // Verifica se há algum resultado na consulta
        if ($result->num_rows > 0) 
        {
            $rows = $result->fetch_assoc();

            foreach ($user as $key => $value) 
            {
                $_SESSION[$key] = $value;
            }

            header("Location: ../dashboard.php");

            exit();
        }
        else
        {
            $_SESSION['msg'] = "Usuário ou senha inválidos!";
        }
    } 
    else
    {
        $_SESSION['msg'] = "Usuário ou senha vazios!";
    }

    if(!empty($_SESSION['msg']))
    {
        header("Location: ../index.php");

        exit();
    }
}
?>