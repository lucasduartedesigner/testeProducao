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

        $id_pergunta_turma = $_POST['id_pergunta_turma'];
        $id_problema       = $_POST['id_problema'];
        $id_avaliacao      = $_POST['id_avaliacao'];
        $pergunta          = $_POST['pergunta'];
        $resposta          = $_POST['resposta'];
        $interpretacao     = $_POST['interpretacao'];
        $tipo              = $_POST['tipo'];

        $sql = "SELECT a.id_avaliacao, p.id_problema, pt.id_estudante
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

        mysqli_stmt_bind_param($stmt, "iiiisss", $id_problema, $id_avaliacao, $codcurso, $periodo, $semestre, $codturma, $subturma);

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

                    $arrayDados = array( 
                                         "id_problema"   => "'$id_problema'",
                                         "id_avaliacao"  => "'$id_avaliacao'",
                                         "id_tipo"       => "'$tipo'",
                                         "id_estudante"  => "'$id_estudante'",
                                         "codcurso"      => "'$codcurso'",
                                         "periodo"       => "'$periodo'",
                                         "semestre"      => "'$semestre'",
                                         "codturma"	     => "'$codturma'",
                                         "subturma"	     => "'$subturma'",
                                         "status"	     => "'$status'",
                                         "pergunta"	     => "'$pergunta'",
                                         "interpretacao" => "'$interpretacao'",
                                         "resposta"	     => "'$resposta'"
                                        );

                    $arrayDados = removeNullFromArray($arrayDados);

                    if(!empty($id_pergunta_turma))
                    {
                        $where = " id_pergunta_turma = $id_pergunta_turma ";
                        $obj->update($table, $arrayDados, $where);
                    }
                    else
                    {        
                        $obj->insert($table, $arrayDados);
                        $id_pergunta_turma = $obj->getResult()[0];
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