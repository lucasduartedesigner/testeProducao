from db_connection import create_connection

def create_table():
    conn = create_connection()
    if conn is None:
        return

    cursor = conn.cursor()

    create_table_sql = """
    CREATE TABLE IF NOT EXISTS prompts (
        id_prompts INT PRIMARY KEY AUTO_INCREMENT,
        prompt_type VARCHAR(50) NOT NULL,
        description VARCHAR(255),
        prompt_text TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );
    """

    try:
        cursor.execute(create_table_sql)
        conn.commit()
        print("Tabela criada")
    except Exception as e:
        print(f"Erro ao criar a tabela: {e}")
    finally:
        cursor.close()
        conn.close()

def insert_table():
    conn = create_connection()
    if conn is None:
        return

    cursor = conn.cursor()

    # SQL de inserção com placeholders (%s) para valores
    insert_table_sql = """
        INSERT INTO prompts (prompt_type, description, prompt_text) 
        VALUES (%s, %s, %s)
    """

    # Definição dos valores a serem inseridos
    values = (
        'anamnese',
        'Pre Prompt para criação de anamneses',
        """
        Você está ajudando a criar uma anamnese para um caso clínico educativo. Baseado nos detalhes fornecidos pelo professor, elabore uma anamnese completa e realista, incluindo histórico médico, descrição de sintomas, e características comportamentais que sejam úteis para o aprendizado dos estudantes. Siga estas diretrizes:
        1. Estruture a anamnese de forma clara, começando com uma introdução breve sobre o paciente (idade, profissão, cidade, etc.).
        2. Descreva os sintomas principais de forma detalhada e coerente.
        3. Inclua detalhes relevantes para o diagnóstico sem sugerir soluções ou tratamentos.
        4. Mantenha a linguagem médica apropriada, acessível para estudantes em fase de aprendizado.
        Use as informações fornecidas para criar uma anamnese útil e bem estruturada.
        """
    )

    try:
        cursor.execute(insert_table_sql, values)
        conn.commit()
        print("Dados inseridos")
    except Exception as e:
        print(f"Erro ao inserir dados: {e}")
    finally:
        cursor.close()
        conn.close()

def select_table():
    conn = create_connection()
    if conn is None:
        return

    cursor = conn.cursor()
    select_sql = """SELECT * FROM prompts"""

    try:
        cursor.execute(select_sql)
        results = cursor.fetchall()

        if results:
            print("Registros encontrados na tabela prompts:")
            for row in results:
                print(row)
        else:
            print("Nenhum registro encontrado na tabela prompts.")
    except Exception as e:
        print(f"Erro ao realizar o SELECT: {e}")
    finally:
        cursor.close()
        conn.close()

# Teste de criação da tabela e inserção
#
#insert_table()

if __name__ == "__main__":
    #insert_table()
    select_table()