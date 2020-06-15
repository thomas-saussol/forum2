<html>

<head>
	<title>Forum</title>
	<link href="../forum.css" rel="stylesheet">
	<meta charset="UTF-8">
</head>

<?php
session_start();

$base = mysqli_connect("localhost", "root", "", "forum");
mysqli_set_charset($base, "utf8");
$titre=$_SESSION['topic'];


$topic = "SELECT id FROM sous_categorie WHERE titre='$titre'";
$result=mysqli_query($base, $topic);
$numtopic=mysqli_fetch_array($result);

$categorie = "SELECT id_categorie FROM sous_categorie  WHERE titre ='$titre'";
$result=mysqli_query($base, $categorie);
$numcategorie=mysqli_fetch_array($result);
	
if (!isset($_GET['categorie'])) {
	echo 'Categorie non définie.';
}
else {

$_GET['categorie'] = $numcategorie['id_categorie'];
$_GET['topic'] = $numtopic['id'];


?>

<body class="forum">

<header>
	<ul>
<?php


	
	if(isset($_POST['deco']))
	{
	unset($_SESSION['login']);
	unset($_SESSION['password']);		
	}
		
	if(isset($_SESSION['login']))
	{
?>	
	<li><a href="../../index.php">Accueil</a></li>
	<div class="deco">
	<form method="post"  action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="submit" name="deco" value="Déconnexion">
	</form>
	</div>
<?php		
	}
	else
	{
?>
	<li><a href="../../index.php">Accueil</a></li>
	<div>
	<li><a href="../connexion.php">Connexion</a></li>
	<li><a href="../inscription.php">Inscription</a></li>
	</div>
<?php
	}
?>
	</ul>			
</header>


<?php


$sql = 'SELECT id, auteur, titre, date_derniere_reponse FROM forum_sujets WHERE correspondance_categorie="'.$_GET['categorie'].'" and topic="'.$_GET['topic'].'" ORDER BY date_derniere_reponse DESC';


$req = mysqli_query($base, $sql) or die(mysqli_error($base));
$nb_sujets = mysqli_num_rows ($req);

	
	
if ($nb_sujets == 0) {
	echo 'Aucune catégorie';
	if(isset($_SESSION['login']))
{
?>
<div class="newsujet">
	<a href="../insert_sujet.php/?categorie=<?php echo $_GET['categorie']; ?>/?topic=<?php echo $_GET['topic'];?>"><button class="ajoutsujet" >Insérer un sujet</button></a>
</div>
<?php
}
}
else {
	?>
<div id="espace">
</div>
<div class="nomcategorie">
	<a id="h1"href="../../index.php"><h1><?php echo $_SESSION['categorie'];?>&nbsp;></h1></a>&nbsp;
    <a id="h2" href=""><h2><?php echo $_SESSION['topic'];?></h2></a>
</div>

	
<article class="sujets">
	
	
	<table><tr>
	<th>
	Sujet(s)
	</th><th>
	Créé par
	</th><th>
	Dernière réponse
	</th>
	</tr>
	<?php
	// on va scanner tous les tuples un par un
	while ($data = mysqli_fetch_array($req)) {

	// on décompose la date
	sscanf($data['date_derniere_reponse'], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde);

	// on affiche les résultats
	echo '<tr>';
	echo '<td>';

	
	// on affiche le titre du sujet, et sur ce sujet, on insère le lien qui nous permettra de lire les différentes réponses de ce sujet
	
	$_SESSION['sujet']=$data['titre'];
	echo '<a class="lecturesujet"" href="../lire_sujet.php?id_sujet_a_lire=' , $data['id'] ,' ">' , htmlentities(trim($data['titre'])) , '</a>';
	
	echo '</td><td>';
	
	// on affiche le nom de l'auteur de sujet
	echo htmlentities(trim($data['auteur']));
	

	echo '</td><td>';

	// on affiche la date de la dernière réponse de ce sujet
	echo $jour , '-' , $mois , '-' , $annee , ' ' , $heure , ':' , $minute;
	
	}
	?>
	</td></tr></table>
</article>
<?php
if(isset($_SESSION['login']))
{
?>
<div class="newsujet">
	<a href="../insert_sujet.php/?categorie=<?php echo substr($_GET['categorie'], 0, 1); ?>/?topic=<?php echo SUBSTR($_GET['categorie'],9, 1);?>"><button class="ajoutsujet" >Insérer un sujet</button></a>
</div>
<?php
}
}

// on libère l'espace mémoire alloué pour cette requête
mysqli_free_result ($req);
// on ferme la connexion à la base de données.
mysqli_close ($base);
}
?>


</body>

</body>
</html>