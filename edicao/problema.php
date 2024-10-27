<?php $href = "$path?id=".@$id_problema; ?>

<div class="content-wrapper container-xxl p-0">
	<div class="content-body">
        <div class="bs-stepper checkout-tab-steps mb-2">
            <?php
            $steps = [
                ['p' => 1, 'icon' => 'file-text', 'title' => 'Disparador', 'subtitle' => 'Solução Problema'],
                ['p' => 2, 'icon' => 'activity', 'title' => 'O que Examinar?', 'subtitle' => 'Exame Físico'],
                ['p' => 3, 'icon' => 'monitor', 'title' => 'Exames à solicitar?', 'subtitle' => 'Exames Laboratoriais']
            ];
            
            $idExists = isset($_GET['id']);
            ?>

            <div class="bs-stepper-header">
                <?php foreach ($steps as $index => $step): if (!$idExists && $step['p'] !== 1) { break; } ?>
                    <a class="step <?php echo ($_GET['p'] == $step['p']) ? 'active' : ''; ?>" href="<?= "$href&p=" . $step['p'] ?>">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box">
                                <i data-feather="<?= $step['icon'] ?>" class="font-medium-3"></i>
                            </span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title"><?= $step['title'] ?></span>
                                <span class="bs-stepper-subtitle"><?= $step['subtitle'] ?></span>
                            </span>
                        </button>
                    </a>
                    <?php if ($index < count($steps) - 1): ?>
                        <div class="line">
                            <i data-feather="chevron-right" class="font-medium-2"></i>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <?php 
            if($_GET['p'] == 1 || empty($_GET['p']))
            { 
                ?>

<form id="form-problema" action="php/form/problema.php" enctype="multipart/form-data" method="post">
    <div class="row mt-2">
        <div class="col-lg-12 content-body">
            <div class="card" style="height: calc(100% - 2rem);">
                <h4 class='card-header'>Dados da Avaliação</h4>
                <div class="card-body">
                    <div class="row">
                        <?php 

                            inputHidden('id_problema', @$id_problema);

                            inputHidden("nome", @$nome);
 
                            textarea("col-md-6 col-12", "Disparador", "disparador", @$disparador, "7");

                            textarea("col-md-6 col-12", "Identificação (ID)", "identificacao", @$identificacao, "7");

                            textarea("col-md-6 col-12", "Descrição de História da Doença Atual (HDA)", "desc_hda", @$desc_hda, "7");

                            textarea("col-md-6 col-12", "Descrição de História Patológica Pregressa (HPP)", "desc_hpp", @$desc_hpp, "7");

                            textarea("col-md-6 col-12", "Descrição de História Social (HS)", "desc_hs", @$desc_hs, "7");

                            textarea("col-md-6 col-12", "Descrição de História Familiar (HPF)", "desc_hpf", @$desc_hpf, "7");

                            inputForm("col-md-9 col-12", "Diagnóstico", "diagnostico", @$diagnostico, "", "", "");

                            $options = array('Ativo', 'Inativo');

                            selectOptions("col-md-3 col-12", "Status", 'cod_status', @$cod_status, $options, "");

                            if(!empty($arquivo))
                            {
                                $nome = $nome ?? '';

                                $uploaddir = "app-assets/images/arquivos/$arquivo";
                                $fileType = mime_content_type($uploaddir);

                                //echo "<div class='row d-flex justify-content-center'>";
                                echo "<div class='col-12 col-md-12 mt-1 mb-1 text-center'>";

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

                                // Adicionar o botão de deletar
                                if( @$acessos[$namePage]['deletar'] == true ) {
                                    echo "<button class='btn btn-danger mt-3 deleta-img' id='$arquivo' data-title='Arquivo: $arquivo' data-id='$id_problema' data-name='problema'>";
                                    echo "<i data-feather='trash-2'></i> Deletar";
                                    echo "</button>";
                                }
                                echo "</div>";
                                //echo "</div>";
                            }
                            else
                            {
                                echo '<div class="col-12 col-md-12 mt-1 mb-1 text-center"><div id="file-preview"></div>
                                    <label for="file-input" class="btn p-5 my-2 w-100 btn-outline-primary">
                                        <div class="icon-wrapper mb-2">
                                        <i data-feather="upload"></i>
                                        </div>
                                        <h2>Carregar arquivo para disparador</h2>
                                    </label>
                                    <input type="file" name="file" id="file-input"></div>';
                            }
                        ?>

                        <?php if( @$acessos[$namePage]['editar'] == true ) { ?>
                            <div class="col-12 col-md-9">
                                <button type="submit" class="btn btn-primary btn-cadastrar w-100 mt-1 mb-3">Salvar</button>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="button" class="btn btn-info btn-gerar-ia w-100 mt-1 mb-3">Gerar Caso com IA</button>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>

    </div>


</form>

                <?php
            }
            elseif($_GET['p'] == 2)
            { 
                $title = 'Exame Físico';
                $tipo = 2;
                ?>
    <div class="body-container" id="body-container">        
        <img src="app-assets/images/paciente/humano.jpg" alt="Corpo Humano" class="img-fluid1 rounded rounded-3">
        <?php 

            echo "<div class='marker-red' data-toggle='tooltip' title='Abrir zoom da cabeça' style='top: 113.5px; left: 560px;'></div>";

            $sql = "SELECT p.*, p.top_position, p.left_position
                    FROM exame_fisico p
                    WHERE p.cod_status = 1
                    AND p.id_problema = ?
                    AND p.cod_tipo = ? 
                    ORDER BY p.ordem ";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $id_problema, $tipo);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_array($result)) 
            {
                if(!empty($row)) 
                {
                    extract($row);

                    echo "<div class='marker' data-toggle='tooltip' title='$descricao' data-id='$id_exame_fisico' style='top: {$top_position}px; left: {$left_position}px;'></div>";
                }
            } 
        ?>
    </div>

    <div class="modal modal-slide-in1 sidebar-todo-modal1 fade" id="cabeca">
        <div class="modal-dialog sidebar-lg1">
            <div class="modal-content p-0">
                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">Exames Físicos</h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <img src="app-assets/images/paciente/corpo.jpg" alt="Corpo Humano" class="img-fluid1 rounded rounded-3">
                    <?php 
 
                        $sql = "SELECT p.*, p.top_position, p.left_position
                                FROM exame_fisico p
                                WHERE p.cod_status = 2
                                AND p.id_problema = ?
                                AND p.cod_tipo = ?
                                ORDER BY p.ordem";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "ii", $id_problema, $tipo);

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        while($row = mysqli_fetch_array($result))
                        {
                            if(!empty($row)) 
                            {
                                extract($row);
                                echo "<div class='marker' data-toggle='tooltip' title='$descricao' data-id='$id_exame_fisico' style='top: {$top_position}px; left: {$left_position}px;'></div>";
                            }
                        } 
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary add-todo-item me-1">Prosseguir</button>
                </div>
            </div>
        </div>
    </div>

                <?php

            }
            elseif($_GET['p'] == 3)
            { 
                $title = 'Exame Laboratorial';
                $tipo = 3;
?>
<?php

$sql = "SELECT count(*) total
        FROM exame_laboratorial p
        WHERE p.cod_tipo IS NOT NULL
        AND p.id_problema = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id_problema);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_array($result);

if($row['total'] <= 30)
{
  if( @$acessos[$namePage]['editar'] == true ) 
  {
      $draggable = "draggable";
?>
<button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal-exame-laboratorial">
Adicionar
</button>
<?php
  } 
} 
?> 

<section id="sortable-lists">
<div class="row">
    <div class="col-sm-12 mt-2">
        <div class="card">
            <div class="card-body p-0">
                <ul class="list-group" id="basic-list-group1">
                    <?php

                        $sql = "SELECT p.*
                                FROM exame_laboratorial p
                                WHERE p.cod_tipo IS NOT NULL
                                AND p.id_problema = ?";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "i", $id_problema);

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        while($row = mysqli_fetch_array($result)){

                            if(!empty($row))
                            {
                                extract($row);
                                
                                $resposta = (!empty($resposta)) ? $resposta : "<span class='text-danger fst-italic'>Sem resposta cadastrada</span>";
                                
                                if($tipo == 3 && !empty($valor))
                                {
                                    $valor = moeda($valor);
                                    
                                    $descricao = "$descricao - <b>$valor</b>";
                                }

                                if(!empty($arquivo))
                                {
                                    $arquivo = "<span class='text-center' data-bs-toggle='tooltip' data-bs-placement='top' title='Arquivo anexado'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-upload-cloud'><polyline points='16 16 12 12 8 16'></polyline><line x1='12' y1='12' x2='12' y2='21'></line><path d='M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3'></path><polyline points='16 16 12 12 8 16'></polyline></svg>
                                    </span>";
                                }
                                else
                                {
                                    $arquivo = "";
                                }

                                echo "<li class='list-group-item draggable1' data-id='$id_exame_laboratorial'>
                                        <div class='row'>
                                            <div class='col-11 d-flex align-items-center'>
                                                <button type='button' class='btn btn-icon btn-primary waves-effect waves-float waves-light me-2' data-id='$id_exame_laboratorial' onClick='editarExameLaboratorial($id_exame_laboratorial)'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-edit'>
                                                        <path d='M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7'></path>
                                                        <path d='M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z'></path>
                                                    </svg>
                                                </button>
                                          
                                                <div class='more-info'>
                                                    <h5 class='mb-1'>$descricao $gabarito</h5>
                                                    <span>$resposta $arquivo</span>
                                                </div>
                                            </div>";
                                if (@$acessos[$namePage]['deletar'] == true) {
                                    echo "<div class='col-sm-1 d-flex justify-content-end align-items-center'>
                                            <button type='button' class='btn btn-icon btn-danger waves-effect waves-float waves-light  deletar' data-id='$id_exame_laboratorial' data-title='Pergunta: $descricao' data-name='exame_laboratorial'>
                                                <svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-trash-2'>
                                                    <polyline points='3 6 5 6 21 6'></polyline>
                                                    <path d='M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2'></path>
                                                    <line x1='10' y1='11' x2='10' y2='17'></line>
                                                    <line x1='14' y1='11' x2='14' y2='17'></line>
                                                </svg>
                                            </button>
                                          </div>";
                                }
                                echo "
                                        </div>
                                    </li>";

                            }
                        }
                    ?>

                </ul>
            </div>
        </div>
    </div>
</div>
</section>
<?php
            }

        ?>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Visualização da Imagem</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center p-0">
        <img id="modalImage" src="<?php if(!empty($uploaddir)) { echo $uploaddir; } ?>" class="img-fluid rounded-bottom" alt="Imagem">
      </div>
    </div>
  </div>
</div>