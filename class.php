<?php
/*
 * Project: PHP-Image-Resize
 * File: class.php
 * Version: Rev 0
 */

class PHPImageResize {
	var $imageSouce;
	var $image;
	var $typ; // 0 = get by path; 1 = get by input

	function PHPImageResize() {
		$this->image = '';
	}
	
	// Setzten von Variabeln
	public function __set($name, $value) {
		$this->$name = $value;
	}

	// Auslesen von Variabeln
	public function __get($name) {
		return $this->$name;
	}

	function importImageByPath($imageSouce) { // Nur JPG erlaubt
		$this->imageSouce = $imageSouce;
		$this->image = imagecreatefromjpeg($imageSouce);
		
		$this->type = 0;
	}
	
	function importImageInput($FILE, $tmpFilePath = false) { // JPG und PNG erlaubt
		if (!$tmpFilePath) {
			$tmpFilePath = 'tmp/' . microtime();
		}
		
		// Pruefe ob Datei JPG oder PNG
		if ($FILE['type'] == 'image/jpeg') { // Lade JPG in Klasse
			// Speiche Bild temporaer ab
			copy($FILE['tmp_name'], $tmpFilePath);
			
			$this->imageSouce = $tmpFilePath;
			$this->image = imagecreatefromjpeg($tmpFilePath);
			
			$this->type = 1;
		} elseif ($FILE['type'] == 'image/png'){
			// Wandle PNG in Image Souce
			$png = imagecreatefrompng($FILE['tmp_name']);
			
			// Speiche Bild temporaer ab
			imagejpeg($png, $tmpFilePath, 100);
			
			$this->imageSouce = $tmpFilePath;
			$this->image = imagecreatefromjpeg($tmpFilePath);
			
			$this->type = 1;
			
			// Leere $png
			unset($png);
		}else {
			return 'false:onlyJpgOrPng';
		}
	}
	
	function endResizing() { // Endungsklassr, welche Temoraer erzeuge Daten loest
		unset($this->image);
		
		// Pruefe ob es sich hierbei um ein hochgeladenes Bild handelt. Wenn ja, loese temporaer erzeugtes Bild
		if ($this->type == 1) {
			unlink($this->imageSouce);
		}
	}

	// Berklwinerung von Bildern (Masstrabsgereu)
	function resize($maxWidth, $maxHeight, $quality = 90, $savePath = false, $biggerThanOriginal = false) {
		// Ermittle Bildgroesse
		$imageSize = getimagesize($this->imageSouce);
		$width = $imageSize[0];
		$height = $imageSize[1];

		// Berechne Skalierungsfaktor der Breite
		$factor[0] = $maxWidth / $width;
		// Berechne Skalirungsfaktor der Hoehe
		$factor[1] = $maxHeight / $height;
		
		// Pruefe welches Fakotor der kleinere ist und speichere diesen als $factor
		if ($factor[0] < $factor[1]) {
			$factor = $factor[0];
		}else {
			$factor = $factor[1];
		}
		
		// Pruefe ob Faktor ueber 1 ist (vergroesergung des Bilders). Pruefe ob gewuenscht, wenn nicht, gebe Bild in Orginalgroesse zurueck)
		if ($factor > 1 && !$biggerThanOriginal) {
			if ($savePath) {
				// Speichere Bild unter angegebenen Pfad ab
				imagejpeg($this->image, $savePath, $quality);
				return;
			}else {
				// Gebe verkleinertes Bild zurueck
				return $this->image;
			}
		}
		
		
		// Berechne neue Verhaeltnisse
		$newWidth = round($width * $factor);
		$newHeight = round($height * $factor);

		// Verkleinere Bild
		$resizedImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($resizedImage, $this->image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

		if ($savePath) {
			// Speichere Bild unter angegebenen Pfad ab
			imagejpeg($resizedImage, $savePath, $quality);
			unset($resizedImage);
		}else {
			// Gebe verkleinertes Bild zurueck
			return $resizedImage;
		}
	}

	// Verkleinerung des Bildes au Quadrat
	function resizeToSquare($size, $quality = 90, $savePath = false) {
		// Verkleine Bild auf das 1,3-F	Fache von Zielgroesse (ohne Beschneidung auf quadrat) und lade es in Variable
		$this->resize($size * 1.8, $size * 1.8, 100, $this->imageSouce . '-2', true);
		$image = imagecreatefromjpeg($this->imageSouce . '-2');
	
		// Erzeuge neues Bild
		$resizedImage = imagecreatetruecolor($size, $size);
		
		// Ermittle Bildgroesse des erkleinerten Bildes
		$imageSize = getimagesize($this->imageSouce . '-2');
		$width = $imageSize[0];
		$height = $imageSize[1];
		
		// Berechne Ansatzpunk fuer zentrieren Quadratausschnitt
		$newWidthPoint = round(($width / 2) - ($size / 2));
		$newHeightPoint = round(($height / 2) - ($size / 2));
		
		imagecopyresized($resizedImage, $image, 0, 0, $newWidthPoint, $newHeightPoint, $size, $size, $size, $size);
		
		// Loesche verkleinertes Bild
		unlink($this->imageSouce . '-2');
		unset($image);

		if ($savePath) {
			// Speichere Bild unter angegebenen Pfad ab
			imagejpeg($resizedImage, $savePath, $quality);
			unset($resizedImage);
		} else {
			// Gebe verkleinertes Bild zurueck
			return $resizedImage;
		}
	}
}
?>
