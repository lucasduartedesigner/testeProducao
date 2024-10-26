<div class="modal fade" id="new-task-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-0">
            <div class="modal-header align-items-center mb-1">
                <h5 class="modal-title" id="descricao">Detalhe do Exame</h5>
                <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                    <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                </div>
            </div>
            <div class="modal-body">
                <h4 id="resposta"></h4>
                <div id="file-preview" class="mt-1"></div>
            </div>
            <div class="modal-body d-none" id="interpretar">
                <form action="../php/form/pergunta_turma.php" method="post" class="todo-modal">
                    <?php

                    inputHidden('id_problema', @$id_problema);

                    inputHidden('id_avaliacao', @$id_avaliacao);

                    inputHidden('id_pergunta', @$id_pergunta);

                    inputHidden('id_pergunta_turma', @$id_pergunta_turma);

                    inputHidden('tipo', @$tipo);

                    textarea("col-md-12 col-12", "Interpretação da Equipe", "interpretacao", "", "4");

                    ?>
                    <button type="submit" class="btn btn-primary add-todo-item me-1">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>