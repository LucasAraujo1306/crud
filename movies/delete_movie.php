<?php
include_once '../includes/header.php';  // Cabeçalho HTML e link CSS
include_once '../includes/navbar.php';

require '../db/db_connection.php';

$message = ''; // Variável para armazenar a mensagem de sucesso

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $query = "DELETE FROM movies WHERE id = :id";
  $statement = $db->prepare($query);
  $statement->execute([':id' => $id]);

  $message = "Filme excluído com sucesso!";
}

?>
<div class="message-container" id="message" style="display: none;">
  <p class="success-message"><?php echo $message; ?></p>
</div>

<script>
// Se a mensagem não estiver vazia, exiba e faça a animação
const message = document.getElementById('message');
if (message.innerText) {
  message.style.display = 'block'; // Exibe a mensagem
  setTimeout(() => {
    message.classList.add('fade-out'); // Adiciona a classe de fade-out
  }, 2000); // Aguardar 2 segundos antes de começar a animação

  // Remover a mensagem após a animação
  message.addEventListener('animationend', () => {
    message.style.display = 'none'; // Oculta a mensagem após a animação
  });
}
</script>

<style>
.message-container {
  position: relative;
  text-align: center;
  margin: 20px;
}

.success-message {
  font-size: 1.5em;
  color: red;
  transition: opacity 0.5s ease;
}

.fade-out {
  opacity: 0;
  /* Transição para invisibilidade */
  animation: fadeOut 0.5s forwards;
  /* Animação de fade-out */
}

@keyframes fadeOut {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
  }
}
</style>

<?php include_once '../includes/footer.php'; // Inclui o rodapé 
?>