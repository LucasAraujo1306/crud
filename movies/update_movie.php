<?php
require '../db/db_connection.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "SELECT * FROM movies WHERE id = :id";
  $statement = $db->prepare($query);
  $statement->execute([':id' => $id]);
  $movie = $statement->fetch(PDO::FETCH_ASSOC);

  // Verifica se o filme foi encontrado
  if (!$movie) {
    echo "Filme não encontrado.";
    exit();
  }

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
    header('Location:./list_movies.php');
  }
} else {
  echo "ID do filme não especificado.";
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atualizar Filme</title>
</head>

<body>
  <h2>Atualizar Filme</h2>

  <form method="POST" action="">
    <label for="title">Título:</label>
    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
    <br>

    <label for="release_year">Ano de Lançamento:</label>
    <input type="number" id="release_year" name="release_year"
      value="<?php echo htmlspecialchars($movie['release_year']); ?>" required>
    <br>

    <label for="duration">Duração (em minutos):</label>
    <input type="number" id="duration" name="duration" value="<?php echo htmlspecialchars($movie['duration']); ?>"
      required>
    <br>

    <label for="age_rating">Classificação Etária:</label>
    <input type="number" id="age_rating" name="age_rating" value="<?php echo htmlspecialchars($movie['age_rating']); ?>"
      required>
    <br>

    <label for="trailer_url">URL do Trailer:</label>
    <input type="url" id="trailer_url" name="trailer_url" value="<?php echo htmlspecialchars($movie['trailer_url']); ?>"
      required>
    <br>

    <label for="cover_image_url">URL da Capa:</label>
    <input type="url" id="cover_image_url" name="cover_image_url"
      value="<?php echo htmlspecialchars($movie['cover_image_url']); ?>" required>
    <br>

    <button type="submit">Atualizar Filme</button>
  </form>
</body>

</html>