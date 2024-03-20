<?php
session_start();

// Finaliza a sessão
session_unset();
session_destroy();

// Redireciona para a página de login ou para onde desejar
header('Location: login.html');
exit;
?>
