<?php

    @$nom = $_POST['nom'];
    @$prenom = $_POST['prenom'];
    @$login = $_POST['login'];
    @$password = $_POST['password'];
    @$password_confirm = $_POST['password_confirm'];
    @$submit = $_POST['submit'];
    @$erreur="";

        if (isset($submit)) {
            if(empty($nom)) $erreur="<li>veuillez renseigner le nom</li>";
            if(empty($prenom)) $erreur="<li>veuillez renseigner le prenom</li>";
            if(empty($login)) $erreur="<li>veuillez renseigner le login</li>";
            if(empty($password)) $erreur="<li>veuillez renseigner le mot de passe</li>";
            if(empty($password_confirm)) $erreur="<li>veuillez confirmer le mot de passe</li>";

            if (empty($erreur)) {
                include("connexion.php");
                if($password != $password_confirm) $erreur="<li>Les mots de passe ne sont pas identiques</li>";
                $req=$pdo->prepare("SELECT id FROM utilisateurs WHERE login=? limit 1");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute(array($login));
                $tab = $req->fetchAll();
                if (count($tab) > 0) {
                    $erreur = "<li>Ce login existe déjà</li>";
                }else{
                    $insert = $pdo->prepare("INSERT into utilisateurs(nom,prenom,login,password) values(?,?,?,?)");
                    $insert->execute(array($nom,$prenom,$login,$password));
                    header("location:login.php");
                }

            }

        }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="listStyle.css">
    <title>Gestion Magasin</title>
</head>
<body>
    <header class="entete">
        <div class="content">
            <a href="login.php">CONNEXION</a>
        </div>
    </header>
    <div class="container">
        <h2>INSCRIPTION</h2>
        <form action="" method="post">
            <div class="label">Nom</div>
            <input type="text" name="nom" value="<?php echo $nom?>">
            <div class="label">Prénom</div>
            <input type="text" name="prenom" value="<?php echo $prenom?>">
            <div class="label">Login</div>
            <input type="text" name="login" value="<?php echo $login?>">
            <div class="label">Mot de passe</div>
            <input type="password" name="password">
            <div class="label">Confirmation mot de passe</div>
            <input type="password" name="password_confirm" id="password_confirm"><br>
            <button type="submit" name="submit">s'inscrire</button>

            <?php if (!empty($erreur)) { ?>
                    <div id="erreur">
                        <?= $erreur ?>
                    </div>
            <?php } ?> 
        </form>
    </div>
</body>
</html>