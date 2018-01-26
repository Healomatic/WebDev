
<?php
// Fonction pour générer le tableau de données
function gen_data()
{
	setcookie('pass','password',time() + 24*3600, null, null, false, true);
	echo'
		<!DOCTYPE html>
		<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>home</title>
		</head>
		<body>';

	echo'<a href="form.php">Formulaire</a></br></br>
		<form action="search.php" methode="post" enctype="multipart/form-data">
			<div class="recherche">Recherche</br></br>
				Prenom:<input type="text" name="rechpre" id="rechpre" default="Prenom"/>
				Nom:<input type="text" name="rechnom" id="rechnom" />
				Service:<select name="Service" id="Service">
							<option value=""></option>
							<option value="RH">RH</option>
							<option value="Methodes">Methodes</option>
							<option value="Bureau d\'études">Bureau d\'études</option>
							<option value="Informatique">Informatique</option>
						</select>
					<input type="checkbox" name="AD" id="AD" /> <label for="AD">AD</label>
                    <input type="checkbox" name="M3" id="M3" /> <label for="M3">M3</label>
                    <input type="checkbox" name="Lotus" id="Lotus" /> <label for="Lotus">Lotus</label>
                    <input type="checkbox" name="VPN" id="VPN" /> <label for="VPN">VPN</label>
					</br></br><input type="submit" value="Rechercher" />
			</div></form></br>';
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=rh;charset=utf8', 'root', '');
		}
		catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());
		}
		//Affichage des données contenues dans la BDD:
		$reponse = $bdd->query('SELECT * FROM data ORDER BY Nom');

		echo'<table>
			<tbody>
				<tr>
					<th>Prenom</th>
					<th>Nom</th>
					<th>Service</th>
					<th>AD</th>
					<th>M3</th>
					<th>Lotus</th>
					<th>VPN</th>
					<th>Commentaire</th>
					<th>Modifier</th>
				</tr>';
		while ($donnees = $reponse->fetch()){
			echo'<tr><td align="center">';echo $donnees['Prenom'];echo'</td>';
			echo'<td align="center">';echo $donnees['Nom'];echo'</td>';
			echo'<td align="center">';echo $donnees['Service'];echo'</td>';
			echo'<td align="center">';echo $donnees['AD'];echo'</td>';
			echo'<td align="center">';echo $donnees['M3'];echo'</td>';
			echo'<td align="center">';echo $donnees['Lotus'];echo'</td>';
			echo'<td align="center">';echo $donnees['VPN'];echo'</td>';
			echo'<td align="center">';echo $donnees['Commentaire'];echo'</td>';
			echo'<td align="center"><a href="modif.php">Modifier</a></td></tr>';
		}
			echo'</tbody>
				</table>';
	$reponse->closeCursor(); // Termine le traitement de la requête
	echo'</body>
	</html>';}

	if (!isset($_COOKIE['pass']) or $_COOKIE['pass'] != "rgnko")
	{
		echo'<!DOCTYPE html>
		<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style.css" />
		<title>Connexion</title>
		</head>
		<body>
		<p>Veuillez entrer le mot de passe:</p>';
		echo"<form action='data.php' method='post'>
        <p>
        <input type='password' name='mot_de_passe' />
        <input type='submit' value='Valider' />
        </p>
		</form>
		<p>L'accés à cette page est réservé au personnel autorisé </p>
		</body>
		</html>";
	}else{
		gen_data();
	}

//end
?>

