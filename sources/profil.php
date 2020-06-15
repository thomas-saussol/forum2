<?php
session_start();

if(isset($_POST['deco']))
{
unset($_SESSION['login']);
unset($_SESSION['password']);	
}


if(isset($_SESSION['login']))
{
?>
<html>

<head>
		<link href="forum.css" rel="stylesheet">
		<title>Profil</title>
</head>

<body class="profil">
<header>	
	<ul>
		<li><a href="../index.php">Accueil</a></li>
		<div class="deco">
			<form  method="post" action="profil.php">
				<input type="submit" name="deco" value="Déconnexion">
			</form>
		</div>
	</ul>
</header>

<?php
$login=$_SESSION['login'];
$password=$_SESSION['password'];
$connexion= mysqli_connect("localhost", "root", "", "forum"); 	
$query="SELECT *from utilisateurs WHERE login='$login'";
$result= mysqli_query($connexion, $query);
$row = mysqli_fetch_array($result);
	
if(!empty($_POST['modifier']))
{
	
	
$loginexistant=false;
$modif=false;
$connexion= mysqli_connect("localhost", "root", "", "forum"); 
$login=$_POST['login'];
$checkdups="SELECT  *from utilisateurs WHERE login='$login'";
$checkdups2=mysqli_query($connexion, $checkdups) or die(mysqli_error($connexion));
$checkdups3=mysqli_num_rows($checkdups2);
{	
if (($_POST['login'] !=  $row['login'])&&($checkdups3 == 0)&&(strlen($_POST['password']) > 5))
{
	$query="UPDATE `utilisateurs` SET `login` = '".$_POST['login']."' WHERE `utilisateurs`.`login`='".$row['login']."'";
	$result= mysqli_query($connexion, $query);
	$_SESSION['login']=$_POST['login'];
	$modif=true;
	mysqli_close($connexion);	
}
else if (($checkdups3 > 0)&&($_POST['login'] !=  $row['login']))
{ 	
	$loginexistant=true;
	$modif=false;
	?>
	<div class="erreur">
	<img src="../img/erreur.jpg" width="2%">
	<div class="affichage">
	<?php
	echo "*Login déjà existant";	
	?>
	</div>
	</div>
	<?php
}
else if (strlen($_POST['password']) < 5)
{
	$modif=false;
	?>
	<div class="erreur">
	<img src="../img/erreur.jpg" width="2%">
	<div class="affichage">
	<?php
	echo "*Mot de passe trop court";	
	?>
	</div>
	</div>
	<?php	
	
}


if (($_POST['password'] !=  $password)&&($loginexistant==false)&&(strlen($_POST['password']) > 5))
{
	$hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);	
	$connexion= mysqli_connect("localhost", "root", "", "forum"); 	
	$query="UPDATE `utilisateurs` SET `password` = '".$hash."' WHERE `utilisateurs`.`password`='".$row['password']."'";
	$result= mysqli_query($connexion, $query);
    $_SESSION['password']=$_POST['password'];
	$modif=true;
	mysqli_close($connexion);
}

if(($loginexistant==false)&&($modif==true))
{
	$_SESSION['profil']="Profil modifié avec succès !";
	header ('location: connexion.php');
}
else if ($modif==false)
{
	?>
	<div class="erreur">
	<img src="../img/erreur.jpg" width="2%">
	<div class="affichage">
	<?php
	echo "*Aucune modification a été faite";	
	?>
	</div>
	</div>
	<?php
}
}
}
?>

<section>
	<div class="form-style-5">
	<form class="form" method="post" action="profil.php">
		<legend><span class="rond"></span>Profil</legend>	
		<input placeholder="Login" required name="login" type="text" id="meeting-time" value="<?php echo $row['login'] ?>">	
		<input placeholder="Password  (5 caractères minimum)" required name="password" type="password" id="meeting-time" value="<?php echo $password ?>">				
		<input name="modifier" type="submit" value="Modifier" />
	</form>
</div>
</section>

</body>
</html>
<?php
}
else
{
header ('location: connexion.php');	
}	
?>