<?php

    session_start(); 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'avaliacao_problema';

    if(!empty($_SESSION))
    {
        extract($_SESSION);

        $sql = "SELECT p.id_problema, p.cod_status, pt.id_estudante, pt.id_avaliacao_problema
                FROM avaliacao a
                  INNER JOIN problema p
                    ON a.id_problema = p.id_problema 
                    AND p.cod_status IS NOT NULL
                  INNER JOIN avaliacao_subturma ast
                    ON a.id_avaliacao = ast.id_avaliacao
                  INNER JOIN avaliacao_problema pt
                    ON p.id_problema = pt.id_problema
                    AND a.id_avaliacao = pt.id_avaliacao
                    AND a.codcurso = pt.codcurso
                    AND a.periodo = pt.periodo
                    AND a.semestre = pt.semestre
                    AND a.codturma = pt.codturma
                    AND ast.subturma = pt.subturma
                WHERE a.status IS NOT NULL
                AND (
                        DATE(a.data_inicio) = CURDATE() OR
                        DATE(a.data_fim) = CURDATE()
                    )
                AND p.id_problema = ?
                AND a.id_avaliacao = ?
                AND a.codcurso = ?
                AND a.periodo = ?
                AND a.semestre = ?
                AND a.codturma = ?
                AND ast.subturma = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "iiiisss", $_POST['id_problema'], $_POST['id_avaliacao'], $codcurso, $periodo, $semestre, $codturma, $subturma);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        if(!empty($row['id_problema']))
        {
            $id_problema = $row['id_problema'];

            if(!empty($row['id_estudante']))
            {
                if($row['id_estudante'] == $id_estudante)
                { 
                    $status = $_POST['status'];

                    if($status > $row['status'])
                    {
                        $sql = "UPDATE avaliacao_problema 
                                SET status = ?
                                WHERE id_avaliacao_problema = ? ";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "ii", $status, $row['id_avaliacao_problema']);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        echo "Sucesso!";
                    }
                    else
                    {
                        echo "Não é possível refazer a avaliação.";
                    }
                }
                else
                {
                    echo "Avaliação já iniciada por outro estudante.";
                }
            }
            else
            {
                echo "Avaliação precisa ser gerada para seguir esse passo.";
            }
        }
        else
        {
            echo "Avaliação não está disponível para início.";
        }           
    }
    else
    {
        echo "Precisa estar logado para iniciar avaliação.";
    }           

?>