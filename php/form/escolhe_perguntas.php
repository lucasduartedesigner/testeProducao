<?php

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'pergunta_turma';

    if(!empty($_SESSION))
    {
        extract($_SESSION);

        $tipo = $_POST['tipo'];

        $sql = "SELECT a.id_avaliacao, p.id_problema, pt.id_estudante, 
                       COUNT(pqt.id_pergunta_turma) escolhas
                FROM avaliacao a
                  INNER JOIN problema p
                    ON a.id_problema = p.id_problema AND p.status IS NOT NULL 
                  INNER JOIN problema_turma pt
                    ON p.id_problema = pt.id_problema
                    AND a.id_avaliacao = pt.id_avaliacao
                  LEFT JOIN pergunta_turma pqt
                    ON p.id_problema = pqt.id_problema
                    AND a.id_avaliacao = pqt.id_avaliacao
                    AND pqt.id_tipo = ?
                WHERE a.status IS NOT NULL
                AND (
                        DATE(a.data_inicio) = CURDATE() OR
                        DATE(a.data_grupo) = CURDATE() OR
                        DATE(a.data_turma) = CURDATE()
                    )
                AND p.id_problema = ?
                AND a.id_avaliacao = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "iii", $tipo, $_POST['id_problema'], $_POST['id_avaliacao']);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        if(!empty($row['id_problema']) && !empty($row['id_avaliacao']))
        {
            $id_problema  = $row['id_problema'];
            $id_avaliacao = $row['id_avaliacao'];

            if(!empty($row['id_estudante']))
            {
                if($row['id_estudante'] == $id_estudante)
                { 
                    $status = 1;

                    $escolhas = (!empty($row['escolhas'])) ? $row['escolhas'] : 0;

                    if(!empty($_POST['checkbox']))
                    {
                        $count = 0;

                        foreach($_POST['checkbox'] as $id_pergunta)
                        {
                            $arrayDados = array( 
                                                 "id_pergunta"  => "'$id_pergunta'",
                                                 "id_problema"  => "'$id_problema'",
                                                 "id_avaliacao" => "'$id_avaliacao'",
                                                 "id_tipo"      => "'$tipo'",
                                                 "id_estudante" => "'$id_estudante'",
                                                 "codcurso"     => "'$codcurso'",
                                                 "periodo"      => "'$periodo'",
                                                 "semestre"     => "'$semestre'",
                                                 "codturma"	    => "'$codturma'",
                                                 "status"	    => "'$status'"
                                                );

                            $arrayDados = removeNullFromArray($arrayDados);

                            $obj->insert($table, $arrayDados);
                            $id_pergunta_turma = $obj->getResult()[0];

                            $count++;
                        }
                    }
                    else
                    {
                        echo "Nenhum item foi selecionado!";
                    }

                }
                else
                {
                    echo "Avaliação já iniciada por outro estudante";
                }
            }
            else
            {
                echo "Avaliação precisa ser gerada para seguir esse passo.";
            }
        }
        else
        {
            echo "Avaliação não está disponível para salvar dados.";
        } 
    }
    else
    {
        echo "Precisa estar logado para iniciar avaliação.";
    }           

?>