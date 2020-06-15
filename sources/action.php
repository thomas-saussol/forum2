<?php

session_start();

$login=$_SESSION['login'];
$bdd = mysqli_connect("localhost", "root", "", "forum");
mysqli_set_charset($bdd, "utf8");
$req="SELECT id from utilisateurs WHERE login='$login'";
$result=mysqli_query($bdd, $req);
$resultat=mysqli_fetch_array($result);

$base = new PDO("mysql:host=127.0.0.1;dbname=forum;charset=utf8", "root", "");


			
if(isset($_GET['t'],$_GET['id']) AND !empty($_GET['t']) AND !empty($_GET['id']))
{
	$getid = (int) $_GET['id'];
	$gett = (int) $_GET['t'];
	
	$check =$base->prepare('SELECT id FROM forum_reponses WHERE id = ?');
	$check->execute(array($getid));
	
	

if($check->rowCount() == 1)
{
	
			if($gett == 1)
			{	
				$check_like= $base->prepare('SELECT id FROM likes WHERE id_forum_reponses = ? AND id_utilisateur = ?');
				$check_like->execute(array($getid, $resultat['id']));
				
				$del= $base->prepare('DELETE  FROM dislikes WHERE id_forum_reponses = ? AND id_utilisateur = ?');
				$del->execute(array($getid, $resultat['id']));
				
				if($check_like->rowCount() == 1)
				{	
					$del= $base->prepare('DELETE  FROM likes WHERE id_forum_reponses = ? AND id_utilisateur = ?');
					$del->execute(array($getid, $resultat['id']));
				}
				else
				{
					$ins = $base->prepare('INSERT INTO likes (id_forum_reponses, id_utilisateur) VALUES (?, ?)');
					$ins->execute(array($getid, $resultat['id']));	
				}				
			}
			else if($gett == 2)
			{
				$check_like= $base->prepare('SELECT id FROM dislikes WHERE id_forum_reponses = ? AND id_utilisateur = ?');
				$check_like->execute(array($getid, $resultat['id']));
				
				$del= $base->prepare('DELETE  FROM likes WHERE id_forum_reponses = ? AND id_utilisateur = ?');
				$del->execute(array($getid, $resultat['id']));
				
				if($check_like->rowCount() == 1)
				{	
					$del= $base->prepare('DELETE  FROM dislikes WHERE id_forum_reponses = ? AND id_utilisateur = ?');
					$del->execute(array($getid, $resultat['id']));
				}
				else
				{
					$ins = $base->prepare('INSERT INTO dislikes (id_forum_reponses, id_utilisateur) VALUES (?, ?)');
					$ins->execute(array($getid, $resultat['id']));	
				}		
			}
			$requete="SELECT correspondance_sujet from forum_reponses WHERE id='$getid'";
			$result=mysqli_query($bdd, $requete);
			$resultat=mysqli_fetch_array($result);
			
			$id=$resultat['correspondance_sujet'];
			
			header('Location: lire_sujet.php?id_sujet_a_lire='.$id);
}
else
{
exit('Erreur fatale');	
}
}
else
{
exit('Erreur fatale');	
}
?>