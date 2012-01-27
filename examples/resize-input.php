<?php
/*
 * Project: PHP-Image-Resize
 * File: examples/resize-input.php
 * Version: Rev 0
 */

include('../class.php');

// Lade Bild in Resize Klasse (Input)
$image = new PHPImageResize;
$image->importImageInput($_FILES['image'], '../tmp/' . microtime());

// Verkleinern des Bildes
$image->resize(500, 280, 90, '../results/' . microtime() . '.jpg'); // Verhaltniss wird beibehalten

// Beenden des Klassenaufrufes
$image->endResizing();

echo 'Sie finden das verkleinerte Bild unter /results';
?>