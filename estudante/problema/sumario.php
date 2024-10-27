<div class="card mt-2">
    <h4 class='card-header'>Prontuário</h4>
    <div class="card-body">
        <h6 class="text-secondary">Descrição do Caso Clínico</h6>
        <h5 class="text-secondary"><?= $disparador ?></h5>
        <?php
            if(!empty($arquivo)) 
            {
                $nome = $nome ?? '';

                $uploaddir = "../app-assets/images/arquivos/$arquivo";
                $fileType = mime_content_type($uploaddir);

                echo "<div class='row d-flex justify-content-center'>";
                echo "<div class='col-12 col-md-12 mt-1 mb-3 text-center' style='padding-bottom:2px'>";

                // Verifica o tipo de arquivo e exibe a visualização adequada
                if (strpos($fileType, 'image/') === 0) 
                {
                    // Exibir imagem
                    echo "<img class='w-100' src='$uploaddir' alt='$arquivo' data-bs-toggle='modal' data-bs-target='#imageModal' style='cursor:pointer;'>";
                }
                elseif (strpos($fileType, 'video/') === 0) 
                {
                    // Exibir vídeo
                    echo "<video controls class='w-100' style='max-height: 400px;'><source src='$uploaddir' type='$fileType'></video>";
                } 
                elseif (strpos($fileType, 'audio/') === 0)
                {
                    // Exibir áudio
                    echo "<audio controls class='w-100'><source src='$uploaddir' type='$fileType'></audio>";
                } 
                elseif ($fileType === 'application/pdf') 
                {
                    // Exibir PDF
                    echo "<embed src='$uploaddir' type='application/pdf' width='100%' height='400px' />";
                } 
                else
                {
                    // Tipo de arquivo não suportado para visualização
                    echo "<p>Arquivo selecionado não pode ser visualizado.</p>";
                }

                echo "</div>";
                echo "</div>";
            }
         ?>

<h4 class="mt-1"><hr></h4>

<?php

    $sql = "SELECT a.status, pp.pergunta, pp.resposta
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

    mysqli_stmt_bind_param($stmt, "iiiisss", 
                           $id_problema, 
                           $id_avaliacao, 
                           $_SESSION['codcurso'], 
                           $_SESSION['periodo'], 
                           $_SESSION['semestre'], 
                           $_SESSION['codturma'], 
                           $_SESSION['subturma']);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $data = [];

    while ($row = mysqli_fetch_assoc($result))
    {
       // $data[] = $row;
    }

    $count = 0;

    $dataGrouped = [];

    if(!empty($data))
    {

        // Iterar pelos grupos de id_tipo
        foreach ($data as $item => $items) 
        {

            if ($_GET['p'] && $count == 0) { $card = 'card-body-content'; $count = 1; }else{ $card = ''; }

            echo "<div class='$card'>";

            foreach ($data as $item):

                $resposta = (empty($item['resposta']) && empty($item['id_pergunta']) && empty($item['arquivo'])) ? 'Aguardando Resposta...' : $item['resposta']; 

                  echo "<div class='row'>";
                    echo "<div class='col-12 col-md-10' style='padding-bottom:2px'>";
                      echo "<h4 class='text-secondary'>{$item['pergunta']}</h4>";
                      echo "<h6 class=''>$resposta</h6>";

                      if(!empty($item['interpretacao']))
                      {
                        echo "<h6>{$item['interpretacao']}</h6>";
                      }

                    echo "</div>";

                    if (!empty($item['arquivo'])): 

                        $arquivo = $item['arquivo'];
                        $uploaddir = "../app-assets/images/arquivos/$arquivo";
                        $fileType = mime_content_type($uploaddir);

                        echo "<div class='col-12 col-md-2 pt-1 text-center' style='padding-bottom:2px'>";
                             if (strpos($fileType, 'image/') === 0): 
                                echo "<a class='btn btn-outline-primary' href='#' data-bs-toggle='modal' data-bs-target='#fileModal' onclick='openFileModal(\"$uploaddir\", \"image\")'>";
                                    echo "<i data-feather='image'></i>";
                                echo "</a>";
                             elseif (strpos($fileType, 'video/') === 0): 
                                echo "<a class='btn btn-outline-primary' href='#' data-bs-toggle='modal' data-bs-target='#fileModal' onclick='openFileModal(\"$uploaddir\", \"video\")'>";
                                    echo "<i data-feather='video'></i>";
                                echo "</a>";
                             elseif (strpos($fileType, 'audio/') === 0): 
                                echo "<a class='btn btn-outline-primary' href='#' data-bs-toggle='modal' data-bs-target='#fileModal' onclick='openFileModal(\"$uploaddir\", \"audio\")'>";
                                   echo "<i data-feather='music'></i>";
                                echo "</a>";
                             elseif ($fileType === 'application/pdf'): 
                                echo "<a class='btn btn-outline-primary' href='$uploaddir' target='_blank'>";
                                    echo "<i data-feather='file'></i>";
                                echo "</a>";
                             else: 
                                echo "<p>Arquivo selecionado não pode ser visualizado.</p>";
                             endif; 
                        echo "</div>";

                    endif;

                  echo "</div>";

                  echo "<div class='mt-1 mb-1'><hr></div>";

              

             endforeach;

            echo "</div>";
         }

        if(!empty($analise_estudante))
        { 
            echo "<h6 class='text-secondary'>Hipótese Diagnóstica</h6>";
            echo "<h4 class='text-secondary'><?= nl2br($analise_estudante) ?></h4>";
         } 
        
?>
    </div>
</div>

<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileModalLabel">Visualizar Arquivo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center" id="modalFileContent">
      </div>
    </div>
  </div>
</div>
<?php }  ?>