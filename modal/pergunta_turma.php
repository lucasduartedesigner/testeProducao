<form id="form-problema" action="php/form/resposta_turma.php" method="post" class="todo-modal">
    <div class="modal fade" id="modal-resposta">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-0">
                <div class="modal-header align-items-center mb-1">
                    <h5 class="modal-title">Responder <?= $title ?></h5>
                    <div class="todo-item-action d-flex align-items-center justify-content-between ms-auto">
                        <i data-feather="x" class="cursor-pointer" data-bs-dismiss="modal" stroke-width="3"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <?php

                        inputHidden('id_problema', @$id_problema);

                        inputHidden('id_avaliacao', @$id_avaliacao);

                        inputHidden('id_pergunta_turma', @$id_pergunta_turma);

                        inputHidden('tipo', @$tipo);

                        inputHidden('ordem', "");

                        textarea("col-md-12 col-12", "Pergunta do Grupo", "descricao", "", "4");

                        $sql = "SELECT p.*, r.descricao resposta, r.arquivo
                                FROM pergunta p
                                INNER JOIN resposta r 
                                ON p.id_pergunta = r.id_pergunta
                                WHERE p.status IS NOT NULL
                                AND p.id_problema = ?
                                AND p.tipo = ?
                                ORDER BY p.ordem";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "ii", $id_problema, $tipo);

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        echo "<div class='col-md-12 col-12 mb-1'>";
                            echo "<label class='form-label'>Perguntas do Gabarito</label>";
                            echo "<select name='id_pergunta' id='id_pergunta' class='form-control form-select'>";
                                echo "<option></option>";

                                while($row = mysqli_fetch_array($result))
                                {
                                    if(!empty($row))
                                    {
                                        extract($row);

                                        echo "<option value='$id_pergunta'>$descricao</option>";
                                    }
                                }

                            echo "</select>";
                        echo "</div>";
                        
                        textarea("col-md-12 col-12 div-resposta", "Resposta", "resposta", "", "4");

                        if($_GET['p'] == 3)
                        {
                            inputForm("col-md-12 col-12 div-resposta", "Custo Exame", "valor", "", "", "valor", "");
                        }

                        echo '<div id="file-preview" class="mt-1"></div>
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