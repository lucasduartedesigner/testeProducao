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

        $sql = "SELECT a.*, p.id_problema, pt.id_pessoa, ast.subturma
                FROM avaliacao a
                  INNER JOIN problema p 
                    ON a.id_problema = p.id_problema
                    AND p.cod_status IS NOT NULL
                  INNER JOIN avaliacao_subturma ast
                    ON a.id_avaliacao = ast.id_avaliacao
                  LEFT JOIN avaliacao_problema pt 
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
                AND a.codcurso = ?
                AND a.periodo = ?
                AND a.semestre = ?
                AND a.codturma = ?
                AND ast.subturma = ? ";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "iisss", $codcurso, $periodo, $semestre, $codturma, $subturma);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $locale = 'pt_BR';

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
                    echo 'teste 1';
                }
                else
                {
                    echo "Avaliação já iniciada por outro estudante.";
                }
            }
            else
            {
                $status = 1;

                $arrayDados = array( 
                                     "id_problema"  => "'$id_problema'",
                                     "id_avaliacao" => "'$id_avaliacao'",
                                     "id_pessoa"    => "'$id_estudante'",
                                     "codcurso"     => "'$codcurso'",
                                     "periodo"      => "'$periodo'",
                                     "semestre"     => "'$semestre'",
                                     "codturma"	    => "'$codturma'",
                                     "codturma"	    => "'$codturma'",
                                     "subturma"	    => "'$subturma'",
                                     "cod_status"	=> "'$status'"
                                    );

                $arrayDados = removeNullFromArray($arrayDados);

                $obj->insert($table, $arrayDados);
                $id_problema_turma = $obj->getResult()[0];

                if(!empty($id_problema_turma))
                {
                    $table = 'notificacao_professor';

                    $arrayDados = array( 
                                         "titulo"       => "'O $subturma iniciou a Discussão do Caso.'",
                                         "descricao"    => "'Clique no link para acompanhar o grupo no Caso Clínico.'",
                                         "link"         => "'https://appcasoclinico.com.br/caso.php?id=$id_avaliacao&pro=$id_problema&p=0'",
                                         "status"       => "'1'",
                                         "id_professor" => "'$id_professor'",
                                         "user_created" => "'$id_estudante'",
                                         "type_created" => "'2'"
                                        );

                    $arrayDados = removeNullFromArray($arrayDados);

                    $obj->insert($table, $arrayDados);
                    $id_notificacao = $obj->getResult()[0];
                }
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