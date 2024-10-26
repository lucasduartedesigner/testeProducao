<?php

	//Cria um Class de login
	class Login 
	{
		public static function remember($user)
		{
			$validade = time() + ( 60 * 60 * 24 * 30 );

			setcookie("login", $user, $validade, "/", "", false, true);
		}

		public static function forget()
		{
			$expira = time() - 3600;

			setcookie("login", "", $expira, "/", "", false, true);
		}
	}

?>