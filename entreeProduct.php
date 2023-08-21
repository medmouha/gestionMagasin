<?php 

session_start();
if (@$_SESSION["autoriser"] != "oui") {
    header("location:login.php");
    exit();
}

?>
<?php

	@$reference = strtoupper($_POST['reference']);
    @$libelle = $_POST['libelle'];
    @$quantite = $_POST['quantite'];
	@$date_enregistrement = date('d.m.Y');
    @$submit = $_POST['submit'];
    @$erreur="";

        if (isset($submit)) {
            if(empty($reference)) $erreur="<li>Référence obligatoire</li>";
            if(empty($libelle)) $erreur="<li>Nom produit à renseigner</li>";
            if(empty($quantite)) $erreur="<li>Quantité à définir</li>";
            if (empty($erreur)) {
                include("connexion.php");
                $req=$pdo->prepare("SELECT id FROM stock WHERE reference=? or libelle=? LIMIT 1");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute(array($reference,$libelle));
                $tab = $req->fetchAll();
                if (count($tab) > 0) {
                    
                    $erreur ="<li>référence ou libellé déjà utilisé";
                }elseif
                        ($quantite <= 0){
                        $erreur ="<li>La quantité ne peut etre négative</li>";
                }else {
                        $insert = $pdo->prepare("insert into stock(reference,libelle,quantite,date) values(?,?,?,?)");
                        $insert->execute(array($reference,$libelle,$quantite,$date_enregistrement));
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
	<title>Gestion Magasin</title>
</head>
<body>
	<div class="container">
        <h2>NOUVEAU PRODUIT</h2>
		<form action="" method="post">
			<div class="label">Référence</div>
            <input type="text" name="reference" id="reference" value="<?php echo $reference?>">            			
            <div class="label">Libellé</div>
			<input type="text" name="libelle" id="libelle" value="<?php echo $libelle?>">
			<div class="label">Quantité</div>
			<input type="number" name="quantite"><br>
			<button type="submit" name="submit">Enregistrer</button>
            <button><a href="index.php">Annuler</a></button>
			<?php if (!empty($erreur)) { ?>
                    <div id="erreur">
                        <?= $erreur ?>
                    </div>
            <?php } ?> 
		</form>
	</div>
</body>
</html>