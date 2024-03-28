<?php
// Chemin vers votre image
// $imagePath = 'C:\Users\DIGITAL LAB\Desktop\AAAA\dashboard_icon_1.png';
// $imagePath = 'C:\Users\DIGITAL LAB\Desktop\AAAA\communication_icon.png';
$imagePath = 'C:\Users\DIGITAL LAB\Desktop\AAAA\finance_icon.png';

// Lire le contenu binaire de l'image
$imageData = file_get_contents($imagePath);

// Encoder l'image en base64
$imageBase64 = base64_encode($imageData);

// Afficher le code base64 de l'image
echo $imageBase64;
?>
