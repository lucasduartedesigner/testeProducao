<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação</title>
</head>

<body>

    <h2>Avaliação</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/cadastra/avaliacao.php" method="POST">
        
        <label for="codcurso">Curso:</label>
            <select name="codcurso" id="codcurso" required>
                <option value="1">Enfermagem</option>
                <option value="2" selected>Fisioterapia</option>
                <option value="3">Medicina</option>
                <option value="4">Terapia Ocupacional</option>
            </select>
        <br>

        <label for="periodo">Período:</label>
            <select name="periodo" id="periodo" required>
                <option value="1">1º</option>
                <option value="2">2º</option>
                <option value="3">3º</option>
                <option value="4">4º</option>
                <option value="5">5º</option>
                <option value="6" selected>6º</option>
                <option value="7">7º</option>
                <option value="8">8º</option>
                <option value="9">9º</option>
                <option value="10">10º</option>
                <option value="11">11º</option>
                <option value="12">12º</option>
            </select>
        <br>

        <label for="semestre">Semestre Letivo:</label>
        <input type="text" name="semestre" id="semestre" value="2024/2"required>
        <br>

        <label for="subturma">Código Subturma:</label>
            <select name="subturma" id="subturma" required>
                <option value="1">A</option>
                <option value="2">B</option>
                <option value="3">C</option>
                <option value="4" selected>D</option>
                <option value="5">E</option>
                <option value="6">F</option>
                <option value="7">G</option>
                <option value="8">H</option>     
            </select>
        <br>

        <label for="data_inicio">Data Início:</label>
        <input type="text" name="data_inicio" id="data_inicio" value="26/10/2024 10:00" required>
        <br>

        <label for="data_fim">Data Fim:</label>
        <input type="text" name="data_fim" id="data_fim" value="27/10/2024 10:00"required>
        <br>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" value="DESCRIÇÃO"required>
        <br>

        <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="1">Agendado</option>
                <option value="2" selected>Em Andamento</option>
                <option value="3">Concluído</option>
                <option value="4">Cancelado</option>
            </select>
        <br>

        <button type="submit">Salvar</button>

        <?php if (isset($_SESSION['msg'])): ?>
            <p style="color: red;"><?php echo $_SESSION['msg']; $_SESSION['msg']= "" ?></p>
        <?php endif; ?>

    </form>

</body>

</html>
