<?php

	function processarDadosUsuario($id_pessoa, $usuario, $nivel_acesso, $reset = null) 
	{
		// Inicia um objeto que acessa a Classe Database
		$obj = new Database();

		// Tabela que vai fazer CRUD
		$table = 'usuarios';

		if (!empty($id_pessoa) && !empty($usuario) && !empty($nivel_acesso)) 
		{
			$rows  = 'id, id_pessoa, usuario, estilo, id_nivel_acesso, status';
			$where = ' id_pessoa = ' . intval($id_pessoa);
			$limit = 1;

			$result = $obj->select($table, $rows, null, $where, null, $limit);

			if (!empty($result[0])) 
			{
				$userData = $result[0];

				if (!empty($result[0])) 
				{
					extract($userData);
				}
			}

			$senha  = md5('123');
			$status = (!empty($status)) ? $status : 1 ;
			$estilo = (!empty($estilo)) ? $estilo : 2 ;

			$arrayDados = array(
				"usuario"           => "'$usuario'",
				"id_pessoa"         => "'$id_pessoa'",
				"id_nivel_acesso"   => "'$nivel_acesso'",
				"status"            => "$status",
				"estilo"            => "$estilo"
			);

			if ($reset == 1) 
			{
				$arrayDados["senha"] = "'$senha'";
				$arrayDados["reset"] = "'1'";
			}

			if (!empty($id)) 
			{
				$where = " id = $id ";

				$obj->update($table, $arrayDados, $where);
			} 
			else 
			{
				$arrayDados["senha"] = "'$senha'";

				$obj->insert($table, $arrayDados);

				$id = $obj->getResult()[0];

				include_once("../email/usuario.php");
			}

		}
	}

	function definirNivelAcesso($tipo)
	{
		switch ($tipo) 
		{
			case 1: return 6;
			case 2: return 5;
			case 3: return 2;
			default: return 3;
		}
	}

	function gerarUsuarioPorCPF($cpf) 
	{
		if ($cpf === null) 
		{
			return '';
		}

		return preg_replace("/[^0-9]/", "", $cpf);
	}

?>