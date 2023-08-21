<?php

session_start();
@$login = $_POST['login'];
@$password = $_POST['password'];
@$submit = $_POST['submit'];
@$message="";

        if (isset($submit)) {

            if(empty($login)) $message="<li>veuillez renseigner le login</li>";
            if(empty($password)) $message="<li>veuillez renseigner le mot de passe</li>";

            if (empty($message)) {
                include("connexion.php");
                    $r=$pdo->prepare("SELECT * FROM utilisateurs WHERE login=? and password=? limit 1");
                    $r->setFetchMode(PDO::FETCH_ASSOC);
                    $r->execute(array($login,$password));
                    $tab = $r->fetchAll();
                    if (count($tab) == 0) {
                        $message = "<li>Login ou mot de passe incorrect</li>";
                    }else{
                        $_SESSION["autoriser"]="oui";
                        $_SESSION["nomPrenom"]=$tab[0]["nom"]." ".$tab[0]["prenom"];
                        header("location:index.php");
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
            <a href="inscription.php">INSCRIPTION</a>
        </div>
    </header>
<div class="container">
    <h2>CONNEXION</h2>
    <form action="" method="post">
        <div class="label">Login</div>
        <input type="text" name="login" value="<?php echo $login?>">
        <div class="label">Mot de passe</div>
        <input type="password" name="password">
        <button type="submit" name="submit">se connecter</button> 

        <?php if (!empty($message)) { ?>
                <div id="message">
                    <?= $message ?>
                </div>
        <?php } ?> 
    </form>
    </div>
</body>
</html>