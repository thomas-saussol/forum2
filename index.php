<html>

<head>
	<title>Index de notre forum</title>
	<link href="sources/forum.css" rel="stylesheet">
	<meta charset="UTF-8">


</head>

<body class="accueil">

<header>  
	<ul>
<?php

	session_start();

	$base = mysqli_connect("localhost", "root", "", "forum");
	mysqli_set_charset($base, "utf8");



	if (isset($_GET['sous-categorie']))
	{
	$caracteres="/?categorie=";
	$categorie=$_GET['numcategorie'];
	$caracteres2="/?topic=";
	$topic=$_GET['numtopic'];
	$_SESSION['categorie']=$_GET['nomcategorie'];

	$_SESSION['topic']=$_GET['nomtopic'];


	$pages=$caracteres."".$categorie."".$caracteres2."".$topic;

	header('location: sources/forum.php'.$pages);

	}
	if(isset($_POST['deco']))
	{
	unset($_SESSION['login']);
	unset($_SESSION['password']);
	}

	if(isset($_SESSION['login']))
	{
	$login=$_SESSION['login'];
	$querygrade="SELECT grade from utilisateurs where login='$login'";
	$resultgrade=mysqli_query($base, $querygrade);
	$grade=mysqli_fetch_array($resultgrade);

	if(($grade['grade']==1)||($grade['grade']==2))
	{
?>
	<div>
	<li><a href="sources/administration.php">Administration</a></li>
	</div>
	<?php
	}
	else
	{
	?>
	<div>
	</div>
	<?php
	}
	?>
	<div class="deco">
	<form  method="post" action="index.php">
		<input type="submit" name="deco" value="Déconnexion">
	</form>
	</div>
<?php
	}
	else
	{
?>
	<div>
	</div>
	<div>
	<li><a href="sources/connexion.php">Connexion</a></li>
	<li><a href="sources/inscription.php">Inscription</a></li>
	</div>
<?php
}
?>
	</ul>
</header>




<div class="logotitre">
	<img src="img/logogw2.png">
</div>

<?php


$sql = 'SELECT id, titre from categorie';

$query= mysqli_query($base, $sql);

?>
<main>
<section class="sectionaccueil">
<?php
while ($data=mysqli_fetch_array($query))
{
?>
	<article class="categorie">
		<span><?php echo $data['titre']; ?></span>

				<?php
				$sql2="SELECT sous_categorie.titre, sous_categorie.id  as idsous, id_categorie, categorie.id from sous_categorie, categorie where id_categorie = categorie.id";
				$query2=mysqli_query($base, $sql2);
				while($data2=mysqli_fetch_array($query2))
				{
				if($data2['id_categorie']==$data['id'])
				{
				?>
				<div>
				<form class="topic" method="get" action="index.php">
				<input type="hidden" name="numcategorie" value="<?php echo $data2['id_categorie'];?>">
				<input type="hidden" name="numtopic" value="<?php echo $data2['idsous']; ?>">
				<input type="hidden" name="nomcategorie" value="<?php echo $data['titre'];?>">
				<input type="hidden" name="nomtopic" value="<?php echo $data2['titre'];?>">
				<input type="submit" name="sous-categorie" value="<?php echo $data2['titre'];?>">
				</form><br>
				</div>
				<?php
				}
				}
				?>
	</article>
<?php
}
?>
</section>
</main>


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
