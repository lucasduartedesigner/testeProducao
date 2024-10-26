<?php

session_start();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Situação Problema</title>
</head>

<body>

    <h2>Cadastro Situação Problema</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="php/cadastra/problema.php" method="POST">
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <br>

        <label for="disparador">Disparador:</label>
        <input type="text" name="disparador" id="disparador" required>
        <br>

        <label for="identificacao">Identificação:</label>
        <input type="text" name="identificacao" id="identificacao" required>
        <br>

        <label for="desc_hda">HDA:</label>
        <input type="text" name="desc_hda" id="desc_hda" required>
        <br>

        <label for="desc_hpp">HPP:</label>
        <input type="text" name="desc_hpp" id="desc_hpp" required>
        <br>

        <label for="desc_hs">HS:</label>
        <input type="text" name="desc_hs" id="desc_hs" required>
        <br>

        <label for="desc_hpf">HPF:</label>
        <input type="text" name="desc_hpf" id="desc_hpf" required>
        <br>

        <label for="arquivo">Arquivo:</label>
        <input type="text" name="arquivo" id="arquivo" required>
        <br>

        <label for="diagnostico">Diagnóstico:</label>
        <input type="text" name="diagnostico" id="diagnostico" required>
        <br>

        <button type="submit">Salvar</button>

        <?php if (isset($_SESSION['msg'])): ?>
            <p style="color: red;"><?php echo $_SESSION['msg']; $_SESSION['msg']= "" ?></p>
        <?php endif; ?>

    </form>

</body>

</html>
