<html>

<head>
	<title>Lecture d'un sujet</title>
	<link href="forum.css" rel="stylesheet">
	<meta charset="UTF-8">
</head>

<body class="lire_sujet">

<header>
	<ul>
<?php

	session_start();
	
	
	
	
	$base = mysqli_connect("localhost", "root", "", "forum");
	mysqli_set_charset($base, "utf8");
	$titre=$_SESSION['topic'];
	
	
	$categorie = "SELECT id_categorie FROM sous_categorie  WHERE titre ='$titre'";
	$result=mysqli_query($base, $categorie);
	$numcategorie=mysqli_fetch_array($result);
	
	$topic = "SELECT id FROM sous_categorie WHERE titre='$titre'";
	$result=mysqli_query($base, $topic);
	$numtopic=mysqli_fetch_array($result);
	
	$_GET['categorie'] = $numcategorie['id_categorie'];
	$_GET['topic'] = $numtopic['id'];
	
	
	
	$id = $_GET['id_sujet_a_lire'];
	$sujet= "SELECT titre from forum_sujets WHERE id='$id'";
	$resultsujet=mysqli_query($base, $sujet);
	$nomsujet=mysqli_fetch_array($resultsujet);

	


	if(isset($_POST['deco']))
	{
	unset($_SESSION['login']);
	unset($_SESSION['password']);		
	}
		
	if(isset($_SESSION['login']))
	{
?>	
	<li><a href="../index.php">Accueil</a></li>
	<div class="deco">
	<form  method="post">
		<input type="submit" name="deco" value="Déconnexion">
	</form>
	</div>
<?php		
	}
	else
	{
?>
	<li><a href="../index.php">Accueil</a></li>
	<div>
	<li><a href="connexion.php">Connexion</a></li>
	<li><a href="inscription.php">Inscription</a></li>
	</div>
<?php
}
?>
	</ul>			
</header>
<?php
if (!isset($_GET['id_sujet_a_lire'])) {
	echo 'Sujet non défini.';
}
else {
?>

<div id="espace"></div>
<div class="nomcategorie">
	<a href="../index.php" id="h1"><h1> <?php echo $_SESSION['categorie'];?> >&nbsp; </h1></a>
	<a href="../sources/forum.php/?categorie=<?php echo $_GET['categorie']; ?>/?topic=<?php echo $_GET['topic'];?>"  id="h2"><h2>  <?php echo $_SESSION['topic'];?> > &nbsp;</h2></a>
	<a href="" id="h3"><h3> <?php echo $nomsujet['titre'];?></h3></a>
</div>

<?php

	// on prépare notre requête
	$sql = 'SELECT auteur, message, DATE_FORMAT(`date_reponse`, "%M, %d %Y") FROM forum_reponses WHERE correspondance_sujet="'.$_GET['id_sujet_a_lire'].'" ORDER BY `forum_reponses`.`id` ASC';

	// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
	$req = mysqli_query($base, $sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error($base));
	
	// Pour sélectioner l'id et pouvoir supprimer le commentaire en fonction de son id
	$requete="SELECT id, message FROM `forum_reponses` WHERE correspondance_sujet='".$_GET['id_sujet_a_lire']."' ORDER BY `forum_reponses`.`id` ASC";
	$idresult= mysqli_query($base, $requete);

	
	
	
while(($data = mysqli_fetch_array($req)) && ($idmessage = mysqli_fetch_array($idresult))){

$auteur=$data['auteur'];
$requete2="SELECT grade from utilisateurs WHERE login='$auteur'";
$result2=mysqli_query($base, $requete2);
$auteurresult=mysqli_fetch_array($result2);


// NOMBRES DE LIKES ET DISLIKES

$idd=$idmessage['id'];
$req2="SELECT id FROM likes WHERE id_forum_reponses='$idd'";
$result2=mysqli_query($base, $req2);
$likes= mysqli_num_rows($result2);	

$req3="SELECT id FROM dislikes WHERE id_forum_reponses='$idd'";
$result3=mysqli_query($base, $req3);
$dislikes= mysqli_num_rows($result3);		

?>
<section>
	<article id="affichagediscussions">
	<?php 
	if(($auteurresult['grade']==2)||($auteurresult['grade']==1))
	{
		?>
		<div id="headerdiscussion">
			<div id="auteur"><?php echo $data['auteur'];?></div>
		    <div><?php echo $data['DATE_FORMAT(`date_reponse`, "%M, %d %Y")'];?></div>
		</div>
	<?php
	}
	else
	{	
	?>
		<div id="headerdiscussion2">
			<div id="auteur"><?php echo $data['auteur'];?></div>
		    <div><?php echo $data['DATE_FORMAT(`date_reponse`, "%M, %d %Y")'];?></div>
		</div>
	<?php
	}
	?>
		<div id="messages">
			<br>
			<p><?php echo $data['message'];?></p>
			
		</div>		
		<div id="likedislike">	
			<div>
					<?php 
					if(isset($_SESSION['login']))
					{
					?>
					<div>
					<a href="action.php?t=1&id=<?php echo $idmessage['id']; ?>"><img src="../img/like.jpg" width="30px"></a> 
					<div><?php echo $likes; ?></div>
					</div>
					<?php
					}
					else
					{
					?>
					<div>
					<img src="../img/like.jpg" width="30px">
					<div><?php echo $likes; ?></div>
					</div>
					<?php
					}
					?>	
				
					<?php
				    if(isset($_SESSION['login']))
					{
					?>
					<div>
					<a href="action.php?t=2&id=<?php echo $idmessage['id']; ?>"><img src="../img/dislike.jpg" width="30px"></a>
					<div><?php echo $dislikes; ?></div>
					</div>
					<?php
					}
					else
					{
					?>
					<div>
					<img src="../img/dislike.jpg" width="30px">
					<div><?php echo $dislikes; ?></div>
					</div>
					<?php
					}
					?>
			</div>
		</div>
		
		<?php
		
			
			if(isset($_SESSION['login']))
			{
				if(($_SESSION['login'] == $data['auteur'])||($_SESSION['login']=="admin"))
				{
			?>
			<div id="suppr">
				<form method="post" action="lire_sujet.php?id_sujet_a_lire=<?php echo $id;?>">
					<td>		
						<input class="supprimer" type="submit" name="effacer" value="Supprimer">
						<input type="hidden" name="suppr" value="<?php echo $idmessage['id'] ?>"> 					
					</td>
				</form>
			<?php
				}	
			if(isset($_POST['effacer']))
			{		
				$message= $_POST['suppr'];
				$query2="DELETE FROM `forum_reponses` WHERE id = '$message'";
				mysqli_query($base, $query2);	
				$url1="id_sujet_a_lire=";
				$url2=$id;
				$url=$url1."".$url2;
				header ('location: lire_sujet.php?'.$url);				
			}
			?>
			</div>
			<?php
			}
			?>
		
	</article>
</section>
<?php
}
?>



</article>

	<!-- on insère un lien qui nous permettra de rajouter des réponses à ce sujet -->
<?php
if(isset($_SESSION['login']))
{
?>
<?php
if(isset($_POST['go']))
{
		// on se connecte à notre base
		$base = mysqli_connect("localhost", "root", "", "forum");
		
		$auteur =$_SESSION['login'];
		$message =$_POST['message'];
		// préparation de la requête d'insertion (table forum_reponses)
		$sql = "INSERT INTO `forum_reponses` (`auteur`, `message`, `date_reponse`, `correspondance_sujet`) VALUES ('".$auteur."', '".$message."', CURRENT_TIMESTAMP(), '".$id."')";

		// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		mysqli_query($base, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

		// préparation de la requête de modification de la date de la dernière réponse postée (dans la table forum_sujets)
		$sql = 'UPDATE forum_sujets SET date_derniere_reponse= CURRENT_TIMESTAMP() WHERE id="'.$id.'"';

		// on lance la requête (mysql_query) et on impose un message d'erreur si la requête ne se passe pas bien (or die)
		mysqli_query($base, $sql) or die('Erreur SQL !'.$sql.'<br />'.mysqli_error($base));

		// on ferme la connexion à la base de données
		mysqli_close($base);

		$page=$_GET['id_sujet_a_lire'];
	
		 header('Location: lire_sujet.php?id_sujet_a_lire='.$page);

		// on termine le script courant
		exit;
	}

}
?>


<body>
<?php
if(isset($_SESSION['login']))
{
?>
<!-- on fait pointer le formulaire vers la page traitant les données -->

<div class="form-style-6">
	<form id="reponse" method="post">
		<textarea required placeholder="Saisissez votre commentaire" name="message"></textarea>
		<input type="hidden" name="categorie" value="<?php echo $_GET['categorie'];?>">
		<input type="hidden" name="topic" value="<?php echo $_GET['topic'];?>">
		<input type="submit" name="go" value="Publier la réponse">
	</form>
</div>


<?php
}
}
?>
<!-- on insère un lien qui nous permettra de retourner à l'accueil du forum -->

<div class="FooterBottomWrap">
	<div class="FooterBottom">
		<div class="FooterBottomInfo">
			<div class="FooterArenaNetLogo">
				<a href="http://www.arena.net/">
				<img src="https://fr-forum.guildwars2.com/themes/guildwars/design/images/logo-arenanet-white.png?v=1.1.0.5dfa5453">
				</a>
			</div>
			<div class="FooterBottomCopyright">
				<div class="FooterCopyrightBottom">
					<a href="https://www.guildwars2.com/fr/legal/arenanet-privacy-policy/">Charte de confidentialité</a>
					<a href="https://www.guildwars2.com/fr/legal/">Mentions Légales</a>
				</div>
			</div>
			<div class="FooterBottomRating">
				<a id="ratingLink" href="http://www.pegi.info" target="_blank" rel="noopener">
				<img id="ratingImage" src="https://fr-forum.guildwars2.com/themes/guildwars/design/images/esrb.png?v=1.1.0.5dfa5453">
				</a>
			</div>
		</div>
	</div>
</div>

</body>
</html>