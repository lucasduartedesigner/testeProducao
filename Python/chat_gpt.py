import openai
import os
from dotenv import load_dotenv

# Carrega as variáveis de ambiente
load_dotenv('config.env')
openai.api_key = os.getenv('OPENAI_API_KEY')

# Dicionário de tokens máximos por tipo de requisição
MAX_TOKENS_BY_TYPE = {
    'paciente': 200,
    'anamnese': 500,
    'correcao': 50,
    'laboratorial': 200
}

# Função genérica para gerenciar o histórico e enviar ao ChatGPT
def get_chatbot_response(full_prompt, user_message, messages_history=None, request_type='paciente', temperature=0.7):
    if messages_history is None:
        messages_history = []
    
    # Adiciona o full_prompt como primeira mensagem 'system' se for a primeira interação
    if not messages_history and full_prompt:
        messages_history.append({"role": "system", "content": full_prompt})
    
    # Adiciona a mensagem do usuário ao histórico
    messages_history.append({"role": "user", "content": user_message})

    try:
        # Envia o histórico para a API do ChatGPT
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=messages_history,
            max_tokens=MAX_TOKENS_BY_TYPE.get(request_type, 100),
            temperature=temperature,
        )

        # Extrai o conteúdo da resposta e adiciona ao histórico
        response_text = response.choices[0].message["content"].strip()
        messages_history.append({"role": "assistant", "content": response_text})

        return response_text, messages_history

    except Exception as e:
        print(f"Erro ao chamar a API do OpenAI para {request_type}: {e}")
        return f"Erro ao chamar a API do OpenAI para {request_type}.", messages_history

# Função para gerar respostas de anamnese
def get_anamnese_response(full_prompt, user_question, messages_history=None):
    return get_chatbot_response(full_prompt, user_question, messages_history, request_type='anamnese', temperature=0.7)

def get_correction_response(full_prompt, messages_history=None):
    """
    Envia o prompt e o histórico para o ChatGPT para avaliação de assertividade das perguntas feitas.
    """
    if messages_history is None:
        messages_history = []

    # Define o full_prompt como a mensagem inicial 'system'
    if not messages_history:
        messages_history.append({"role": "system", "content": full_prompt})

    try:
        # Envia o histórico para a API do ChatGPT
        response = openai.ChatCompletion.create(
            model="gpt-4",
            messages=messages_history,
            max_tokens=MAX_TOKENS_BY_TYPE.get('correcao', 50),
            temperature=0.5,
        )

        # Extrai o conteúdo da resposta e adiciona ao histórico
        response_text = response.choices[0].message["content"].strip()
        messages_history.append({"role": "assistant", "content": response_text})

        return response_text, messages_history

    except Exception as e:
        print("Erro ao chamar a API do OpenAI para correção:", e)
        return "Erro ao gerar correção.", messages_history

