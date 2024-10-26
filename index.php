<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <h2>Login</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/login.php" method="POST">
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" id="matricula" required>
        <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <br>

        <button type="submit">Entrar</button>
    </form>

</body>

</html>
