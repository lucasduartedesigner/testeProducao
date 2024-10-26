<?php
// processar.php
header('Content-Type: application/json');

// Verifica se o ID do problema foi passado na URL
if (isset($_GET['id_problema'])) {
    $id_problema = intval($_GET['id_problema']);
    
    // Aqui você pode buscar no banco de dados ou fazer qualquer outra operação necessária
    // Por exemplo, simulando um retorno de dados
    // Substitua isso pela sua lógica de banco de dados real

    // Exemplo de resposta
    $dadosProblema = [
        "id" => $id_problema,
        "nome" => "Problema " . $id_problema,
        "descricao" => "Descrição do problema " . $id_problema,
        // Adicione outros campos que você precisar
    ];

    // Retorna os dados como JSON
    echo json_encode($dadosProblema);
} else {
    // Caso o ID do problema não seja fornecido, retorna um erro
    echo json_encode(["error" => "ID do problema não fornecido."]);
}
?>
