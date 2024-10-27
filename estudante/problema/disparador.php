<div class="card mt-2">
    <h4 class='card-header'>Descrição do Caso Clínico</h4>
    <div class="card-body">
        <h4 class="text-secondary"><?= $disparador ?></h4>
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
    </div>
</div>

<?php if(empty($status_estudante)){ ?>
    <button id="iniciar" class="btn btn-primary btn-cadastrar w-100 mb-4">Iniciar Avaliação do <?= $_SESSION['subturma'] ?></button>
<?php } ?>
