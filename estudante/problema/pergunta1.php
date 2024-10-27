<?php

    $sql = "SELECT pq.id_pergunta, pq.descricao, r.id_resposta, r.descricao resposta, r.arquivo
            FROM avaliacao a
              INNER JOIN problema p
                ON a.id_problema = p.id_problema AND p.status IS NOT NULL 
              INNER JOIN pergunta_turma pqt
                ON p.id_problema = pqt.id_problema
                AND a.id_avaliacao = pqt.id_avaliacao
                AND pqt.id_tipo = ?
              INNER JOIN pergunta pq
                ON pqt.id_pergunta = pq.id_pergunta AND pq.status IS NOT NULL
              INNER JOIN resposta r 
                ON pq.id_pergunta = r.id_pergunta AND r.status IS NOT NULL
             WHERE a.status IS NOT NULL
             AND (
                     DATE(a.data_inicio) = CURDATE() OR
                     DATE(a.data_grupo) = CURDATE() OR
                     DATE(a.data_turma) = CURDATE()
                 )
             AND p.id_problema = ?
             AND a.id_avaliacao = ?
             ORDER BY pq.ordem ";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iii", $tipo, $id_problema, $id_avaliacao);

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
    <h4 class='card-header'>Escolhas realizadas</h4>
    <div class="card-body">
        <?php foreach ($data as $item): ?>
            <h2 class="text-secondary"><?= htmlspecialchars($item['descricao'], ENT_QUOTES, 'UTF-8') ?></h2>
            <h4 class=""><?= htmlspecialchars($item['resposta'], ENT_QUOTES, 'UTF-8') ?></h4>
            <?php if (!empty($item['arquivo'])): 
                $arquivo = $item['arquivo'];
                $uploaddir = "../app-assets/images/arquivos/$arquivo";
                $fileType = mime_content_type($uploaddir);
            ?>
                <div class='row d-flex justify-content-center'>
                    <div class='col-12 col-md-12 mt-1 text-center' style='padding-bottom:2px'>
                        <?php if (strpos($fileType, 'image/') === 0): ?>
                            <img class='w-100 thumbnail' src='<?= $uploaddir ?>' alt='<?= htmlspecialchars($arquivo, ENT_QUOTES, 'UTF-8') ?>' data-bs-toggle='modal' data-bs-target='#imageModal' style='cursor:pointer;'>
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
            <div class="mt-1 mb-3"><hr></div>
        <?php endforeach; ?>

    </div>
</div>

<?php if(!empty($status_estudante) && $status_estudante == $tipo && $status_estudante <= 3 && $id_estudante == $_SESSION['id_estudante']){ ?>
    <button id="atualiza" class="btn btn-primary btn-cadastrar w-100 mb-4" data-id="<?= ($status_estudante + 1) ?>">
        Seguir para o próximo passo
    </button>
<?php }  ?>

<?php }else{ ?> 
    <div class="card mt-2">
        <div class="card-body p-0">
            <ul class="list-group" id="basic-list-group">
                <?php

                    $sql = "SELECT p.*, r.descricao resposta, r.arquivo
                            FROM pergunta p
                            INNER JOIN resposta r 
                            ON p.id_pergunta = r.id_pergunta AND r.status IS NOT NULL
                            WHERE p.status IS NOT NULL
                            AND p.id_problema = ?
                            AND p.tipo = ?
                            ORDER BY p.ordem";

                    $stmt = mysqli_prepare($conn, $sql);

                    mysqli_stmt_bind_param($stmt, "ii", $id_problema, $tipo);

                    mysqli_stmt_execute($stmt);

                    $result = mysqli_stmt_get_result($stmt);

                    while($row = mysqli_fetch_array($result)){

                        if(!empty($row))
                        {
                            extract($row);

                            echo "<li class='list-group-item py-1' data-id='$id_pergunta'>";
                              echo "<div class='form-check'>";
                                if($id_estudante == $_SESSION['id_estudante']){
                                  echo "<input type='checkbox' class='form-check-input question-checkbox' id='p-$id_pergunta-$tipo' name='checkbox[]' value='{$id_pergunta}'>";
                                }
                                echo "<label class='form-check-label' for='p-$id_pergunta-$tipo'><h5>$descricao</h5></label>";
                              echo "</div>";
                            echo "</li>";
                        }
                    }

                ?>

            </ul>
        </div>
    </div>

    <?php if(!empty($status_estudante) && $status_estudante == $tipo && $id_estudante == $_SESSION['id_estudante']){ ?>
        <button id="perguntas" class="btn btn-primary btn-cadastrar w-100 mb-4">Escolher as opções do grupo</button>
    <?php } ?>
<?php } ?> 