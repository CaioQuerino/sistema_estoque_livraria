<?php 
// Verifica se o arquivo database.php existe antes de incluí-lo
if (file_exists('./database.php')) {
    include_once './database.php';
} else {
    die("<div class='alert alert-danger'>Erro: Arquivo de banco de dados não encontrado.</div>");
}

// Busca todas as filiais do banco de dados para exibir no dropdown
$sql_branch = "SELECT id_branch, name_branch FROM branches";
$result_branch = $conn->query($sql_branch);

// Busca todos os autores do banco de dados para exibir no dropdown
$sql_author = "SELECT id_author, name_author FROM authors";
$result_author = $conn->query($sql_author);

class Stock {
    private $ISBN;
    private $quantity_stock;
    private $price;
    private $id_author;
    private $id_branch;

    public function __construct($ISBN, $quantity_stock, $price, $id_author, $id_branch) {
        $this->ISBN = $ISBN;
        $this->quantity_stock = $quantity_stock;
        $this->price = $price;
        $this->id_author = $id_author;
        $this->id_branch = $id_branch;
    }

    public function setStock($conn) {
        // Verificar se o autor existe na tabela authors
        $sql_check_author = "SELECT * FROM authors WHERE id_author = ?";
        $stmt_check_author = $conn->prepare($sql_check_author);
        $stmt_check_author->bind_param("i", $this->id_author);
        $stmt_check_author->execute();
        $result_author = $stmt_check_author->get_result();

        if ($result_author->num_rows > 0) {
            // O autor existe, então pode inserir no estoque
            $sql_insert_stock = "INSERT INTO stocks (ISBN, quantity_stock, price, id_author, id_branch) VALUES (?, ?, ?, ?, ?)";
            $stmt_insert_stock = $conn->prepare($sql_insert_stock);
            $stmt_insert_stock->bind_param("siiii", $this->ISBN, $this->quantity_stock, $this->price, $this->id_author, $this->id_branch);

            if ($stmt_insert_stock->execute()) {
                echo "<div class='alert alert-success'>Estoque adicionado com sucesso!</div>";
            } else {
                echo "<div class='alert alert-danger'>Erro ao adicionar estoque: " . $conn->error . "</div>";
            }
        } else {
            // Autor não existe
            echo "<div class='alert alert-danger'>Erro: O autor com ID " . $this->id_author . " não existe. Adicione o autor primeiro.</div>";
        }
    }
}

// Processa o formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ISBN = $_POST['ISBN'] ?? null;
    $id_author = $_POST['id_author'] ?? null;
    $price = $_POST['price'] ?? null;
    $quantity_stock = $_POST['quantity_stock'] ?? null;
    $id_branch = $_POST['id_branch'] ?? null;

    if ($ISBN && $id_author && $quantity_stock && $id_branch && $price) {
        $stock = new Stock($ISBN, $quantity_stock, $price, $id_author, $id_branch);
        $stock->setStock($conn);
    } else {
        echo "<div class='alert alert-warning'>Preencha todos os campos.</div>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Estoque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
        <h2>Adicionar Estoque</h2>
        <p id="message" style="color: brown;"></p>

        <label for="ISBN">ISBN do Livro:</label>
        <input type="text" id="ISBN" name="ISBN" required maxlength="13"><br>

        <label for="id_author">Autor:</label>
        <select id="id_author" name="id_author" required>
            <option value="">Selecione Autor</option>
            <?php
            if ($result_author->num_rows > 0) {
                while ($row_author = $result_author->fetch_assoc()) {
                    echo "<option value='{$row_author['id_author']}'>{$row_author['name_author']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum autor cadastrado</option>";
            }
            ?>
        </select><br>

        <label for="price">Preço do Livro:</label>
        <input type="text" id="price" name="price" required><br>

        <label for="quantity_stock">Quantidade em Estoque:</label>
        <input type="number" id="quantity_stock" name="quantity_stock" required><br>

        <label for="id_branch">Filial:</label>
        <select id="id_branch" name="id_branch" required>
            <option value="">Selecione Filial</option>
            <?php
            if ($result_branch->num_rows > 0) {
                while ($row_branch = $result_branch->fetch_assoc()) {
                    echo "<option value='{$row_branch['id_branch']}'>{$row_branch['name_branch']}</option>";
                }
            } else {
                echo "<option value=''>Nenhuma filial cadastrada</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Adicionar Estoque">
    </form>
    <script type="module" src="./js/main.js"></script>
</body>
</html>
