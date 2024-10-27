<?php

	function enviaWhatsapp($phone, $message, $api)
	{
        $api_instance   = $api['api_instance'];
        $id_instance    = $api['id_instance'];
        $token_instance = $api['token_instance'];
        $token_security = $api['token_security'];
 
		$phone = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($phone)));

        $curl = curl_init();

        $url = 'https://api.z-api.io/instances/3CED7608B9D6806C594E72B70F2FFCF9/token/7451AD74CE9EE71D346712A7/send-text';

        curl_setopt_array($curl, array(
          CURLOPT_URL            => "$api_instance",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING       => "",
          CURLOPT_MAXREDIRS      => 10,
          CURLOPT_TIMEOUT        => 30,
          CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST  => "POST",
          CURLOPT_POSTFIELDS     => "{\"phone\": \"$phone\", \"message\": \"$message\"}",
          CURLOPT_HTTPHEADER     => array(
            "client-token: $token_security",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        if ($err) 
        {
          return "cURL Error #:" . $err;
        } 
        else 
        {
          return $response;
        }
	}

?>