<?php
/*
 * Project: PHP-Image-Resize
 * File: examples/resize-input-to-square.php
 * Version: Rev 0
 */

include('../class.php');
 
// Lade Bild in Resize Klasse (Input)
$image = new PHPImageResize;
$image->importImageInput($_FILES['image'], '../tmp' . microtime());

// Verkleinern des Bildes
$image->resizeToSquare(100, 90, '../results/' . microtime() . '.jpg'); // Quadratischer Ausschnitt des Bildes wird hergestellt

// Beenden des Klassenaufrufes
$image->endResizing();

echo 'Sie finden das verkleinerte Bild unter /results';
?>