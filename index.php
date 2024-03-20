<?php
session_start();

// Verifica se o usuário está logado, se não estiver, redireciona para a página de login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de QR Code</title>
    <script src="./qrcode.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="logout">
        <a href="logout.php" class="logout">Logout</a>
    </div>
    <picture>
        <img src="images/Tentpeg_Logo_outlines.png" alt="Tentpeg Logo" class="logo">
    </picture>
    <h2>QR Code Generator</h2>
    <form id="qrForm">
        <label for="text">Text:</label>
        <input type="text" id="text" name="text">
        <button type="button" onclick="generateQRCode()">Generate QR Code</button>
    </form>
    <div id="qrcode"></div>
    <div class="button__qr">
        <button id="downloadButton" style="display: none;" onclick="downloadQRCode()">Download QR Code</button>
    </div>
    

    <script>
        function generateQRCode() {
            var text = document.getElementById('text').value;
            var qrCodeDiv = document.getElementById('qrcode');

            // Limpa o conteúdo anterior, se houver
            qrCodeDiv.innerHTML = '';

            // Cria o QR Code
            var qr = new QRCode(qrCodeDiv, {
                text: text,
                width: 256,
                height: 256,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            // Exibe o botão de download
            document.getElementById('downloadButton').style.display = 'block';
        }

        function downloadQRCode() {
            // Obtém o conteúdo da imagem do QR code
            var qrCodeImage = document.querySelector('canvas').toDataURL("image/png");

            // Cria um link temporário para o download
            var link = document.createElement('a');
            link.download = 'qrcode.png';
            link.href = qrCodeImage;

            // Simula um clique no link para iniciar o download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>
