<?php
include_once './database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name_author = $_POST['name_author'] ?? '';

    // Valida o campo do autor
    if (!empty($name_author)) {
        class Authors {
            private $name_author;

            public function __construct($name_author) {
                $this->name_author = $name_author;
            }

            public function cadastrarAutor($conn) {
                $sql = "INSERT INTO authors (name_author) VALUES(?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $this->name_author);

                if ($stmt->execute()) {
                    return "Autor cadastrado com sucesso!";
                } else {
                    return "Erro ao cadastrar autor: " . $stmt->error;
                }
            }
        }

        // Cria o autor e tenta cadastrar
        $autor = new Authors($name_author);
        $message = $autor->cadastrarAutor($conn);
    } else {
        $message = "O nome do autor não pode estar vazio.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Autor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
        <h2>Adicionar Autor</h2>
        <p id="message" style="color: brown;"></p> <!-- Exibe a mensagem dinamicamente -->

        <label for="name_author">Nome do Autor:</label>
        <input type="text" id="name_author" name="name_author" required placeholder="Nome do autor"><br>

        <input type="submit" value="Adicionar Autor">
    </form>

    <script type="module" src="./js/main.js"></script>
</body>
</html>
