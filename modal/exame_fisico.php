<form id="form-problema" action="php/form/exame_fisico.php" method="post" class="todo-modal">
    <div class="modal modal-slide-in sidebar-todo-modal fade" id="modal-exame-fisico">
        <div class="modal-dialog sidebar-lg">
            <div class="modal-content p-0">
                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">Adicionar <?= $title ?></h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <?php

                        inputHidden('id_problema', @$id_problema);

                        inputHidden('id_exame_fisico', @$id_exame_fisico);

                        inputHidden('cod_tipo', @$cod_tipo);
                        
                        inputHidden('cod_status', '');

                        inputHidden('top_position', '');

                        inputHidden('left_position', '');

                        inputHidden('ordem', "");

                        textarea("col-md-12 col-12", "Descrição", "descricao", "", "4");

                        textarea("col-md-12 col-12", "Resposta", "resposta", "", "4");

                        echo '<div id="file-preview" class="mt-1"></div>
                              <label for="file-input" class="btn p-1 mt-1 mb-1 w-100 btn-outline-primary">
                                <div class="icon-wrapper mb-1">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-upload" style="height: 30px;width: 30px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                </div>
                                <h5>Carregar arquivo para resposta</h5>
                              </label>
                              <input type="file" name="file" id="file-input">';

                    ?>
                </div>
                <div class="modal-footer">
                    <?php if( @$acessos[$namePage]['editar'] == true ) { ?>
                        <button type="submit" class="btn btn-primary add-todo-item me-1">Salvar</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</form>