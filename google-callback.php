<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require_once 'vendor/autoload.php';

    session_start();

    // Configurações da API do Google
    $clientID     = '6035653190-3mvpvfhsns2viql0u7egfcdccib4dhin.apps.googleusercontent.com';
    $clientSecret = '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';
    $redirectUri  = 'https://appcasoclinico.com.br/google-callback.php';

    // Configura o cliente OAuth 2.0 do Google
    $client = new Google_Client();

    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);

    if (isset($_GET['code']))
    {
        // Obtém o token de autenticação
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token['access_token']);

        // Obter informações do perfil do Google
        $googleService = new Google_Service_Oauth2($client);
        $userData = $googleService->userinfo->get();

        // Armazena os dados do usuário na sessão
        $_SESSION['user_id'] = $userData->id;
        $_SESSION['user_name'] = $userData->name;
        $_SESSION['user_email'] = $userData->email;
        $_SESSION['user_picture'] = $userData->picture;

        // Redireciona para a página inicial ou de perfil
        header('Location: profile.php');
        exit();
    }

?>
