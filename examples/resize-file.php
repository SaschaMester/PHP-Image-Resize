<?php
/*
 * Project: PHP-Image-Resize
 * File: examples/resize-file.php
 * Version: Rev 0
 */

include('../class.php');
 
// Lade Bild in Resize Klasse (Input)
$image = new PHPImageResize;
$image->importImageByPath('images/' . $_POST['image']);

// Verkleinern des Bildes
$image->resize(500, 280, 90, '../results/' . microtime() . '.jpg'); // Verhaltniss wird beibehalten

// Beenden des Klassenaufrufes
$image->endResizing();

echo 'Sie finden das verkleinerte Bild unter /results';
?>