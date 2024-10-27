from flask import Flask, request, jsonify, render_template
from flask_cors import CORS
from chat_gpt import get_chatbot_response, get_anamnese_response, get_correction_response
from utils import get_prompt_from_db, save_interaction_in_db, get_anamnese_prompt_from_db, get_correction_prompt_from_db, save_assertiveness_evaluation_in_db

app = Flask(__name__)
CORS(app)  # Habilita CORS para o aplicativo Flask

# Endpoint para exibir o HTML do chat de pacientes
@app.route('/')
def index():
    return render_template('teste.html')

# Endpoint para exibir o HTML de geração de anamnese
@app.route('/anamnese')
def anamnese():
    return render_template('teste_anamnese.html')  # Certifique-se de que o HTML de anamnese é salvo como teste_anamnese.html

# Endpoint para gerenciar perguntas e respostas do ChatGPT (pacientes)
@app.route('/api/send_question', methods=['POST'])
def send_question():
    data = request.get_json()
    id_problema = data.get('id_problema')
    id_avaliacao_problema = data.get('id_avaliacao_problema')
    user_question = data.get('user_question')
    messages_history = data.get('messages_history', [])  # Histórico de mensagens, vazio para a primeira interação
    
    # Validação de dados
    if not id_problema or not user_question or not id_avaliacao_problema:
        print("Erro: Dados insuficientes fornecidos.")
        return jsonify({"error": "ID do problema, avaliação do problema ou pergunta do usuário não fornecidos"}), 400

    # Obtém o full_prompt apenas na primeira interação
    if not messages_history:
        full_prompt = get_prompt_from_db(id_problema)
        print("Full Prompt:", full_prompt)  # Log do prompt completo para debug
        if "Erro" in full_prompt:
            print("Erro ao buscar o prompt:", full_prompt)
            return jsonify({"error": full_prompt}), 500
    else:
        full_prompt = None  # full_prompt não é necessário em interações subsequentes

    # Envia a pergunta e o histórico de mensagens ao ChatGPT
    try:
        response_text, updated_history = get_chatbot_response(full_prompt, user_question, messages_history, request_type='pacientes')
        print("Resposta do ChatGPT:", response_text)  # Log da resposta para debug
    except Exception as e:
        print("Erro ao gerar a resposta do ChatGPT:", e)
        return jsonify({"error": "Erro ao gerar a resposta do ChatGPT"}), 500
    
    # Salva a interação no banco de dados
    try:
        save_interaction_in_db(id_avaliacao_problema, user_question, response_text)
    except Exception as e:
        print("Erro ao salvar a interação no banco de dados:", e)
        return jsonify({"error": "Erro ao salvar a interação no banco de dados"}), 500

    # Retorna a resposta e o histórico atualizado ao front-end
    return jsonify({"response": response_text, "messages_history": updated_history})

# Novo endpoint para geração de anamnese
@app.route('/api/generate_anamnese', methods=['POST'])
def generate_anamnese():
    data = request.get_json()
    diagnostico_array = data.get('diagnostico_array', [])

    # Validação de dados
    if not diagnostico_array:
        return jsonify({"error": "Diagnóstico não fornecido"}), 400

    # Gera o full_prompt de anamnese
    full_prompt = get_anamnese_prompt_from_db(diagnostico_array)
    
    # Mensagem inicial para geração de anamnese
    user_question = "Por favor, crie uma anamnese com base no diagnóstico fornecido."
    messages_history = []

    try:
        # Gera a anamnese usando o ChatGPT
        response_text, updated_history = get_anamnese_response(full_prompt, user_question, messages_history)
        return jsonify({"response": response_text})

    except Exception as e:
        print("Erro ao gerar a anamnese:", e)
        return jsonify({"error": "Erro ao gerar a anamnese"}), 500


@app.route('/api/evaluate_assertiveness', methods=['POST'])
def evaluate_assertiveness():
    data = request.get_json()
    id_problema = data.get('id_problema')
    id_avaliacao = data.get('id_avaliacao')

    if not id_problema or not id_avaliacao:
        print("Erro: ID do problema ou ID de avaliação não fornecido.")
        return jsonify({"error": "ID do problema ou ID de avaliação não fornecido"}), 400

    try:
        full_prompt = get_correction_prompt_from_db(id_problema, id_avaliacao)
        response_text, _ = get_correction_response(full_prompt)

        # Extraindo a porcentagem de assertividade, se a resposta estiver no formato esperado
        assertividade = response_text.strip('%')  # Ajuste conforme o formato da resposta
        save_assertiveness_evaluation_in_db(id_avaliacao, id_problema, assertividade)

        return jsonify({"assertiveness_evaluation": response_text})

    except Exception as e:
        print("Erro ao gerar a avaliação de assertividade:", e)
        return jsonify({"error": "Erro ao gerar a avaliação de assertividade"}), 500


# Outros endpoints e código de inicialização...
if __name__ == '__main__':
    app.run(debug=True)
