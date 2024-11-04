<?php
require '../db/db_connection.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "DELETE FROM movies WHERE id = :id";
  $statement = $db->prepare($query);
  $statement->execute([':id' => $id]);

  echo "Filme excluído com sucesso!";
}
