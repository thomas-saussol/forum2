<html>

<head>
	<title>Administration</title>
	<link href="forum.css" rel="stylesheet">
	<meta charset="UTF-8">


</head>

<body class="administration">

<header>
	<ul> 
<?php

	session_start();

	if(isset($_POST['deco']))
	{
	unset($_SESSION['login']);
	unset($_SESSION['password']);
	}

if(isset($_SESSION['login']))
{
$login=$_SESSION['login'];
$base = mysqli_connect("localhost", "root", "", "forum");
$requete="SELECT grade from utilisateurs WHERE login='$login'";
$result=mysqli_query($base, $requete);
$resultat=mysqli_fetch_array($result);
if(($resultat['grade']==1)||($resultat['grade']==2))
{
?>
	<div>
	<li><a href="../index.php">Accueil</a></li>
	</div>
	<div class="deco">
	<form  method="post" action="administration.php">
		<input type="submit" name="deco" value="Déconnexion">
	</form>
	</div>
	</ul>
</header>

<?php
if(isset($_POST['Valider1']))
		{
			$base = mysqli_connect("localhost", "root", "", "forum");
			mysqli_set_charset($base, "utf8");
			$titre1=$_POST['titrecategorie'];
			$requete="SELECT id FROM categorie WHERE titre='$titre1'";
			$result=mysqli_query($base, $requete);
			$titre2=mysqli_fetch_array($result);

			$requete1='INSERT INTO `sous_categorie` (`id`, `titre`, `id_categorie`) VALUES (NULL, "'.$_POST['field1'].'", "'.$titre2['id'].'" );';
			mysqli_query($base, $requete1);

			?>
			<div class="erreur">
			<img src="../img/erreur.jpg" width="2%">
			<div class="affichage">
			<?php
			echo "Sous-catégorie";
			echo " ";
			echo $_POST['field1'];
			echo " ";
			echo "ajoutée avec succès !";
			?>
			</div>
			</div>
			<?php
		}
//Ajout Catégorie

	if(isset($_POST['Valider2']))
	{
	$base = mysqli_connect("localhost", "root", "", "forum");
	mysqli_set_charset($base, "utf8");

	$titre=$_POST['field1'];
	$requete1="SELECT titre from categorie WHERE titre='$titre'";
	$result=mysqli_query($base, $requete1);
	$correspondance=mysqli_num_rows($result);
	$ajout=true;

	if($correspondance > 0)
	{
	?>
	<div class="erreur">
	<img src="../img/erreur.jpg" width="2%">
	<div class="affichage">
	<?php
	echo "Catégorie déjà existante !";
	?>
	</div>
	</div>
	<?php
	}
	else
	{
	$requete='INSERT INTO `categorie` (`id`, `titre`) VALUES (NULL, "'.$_POST['field1'].'");';
	mysqli_query($base, $requete);
	?>
	<div class="erreur">
	<img src="../img/erreur.jpg" width="2%">
	<div class="affichage">
	<?php
	echo "Catégorie";
	echo " ";
	echo $_POST['field1'];
	echo " ";
	echo "ajoutée avec succès";
	?>
	</div>
	</div>
	<?php

	}
	}
else if(isset($_POST['Valider3']))
		{
			$base = mysqli_connect("localhost", "root", "", "forum");
			mysqli_set_charset($base, "utf8");
			$sous_categorie=$_POST['titresouscategorie'];
			$requete="DELETE FROM `sous_categorie` WHERE titre='$sous_categorie'";
			mysqli_query($base, $requete);

			?>
			<div class="erreur">
			<img src="../img/erreur.jpg" width="2%">
			<div class="affichage">
			<?php
			echo "Sous-catégorie";
			echo " ";
			echo $_POST['titresouscategorie'];
			echo " ";
			echo "supprimée avec succès !";
			?>
			</div>
			</div>
			<?php

		}
else if(isset($_POST['Valider4']))
		{
			$base = mysqli_connect("localhost", "root", "", "forum");
			mysqli_set_charset($base, "utf8");
			$categorie=$_POST['titrecategorie'];
			$requete1="SELECT id FROM categorie WHERE titre='$categorie'";
			$resultat=mysqli_query($base, $requete1);
			$result=mysqli_fetch_array($resultat);

			$id=$result['id'];

			$requete3="DELETE FROM `sous_categorie` WHERE id_categorie='$id'";
			mysqli_query($base, $requete3);

			$requete2="DELETE FROM `categorie` WHERE titre='$categorie'";
			mysqli_query($base, $requete2);
			?>
			<div class="erreur">
			<img src="../img/erreur.jpg" width="2%">
			<div class="affichage">
			<?php
			echo "Catégorie";
			echo " ";
			echo $_POST['titrecategorie'];
			echo " ";
			echo "supprimée avec succès !";
			?>
			</div>
			</div>
			<?php

		}
else if(isset($_POST['Valider5']))
		{
			?>
			<div class="erreur">
			<img src="../img/erreur.jpg" width="2%">
			<div class="affichage">
			<?php

			$base = mysqli_connect("localhost", "root", "", "forum");
			mysqli_set_charset($base, "utf8");



			$grade=$_POST['grade'];
			$login=$_POST['users'];
			$requete1="UPDATE utilisateurs SET grade='$grade' WHERE login='$login'";
			mysqli_query($base, $requete1);

			echo $_POST['users'];
			echo " ";
			echo ":";
			echo " ";
			echo "Grade Modifié avec succès !";
			?>
			</div>
			</div>
			<?php

		}

?>

<section class="formcenter">
<article class="formulaireajout">
	<div class="optioncategorie">
		<div class="form-style-7">
			<form method="post" action="administration.php">
				<input type="submit" name="categorie" value="Ajouter Catégorie">
			</form>
		</div>
		<div class="form-style-7">
			<form method="post" action="administration.php">
				<input type="submit" name="suppr_categorie" value="Supprimer Catégorie">
			</form>
		</div>
	</div>

	<div class="optioncategorie">
		<div class="form-style-7">
			<form method="post" action="administration.php">
				<input type="submit" name="sous-categorie" value="Ajouter Sous-catégorie">
			</form>
		</div>
		<div class="form-style-7">
			<form method="post" action="administration.php">
				<input type="submit" name="suppr_sous-categorie" value="Supprimer Sous-catégorie">
			</form>
		</div>
	</div>

	<?php
	$base = mysqli_connect("localhost", "root", "", "forum");
	$login=$_SESSION['login'];
	$querygrade="SELECT grade from utilisateurs where login='$login'";
	$resultgrade=mysqli_query($base, $querygrade);
	$grade=mysqli_fetch_array($resultgrade);

	if($grade['grade']==1)
	{
	?>
	<div id="grade">
		<div class="form-style-7">
			<form method="post" action="administration.php">
				<input type="submit" name="grade" value="Changement de Grade">
			</form>
		</div>
	</div>
	<?php
	}
	?>
</article>
</section>

<?php

if(isset($_POST['sous-categorie']))
{
$base = mysqli_connect("localhost", "root", "", "forum");
mysqli_set_charset($base, "utf8");
$requete="SELECT titre from categorie";
$resultat=mysqli_query($base, $requete);

?>

<section class="formsouscategorie">
	<div class="form-style-5">
		<form method="post" action="administration.php">
		<fieldset>
		<legend>Sous-Catégorie</legend>
		<div class="input">
		<input type="text" name="field1" required placeholder="Nom*">
		</div>
		<div class="input">
			<select required  name="titrecategorie">
			<option value="">Chosir la Catégorie</option>
			<?php while($titre=mysqli_fetch_array($resultat))
			{
			?>
			<option><?php echo $titre['titre'];?></option>
			<?php
			}
			?>
			</select>
		</div>
		<div class="input">
		<input type="submit" name="Valider1" value="AJOUTER"/>
		</div>
		</fieldset>
		</form>
	</div>
</section>

<?php
}
else if(isset($_POST['categorie']))
{
?>
<section class="formsouscategorie">
	<div class="form-style-5">
		<form method="post" action="administration.php">
		<fieldset>
		<legend>Catégorie</legend>
		<div class="input">
		<input type="text" name="field1" required placeholder="Nom*">
		</div>
		<div class="input">
		<input type="submit" name="Valider2" value="AJOUTER"/>
		</div>
		</fieldset>
		</form>
	</div>
</section>
<?php

}
else if(isset($_POST['suppr_sous-categorie']))
{

$base = mysqli_connect("localhost", "root", "", "forum");
mysqli_set_charset($base, "utf8");
$requete="SELECT titre from sous_categorie";
$resultat=mysqli_query($base, $requete);

?>
<section class="formsouscategorie">
	<div class="form-style-5">
		<form method="post" action="administration.php">
		<fieldset>
		<legend>Supprimer une sous-catégorie</legend>
		<div class="input">
			<select required  name="titresouscategorie">
			<option value="">Chosir la sous-catégorie</option>
			<?php while($titre=mysqli_fetch_array($resultat))
			{
			?>
			<option><?php echo $titre['titre'];?></option>
			<?php
			}
			?>
			</select>
		</div>
		<div class="input">
		<input type="submit" name="Valider3" value="Supprimer"/>
		</div>
		</fieldset>
		</form>
	</div>
</section>
<?php
}
else if(isset($_POST['suppr_categorie']))
{

$base = mysqli_connect("localhost", "root", "", "forum");
mysqli_set_charset($base, "utf8");
$requete="SELECT titre from categorie";
$resultat=mysqli_query($base, $requete);

?>
<section class="formsouscategorie">
	<div class="form-style-5">
		<form method="post" action="administration.php">
		<fieldset>
		<legend>Supprimer une Catégorie</legend>
		<div class="input">
			<select required  name="titrecategorie">
			<option value="">Chosir la catégorie</option>
			<?php while($titre=mysqli_fetch_array($resultat))
			{
			?>
			<option><?php echo $titre['titre'];?></option>
			<?php
			}
			?>
			</select>
		</div>
		<div class="input">
		<input type="submit" name="Valider4" value="Supprimer"/>
		</div>
		</fieldset>
		</form>
	</div>
</section>
<?php
}
else if(isset($_POST['grade']))
{

$base = mysqli_connect("localhost", "root", "", "forum");
mysqli_set_charset($base, "utf8");
$requete='SELECT login from utilisateurs WHERE grade !="1"';
$resultat=mysqli_query($base, $requete);


?>
<section class="formsouscategorie">
	<div class="form-style-5">
		<form method="post" action="administration.php">
		<fieldset>
		<legend>Changement de grade</legend>
		<div class="input">
			<select required  name="users">
			<option value="">Utilisateurs</option>
			<?php while($login=mysqli_fetch_array($resultat))
			{
			?>
			<option><?php echo $login['login'];?></option>
			<?php
			}
			?>
			</select>
		</div>
		<div class="input">
			<select required  name="grade">
			<option value="">Grade</option>
			<option  value="2" >Modérateur</option>
			<option  value="3">Utilisateur</option>
			</select>
		</div>
		<div class="input">
		<input type="submit" name="Valider5" value="Changer"/>
		</div>
		</fieldset>
		</form>
	</div>
</section>
<?php
}
}
else
{
header('location: ../index.php');
}
}
else
{
header('location: ../index.php');
}
?>
