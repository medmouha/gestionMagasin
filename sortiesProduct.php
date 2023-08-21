<?php 

session_start();
if (@$_SESSION["autoriser"] != "oui") {
    header("location:login.php");
    exit();
}

?>
<?php

@$id_entree = $_POST['id_entree'];
@$quantite = (int)$_POST['quantite'];
@$date_sortie = date('d.m.Y');
@$submit = $_POST['submit'];
@$erreur="";

        if (isset($submit)) {

            if(empty($quantite)) $erreur="<li>Quantité à définir</li>";
            if (empty($erreur)) {
                include("connexion.php");
                $r = $pdo->prepare("SELECT * FROM stock WHERE stock.id =?");
                $r->setFetchMode(PDO::FETCH_ASSOC);
                $r->execute(array($id_entree));
                $row = $r->fetch();

                if($quantite < 0){
                    $erreur = "<li>La quantité ne peut etre négative</li>";
                
                }elseif 
                    ($row['quantite'] < $quantite) {                    
                    $erreur = "<li>La quantité en stock est insuffisante</li>";
                
                }else {
                    $newStock = $row['quantite'] - $quantite;

                    $r = $pdo->prepare("UPDATE stock SET quantite =? WHERE id =?");
                    $r->execute(array($newStock, $id_entree));

                    $insert = $pdo->prepare("INSERT INTO sorties(id_entree,quantite_sortie,date_sortie) VALUES(?,?,?)");
                    $insert->execute(array($id_entree,$quantite,$date_sortie));
                    header("location:archiveProduct.php"); 
                }
            }
        }
   
?>

<?php
    include("connexion.php");
    $re=$pdo->prepare("SELECT * FROM stock");
    $re->setFetchMode(PDO::FETCH_ASSOC);
    $re->execute();
    $table = $re->fetchAll();
   
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
        <h2>ENREGISTREMENT DE SORTIE</h2>
		<form action="" method="post">
			<div class="label">Référence</div>           
			<select name="id_entree">
                <option value="">choisir</option>
                <?php foreach($table as $line) { ?>
                    <option libelle="<?php echo $line['libelle'];?>" value="<?php echo $line['id'];?>">
                        <?php echo $line['reference'];?> => <?php echo $line['libelle'];?>
                    </option>
                <?php }?>
            </select>
			<div class="label">Libellé</div>
			<input type="text" name="libelle" id="libelle" disabled>
			<div class="label">Quantité</div>
			<input type="number" name="quantite"> <br>
			<button type="submit" name="submit">Enregistrer</button>
            <button><a href="index.php">Annuler</a></button>
			<?php if (!empty($erreur)) { ?>
                    <div id="erreur">
                        <?= $erreur ?>
                    </div>
            <?php } ?> 
		</form>
	</div>


<script>
    const select = document.querySelector('select[name="id_entree"]');
    let libelle;

    select.addEventListener("change", ()=>{
        const currentValue = select.selectedOptions[0];
        libelle = currentValue.getAttribute("libelle");
        
        document.querySelector("#libelle").value = libelle;
    })

</script>
</body>
</html>