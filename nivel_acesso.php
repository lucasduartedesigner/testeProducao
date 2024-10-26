<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nível Acesso</title>
</head>

<body>

    <h2>Nível Acesso</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/cadastra/nivel_acesso.php" method="POST">
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <br>

        <button type="submit">Confirma</button>

        <?php if (isset($_SESSION['msg'])): ?>
            <p style="color: red;"><?php echo $_SESSION['msg']; $_SESSION['msg']= "" ?></p>
        <?php endif; ?>

    </form>

</body>

</html>
