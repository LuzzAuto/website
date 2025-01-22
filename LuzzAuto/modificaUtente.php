<?php

require_once 'dbConnection.php';
use DB\DBConnection;

session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION["utente"])) {
    header("location: login.php");
    exit();
}
// Controllo se l'utente è loggato
if (isset($_SESSION["utente"]) && $_SESSION["utente"]=="admin") {
    header("location: amministratore.php");
    exit();
}


//INFORMAZIONI UTENTE

// Recupero username dalla sessione
$username = $_SESSION["utente"];

$db = new DBConnection();

try {

    $utente = $db->getNomeCognomeUser($username);

    if (!empty($utente)) {
        $nome = $utente[0]['nome'];
        $cognome = $utente[0]['cognome'];
        $username = $utente[0]['username'];
    } else {
        $nome = 'Nome non trovato';
        $cognome = 'Cognome non trovato';
        $username = 'Utente non trovato';
    }

    $db->closeConnection();

} catch (Exception $e) {
    header("location: 500.html");
    exit();
}

// Carico template html
$pagina = file_get_contents('modificaUtente.html');

// Sostituisco i segnaposto nel template con i dati recuperati
$pagina = str_replace('[nome]', htmlspecialchars($nome), $pagina);
$pagina = str_replace('[cognome]', htmlspecialchars($cognome), $pagina);
$pagina = str_replace('[username]', htmlspecialchars($username), $pagina);
$pagina = str_replace('[password]', htmlspecialchars("*********"), $pagina);
$pagina = str_replace('[password2]', htmlspecialchars("*********"), $pagina);

$db = new DBConnection();
/*$ris = $db->updateNome($username, $_POST["nome"]);*/
$db->closeConnection();

unset($db);

$err = "";


if(isset($_POST["nome"]) || isset($_POST["cognome"]) || isset($_POST["username"]) || isset($_POST["password"]) || isset($_POST["password2"])){

    if($nome != $_POST["nome"]){
        if (!preg_match("/^[A-Za-z]+$/", $_POST["nome"])) {
			$err = $err . "<p>Nome non valido, puoi usare solo lettere.</p>";
		}
    }
    if($cognome != $_POST["cognome"]){
        if (!preg_match("/^[A-Za-z]+$/", $_POST["cognome"])) {
			$err = $err . "<p>Cognome non valido, puoi usare solo lettere</p>";
		}
    }
    if($username != $_POST["username"]){
		if (strlen($_POST["username"]) > 30) {
			$err = $err . "<p>L'<span lang='en-GB'>username</span> deve essere lungo al massimo 30 caratteri.</p>";
		}
        if (!preg_match("/^[A-Za-z0-9]+$/", $_POST["username"])) {
			$err = $err . "<p><span lang='en-GB'>Username</span> non valido, puoi usare solo lettere o numeri.</p>";
		}
    }

    if(empty($_POST["password"]) && !empty($_POST["password2"])){
        $err = $err . "<p>Devi inserire anche la vecchia <span lang='en-GB'>password</span>.</p>";
    }
    
    if(!empty($_POST["password"]) && empty($_POST["password2"])){
        $err = $err . "<p>Devi inserire anche la nuova <span lang='en-GB'>password</span>.</p>";
    }

    if(!empty($_POST["password"]) && !empty($_POST["password2"])){
		if (strlen($_POST["password2"]) < 8) {
			$err = $err . "<p>La <span lang='en-GB'>password</span> deve essere di almeno 8 caratteri.</p>";
		}
        if (!preg_match("/\d/", $_POST["password2"]) || ! preg_match("/[a-zA-Z]/", $_POST["password2"])) {
			$err = $err . "<p>La <span lang='en-GB'>password</span> deve contenere almeno una lettera e un numero.</p>";
		}
    }

    //CONTROLLO ERRORI
	if (!empty($err)) {
		echo str_replace("[err]", $err, $pagina);
		exit();
	}

    //ESECUZIONE DELLA QUERY
    try{
        $db = new DBConnection();
        if(!empty($_POST['nome'])){
            $ris = $db->updateNome($username, $_POST['nome']);
        }
        if(!empty($_POST['cognome'])){
            $ris = $db->updateCognome($username, $_POST['cognome']);
        }
        if(!empty($_POST['username'])){
            $ris = $db->updateUsername($username, $_POST['username']);
            $_SESSION["utente"] = $_POST['username'];
        }
        if(!empty($_POST['password']) && !empty($_POST['password2'])){
            $ris = $db->updatePassword($username, $_POST['password'], $_POST['password2']);
        }
        $db->closeConnection();
        
        unset($db);
        
        /*header("location: utente.php");*/
    }
    catch(Exception){
        header("location: 500.html");
        exit();
    }

}else{
    $pagina = str_replace("[err]", $err, $pagina);
}



echo $pagina;


?>