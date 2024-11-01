<?php
require 'db_connection.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "SELECT * FROM movies WHERE id = :id";
  $statement = $db->prepare($query);
  $statement->execute([':id' => $id]);
  $movie = $statement->fetch(PDO::FETCH_ASSOC);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $release_year = $_POST['release_year'];
    $duration = $_POST['duration'];
    $age_rating = $_POST['age_rating'];
    $trailer_url = $_POST['trailer_url'];
    $cover_image_url = $_POST['cover_image_url'];

    $query = "UPDATE movies SET title = :title, release_year = :release_year, duration = :duration,
age_rating = :age_rating, trailer_url = :trailer_url, cover_image_url = :cover_image_url
WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->execute([
      ':title' => $title,
      ':release_year' => $release_year,
      ':duration' => $duration,
      ':age_rating' => $age_rating,
      ':trailer_url' => $trailer_url,
      ':cover_image_url' => $cover_image_url,
      ':id' => $id
    ]);

    echo "Filme atualizado com sucesso!";
  }
}
