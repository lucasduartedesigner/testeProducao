<?php

    $sql = "SELECT pt.id_problema_turma, pt.id_estudante, pt.descricao, pt.status, pt.subturma
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
            AND a.id_problema = ?
            AND a.id_avaliacao = ?
            AND a.codcurso = ?
            AND a.periodo = ?
            AND a.semestre = ?
            AND a.codturma = ?
            AND ast.subturma = ? ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iiiisss", $id_problema, $id_avaliacao, $_SESSION['codcurso'], $_SESSION['periodo'], $_SESSION['semestre'], $_SESSION['codturma'], $_SESSION['subturma']);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);
 
    if(!empty($row['descricao']) && $row['status'] == 5)
    {
?>
<div class="card mt-2">
    <h4 class='card-header'><?= $title?></h4>
    <div class="card-body">
        <h4 class="text-secondary"><?= nl2br($row['descricao']) ?></h4>
    </div>
</div>

<?php }else{ ?> 
    <div class="card mt-2">
        <div class="card-body">
            <?php 
                textarea("col-md-12 col-12", "Resposta", "resposta", "", "12", "maxlength='4000'"); 
            ?>
        </div>
    </div>

    <?php if(!empty($status_estudante) && $status_estudante == $tipo && $id_estudante == $_SESSION['id_estudante']){ ?>
        <button id="diagnostico" class="btn btn-primary btn-cadastrar w-100 mb-4">Enviar diagnóstico do grupo</button>
    <?php } ?>
<?php } ?> 