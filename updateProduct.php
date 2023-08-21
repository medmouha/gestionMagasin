<?php 

session_start();
if (@$_SESSION["autoriser"] != "oui") {
    header("location:login.php");
    exit();
}

?>
<?php

    @$id = $_GET['id'];
	@$reference = strtoupper($_POST['reference']);
    @$libelle = $_POST['libelle'];
    @$quantite = $_POST['quantite'];
    @$submit = $_POST['submit'];
    @$erreur="";

        if (isset($submit)) {
            if(empty($reference)) $erreur="<li>Reference obligatoire</li>";
            if(empty($libelle)) $erreur="<li>Nom produit à renseigner</li>";
            if(empty($quantite)) $erreur="<li>Quantité à définir</li>";
            if (empty($erreur)) {
                include("connexion.php");
                $req=$pdo->prepare("SELECT * FROM stock WHERE id!=? and (reference=? or libelle=?)");
                $req->setFetchMode(PDO::FETCH_ASSOC);
                $req->execute(array($id,$reference,$libelle));
                $tab = $req->fetchAll();
                if (count($tab) > 0) {
                    
                    $erreur ="<li>référence ou libellé déjà utilisé pour un produit";
                }elseif
                    ($quantite < 0){
                    $erreur ="<li>La quantité ne peut etre négative</li>";
                }else {
                    $insert = $pdo->prepare("UPDATE stock SET reference=?,libelle=?,quantite=? where id=?");
                    $insert->execute(array($reference,$libelle,$quantite,$id));
                        header("location:index.php");
                }

            }

        }
   
?>

<?php
@$id = $_GET['id'];

        if (isset($id)) {
                include("connexion.php");
                $r=$pdo->prepare("SELECT * FROM stock WHERE id= ?");
                $r->setFetchMode(PDO::FETCH_ASSOC);
                $r->execute(array($id));
                $row = $r->fetchAll();
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
        <h2>MODIFIER LE PRODUIT</h2> 
        <?php foreach($row as $ro) {?>
		<form action="" method="post">
			<div class="label">Référence</div>
            <input type="text" name="reference" id="reference" value="<?php echo $ro['reference']?>">            			
            <div class="label">Libellé</div>
			<input type="text" name="libelle" id="libelle" value="<?php echo $ro['libelle']?>">
			<div class="label">Quantité</div>
			<input type="number" name="quantite" value="<?php echo $ro['quantite']?>"><br>
			<button type="submit" name="submit">Modifier</button>
            <button><a href="index.php">Annuler</a></button>
			<?php if (!empty($erreur)) { ?>
                    <div id="erreur">
                        <?= $erreur ?>
                    </div>
            <?php } ?> 
		</form>
        <?php } ?>
	</div>
</body>
</html>