<?php

    session_start(); 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    include_once("../../conn/conn.php");  

    include_once("../function/db.php");  

	include('../../class/database.php');

	$obj   = new Database();

	$table = 'pergunta_turma';

    if(!empty($_SESSION))
    {
        extract($_SESSION);

        $id_pergunta = !empty($_POST['id']) ? $_POST['id'] : $_POST['id_pergunta'];

        $tipo = 2;

        $sql = "SELECT a.*, p.id_problema, pt.id_estudante, 
                       COUNT(pqt.id_pergunta_turma) escolhas
                FROM avaliacao a
                  INNER JOIN avaliacao_subturma ast
                    ON a.id_avaliacao = ast.id_avaliacao
                  INNER JOIN problema p
                    ON a.id_problema = p.id_problema 
                    AND p.status IS NOT NULL 
                  INNER JOIN problema_turma pt
                    ON p.id_problema = pt.id_problema
                    AND a.id_avaliacao = pt.id_avaliacao
                  LEFT JOIN pergunta_turma pqt
                    ON p.id_problema = pqt.id_problema
                    AND a.id_avaliacao = pqt.id_avaliacao
                    AND pqt.id_tipo = ?
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

        mysqli_stmt_bind_param($stmt, "iiiiisss", $tipo, $id_problema, $id_avaliacao, $codcurso, $periodo, $semestre, $codturma, $subturma);

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
                    $status = 1;

                    $escolhas = (!empty($row['escolhas'])) ? $row['escolhas'] : 0;

                    if(!empty($id_pergunta))
                    {

                        $sql = 'SELECT pqt.id_pergunta_turma,
                                       pqt.interpretacao
                                FROM avaliacao a
                                  INNER JOIN problema p
                                    ON a.id_problema = p.id_problema 
                                    AND p.status IS NOT NULL 
                                  INNER JOIN avaliacao_subturma ast
                                    ON a.id_avaliacao = ast.id_avaliacao
                                  INNER JOIN pergunta_turma pqt
                                    ON p.id_problema = pqt.id_problema
                                    AND a.id_avaliacao = pqt.id_avaliacao
                                    AND a.codcurso = pqt.codcurso
                                    AND a.periodo = pqt.periodo
                                    AND a.semestre = pqt.semestre
                                    AND a.codturma = pqt.codturma
                                    AND ast.subturma = pqt.subturma
                                  LEFT JOIN pergunta pq
                                    ON pqt.id_pergunta = pq.id_pergunta 
                                    AND pq.status IS NOT NULL
                                  LEFT JOIN resposta r 
                                    ON pq.id_pergunta = r.id_pergunta 
                                    AND r.status IS NOT NULL
                                 WHERE a.status IS NOT NULL
                                 AND p.id_problema = ?
                                 AND a.id_avaliacao = ?
                                 AND pq.id_pergunta = ?
                                 AND a.codcurso = ?
                                 AND a.periodo = ?
                                 AND a.semestre = ?
                                 AND a.codturma = ?
                                 AND ast.subturma = ?
                                 GROUP BY pqt.id_pergunta_turma,
                                          pqt.interpretacao';
                        
                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "iiiiisss", $id_problema, $id_avaliacao, $id_pergunta, $codcurso, $periodo, $semestre, $codturma, $subturma);

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        $row = mysqli_fetch_assoc($result);
                        
                        if(!empty($row)){ extract($row); }

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
                                             "subturma"	    => "'$subturma'",
                                             "status"	    => "'$status'"
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

                        echo $id_pergunta_turma;
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