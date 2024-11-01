<?php
require 'db_connection.php';

$query = "SELECT * FROM movies";
$statement = $db->prepare($query);
$statement->execute();
$movies = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($movies as $movie) {
  echo "<div class='movie'>";
  echo "<h2>" . htmlspecialchars($movie['title']) . "</h2>";
  echo "<p>Ano: " . htmlspecialchars($movie['release_year']) . "</p>";
  echo "<p>Duração: " . htmlspecialchars($movie['duration']) . " minutos</p>";
  echo "<p>Classificação: " . htmlspecialchars($movie['age_rating']) . "+</p>";
  echo "<iframe src='" . htmlspecialchars($movie[' trailer_url']) . "'></iframe>";
  echo "<img src='" .
    htmlspecialchars($movie['cover_image_url']) . "' alt='Capa do filme'>";
  echo "<a href='update_movie.php?id=" .
    $movie['id'] . "'>Editar</a> | ";
  echo "<a href='delete_movie.php?id=" . $movie['id'] . "'>Excluir</a>";
  echo "</div>";
}
