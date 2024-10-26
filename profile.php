<?php

session_start();

if (!isset($_SESSION['user_id'])) 
{
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Perfil do Usuário</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
    <img src="<?php echo htmlspecialchars($_SESSION['user_picture']); ?>" alt="Foto de Perfil">

    <a href="logout.php">Sair</a>
</body>
</html>
