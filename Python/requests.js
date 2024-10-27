document.addEventListener("DOMContentLoaded", function() {
    let messagesHistory = [];

    // Função para exibir o histórico de conversa em tempo real
    function updateChatHistory(userQuestion, responseText) {
        const chatHistoryDiv = document.getElementById('chatgpt-response');

        const userQuestionElement = document.createElement("p");
        userQuestionElement.innerHTML = `<strong>Você:</strong> ${userQuestion}`;
        chatHistoryDiv.appendChild(userQuestionElement);

        const responseTextElement = document.createElement("p");
        responseTextElement.innerHTML = `<strong>ChatGPT:</strong> ${responseText}`;
        chatHistoryDiv.appendChild(responseTextElement);

        chatHistoryDiv.scrollTop = chatHistoryDiv.scrollHeight;
    }

    // Função para exibir mensagens de erro no console e no chat
    function showError(errorMessage) {
        const chatHistoryDiv = document.getElementById('chatgpt-response');
        const errorElement = document.createElement("p");
        errorElement.innerHTML = `<strong>Erro:</strong> ${errorMessage}`;
        errorElement.style.color = "red";
        chatHistoryDiv.appendChild(errorElement);
        console.error(errorMessage);
    }

    // Função para enviar a pergunta ao back-end
    function sendQuestion(userQuestion) {
        const idProblema = 3;           // ID simulado para id_problema
        const idAvaliacaoProblema = 3;  // ID simulado para id_avaliacao_problema

        const data = {
            id_problema: idProblema,
            id_avaliacao_problema: idAvaliacaoProblema,
            user_question: userQuestion,
            messages_history: messagesHistory
        };

        fetch('http://127.0.0.1:5000/api/send_question', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log("Status da resposta:", response.status);
            if (!response.ok) {
                throw new Error("Erro na resposta do servidor.");
            }
            return response.json();
        })
        .then(data => {
            if (data.response) {
                updateChatHistory(userQuestion, data.response);
                messagesHistory = data.messages_history;
            } else {
                showError("Erro ao receber resposta do servidor. Dados da resposta não estão no formato esperado.");
            }
        })
        .catch(error => {
            showError("Erro ao enviar a requisição. Verifique a conexão com o servidor.");
            console.error("Erro ao enviar a requisição:", error);
        });
    }

    // Evento para enviar a pergunta ao pressionar Enter
    const userQuestionInput = document.getElementById("user-question");
    if (userQuestionInput) {
        userQuestionInput.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                const userQuestion = event.target.value.trim();
                if (userQuestion !== "") {
                    sendQuestion(userQuestion);
                    event.target.value = "";
                }
            }
        });
    }

    // Função para capturar o diagnóstico e enviar ao servidor para gerar a anamnese
    function generateAnamnese() {
        const diagnostico = document.getElementById('diagnostico').value.trim();

        if (!diagnostico) {
            alert("Preencha o diagnóstico antes de gerar a anamnese.");
            return;
        }

        const diagnosticoArray = diagnostico.split("\n");

        const data = {
            diagnostico_array: diagnosticoArray
        };

        fetch('http://127.0.0.1:5000/api/generate_anamnese', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao gerar a anamnese.");
            }
            return response.json();
        })
        .then(data => {
            const anamneseDiv = document.getElementById('anamnese-result');
            if (data.response) {
                anamneseDiv.innerHTML = `<strong>Anamnese Gerada:</strong> ${data.response}`;
            } else {
                console.error("Erro na resposta:", data.error);
                anamneseDiv.innerHTML = `<strong>Erro:</strong> ${data.error}`;
            }
        })
        .catch(error => {
            console.error("Erro ao enviar a requisição:", error);
            alert("Erro ao gerar a anamnese. Verifique o console para mais detalhes.");
        });
    }

    // Botão para chamar a função generateAnamnese
    const generateAnamneseBtn = document.getElementById("generate-anamnese-btn");
    if (generateAnamneseBtn) {
        generateAnamneseBtn.addEventListener("click", generateAnamnese);
    }

    // Função para avaliar a assertividade das perguntas feitas
    function evaluateAssertiveness() {
        const idProblema = 3;
        const idAvaliacao = 3;

        const data = {
            id_problema: idProblema,
            id_avaliacao: idAvaliacao
        };

        fetch('http://127.0.0.1:5000/api/evaluate_assertiveness', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log("Status da resposta:", response.status);
            if (!response.ok) {
                throw new Error("Erro na resposta do servidor.");
            }
            return response.json();
        })
        .then(data => {
            if (data.assertiveness_evaluation) {
                const evaluationDiv = document.getElementById('assertiveness-result');
                evaluationDiv.innerHTML = `<strong>Avaliação de Assertividade:</strong> ${data.assertiveness_evaluation}`;
            } else {
                console.error("Erro na resposta:", data.error);
            }
        })
        .catch(error => console.error("Erro ao enviar a requisição:", error));
    }

    // Botão para chamar a função evaluateAssertiveness
    const evaluateAssertivenessBtn = document.getElementById("evaluate-assertiveness-btn");
    if (evaluateAssertivenessBtn) {
        evaluateAssertivenessBtn.addEventListener("click", evaluateAssertiveness);
    }
});
