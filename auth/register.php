<?php
include '../functions/uuid.php';

session_start();
include '../db/db_connection.php'; // Conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $uuid = generateUUIDv4(); // Gerando o UUID

  // Verifica se o nome de usuário já existe
  $checkQuery = "SELECT COUNT(*) FROM users WHERE username = :username";
  $checkStmt = $db->prepare($checkQuery);
  $checkStmt->execute([':username' => $username]);
  $userExists = $checkStmt->fetchColumn();

  if ($userExists) {
    echo "<p>Esse nome de usuário já está em uso. Por favor, escolha outro.</p>";
  } else {
    // Inserir o novo usuário no banco de dados
    $query = "INSERT INTO users (id, username, password) VALUES (:id, :username, :password)";
    $statement = $db->prepare($query);
    $statement->execute([
      ':id' => $uuid,
      ':username' => $username,
      ':password' => $hashed_password
    ]);

    echo "<p>Registro bem-sucedido! Você pode fazer login agora.</p>";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
</head>

<body>
  <h2>Criar Conta</h2>
  <form method="POST" action="register.php">
    <label for="username">Usuário:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Registrar</button>
  </form>
</body>

</html>