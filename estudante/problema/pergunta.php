
<?php

    $sql = "SELECT a.status, pp.pergunta, pp.resposta, pqt.id_avaliacao_problema
            FROM avaliacao a
              INNER JOIN problema p
                ON a.id_problema = p.id_problema 
                AND p.cod_status IS NOT NULL 
              INNER JOIN avaliacao_subturma ast
                ON a.id_avaliacao = ast.id_avaliacao
              INNER JOIN avaliacao_problema pqt
                ON p.id_problema = pqt.id_problema
                AND a.id_avaliacao = pqt.id_avaliacao
                AND a.codcurso = pqt.codcurso
                AND a.periodo = pqt.periodo
                AND a.semestre = pqt.semestre
                AND a.codturma = pqt.codturma
                AND ast.subturma = pqt.subturma
              LEFT JOIN pergunta_problema pp
                ON pp.id_avaliacao_problema = pqt.id_avaliacao_problema
                AND pp.cod_status IS NOT NULL
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
             AND ast.subturma = ?
             ORDER BY a.status ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iiiisss", $id_problema, $id_avaliacao, $_SESSION['codcurso'], $_SESSION['periodo'], $_SESSION['semestre'], $_SESSION['codturma'], $_SESSION['subturma']);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = [];

    while ($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }
 
    if(!empty($data))
    {
?>

<div class="card mt-2">
    <h4 class='card-header'><?php echo ($_GET['p'] == 1) ? 'Perguntas realizadas' : 'Exames realizados'; ?> </h4>
    <div class="card-body card-body-content" id="card-body-content"  style="min-height:420px !important">
        <?php foreach ($data as $item): ?>
        <?php

            $resposta = (empty($item['resposta']) && empty($item['id_pergunta']) && empty($item['arquivo'])) ? 'Aguardando Resposta...' : $item['resposta'];

            if($tipo == 3 && (!empty($item['valor']) || !empty($item['valornovo'])))
            {
                $valor =  (!empty($item['valor'])) ? moeda($item['valor']) : moeda($item['valornovo']);

                $item['pergunta'] = "{$item['pergunta']} - {$valor}";
            }

        ?>
            <h2 class="text-secondary"><?= @$item['pergunta'] ?></h2>
            <h4 class=""><?= htmlspecialchars($resposta, ENT_QUOTES, 'UTF-8') ?></h4>

            <?php if(!empty($item['interpretacao'])){ ?>
                <h6><?= htmlspecialchars($item['interpretacao'], ENT_QUOTES, 'UTF-8') ?></h6>
            <?php } ?>

            <?php if (!empty($item['arquivo'])): 
                $arquivo_resposta = $item['arquivo'];
                $uploaddir = "../app-assets/images/arquivos/$arquivo_resposta";
                $fileType = mime_content_type($uploaddir);
            ?>
                <div class='row d-flex justify-content-center'>
                    <div class='col-12 col-md-12 mt-1 text-center' style='padding-bottom:2px'>
                        <?php if (strpos($fileType, 'image/') === 0): ?>
                            <img class='w-100 thumbnail' src='<?= $uploaddir ?>' alt='<?= htmlspecialchars($arquivo_resposta, ENT_QUOTES, 'UTF-8') ?>' data-bs-toggle='modal' data-bs-target='#imageModal' style='cursor:pointer;'>
                        <?php elseif (strpos($fileType, 'video/') === 0): ?>
                            <video controls class='w-100' style='max-height: 400px;'>
                                <source src='<?= $uploaddir ?>' type='<?= $fileType ?>'>
                            </video>
                        <?php elseif (strpos($fileType, 'audio/') === 0): ?>
                            <audio controls class='w-100'>
                                <source src='<?= $uploaddir ?>' type='<?= $fileType ?>'>
                            </audio>
                        <?php elseif ($fileType === 'application/pdf'): ?>
                            <embed src='<?= $uploaddir ?>' type='application/pdf' width='100%' height='400px' />
                        <?php else: ?>
                            <p>Arquivo selecionado não pode ser visualizado.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <div class="mt-1 mb-1"><hr></div>
        <?php endforeach; ?>
        </div>
        <div class="card-body card-body-content" id="card-body-content"  style="min-height:70px !important">
        <?php if( $id_estudante == $_SESSION['id_estudante'] && $status_estudante == $_GET['p'] ) { ?>

        <form id="form-problema-estudante" action="../py/" method="post" class="todo-modal row chat-app-form">
            
            <?php

                inputHidden('id_avaliacao_problema', @$id_avaliacao_problema);

                inputHidden('id_avaliacao', @$id_avaliacao);

                inputHidden('id_problema', @$id_problema);

                textarea("col-md-10 col-10", "Descrição", "pergunta", "", "1");

            ?>
            <div class="col-md-2 col-2 text-center">
                <button type="button" class="btn btn-primary" style="margin-top:25px">
                <i data-feather='send'></i>
                </button>
            </div>
                        
        </form>
        <?php } ?>

    </div>

    
</div>

<?php } ?>


<?php if(!empty($status_estudante) && $status_estudante == $tipo && $status_estudante <= 3 && $id_estudante == $_SESSION['id_estudante']){ ?>
    <button id="atualiza" class="btn btn-primary btn-cadastrar w-100 mt-1" data-id="<?= ($status_estudante + 1) ?>">
        Seguir para o próximo passo <i data-feather='arrow-right'></i>
    </button>
<?php }  ?>

