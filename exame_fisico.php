<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exame Físico</title>
</head>

<body>

    <h2>Exame Físico</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/cadastra/avaliacao.php" method="POST">
        
        <label for="codcurso">Curso:</label>
            <select name="codcurso" id="codcurso" required>
                <option value="1">Enfermagem</option>
                <option value="2">Fisioterapia</option>
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
                <option value="6">6º</option>
                <option value="7">7º</option>
                <option value="8">8º</option>
                <option value="9">9º</option>
                <option value="10">10º</option>
                <option value="11">11º</option>
                <option value="12">12º</option>
            </select>
        <br>

        <label for="semestre">Semestre Letivo:</label>
        <input type="text" name="semestre" id="semestre" required>
        <br>




        <button type="submit">Salvar</button>

        <?php if (isset($_SESSION['msg'])): ?>
            <p style="color: red;"><?php echo $_SESSION['msg']; $_SESSION['msg']= "" ?></p>
        <?php endif; ?>

    </form>

</body>

</html>
