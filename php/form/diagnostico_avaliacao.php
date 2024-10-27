<?php

    session_start(); 

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'problema_turma';

    if(!empty($_SESSION))
    {
        extract($_SESSION);

        $sql = "SELECT p.id_problema, a.id_avaliacao, p.status, pt.id_estudante, pt.id_problema_turma
                FROM avaliacao a
                  INNER JOIN problema p 
                    ON a.id_problema = p.id_problema 
                    AND p.status IS NOT NULL
                  INNER JOIN avaliacao_subturma ast
                    ON a.id_avaliacao = ast.id_avaliacao
                  INNER JOIN problema_turma pt
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
                        DATE(a.data_grupo) = CURDATE() OR
                        DATE(a.data_turma) = CURDATE()
                    )
                AND p.id_problema = ?
                AND a.id_avaliacao = ?
                AND a.codcurso = ?
                AND a.periodo = ?
                AND a.semestre = ?
                AND a.codturma = ?
                AND ast.subturma = ? ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "iiiisss", $_SESSION['id_problema'], $_SESSION['id_avaliacao'], $_SESSION['codcurso'], $_SESSION['periodo'], $_SESSION['semestre'], $_SESSION['codturma'], $_SESSION['subturma']);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);

        if(!empty($row['id_problema']) && !empty($row['id_avaliacao']))
        {
            $id_problema  = $row['id_problema'];
            $id_avaliacao = $row['id_avaliacao'];
            $id_professor = $row['id_professor'];

            if(!empty($row['id_estudante']))
            {
                if($row['id_estudante'] == $id_estudante)
                { 
                    $status = 5;

                    if($status > $row['status'])
                    {
                        $sql = "UPDATE problema_turma 
                                SET status = ? , descricao = ? 
                                WHERE id_problema_turma = ? ";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "isi", $status, $_POST['resposta'], $row['id_problema_turma']);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        $table = 'notificacao_professor';

                        $arrayDados = array( 
                                             "titulo"       => "'O $subturma finalizou a Discussão do Caso.'",
                                             "descricao"    => "'Clique no link para ver o diagnóstico do grupo no Caso Clínico.'",
                                             "link"         => "'https://appcasoclinico.com.br/caso.php?id=$id_avaliacao&pro=$id_problema&p=4'",
                                             "status"       => "'1'",
                                             "id_professor" => "'$id_professor'",
                                             "user_created" => "'$id_estudante'",
                                             "type_created" => "'2'"
                                            );

                        $arrayDados = removeNullFromArray($arrayDados);

                        $obj->insert($table, $arrayDados);
                        $id_notificacao = $obj->getResult()[0];
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