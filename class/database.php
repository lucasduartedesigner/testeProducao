<?php

class Database
{
    private $host = "localhost";
    private $db   = "appcasoclinico";
    private $user;
    private $pass;

    private $mysqli = "";
    private $result = array();
    private $conn   = false;

	//Constroi uma conexão com o banco de dados
    public function __construct()
	{
        if(!$this->conn)
		{
            if($_SERVER['HTTP_HOST'] == "localhost")
            {
                $this->db   = "appcasoclinico";
                $this->user = "root";
                $this->pass = "";
            }
            else
            {
                $this->host = "192.185.176.160";
                $this->db   = "appcas29_casoclinico";
                $this->user = "appcas29_casoclinico";
                $this->pass = "$2UzP)juxntu";
            }

			$this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);

			$this->conn = true;

			if($this->mysqli->connect_error)
			{
				array_push($this->result, $this->mysqli->connect_error);

				return false;
			}
		}
		else
		{
			true;
		}
    }

	//Função que adicionar os dados a tabela desejada
	public function insert($table, $params=array())
	{
		if($this->tableExists($table))
		{

			$table_columns = implode(", ", array_keys($params));
			$table_values  = implode(", ", $params);

			$sql = "INSERT INTO $table ($table_columns) VALUES ($table_values)";
			//echo $sql . "<br>";

			if($this->mysqli->query($sql))
			{
                $insert_id = $this->mysqli->insert_id;
 
				array_push($this->result, $insert_id);

				return true;
			}
			else
			{
				array_push($this->result, $this->mysqli->error);

				return false;
			}
		}
		else
		{
			return false;
		}
	}

	//Função que atualiza os dados da tabela com condições enviadas
	public function update($table, $params=array(), $where = null)
	{
		if($this->tableExists($table))
		{
			//Cria conjunto de dados
			$args = array();

			//Laço de repetição para montar update de dados
			foreach ($params as $keys => $value )
			{
				$args[] = "$keys = $value";
			}

			//Formata os dados a serem atulizados
			$table_set  = implode(", ", $args);

			$cond_where;

			if($where != null)
			{
				$cond_where = " WHERE $where";
			}

			$sql = "UPDATE $table SET $table_set $cond_where ";
			//echo $sql . "<br>";

			if($this->mysqli->query($sql))
			{
				array_push($this->result, $this->mysqli->affected_rows);
			}
			else
			{
				array_push($this->result, $this->mysqli->error);
			}
		}
		else
		{
			return false;
		}
	}

	//Função que deleta os dados da tabela com condições enviadas
	public function delete($table, $where = null)
	{
		if($this->tableExists($table))
		{
			$cond_where;

			if($where != null)
			{
				$cond_where = " WHERE $where";
			}

			$sql = "DELETE FROM $table $cond_where ";

			if($this->mysqli->query($sql))
			{
				array_push($this->result, $this->mysqli->affected_rows);
			}
			else
			{
				array_push($this->result, $this->mysqli->error);
			}

		}
		else
		{
			return false;
		}	
	}

	//Função que busca os dados da tabela com condições enviadas
	public function select($table, $rows = "*", $join = null, $where = null, $order = null, $limit = null)
	{

		if($this->tableExists($table))
		{
			$sql = " SELECT $rows FROM $table";

			if($join != null)
			{
				$sql .= " $join ";
			}

			if($where != null)
			{
				$sql .= " WHERE $where";
			}

			if($order != null)
			{
				$sql .= " ORDER BY $order";
			}

			if($limit != null)
			{
				$sql .= " LIMIT  0, $limit";
			}

			$query = $this->mysqli->query($sql);

			if($query)
			{
				array_push($this->result, $query->fetch_all(MYSQLI_ASSOC));

				return true;
			}
			else
			{
				array_push($this->result, $this->mysqli->error);

				return false;
			}
		}
		else
		{
			return false;
		}		
	}

	//Função que busca dados na tabela
	public function sql($sql)
	{

		$query = $this->mysqli->query($sql);

		if($query)
		{
			$this->result = $query->fetch_all(MYSQLI_ASSOC);

			return true;
		}
		else
		{
			array_push($this->result, $this->mysqli->error);

			return false;
		}
	}

	//Função que verifica se tabela existe
	private function tableExists($table)
	{
		$sql 	   = "SHOW TABLES FROM $this->db LIKE '$table'";

		$tableInDb = $this->mysqli->query($sql);

		if($tableInDb)
		{
			if($tableInDb->num_rows == 1)
			{
				return true;
			}
			else
			{
				array_push($this->result, $table. " não existe essa tabela!");

				return false;
			}
		}
	}

	//Função que leva o resultado
	public function getResult()
	{
		$val = $this->result;

		$this->result = array();

		return $val;
	}

	//Função que destroi a conexão do banco de dados
	public function __destruct()
	{
		if($this->conn)
		{
			if($this->mysqli->close())
			{
				$this->conn = false;

				return true;
			}
		}
		else
		{
			return false;
		}
	}

}

?>