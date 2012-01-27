<?php
/*
 * Project: PHP-Image-Resize
 * File: examples/index.php
 * Version: Rev 0
 */

 // Pruefe ob User gewaelt hat von wo er das Bild nehmen möchte
if (isset($_GET['upload'])) {
	// Pruee ob Uploade Mode gewaelt ist
	if (isset($_GET['mode'])) {
		echo '<h1>';
			echo 'Laden Sie bitte Ihr Bild hoch!';
		echo '</h1>';
		
		// Pruefe wohin der Upload gesendet werden soll
		if ($_GET['mode'] == 'resize') {
			$uploadTarget = 'resize-input.php';
		}elseif ($_GET['mode'] == 'resize-to-square') {
			$uploadTarget = 'resize-input-to-square.php';
		}
		
		echo '<form action="' . $uploadTarget . '" method="post" enctype="multipart/form-data">';
			echo '<input type="file" name="image">';
			echo '<input type="submit" value="Hochladen">';
		echo '</form>';

	}else {
		echo '<h1>';
			echo 'In welche Form soll das Bild, welche Sie hochladen möchten, skaliert werden?';
		echo '</h1>';
	
		echo '<form action="?upload&mode=resize" method="post">';
			echo '<input type="submit" name="send" value="Bild proportional skalieren" />';
		echo '</form>';	
			
		echo '<form action="?upload&mode=resize-to-square" method="post">';
			echo '<input type="submit" name="send" value="Bild quadratisch skalieren" />';
		echo '</form>';	
	}
}elseif (isset($_GET['file'])) {
	// Pruefe ob Image bereits gewaelt wurde
	if (isset($_GET['image'])) {
		echo '<h1>';
			echo 'In welche Form soll das Bild skaliert werden?';
		echo '</h1>';
		echo '<table width="50%" border="0">';
			echo '<tr>';
				echo '<td>';
					echo '<img src="images/' . $_GET['image'] . '.jpg" width="200" height="133" />';
				echo '</td>';
				
				echo '<td>';
					echo '<form action="resize-file.php" method="post">';
						echo '<input type="hidden" name="image" value="' . $_GET['image'] . '.jpg" />';
						echo '<input type="submit" name="send" value="Bild proportional skalieren" />';
					echo '</form>';	
					
					echo '<form action="resize-file-to-square.php" method="post">';
						echo '<input type="hidden" name="image" value="' . $_GET['image'] . '.jpg" />';
						echo '<input type="submit" name="send" value="Bild quadratisch skalieren" />';
					echo '</form>';	
				echo '</td>';
			echo '</tr>';
		echo '</table>';
	}else {
		echo '<h1>';
			echo 'Welches Bild möchten Sie skalieren?';
		echo '</h1>';
		
		echo '<form action="?file" method="get">';
			echo '<table width="100%" border="0">';
				echo '<tr>';
					echo '<td>';
						echo '<img src="images/001.jpg" width="200" height="133" />';
						echo '<input type="radio" name="image" value="001" />';
					echo '</td>';
					
					echo '<td>';
						echo '<img src="images/002.jpg" width="200" height="133" />';
						echo '<input type="radio" name="image" value="002" />';
					echo '</td>';
					
					echo '<td>';
						echo '<img src="images/003.jpg" width="200" height="133" />';
						echo '<input type="radio" name="image" value="003" />';
					echo '</td>';
				echo '</tr>';
			echo '</table>';
			
			echo '<br /><br />';
			echo '<input type="hidden" name="file" value="" />';
			echo '<input type="submit" name="submit" value="Weiter" />';
		echo '</form>';	
	}
}else {
	echo '<h1>';
		echo 'Von welcher Quelle möchten Sie ein Bild verändern?';
	echo '</h1>';
	
	echo '<p>';
		echo '<a href="?file">';
			echo 'Bildergalerie';
		echo '</a>';
		
		echo ' - ';
		
		echo '<a href="?upload">';
			echo 'Upload';
		echo '</a>';
	echo '</p>';
}
?>