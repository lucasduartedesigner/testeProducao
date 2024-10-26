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

    <form action="php/cadastra/pessoa.php" method="POST">
        
        <label for="matricula">Matricula:</label>
        <input type="text" name="matricula" id="matricula" required>
        <br>

        <label for="matricula">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <br>

        <label for="text">CPF:</label>
        <input type="text" name="cpf" id="cpf" required>
        <br>
        
        <label for="text">Email:</label>
        <input type="text" name="email" id="email" required>
        <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>
        <br>

        <button type="submit">Entrar</button>
    </form>

</body>

</html>
