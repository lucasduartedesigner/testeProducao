from db_connection import create_connection

def get_prompt_from_db(id_problema):
    conn = create_connection()
    if conn is None:
        return "Erro ao conectar ao banco de dados."

    try:
        cursor = conn.cursor()
        
        # Consulta para obter o pré-prompt
        pre_prompt_query = "SELECT prompt_text FROM prompts WHERE prompt_type = 'paciente'"
        cursor.execute(pre_prompt_query)
        pre_prompt_result = cursor.fetchone()
        anamnese_prompt = pre_prompt_result[0] if pre_prompt_result else "Pré-prompt de anamnese não encontrado."
        
        # Consulta para obter cada campo do caso clínico individualmente
        case_prompt_query = """
            SELECT COALESCE(identificacao, ''), COALESCE(desc_hda, ''), COALESCE(desc_hpp, ''), 
                   COALESCE(desc_hs, ''), COALESCE(desc_hpf, '') 
            FROM problema 
            WHERE id_problema = %s
        """
        cursor.execute(case_prompt_query, (id_problema,))
        case_prompt_result = cursor.fetchone()
        
        # Concatena os campos para formar o case_prompt
        if case_prompt_result:
            identificacao, desc_hda, desc_hpp, desc_hs, desc_hpf = case_prompt_result
            case_prompt = f"{identificacao}; {desc_hda}; {desc_hpp}; {desc_hs}; {desc_hpf}"
        else:
            case_prompt = "Instruções do caso clínico não encontradas."
        
        # Concatena o pré-prompt com o prompt específico do problema
        full_prompt = f"{anamnese_prompt}\n\n{case_prompt}"
    
    except Exception as e:
        full_prompt = f"Erro ao buscar o prompt do banco de dados: {e}"
    
    finally:
        cursor.close()
        conn.close()

    return full_prompt

def get_anamnese_prompt_from_db(diagnostico_array):
    conn = create_connection()
    if conn is None:
        return "Erro ao conectar ao banco de dados."

    try:
        cursor = conn.cursor()
        
        pre_prompt_query = "SELECT prompt_text FROM prompts WHERE prompt_type = 'anamnese'"
        cursor.execute(pre_prompt_query)
        pre_prompt_result = cursor.fetchone()
        anamnese_prompt = pre_prompt_result[0] if pre_prompt_result else "Pré-prompt de anamnese não encontrado."

        diagnostico_text = "\n".join(diagnostico_array)
        full_prompt = f"{anamnese_prompt}\n\nDiagnóstico fornecido:\n{diagnostico_text}"
    
    except Exception as e:
        full_prompt = f"Erro ao buscar o prompt do banco de dados: {e}"
    
    finally:
        cursor.close()
        conn.close()

    return full_prompt

def save_interaction_in_db(id_problema_avaliacao, user_question, response_text):
    conn = create_connection()
    if conn is None:
        print("Erro ao conectar ao banco de dados.")
        return

    try:
        cursor = conn.cursor()
        insert_query = """
            INSERT INTO pergunta_problema (id_avaliacao_problema, pergunta, resposta) 
            VALUES (%s, %s, %s)
        """
        cursor.execute(insert_query, (id_problema_avaliacao, user_question, response_text))
        conn.commit()
    except Exception as e:
        print(f"Erro ao salvar a interação no banco de dados: {e}")
    finally:
        cursor.close()
        conn.close()

def get_correction_prompt_from_db(id_problema, id_avaliacao):
    
    conn = create_connection()
    if conn is None:
        return "Erro ao conectar ao banco de dados."

    try:
        cursor = conn.cursor()

        # Consulta para obter o pré-prompt de correção
        pre_prompt_query = "SELECT prompt_text FROM prompts WHERE prompt_type = 'correcao'"
        cursor.execute(pre_prompt_query)
        correction_prompt_result = cursor.fetchone()
        correction_prompt = correction_prompt_result[0] if correction_prompt_result else "Pré-prompt de correção não encontrado."

        # Consulta para obter o contexto do caso clínico (prompt do id_problema)
        case_context_query = """
            SELECT COALESCE(identificacao, ''), COALESCE(desc_hda, ''), COALESCE(desc_hpp, ''), 
                   COALESCE(desc_hs, ''), COALESCE(desc_hpf, '') 
            FROM problema 
            WHERE id_problema = %s
        """
        cursor.execute(case_context_query, (id_problema,))
        case_context_result = cursor.fetchone()

        if case_context_result:
            identificacao, desc_hda, desc_hpp, desc_hs, desc_hpf = case_context_result
            case_context = f"{identificacao}; {desc_hda}; {desc_hpp}; {desc_hs}; {desc_hpf}"
        else:
            case_context = "Contexto do caso clínico não encontrado."

        # Consulta para buscar todas as perguntas do estudante associadas ao id_problema e id_avaliacao
        questions_query = """
            SELECT p.pergunta 
            FROM pergunta_problema p
            INNER JOIN avaliacao_problema a ON a.id_avaliacao_problema = p.id_avaliacao_problema
            WHERE a.id_problema = %s AND a.id_avaliacao = %s
        """
        cursor.execute(questions_query, (id_problema, id_avaliacao))
        questions = cursor.fetchall()

        # Concatena todas as perguntas do estudante em um único texto
        if questions:
            questions_text = "\n".join([f"- {question[0]}" for question in questions])
        else:
            questions_text = "Nenhuma pergunta encontrada para avaliação."

        # Concatena o pré-prompt de correção, o contexto do caso e as perguntas do estudante para criar o full_prompt
        full_prompt = (
            f"{correction_prompt}\n\n"
            f"Contexto do Caso Clínico:\n{case_context}\n\n"
            f"Perguntas do Estudante:\n{questions_text}\n\n"
        )
    
    except Exception as e:
        full_prompt = f"Erro ao buscar o prompt do banco de dados: {e}"
        print("Erro ao executar a função get_correction_prompt_from_db:", e)
    
    finally:
        cursor.close()
        conn.close()

    return full_prompt

def save_assertiveness_evaluation_in_db(id_avaliacao, id_problema, assertividade):
    conn = create_connection()
    if conn is None:
        print("Erro ao conectar ao banco de dados.")
        return

    try:
        cursor = conn.cursor()
        # Supondo que exista uma tabela chamada `avaliacao_assertividade` para armazenar os dados
        insert_query = """
            update avaliacao_problema set assertividade = %s
            where id_avaliacao = %s and id_problema = %s
        """
        cursor.execute(insert_query, (assertividade, id_avaliacao, id_problema))
        conn.commit()
    except Exception as e:
        print(f"Erro ao salvar a assertividade no banco de dados: {e}")
    finally:
        cursor.close()
        conn.close()
