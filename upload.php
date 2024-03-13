<?php
// Verifica se um arquivo foi enviado
if ($_FILES["file"]["error"] == 0) {
    // Move o arquivo para o diretório de destino
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    // Insere os dados no banco de dados
    $text = $_POST["text"]; // Supondo que você está enviando o texto junto com a imagem
    $image_path = $target_file;

    // Conecte-se ao banco de dados e insira os dados aqui
    // Substitua 'seu_banco_de_dados', 'seu_usuario', 'sua_senha' e 'sua_tabela' pelos valores reais
    $conn = new mysqli('localhost', 'u671310777_qrcode', '9JI?yTT9|xX', 'u671310777_qrcode');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO sua_tabela (text, image_path) VALUES (?, ?)");
    $stmt->bind_param("ss", $text, $image_path);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    // Redireciona de volta para a página anterior
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
