<?php

    $status_estudante = 0;

    $sql = "SELECT a.id_avaliacao, p.*, pt.id_pessoa, pt.diagnostico analise_estudante, 
                   pt.cod_status status_estudante, CURDATE() dataserver, DATE(a.data_inicio) inicio,
                   pt.id_avaliacao_problema
            FROM avaliacao a
              INNER JOIN problema p 
                ON a.id_problema = p.id_problema 
                AND p.cod_status IS NOT NULL
              INNER JOIN avaliacao_subturma ast
                ON a.id_avaliacao = ast.id_avaliacao
              LEFT JOIN avaliacao_problema pt 
                ON p.id_problema = pt.id_problema
                AND a.id_avaliacao = pt.id_avaliacao
                AND a.codcurso = pt.codcurso
                AND a.periodo = pt.periodo
                AND a.semestre = pt.semestre
                AND a.codturma = pt.codturma
                AND ast.subturma = pt.subturma
            WHERE a.status = 2
            AND (
                    DATE(a.data_inicio) = CURDATE() OR
                    DATE(a.data_fim) = CURDATE()
                )
            AND a.codcurso = ?
            AND a.periodo = ?
            AND a.semestre = ?
            AND a.codturma = ?
            AND ast.subturma = ?
            ORDER BY a.data_inicio desc ";
    
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "iisss", $_SESSION['codcurso'], $_SESSION['periodo'], $_SESSION['semestre'], $_SESSION['codturma'], $_SESSION['subturma']);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $locale = 'pt_BR';

    $row = mysqli_fetch_assoc($result);

    if(!empty($row))
    {
        extract($row);

        $href = "$path?url={$_GET['url']}";

        $_GET['p'] = !empty($_GET['p']) ? $_GET['p'] : 0;

        $_SESSION['status_estudante']  = $status_estudante;

        $_SESSION['id_avaliacao'] = $id_avaliacao;
        $_SESSION['id_avaliacao'] = $id_avaliacao;
        $_SESSION['id_problema']  = $id_problema;
?>

<div class="content-wrapper container-xxl p-0">
	<div class="content-body">
        <div class="bs-stepper checkout-tab-steps mb-2">
            <?php
            $steps = [
                ['p' => 0, 'icon' => 'file-text', 'title' => 'Caso Clínico', 'subtitle' => 'Solução Problema'],
                ['p' => 1, 'icon' => 'user', 'title' => 'O que Perguntar?', 'subtitle' => 'Anamnese do Paciente'],
                ['p' => 2, 'icon' => 'activity', 'title' => 'O que Examinar?', 'subtitle' => 'Exame Físico'],
                ['p' => 3, 'icon' => 'monitor', 'title' => 'Exames à solicitar?', 'subtitle' => 'Exames Laboratoriais'],
                ['p' => 4, 'icon' => 'check-circle', 'title' => 'Hipótese Diagnóstica', 'subtitle' => 'Conclusão do Caso']
            ];
             ?>

            <div class="bs-stepper-header">
                <?php foreach ($steps as $index => $step): if ($step['p'] > $status_estudante) { break; } ?>
                    <a class="step <?php echo (@$_GET['p'] == $step['p']) ? 'active' : ''; ?>" href="<?= "$href&p=" . $step['p'] ?>">
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
    
        <div class="row">
            <div class="<?php echo (@$_GET['p'] == 0 || empty($_GET['p']) || ($_GET['p'] == 2)) ? 'col-lg-12' : 'col-lg-6'; ?>">
            <?php 
                if(@$_GET['p'] == 0 || empty($_GET['p']))
                { 
                    include_once('problema/disparador.php');
                }
                elseif($_GET['p'] == 1)
                { 
                    $title = 'Pergunta';
                    $tipo = 1;
                    include_once('problema/pergunta.php');
                }
                elseif($_GET['p'] == 2)
                { 
                    $title = 'Exame Físico';
                    $tipo = 2;
                    include_once('problema/fisico.php');
                }
                elseif($_GET['p'] == 3)
                {
                    $title = 'Exame Laboratorial';
                    $tipo = 3;
                    include_once('problema/pergunta.php');
                }
                elseif($_GET['p'] == 4)
                {
                    $title = 'Hipótese Diagnóstica';
                    $tipo = 4;
                    include_once('problema/diagnostico.php');
                }

            ?>
            </div>
            <div class="col-lg-6 <?php echo (@$_GET['p'] == 0 || empty($_GET['p']) || ($_GET['p'] == 2)) ? 'd-none' : ''; ?>">
            <?php 
                include_once('problema/sumario.php');
            ?>
            </div>
        </div>
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
<?php  
    }
    else
    {
		msgNotExists('Não encontrada avaliação', 'Acompanhe as próximas avaliações na sua agenda!', "", $raiz);
    }
?>