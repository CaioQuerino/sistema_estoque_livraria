<?php 
    include_once './database.php';

    // Busca todas as filiais do banco de dados para exibir no dropdown
    $sql_branch = "SELECT id_branch, name_branch FROM branches";
    $result_branch = $conn->query($sql_branch);

    // Busca todos os autores do banco de dados para exibir no dropdown
    $sql_author = "SELECT id_author, name_author FROM authors";
    $result_author = $conn->query($sql_author);
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
        <p id="message" style="color: brown;"></p> <!-- Exibe a mensagem dinamicamente -->

        <label for="ISBN">ISBN do Livro:</label>
        <input type="text" id="ISBN" name="ISBN" required><br>

        <label for="id_author">Autor:</label>
        <!-- Dropdown para selecionar o autor -->
        <select id="id_author" name="id_author" required>
            <option value="">Selecione Autor</option>
            <?php
            // Preenche o dropdown com as opções de autores
            if ($result_author->num_rows > 0) {
                while ($row_author = $result_author->fetch_assoc()) {
                    echo "<option value='{$row_author['id_author']}'>{$row_author['name_author']}</option>";
                }
            } else {
                echo "<option value=''>Nenhum autor cadastrado</option>";
            }
            ?>
        </select><br>

        <label for="quantity_stock">Quantidade em Estoque:</label>
        <input type="number" id="quantity_stock" name="quantity_stock" required><br>

        <label for="id_branch">Filial:</label>
        <!-- Dropdown para selecionar a filial -->
        <select id="id_branch" name="id_branch" required>
            <option value="">Selecione Filial</option>
            <?php
            // Preenche o dropdown com as opções de filiais
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
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $ISBN = $_POST['ISBN'] ?? null;
    $id_author = $_POST['id_author'] ?? null;
    $quantity_stock = $_POST['quantity_stock'] ?? null;
    $id_branch = $_POST['id_branch'] ?? null;

    if ($ISBN && $id_author && $quantity_stock && $id_branch) {
        class Stock {
            private $ISBN;
            private $id_author;
            private $quantity_stock;
            private $id_branch;

            public function __construct($ISBN, $id_author, $quantity_stock, $id_branch) {
                $this->ISBN = $ISBN;
                $this->id_author = $id_author;
                $this->quantity_stock = $quantity_stock;
                $this->id_branch = $id_branch;
            }

            public function setStock($conn) {
                $sql = "INSERT INTO stocks (ISBN, id_author, quantity_stock, id_branch) VALUES(?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param("siii", 
                    $this->ISBN, 
                    $this->id_author, 
                    $this->quantity_stock,
                    $this->id_branch
                );

                if ($stmt->execute()) {
                    echo "Estoque cadastrado com sucesso!";
                } else {
                    echo "Erro ao cadastrar estoque: " . $stmt->error;
                }

                $stmt->close();
            }
        }

        $estoque = new Stock($ISBN, $id_author, $quantity_stock, $id_branch);
        $estoque->setStock($conn);
    } else {
        echo "Por favor, preencha todos os campos.";
    }

    $conn->close();
}
?>

</html>
