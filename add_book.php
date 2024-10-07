<?php
include_once './database.php';

// Variáveis para armazenar mensagens e resultados
$message = '';

// Busca todos os autores
$sql = "SELECT id_author, name_author FROM authors";
$result = $conn->query($sql);

// Busca todas as filiais
$sql1 = "SELECT id_branch, name_branch FROM branches";
$result1 = $conn->query($sql1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Captura os dados do formulário
    $isbn = $_POST['ISBN'] ?? null;
    $title = $_POST['title'] ?? null;
    $id_author = $_POST['id_author'] ?? null;
    $price = $_POST['price'] ?? null;
    $quantity_stock = $_POST['stock'] ?? null;
    $id_branch = $_POST['id_branch'] ?? null;

    if ($isbn && $title && $id_author && $price && $quantity_stock && $id_branch) {
        class Books {
            private $isbn;
            private $title;
            private $id_author;
            private $price;
            private $quantity_stock;
            private $id_branch;

            public function __construct($isbn, $title, $id_author, $price, $quantity_stock, $id_branch) {
                $this->isbn = $isbn;
                $this->title = $title;
                $this->id_author = $id_author;
                $this->price = $price;
                $this->quantity_stock = $quantity_stock;
                $this->id_branch = $id_branch;
            }

            public function setBook($conn) {
                $sql = "INSERT INTO books (ISBN, title, id_author, price, quantity_stock, id_branch) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssdii", $this->isbn, $this->title, $this->id_author, $this->price, $this->quantity_stock, $this->id_branch);

                if ($stmt->execute()) {
                    return "Livro cadastrado com sucesso!";
                } else {
                    return "Erro ao cadastrar o livro: " . $stmt->error;
                }
            }
        }

        // Cria a instância da classe Books e insere o livro
        $book = new Books($isbn, $title, $id_author, $price, $quantity_stock, $id_branch);
        $message = $book->setBook($conn);
    } else {
        $message = "Preencha todos os campos!";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Livros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
        <h1>Cadastrar Livro</h1>
        <p id="message" style="color: brown;"></p> <!-- Exibe a mensagem dinamicamente -->

        <label for="ISBN">ISBN:</label>
        <input type="text" id="ISBN" name="ISBN" maxlength="13" required><br>

        <label for="title">Título:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="id_author">Autor:</label>
        <select id="id_author" name="id_author" required>
            <option value="">Selecione um autor</option>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_author']}'>{$row['name_author']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum autor cadastrado</option>";
            }
            ?>
        </select><br>

        <label for="price">Valor unitário (R$):</label>
        <input type="text" id="price" name="price" required><br>

        <label for="stock">Quantidade:</label>
        <input type="number" id="stock" name="stock" maxlength="10" required><br>

        <label for="id_branch">Selecione Filial:</label>
        <select id="id_branch" name="id_branch" required>
            <option value="">Selecione uma filial</option>
            <?php
            if ($result1->num_rows > 0) {
                while ($row = $result1->fetch_assoc()) {
                    echo "<option value='{$row['id_branch']}'>{$row['name_branch']}</option>";
                }
            } else {
                echo "<option value=''>Nenhuma filial cadastrada</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Cadastrar">
    </form>

    <script type="module" src="./js/main.js"></script>
</body>
</html>
