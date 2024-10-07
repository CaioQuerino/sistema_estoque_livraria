<?php 
include_once 'database.php'; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra de Livros</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Compra de Livros por CPF</h1>
        
        <!-- Sessão de Compra de Livros -->
        <div class="card shadow mb-4">
            <div class="card-header text-white bg-primary">
                <h3>Comprar Livro</h3>
            </div>
            <div class="card-body">
                <form id="purchase-form" action="" method="POST">
                    <div class="form-group">
                        <label for="CPF">Informe o CPF:</label>
                        <input type="text" class="form-control" id="CPF" name="CPF" placeholder="Digite o CPF" maxlength="14" required>
                    </div>

                    <div class="form-group">
                        <label for="ISBN">Selecione o Livro:</label>
                        <select class="form-control" id="ISBN" name="ISBN" required>
                            <option value="">Selecione Livro</option>
                            <?php 
                                // Selecionar todos os livros
                                $sql_books = "SELECT ISBN, title FROM books";
                                $result_books = $conn->query($sql_books);
                                
                                if ($result_books->num_rows > 0) {
                                    // Percorre cada livro
                                    while ($row_books = $result_books->fetch_assoc()) {
                                        $ISBN = $row_books['ISBN'];
                                        
                                        // Verificar se há estoque para este livro
                                        $sql_stock = "SELECT quantity_stock FROM stocks WHERE ISBN = '$ISBN' AND quantity_stock > 0";
                                        $result_stock = $conn->query($sql_stock);
                                        
                                        if ($result_stock->num_rows > 0) {
                                            echo "<option value='" . $row_books['ISBN'] . "'>" . $row_books['title'] . "</option>";
                                        }
                                    }
                                } else {
                                    echo "<option value=''>Nenhum livro disponível</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantidade:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Finalizar Compra</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Processar a compra quando o formulário for submetido
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $CPF = $_POST['CPF'] ?? null;
        $ISBN = $_POST['ISBN'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
    
        if ($CPF && $ISBN && $quantity) {
            // Verificar se o cliente existe
            $sql_check_client = "SELECT * FROM clients WHERE CPF = ?";
            $stmt_check_client = $conn->prepare($sql_check_client);
            $stmt_check_client->bind_param("s", $CPF);
            $stmt_check_client->execute();
            $result_client = $stmt_check_client->get_result();
    
            if ($result_client->num_rows > 0) {
                // Verificar se há estoque disponível e obter o preço do livro
                $sql_check_stock = "SELECT s.quantity_stock, b.price, b.id_branch 
                                    FROM stocks s 
                                    INNER JOIN books b ON s.ISBN = b.ISBN 
                                    WHERE s.ISBN = ?";
                $stmt_check_stock = $conn->prepare($sql_check_stock);
                $stmt_check_stock->bind_param("s", $ISBN);
                $stmt_check_stock->execute();
                $result_stock = $stmt_check_stock->get_result();
    
                if ($result_stock->num_rows > 0) {
                    $row_stock = $result_stock->fetch_assoc();
                    $id_branch = $row_stock['id_branch'];  // Obter o id_branch do livro

                    if ($row_stock['quantity_stock'] >= $quantity) {
                        // Atualiza o estoque
                        $new_stock = $row_stock['quantity_stock'] - $quantity;
                        $sql_update_stock = "UPDATE stocks SET quantity_stock = ? WHERE ISBN = ?";
                        $stmt_update_stock = $conn->prepare($sql_update_stock);
                        $stmt_update_stock->bind_param("is", $new_stock, $ISBN);
                        $stmt_update_stock->execute();
    
                        // Registra a venda na tabela de itens
                        $sql_insert_item = "INSERT INTO items (CPF, ISBN, quantity_item, id_branch) VALUES (?, ?, ?, ?)";
                        $stmt_insert_item = $conn->prepare($sql_insert_item);
                        $stmt_insert_item->bind_param("ssii", $CPF, $ISBN, $quantity, $id_branch);
                        $stmt_insert_item->execute();
    
                        // Registrar a entrada no caixa
                        $amount = $row_stock['price'] * $quantity;
                        $description = "Venda de Livro ISBN $ISBN para CPF $CPF";
                        $sql_insert_cash_flow = "INSERT INTO cash_flow (transaction_type, amount, description) VALUES ('entrada', ?, ?)";
                        $stmt_insert_cash_flow = $conn->prepare($sql_insert_cash_flow);
                        $stmt_insert_cash_flow->bind_param("ds", $amount, $description);
                        $stmt_insert_cash_flow->execute();
    
                        echo "<div class='alert alert-success mt-4'>Compra realizada com sucesso!</div>";
                    } else {
                        echo "<div class='alert alert-danger mt-4'>Estoque insuficiente!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger mt-4'>Livro não encontrado no estoque!</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-4'>Cliente não encontrado!</div>";
            }
        } else {
            echo "<div class='alert alert-warning mt-4'>Por favor, preencha todos os campos.</div>";
        }
    
        $conn->close();
    }
    ?>

    <script type="module" src="./js/main.js"></script>
    <!-- Bootstrap JS, jQuery e Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
