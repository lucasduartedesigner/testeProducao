<?php $href = "$path?id=".@$id_pessoa; ?>

<div class="content-wrapper container-xxl p-0">
	<div class="content-body">

<form id="form-professor" action="php/form/professor.php" enctype="multipart/form-data" method="post">
    <div class="row mt-2">
        <div class="col-lg-12 content-body">
            <div class="card" style="height: calc(100% - 2rem);">
                <h4 class='card-header'>Dados da Avaliação</h4>
                <div class="card-body">
                    <div class="row">
                        <?php 

                            inputHidden('id_pessoa', @$id_pessoa);

                            inputHidden('cod_tipo', @$cod_tipo);

                            inputHidden("nome", @$nome);
 
                            textarea("col-md-6 col-12", "Disparador", "disparador", @$disparador, "7");

                            textarea("col-md-6 col-12", "Identificação (ID)", "identificacao", @$identificacao, "7");

                            textarea("col-md-6 col-12", "Descrição de História da Doença Atual (HDA)", "desc_hda", @$desc_hda, "7");

                            textarea("col-md-6 col-12", "Descrição de História Patológica Pregressa (HPP)", "desc_hpp", @$desc_hpp, "7");

                            textarea("col-md-6 col-12", "Descrição de História Social (HS)", "desc_hs", @$desc_hs, "7");

                            textarea("col-md-6 col-12", "Descrição de História Familiar (HPF)", "desc_hpf", @$desc_hpf, "7");

                            inputForm("col-md-9 col-12", "Diagnóstico", "diagnostico", @$diagnostico, "", "", "");

                            $options = array('Ativo', 'Inativo');

                            selectOptions("col-md-3 col-12", "Status", 'status', @$status, $options, "");

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
                                    echo "<button class='btn btn-danger mt-3 deleta-img' id='$arquivo' data-title='Arquivo: $arquivo' data-id='$id_professor' data-name='professor'>";
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

    </div>
</div>
