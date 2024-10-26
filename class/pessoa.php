<?php

include_once('database.php');

class PessoaHandler 
{
	// Propriedades da classe
    private Database $obj;
    private string $table;
    private array $data;
    private int $id_pessoa;

	// Construtor da classe
    public function __construct(string $table, array $data) 
	{
		// Inicializa as propriedades
        $this->obj   = new Database();
        $this->table = $table;
        $this->data  = $data;
    }

	// Método principal que processa os dados
    public function process() 
	{
		// Limpa os dados removendo campos vazios
        $this->sanitizeData();

        $arrayDados = [
            "nome"      => "'{$this->data['pessoa']}'",
            "cpf"       => "'{$this->data['cpf']}'",
            "crmv"      => "'{$this->data['crmv']}'",
            "telefone"  => "'{$this->data['telefone']}'",
            "celular"   => "'{$this->data['celular']}'",
            "celular2"  => "'{$this->data['celular2']}'",
            "email"     => "'{$this->data['email']}'",
            "status"    => "'{$this->data['status']}'",
            "id_setor"  => "'{$this->data['setor']}'",
            "tipo"      => "'{$this->data['tipo']}'"
        ];

		$arrayDados = array_filter($arrayDados, fn($value) => $value !== null && $value !== '');

        if (!empty($this->data['id_pessoa'])) 
		{
            $where = "id_pessoa = {$this->data['id_pessoa']}";
            $this->obj->update($this->table, $arrayDados, $where);
        } 
		else 
		{
            $this->obj->insert($this->table, $arrayDados);
            $this->data['id_pessoa'] = $this->obj->getResult()[0];
        }

		$this->id_pessoa = $this->data['id_pessoa'];

		if (!empty($this->data['tipo']) && empty($this->data['nivel_acesso']))
		{
			$this->data['nivel_acesso'] = definirNivelAcesso($this->data['tipo']);
		}

		if (!empty($this->data['cpf']) && empty($this->data['usuario']) && $this->data['tipo'] == 1)
		{
			echo $this->data['usuario'] = gerarUsuarioPorCPF($this->data['cpf']);
		}

		if (!empty($this->data['crmv']) && empty($this->data['usuario']) && $this->data['tipo'] == 2)
		{
			echo $this->data['usuario'] = gerarUsuarioPorCPF($this->data['crmv']);
		}

		if (!empty($this->data['id_pessoa']) && !empty($this->data['usuario']) && !empty($this->data['nivel_acesso'])) 
		{
			$id_pessoa    = $this->data['id_pessoa'];
			$usuario      = $this->data['usuario'];
			$nivel_acesso = $this->data['nivel_acesso'];
			$reset        = $this->data['reset'];
			
			$this->updateOrCreateUsuario($id_pessoa, $usuario, $nivel_acesso, $reset);
		}

    }

	// Método para atualizar ou criar um novo usuário
    public function updateOrCreateUsuario($id_pessoa, $usuario, $nivel_acesso, $reset = null)
    {
		$rows  = 'id, usuario, estilo, id_nivel_acesso, status';
		$where = ' id_pessoa = ' . intval($id_pessoa);
		$limit = 1;

		$this->obj->select('usuarios', $rows, null, $where, null, $limit);

		$result = $this->obj->getResult()[0];

		if (!empty($result)) 
		{
			$id_usuario 	 = $result['id'];
			$usuario 		 = (!empty($usuario)) ? $usuario : $result['usuario'];
			$id_nivel_acesso = (!empty($id_nivel_acesso)) ? $id_nivel_acesso : $result['id_nivel_acesso'];
			$estilo 		 = $result['estilo'];
			$status 		 = $result['status'];
		}

		$senha = md5('123');

		$estilo = (!empty($estilo)) ? $estilo : 2 ;
		$status = (!empty($status)) ? $status : 1 ;

		$arrayDados = array(
			"usuario"           => "'$usuario'",
			"id_pessoa"         => "'$id_pessoa'",
			"id_nivel_acesso"   => "'$nivel_acesso'",
			"status"            => "$status",
			"estilo"            => "$estilo"
		);

		if($reset == 1) 
		{
			$arrayDados["senha"] = "'$senha'";
			$arrayDados["reset"] = "'1'";
		}

		if (!empty($id_usuario)) 
		{
			$where = " id = $id_usuario ";

			$this->obj->update('usuarios', $arrayDados, $where);
		} 
		else 
		{
			$arrayDados["senha"] = "'$senha'";

			$this->obj->insert('usuarios', $arrayDados);

			$id_usuario = $this->obj->getResult()[0];

			$emailHandler = new EmailHandler();

			$this->obj->select('config', '*', null, 'id_config = 1');

			$row = $this->obj->getResult()[0];

			if (!empty($row)) 
			{
				extract($row);
			}

			$rows = 'p.id_pessoa, p.nome, l.nome AS laboratorio, l.foto, u.id AS id_usuario, p.email email_reset, u.usuario ';
			$tables = "pessoa";
			$join = " p INNER JOIN usuarios u ON p.id_pessoa = u.id_pessoa LEFT JOIN clinica l ON l.id_clinica = $id_clinica";
			$where = "u.id = $id_usuario ";
			$order = 'p.tipo';
			$limit = 1;

			$this->obj->select($tables, $rows, $join, $where, $order, $limit);
			$result = $this->obj->getResult()[0];

			if (!empty($result)) 
			{
				extract($result);
			}

			$system_link = "https://$site/app";
			$logo 		 = "https://$site/app/app-assets/images/logo/$foto";

			$title 		 = "Cadastro no Sistema";
			$header		 = "Parabéns! Seu cadastro foi concluído com sucesso. Seu usuário é <b>$usuario</b> e sua senha é <b>123</b>.";
			$body		 = "Para acessar e consultar seus exames, utilize este link.";
			$main		 = "Assim que seus exames estiverem prontos, você receberá uma notificação no seu e-mail.";
			$btn_link 	 = "$system_link";
			$btn_txt	 = "Acessar o sistema";
			$rodape		 = "Esses dados são validos para o primeiro acesso. Após o primeiro acesso recomendamos alterar sua senha.";

			$html = $emailHandler->modeloEmail($title, $nome, $header, $body, $main, $btn_link, $btn_txt, $rodape, $system_link, $logo, $laboratorio);

			$email_recebe = $email_reset;
			$name_recebe  = $nome;
			$subject 	  = "Cadastro no sistema Lab & Pet";

			if(!empty($email_recebe))
			{
				$enviadoComSucesso = $emailHandler->enviarEmail($email_recebe, $name, $subject, $html, $host, $email, $laboratorio, $senha, $smtp);

				if ($enviadoComSucesso) 
				{
					echo "Email enviado com sucesso!";
				} 
				else 
				{
					echo "Erro ao enviar o email.";
				}
			}
		}
	}

    public function getIdPessoa()
    {
        return $this->id_pessoa;
    }

    private function sanitizeData() 
	{
		// Remover os campos vazios do array POST
		$this->data = array_filter($this->data, fn($value) => $value !== null && $value !== '');
    }
}

?>