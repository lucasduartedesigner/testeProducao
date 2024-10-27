<div class="row">
    <div class="col-12 col-lg-8">
        <div class="card">
            <h4 class='card-header'>Dados</h4>
            <div class="card-body">
                <div class="row">
                    <?php 

                        inputForm("col-md-12 col-12", "Nome", "nome", $nome, "disabled", "", "");

                        inputForm("col-md-4 col-12", "Matrícula", "matricula", $matricula, "disabled", "", "");

                        inputForm("col-md-4 col-12", "CPF", "cpf", $cpf, "disabled", "cpf", "");

                        $options = array(1 => 'Ativo', 0 => 'Inativo');

                        //selectOptions("col-md-4 col-12", "Status", 'status', $status, $options, "");
                    
                        inputForm("col-md-4 col-12", "Status", "status", @$options[$status], "disabled", "", "");

                        $options = array(13 => 'Medicina');

                        //selectOptionsKey("col-md-3 col-12", "Curso", 'codcurso', $curso, $options, "");
                    
                        inputForm("col-md-3 col-12", "Curso", "codcurso", @$options[$codcurso], "disabled", "", "");

                        $options = array(5 => '5º',  6 => '6º');

                        //selectOptionsKey("col-md-3 col-12", "Período", 'periodo', @$periodo, $options, "");
                    
                        inputForm("col-md-3 col-12", "Período", "periodo", @$options[$periodo], "disabled", "", "");

                        $options = array('2024/2' => '2024/2');

                        //selectOptionsKey("col-md-3 col-12", "Semestre", 'semestre', @$semestre, $options, "");
                    
                        inputForm("col-md-3 col-12", "Semestre", "semestre", @$semestre, "disabled", "", "");

                        $options = array(
                                            'GRUPO A' => 'GRUPO A', 
                                            'GRUPO B' => 'GRUPO B',
                                            'GRUPO C' => 'GRUPO C',
                                            'GRUPO D' => 'GRUPO D',
                                            'GRUPO E' => 'GRUPO E',
                                            'GRUPO F' => 'GRUPO F',
                                            'GRUPO G' => 'GRUPO G',
                                            'GRUPO H' => 'GRUPO H',
                                        );

                        //selectOptionsKey("col-md-3 col-12", "Turma", 'subturma', @$subturma, $options, "");
                        inputForm("col-md-3 col-12", "Turma", "subturma", @$subturma, "disabled", "", "");

                        inputForm("col-md-12 col-12", "Email", "email", $email, "disabled", "email", "");

                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card">
            <h4 class='card-header'>Foto</h4>
            <div class="card-body">
                <?php

                    if(!empty($foto))
                    {
                        $nome = $nome ?? '';

                        $uploaddir = "../app-assets/images/fotos/estudante/$foto";

                        echo "<div class='row d-flex justify-content-center'>";
                            echo "<div class='col-12 col-md-8 mb-2 text-center'>";
                                echo "<img class='w-100 rounded-circle' src='$uploaddir'>";
                                    echo "<button class='btn btn-danger mt-2 deleta-img' id='fotos' data-title='Foto: $nome' data-id='$id_estudante' data-name='estudante'>";
                                        echo "<i data-feather='trash-2'></i> Deletar";
                                    echo "</button>";
                            echo "</div>";
                        echo "</div>";
                    }
                    else
                    {
                        echo "<form action='../php/envio/fotos.php?id_estudante=$id_estudante' class='dropzone dropzone-area dz-clickable' id='dpz-single-file' style='min-height: 302px;'>";
                            echo "<div class='dz-message'>Envie sua foto para perfil.</div>";
                        echo "</form>";
                    }

                ?>
            </div>
        </div>
    </div>
</div>