<?php
include_once './database.php';

// Busca todas as filiais do banco de dados para exibir no dropdown
$sql_branches = "SELECT id_branch, name_branch FROM branches";
$result_branches = $conn->query($sql_branches);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
        <h2>Adicionar Item</h2>
        <p id="message" style="color: brown;"></p> <!-- Exibe a mensagem dinamicamente -->

        <label for="CPF">CPF do Cliente:</label>
        <input type="text" id="CPF" name="CPF" required maxlength="14"><br>

        <label for="ISBN">ISBN do Livro:</label>
        <input type="text" id="ISBN" name="ISBN" required  maxlength="13"><br>

        <label for="quantity_item">Quantidade:</label>
        <input type="text" id="quantity_item" name="quantity_item" required><br>

        <!-- Dropdown para selecionar a filial -->
        <label for="id_branch">Filial:</label>
        <select id="id_branch" name="id_branch" required>
            <option value="">Selecione uma filial</option>
            <?php
            // Preenche o dropdown com as opções de filiais
            if ($result_branches->num_rows > 0) {
                while ($row = $result_branches->fetch_assoc()) {
                    echo "<option value='{$row['id_branch']}'>{$row['name_branch']}</option>";
                }
            } else {
                echo "<option value=''>Nenhuma filial cadastrada</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Adicionar Item">
    </form>
    <script type="module" src="./js/main.js"></script>
</body>

<?php
    include_once './database.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Captura os dados do formulário
        $cpf = $_POST['CPF'] ?? null;
        $isbn = $_POST['ISBN'] ?? null;
        $quantity_item = $_POST['quantity_item'] ?? null;
        $id_branch = $_POST['id_branch'] ?? null;  // Captura a filial selecionada

        if ($cpf && $isbn && $quantity_item && $id_branch) {
            // Verifica se o livro tem estoque suficiente na filial selecionada
            $sql_check_stock = "SELECT quantity_stock FROM books WHERE ISBN = ? AND id_branch = ?";
            $stmt = $conn->prepare($sql_check_stock);
            $stmt->bind_param("si", $isbn, $id_branch);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $current_stock = $row['quantity_stock'];

                if ($current_stock >= $quantity_item) {
                    // Atualiza o estoque do livro
                    $new_stock = $current_stock - $quantity_item;
                    $sql_update_stock = "UPDATE books SET quantity_stock = ? WHERE ISBN = ? AND id_branch = ?";
                    $stmt_update = $conn->prepare($sql_update_stock);
                    $stmt_update->bind_param("isi", $new_stock, $isbn, $id_branch);
                    $stmt_update->execute();

                    // Adiciona o item ao carrinho/registro
                    $sql_insert_item = "INSERT INTO items (CPF, ISBN, quantity_item, id_branch) VALUES (?, ?, ?, ?)";
                    $stmt_insert = $conn->prepare($sql_insert_item);
                    $stmt_insert->bind_param("ssii", $cpf, $isbn, $quantity_item, $id_branch);
                    $stmt_insert->execute();

                    echo "Item adicionado com sucesso!";
                } else {
                    echo "Estoque insuficiente na filial selecionada!";
                }
            } else {
                echo "Livro não encontrado ou indisponível na filial selecionada!";
            }

            $stmt->close();
        } else {
            echo "Por favor, preencha todos os campos!";
        }

        $conn->close();
    }
?>
</html>
