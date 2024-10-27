<div class="row match-height">
<?php

    // Função para formatar data
    function formatDate($locale, $dateStr)
    {
        $formatter = new IntlDateFormatter($locale, IntlDateFormatter::FULL, IntlDateFormatter::NONE, null, null, 'E, d MMM, y');
        $date      = new DateTime($dateStr);

        return ucwords($formatter->format($date));
    }

    $sql = "SELECT a.*, p.nome, ast.subturma
            FROM avaliacao a
              INNER JOIN problema p 
                ON a.id_problema = p.id_problema 
                AND p.cod_status IS NOT NULL
              INNER JOIN avaliacao_subturma ast
                ON a.id_avaliacao = ast.id_avaliacao
            WHERE a.status IS NOT NULL
            AND (
                    DATE(a.data_inicio) >= CURDATE() OR
                    DATE(a.data_fim) >= CURDATE()
                )
            AND a.codcurso = ?
            AND a.periodo = ?
            AND a.semestre = ?
            AND a.codturma = ?
            AND ast.subturma = ?
            ORDER BY a.data_inicio, a.data_fim ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iisss", $_SESSION['codcurso'], $_SESSION['periodo'], $_SESSION['semestre'], $_SESSION['codturma'], $_SESSION['subturma']);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $locale = 'pt_BR';

    while ($row = mysqli_fetch_assoc($result)) 
    {
        $href = "$path?id={$row['id_problema']}&p=1";
 
        $data_inicio_formatada = formatDate($locale, $row['data_inicio']);
        $data_grupo_formatada  = formatDate($locale, $row['data_fim']);
?>
    <div class="col-lg-3 col-md-6 col-12">
        <div class="card card-developer-meetup">
            <div class="card-body rounded-top">
                <div class="meetup-header d-flex align-items-center">
                    <div class="my-auto">
                        <h4 class="card-title mb-25"><?= htmlspecialchars($row['nome'], ENT_QUOTES, 'UTF-8') ?></h4>
                        <p class="card-text mb-0"><?= $row['subturma'] ?></p>
                    </div>
                </div>
                <div class="mt-0">
                    <div class="avatar float-start bg-light-primary rounded me-1">
                        <div class="avatar-content">
                            <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                        </div>
                    </div>
                    <div class="more-info">
                        <h6 class="mb-0"><?= $data_inicio_formatada ?></h6>
                        <small>Início da Avaliação</small>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="avatar float-start bg-light-warning rounded me-1">
                        <div class="avatar-content">
                            <i data-feather="calendar" class="avatar-icon font-medium-3"></i>
                        </div>
                    </div>
                    <div class="more-info">
                        <h6 class="mb-0"><?= $data_grupo_formatada ?></h6>
                        <small>Final da Avaliação</small>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
<?php } ?>
</div>
