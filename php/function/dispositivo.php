<?php

	function isMobileDevice() 
	{
		return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i" , $_SERVER["HTTP_USER_AGENT"]);
	}

	//Verifica o dispositivo do aluno
	if(isMobileDevice())
	{
		$dispositivo = "Mobile";
	}
	else 
	{
		$dispositivo = "Desktop";
	}

	//Variavel com dados do usuario
	$user_agent     =   $_SERVER['HTTP_USER_AGENT'];

	//Função que identifica sistema operacional
	function getOS() 
	{ 

		global $user_agent;

		$os_platform    =   "Unknown OS Platform";

		$os_array       =   array(
                                '/windows nt 11/i'      =>  'Windows 11',
								'/windows nt 10/i'      =>  'Windows 10',
                                '/windows nt 10.0|windows nt 10/i' => 'Windows 10',
								'/windows nt 6.3/i'     =>  'Windows 8.1',
								'/windows nt 6.2/i'     =>  'Windows 8',
								'/windows nt 6.1/i'     =>  'Windows 7',
								'/windows nt 6.0/i'     =>  'Windows Vista',
								'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
								'/windows nt 5.1/i'     =>  'Windows XP',
								'/windows xp/i'         =>  'Windows XP',
								'/windows nt 5.0/i'     =>  'Windows 2000',
								'/windows me/i'         =>  'Windows ME',
								'/win98/i'              =>  'Windows 98',
								'/win95/i'              =>  'Windows 95',
								'/win16/i'              =>  'Windows 3.11',
								'/macintosh|mac os x/i' =>  'Mac OS X',
								'/mac_powerpc/i'        =>  'Mac OS 9',
								'/linux/i'              =>  'Linux',
								'/ubuntu/i'             =>  'Ubuntu',
								'/iphone/i'             =>  'iPhone',
								'/ipod/i'               =>  'iPod',
								'/ipad/i'               =>  'iPad',
								'/android/i'            =>  'Android',
								'/blackberry/i'         =>  'BlackBerry',
								'/webos/i'              =>  'Mobile',
                                '/cros/i'               => 'Chrome OS',
                                '/windows phone/i'      => 'Windows Phone',
                                '/symbianos/i'          => 'SymbianOS'
							);

		foreach ($os_array as $regex => $value) 
		{
			if (preg_match($regex, $user_agent)) 
			{
				$os_platform    =   $value;
			}
		}   

		return $os_platform;

	}

	//Função que pega o navegador utilizado
	function getBrowser() 
	{

		global $user_agent;

		$browser        =   "Unknown Browser";

		$browser_array  =   array(
								'/msie/i'       =>  'Internet Explorer',
								'/firefox/i'    =>  'Firefox',
								'/safari/i'     =>  'Safari',
								'/chrome/i'     =>  'Chrome',
								'/edge/i'       =>  'Edge',
								'/opera/i'      =>  'Opera',
                                '/opera|opr/i'  =>  'Opera',
								'/netscape/i'   =>  'Netscape',
								'/maxthon/i'    =>  'Maxthon',
								'/konqueror/i'  =>  'Konqueror',
								'/mobile/i'     =>  'Handheld Browser',
                                '/ucbrowser/i'  => 'UC Browser',
                                '/qqbrowser/i'  => 'QQ Browser',
                                '/vivaldi/i'    => 'Vivaldi',
                                '/brave/i'      => 'Brave',
                                '/yandex/i'     => 'Yandex'
							);

		foreach ($browser_array as $regex => $value) 
		{ 
			if (preg_match($regex, $user_agent)) 
			{
				$browser    =   $value;
			}
		}

		return $browser;
	}

    // Função que obtém o IP do cliente
    function get_client_ip() 
    {
        $ipaddress = '';

        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

	if( !function_exists('random_bytes') )
	{
		function random_bytes($length = 6)
		{
			$characters = '0123456789';
			$characters_length = strlen($characters);
			$output = '';
			for ($i = 0; $i < $length; $i++)
				$output .= $characters[rand(0, $characters_length - 1)];

			return $output;
		}
	}

	$ip_add 		= get_client_ip();
	$user_os        = getOS();
	$user_browser   = getBrowser();

    function generateDeviceUUID() 
    {
        // Obter a data e hora atual no formato YmdHi (Ano, Mês, Dia, Hora, Minuto)
        $datetime = date('YmdHi');

        // Gerar um identificador único baseado na data e hora
        $uniqueId = uniqid($datetime, true);

        // Substituir caracteres especiais para garantir que o UUID seja válido
        $uuid = str_replace(['.', ' '], '', $uniqueId);

        return $uuid;
    }

    $deviceUUID = generateDeviceUUID();
?>