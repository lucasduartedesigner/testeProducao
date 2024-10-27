
    <div class="body-container p-0" id="body-container">        
        <img src="../app-assets/images/paciente/humano.jpg" alt="Corpo Humano" class="img-fluid1 rounded rounded-3">
        <?php 

            echo "<div class='marker-red' data-toggle='tooltip' title='Abrir zoom da cabeça' style='top: 113.5px; left: 560px;'></div>";
        
            $cond = ($status_estudante == 2) ? 'LEFT JOIN' : 'INNER JOIN';

            $sql = "SELECT pq.*, r.descricao resposta, r.arquivo, pq.top_position, pq.left_position
                    FROM avaliacao a
                      INNER JOIN problema p
                        ON a.id_problema = p.id_problema 
                        AND p.status IS NOT NULL 
                      INNER JOIN avaliacao_subturma ast
                        ON a.id_avaliacao = ast.id_avaliacao
                      INNER JOIN pergunta pq
                        ON p.id_problema = pq.id_problema
                        AND pq.tipo = ?
                        AND pq.status IS NOT NULL
                      INNER JOIN resposta r 
                        ON pq.id_pergunta = r.id_pergunta 
                        AND r.status IS NOT NULL
                      $cond pergunta_turma pqt
                        ON p.id_problema = pqt.id_problema
                        AND a.id_avaliacao = pqt.id_avaliacao
                        AND pq.id_pergunta = pqt.id_pergunta
                        AND a.codcurso = pqt.codcurso
                        AND a.periodo = pqt.periodo
                        AND a.semestre = pqt.semestre
                        AND a.codturma = pqt.codturma
                        AND ast.subturma = pqt.subturma
                     WHERE a.status IS NOT NULL
                     AND (
                             DATE(a.data_inicio) = CURDATE() OR
                             DATE(a.data_grupo) = CURDATE() OR
                             DATE(a.data_turma) = CURDATE()
                         )
                     AND p.id_problema = ?
                     AND a.id_avaliacao = ?
                     AND a.codcurso = ?
                     AND a.periodo = ?
                     AND a.semestre = ?
                     AND a.codturma = ?
                     AND ast.subturma = ?
                     AND pq.status = 1
                     ORDER BY pqt.id_pergunta_turma ";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "iiiiisss", $tipo, 
                                                      $id_problema, 
                                                      $id_avaliacao, 
                                                      $_SESSION['codcurso'], 
                                                      $_SESSION['periodo'], 
                                                      $_SESSION['semestre'], 
                                                      $_SESSION['codturma'], 
                                                      $_SESSION['subturma']);

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            while($row = mysqli_fetch_array($result)) 
            {
                if(!empty($row)) 
                {
                    extract($row);

                    echo "<div class='marker' data-toggle='tooltip' title='$descricao' data-id='$id_pergunta' style='top: {$top_position}px; left: {$left_position}px;'></div>";
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
                    <img src="../app-assets/images/paciente/corpo.jpg" alt="Corpo Humano" class="img-fluid1 rounded rounded-3">
                    <?php 
 
                        $sql = "SELECT pq.*, r.descricao resposta, r.arquivo, pq.top_position, pq.left_position
                                FROM avaliacao a
                                  INNER JOIN problema p
                                    ON a.id_problema = p.id_problema 
                                    AND p.status IS NOT NULL 
                                  INNER JOIN avaliacao_subturma ast
                                    ON a.id_avaliacao = ast.id_avaliacao
                                  INNER JOIN pergunta pq
                                    ON p.id_problema = pq.id_problema 
                                    AND pq.status IS NOT NULL
                                  INNER JOIN resposta r 
                                    ON pq.id_pergunta = r.id_pergunta 
                                    AND r.status IS NOT NULL
                                  $cond pergunta_turma pqt
                                    ON p.id_problema = pqt.id_problema
                                    AND a.id_avaliacao = pqt.id_avaliacao
                                    AND pq.id_pergunta = pqt.id_pergunta
                                    AND a.codcurso = pqt.codcurso
                                    AND a.periodo = pqt.periodo
                                    AND a.semestre = pqt.semestre
                                    AND a.codturma = pqt.codturma
                                    AND ast.subturma = pqt.subturma
                                    AND pqt.id_tipo = ?
                                 WHERE a.status IS NOT NULL
                                 AND (
                                         DATE(a.data_inicio) = CURDATE() OR
                                         DATE(a.data_grupo) = CURDATE() OR
                                         DATE(a.data_turma) = CURDATE()
                                     )
                                 AND p.id_problema = ?
                                 AND a.id_avaliacao = ?
                                 AND a.codcurso = ?
                                 AND a.periodo = ?
                                 AND a.semestre = ?
                                 AND a.codturma = ?
                                 AND ast.subturma = ?
                                 AND pq.status = 2
                                 ORDER BY pqt.id_pergunta_turma ";

                        $stmt = mysqli_prepare($conn, $sql);

                        mysqli_stmt_bind_param($stmt, "iiiiisss", $tipo, 
                                                                  $id_problema, 
                                                                  $id_avaliacao, 
                                                                  $_SESSION['codcurso'], 
                                                                  $_SESSION['periodo'], 
                                                                  $_SESSION['semestre'], 
                                                                  $_SESSION['codturma'], 
                                                                  $_SESSION['subturma']);

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);

                        while($row = mysqli_fetch_array($result)) 
                        {
                                        if(!empty($row)) 
                                        {
                                extract($row);
                                echo "<div class='marker' data-toggle='tooltip' title='$descricao' data-id='$id_pergunta' style='top: {$top_position}px; left: {$left_position}px;'></div>";
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

    <?php if(!empty($status_estudante) && $status_estudante == $tipo && $status_estudante <= 3 && $id_estudante == $_SESSION['id_estudante']){ ?>
        <button id="atualiza" class="btn btn-primary w-100 mt-2 mb-4" data-id="<?= ($status_estudante + 1) ?>">
            Seguir para o próximo passo <i data-feather='arrow-right'></i>
        </button>
    <?php }  ?>

    <?php include_once('../modal/exame_fisico_turma.php'); ?>