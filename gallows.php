<?php
	session_start();

?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="./gallows.css">
	</head>
	<body>
		<div id="insert_word">Aici va aparea cine trebuie sa decida cuvantul</div>
		<form action="spanzuratoarea.php" method="post">
			Insert a word/group of words: <input type="password" name="guess_word">
			<input type="submit" value="Submit">
		</form>

		<div class="left">
			<img id="gallows_steps" src="gallows0.jpg">
		</div>
		<div class="right">
			Guess the word:
			<div id="word"></div>
			<form action="spanzuratoarea.php" method="post">
			Insert a letter: <input type="password" name="letter_entered">
			<input type="submit" value="Submit">
		</form>
		</div>
	</body>
</html>

<?php
	session_start();

$word;
$correct_letters = array(" ");
//array_unique(); deduplica valorile dintr-un array
if(isset($_POST['guess_word'])) {
	$_SESSION['used_letters'] = array(" ");
	$_SESSION['correct_letters'] = array(" ");
	$_SESSION['wrong_letters'] = 0;
	$word = strtoupper($_POST['guess_word']);
	$_SESSION["word_to_guess"] = $word;

	$first_letter = $word[0];
	$last_letter = $word[strlen($word) - 1];
	array_push($_SESSION['correct_letters'], $first_letter);
	array_push($_SESSION['correct_letters'], $last_letter);
	array_push($_SESSION['used_letters'], $first_letter);
	array_push($_SESSION['used_letters'], $last_letter);

	display_letters($word, array_unique($_SESSION['correct_letters']));
	$_SESSION['wrong_letters'] = 0;

}


if(isset($_POST['letter_entered'])) {

	$letter = strtoupper($_POST['letter_entered']);

	array_push($_SESSION['used_letters'], $letter);

	if(strpos($_SESSION["word_to_guess"], $letter) !== false) {
		array_push($_SESSION['correct_letters'], $letter);
		echo "<script>document.getElementById('gallows_steps').src = 'gallows".$_SESSION['wrong_letters'].".jpg';</script>";	

	}
	else {
		$_SESSION['wrong_letters'] = $_SESSION['wrong_letters'] +1;
		echo "<script>document.getElementById('gallows_steps').src = 'gallows".$_SESSION['wrong_letters'].".jpg';</script>";	
	}
	display_letters($_SESSION["word_to_guess"], array_unique($_SESSION['correct_letters']));

}


function display_letters($dis_word, $correct_let) {
	
	$letter = "_ ";
	//print_r($_SESSION['correct_letters']);

	for($i=0; $i<strlen($dis_word); $i++) {
		if(in_array($dis_word[$i], $correct_let) ){
			$new_word = $new_word . $dis_word[$i];
		} else {
			$new_word = $new_word . $letter;
		}	
	}

	$display_word = $new_word;
	echo "<script>document.getElementById('word').innerHTML = '".$display_word."';</script>";	
	if(strpos($display_word, "_") === false) {
		echo "<script>
			if (confirm('Congratulation, you won this game! Do you want to play another game?')) {
			    document.getElementById('gallows_steps').src = 'gallows0.jpg';	

			  } else {
			    txt = 'See you around!';
			    document.getElementById('gallows_steps').src = 'gallows0.jpg';
			  }
		</script>";
		$_SESSION['used_letters'] = array(" ");
		$_SESSION['correct_letters'] = array(" ");
		$_SESSION['wrong_letters'] = 0;
		$_SESSION["word_to_guess"] = null;

		echo "<script>document.getElementById('word').innerHTML = '';</script>";	

	}
	$wrong = $_SESSION['wrong_letters'] ;
	if($wrong == 5) {
		echo $_SESSION['wrong_letters'];
			echo "<script>
			if (confirm('Game over, you lost!Do you want to play again?')) {
			    document.getElementById('gallows_steps').src = 'gallows0.jpg';	

			  } else {
			    txt = 'See you around!';
			    document.getElementById('gallows_steps').src = 'gallows0.jpg';
			  }
			</script>";
			$_SESSION['used_letters'] = array(" ");
			$_SESSION['correct_letters'] = array(" ");
			$_SESSION['wrong_letters'] = 0;
			$_SESSION["word_to_guess"] = null;

		echo "<script>document.getElementById('word').innerHTML = '';</script>";
		}

}

/*
cand intri start game, view records, About

start game--> introduceti cuvantul -->cand se apasa pe start se joaca jucatorul-->Introduceti numele--->Numele si scorul se introduc in fisier(cate litere din total)
cnd introduce numele, facem verificare daca mai exista-->Ne pare rau mai e un akt nume


Load game...cu fisier cu json de cuvinte: Easy, Medium si high
get set


order by name/score pt afisarea rezultatelor asc/desc
*/


?>
