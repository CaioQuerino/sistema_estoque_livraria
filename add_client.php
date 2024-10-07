<?php
include_once './database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $CPF = $_POST['CPF'] ?? null;
    $name_client = $_POST['name_client'] ?? null;
    $email_client = $_POST['email_client'] ?? null;

    if ($CPF && $name_client && $email_client) {
        class User {
            private $CPF;
            private $name_client;
            private $email_client;

            public function __construct($CPF, $name_client, $email_client) {
                $this->CPF = $CPF;
                $this->name_client = $name_client;
                $this->email_client = $email_client;
            }

            public function setUser($conn) {
                $sql = "INSERT INTO clients (CPF, name_client, email_client) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $this->CPF, $this->name_client, $this->email_client);

                if ($stmt->execute()) {
                    return "Usuário cadastrado com sucesso!";
                } else {
                    return "Erro ao cadastrar usuário: " . $stmt->error;
                }
            }
        }

        // Criação do objeto User e inserção no banco de dados
        $user = new User($CPF, $name_client, $email_client);
        $message = $user->setUser($conn);

        $conn->close();
    } else {
        $message = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="" method="POST">
        <h2>Adicionar Cliente</h2>
        <p id="message" style="color: brown;"></p> <!-- Exibe a mensagem dinamicamente -->

        <label for="CPF">CPF:</label>
        <input type="text" id="CPF" name="CPF" required maxlength="14"><br>

        <label for="name_client">Nome:</label>
        <input type="text" id="name_client" name="name_client" required><br>

        <label for="email_client">E-mail:</label>
        <input type="email" id="email_client" name="email_client" required><br>

        <input type="submit" value="Adicionar Cliente">
    </form>
    <script type="module" src="./js/main.js"></script>
</body>
</html>
