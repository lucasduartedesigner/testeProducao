<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'vendor/autoload.php';

    // Configurações da API do Google
    $clientID     = '6035653190-3mvpvfhsns2viql0u7egfcdccib4dhin.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri  = 'https://appcasoclinico.com.br/google-callback.php';

    // Configura o cliente OAuth 2.0 do Google
    $client = new Google_Client();

    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
    $client->addScope("email");
    $client->addScope("profile");

    // URL para login
    $loginUrl = $client->createAuthUrl();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login com Google</title>
</head>
<body>
    <a href="<?php echo htmlspecialchars($loginUrl); ?>">Login com Google</a>
</body>
</html>