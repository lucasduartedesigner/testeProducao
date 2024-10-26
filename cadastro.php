<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>

    <h2>Cadastro</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/cadastra/pessoa.php" method="POST">
        
        <label for="matricula">Matricula:</label>
        <input type="text" name="matricula" id="matricula" required>
        <br>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" required>
        <br>
        
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" required>
        <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <br>

        <button type="submit">Entrar</button>

        <?php if (isset($_SESSION['msg'])): ?>
            <p style="color: red;"><?php echo $_SESSION['msg']; $_SESSION['msg']= "" ?></p>
        <?php endif; ?>

    </form>

</body>

</html>
