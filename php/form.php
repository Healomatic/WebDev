
<?php
// Fonction pour générer le formulaire de données
function gen_form()
{
	setcookie('pass','password',time() + 24*3600, null, null, false, true);
    echo'
        <!DOCTYPE html>
        <html lang="en" xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8" />
            <link rel="stylesheet" href="style.css" />
            <title>Formulaire Comptes</title>
        </head>
        <body>
        <a href="data.php">Base de données</a>
        <form action="form.php" method="post" enctype="multipart/form-data">
        <div class="core">
                <p>* = Mentions obligatoires</p>
                <p>Prenom*: <input type="text" name="Prenom" id="Prenom" /></p>
                <p>Nom*: <input type="text" name="Nom" id="Nom" /></p>
                <p>
                    Service:
                    <select name="Service" id="Service">
                        <option value="RH">RH</option>
                        <option value="Methodes">Methodes</option>
                        <option value="Bureau d\'études">Bureau d\'études</option>
                        <option value="Informatique">Informatique</option>
                    </select>
                </p>

                <p>
                    Comptes:</br>
                    <input type="checkbox" name="AD" id="AD" /> <label for="AD">Active Directory</label><br />
                    <input type="checkbox" name="M3" id="M3" /> <label for="M3">M3</label><br />
                    <input type="checkbox" name="Lotus" id="Lotus" /> <label for="Lotus">Lotus</label><br />
                    <input type="checkbox" name="VPN" id="VPN" /> <label for="VPN">VPN</label>
                </p>

                <p>Commentaire:</p>
                <textarea name="Commentaire" rows="8" cols="45"></textarea></br>
                <input type="submit" value="Valider" />
            </div>
        </form>';
    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }
    try
    {
    $bdd = new PDO('mysql:host=localhost;dbname=rh;charset=utf8', 'root', '');
    }
    catch (Exception $e)
    {
    die('Erreur : ' . $e->getMessage());
    }
    
    //Contrôle des valeurs $_POST
    //AD
    if (isset($_POST['AD']) and $_POST['AD'] = "on")
        {
            $_POST['AD'] = "X";
         }else{
            $_POST['AD']="";
         }
    //M3
    if (isset($_POST['M3']) and $_POST['M3'] = "on")
        {
            $_POST['M3'] = "X";
         }else{
            $_POST['M3']="";
         }
    //LOTUS
    if (isset($_POST['Lotus']) and $_POST['Lotus'] = "on")
        {
            $_POST['Lotus'] = "X";
         }else{
            $_POST['Lotus']="";
         }
    //VPN
    if (isset($_POST['VPN']) and $_POST['VPN'] = "on")
        {
            $_POST['VPN'] = "X";
         }else{
            $_POST['VPN']="";
         }
    //Commentaire
    if (!isset($_POST['Commentaire'])){$_POST['Commentaire']="";}
    //Prenom et Nom
    if (isset($_POST['Prenom'],$_POST['Nom']) and $_POST['Prenom']!="" and $_POST['Nom']!="" ){
            $req = $bdd->prepare('INSERT INTO data (Prenom, Nom, Service, AD, M3, Lotus, VPN, Commentaire) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
            $req->execute(array($_POST['Prenom'], $_POST['Nom'], $_POST['Service'], $_POST['AD'], $_POST['M3'], $_POST['Lotus'], $_POST['VPN'], $_POST['Commentaire']));
            }
    echo'</body></html>';
}  

//vérification du mot de passe via $_POST:    

    //vérification si le cookie avec le pass est présent:
        //! Problème au niveau du set up des variables
    if (!isset($_COOKIE['pass']) or $_COOKIE['pass'] != "password")
    {	
        if (!isset($_POST['pass']) or $_POST['pass'] != "password")
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
                echo"<form action='form.php' method='post'>
                <p>
                <input type='password' name='mot_de_passe' />
                <input type='submit' value='Valider' />
                </p>
                </form>
                <p>L'accés à cette page est réservé au personnel autorisé </p>";
                echo $_COOKIE['pass'];
                echo $_POST['pass'];
                echo "
                </body>
                </html>";
    }else{
            session_start();
            setcookie('pass',$_POST['pass'],time() + 24*3600, null, null, false, true);
            gen_form();
        }
    }   
        
echo $_COOKIE['pass'];
echo $_POST['pass'];
  //! fin de pb      

//end
?>
