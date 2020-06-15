<?php
// on teste si le formulaire a été soumis
session_start();

if(isset($_SESSION['login']))
{

if (isset($_POST['go'])) 
{
	echo $_GET['numero_du_sujet'];
	
		$base = mysqli_connect("localhost", "root", "", "forum");
		mysqli_set_charset($base, "utf8");
		
		$auteur =$_SESSION['login'];
		$message =$_POST['message'];
		// préparation de la requête d'insertion (table forum_reponses)
		$sql = "INSERT INTO `forum_reponses` (`auteur`, `message`, `date_reponse`, `correspondance_sujet`) VALUES ('".$auteur."', '".$message."', CURRENT_TIMESTAMP(), '".$_GET['numero_du_sujet']."')";

		// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		mysqli_query($base, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

		// préparation de la requête de modification de la date de la dernière réponse postée (dans la table forum_sujets)
		$sql = 'UPDATE forum_sujets SET date_derniere_reponse= CURRENT_TIMESTAMP() WHERE id="'.$_GET['numero_du_sujet'].'"';

		// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		mysqli_query($base, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

		// on ferme la connexion à la base de données
		mysqli_close($base);

		// on redirige vers la page de lecture du sujet en cours
		header('Location: ../lire_sujet.php?id_sujet_a_lire='.$_GET['numero_du_sujet']);

		// on termine le script courant
		exit;
	}

?>

<html>
<head>
	<title>Insertion d'une nouvelle réponse</title>
	<link href="../forum.css" rel="stylesheet">
	<meta charset="UTF-8">
</head>

<body>


<section class="formsujet">
	<div class="form-style-5">
	<form action="insert_reponse.php?numero_du_sujet=<?php echo $_GET['numero_du_sujet']; ?>" class="insertionsujet" method="post">
		<input type="text" disabled="disabled" name="auteur" value="<?php echo $_SESSION['login']; ?>">
		<textarea required placeholder="Votre message" name="message"></textarea>
		<input type="submit" name="go" value="Répondre">
	</form>
	</div>
</section>
<?php
if (isset($erreur)) echo '<br /><br />',$erreur;
}
else
{
	header('location: connexion.php');
}
?>
</body>
</html>