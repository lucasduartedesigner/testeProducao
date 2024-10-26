<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exame Laboratorial</title>
</head>

<body>

    <h2>Exame Laboratorial</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/cadastra/exame_laboratorial.php" method="POST">

        <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" id="descricao" required>
        <br>
        
        <label for="gabarito">Gabarito</label>
        <input type="text" name="gabarito" id="gabarito" required>
        <br>

        <label for="valor">Valor R$</label>
        <input type="text" name="valor" id="valor" required>
        <br>

        <button type="submit">Salvar</button>

        <?php if (isset($_SESSION['msg'])): ?>
            <p style="color: red;"><?php echo $_SESSION['msg']; $_SESSION['msg']= "" ?></p>
        <?php endif; ?>

    </form>

</body>

</html>
