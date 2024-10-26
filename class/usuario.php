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

			if ($result) 
			{
				$userData = $result[0];

				extract($userData);

				$id_usuario = $id;
			}

			$senha = md5('123');

			$status = (!empty($status)) ? $status : 1 ;
			$estilo = (!empty($estilo)) ? $estilo : 2 ;

			$arrayDados = array(
				"usuario"           => "'$usuario'",
				"id_pessoa"         => "'$id_pessoa'",
				"id_nivel_acesso"   => "'$nivel_acesso'",
				"status"            => "$status",
				"estilo"            => "$estilo"
			);

			if ($_POST['reset'] == 1) 
			{
				$arrayDados["senha"] = "'$senha'";
				$arrayDados["reset"] = "'1'";
			}

			if (!empty($id_usuario)) 
			{
				$where = " id = $id_usuario ";

				$obj->update($table, $arrayDados, $where);
			} 
			else 
			{
				$arrayDados["senha"] = "'$senha'";

				$obj->insert($table, $arrayDados);

				$id_usuario = $obj->getResult()[0];
			}

		}
	}

?>