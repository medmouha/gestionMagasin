<?php 

session_start();
if (@$_SESSION["autoriser"] != "oui") {
    header("location:login.php");
    exit();
}

?>
<?php
    include("connexion.php");

    $req=$pdo->prepare("SELECT reference,libelle,quantite_sortie,date_sortie FROM sorties, stock where id_entree = stock.id");
    $req->setFetchMode(PDO::FETCH_ASSOC);
    $req->execute();
    $tab = $req->fetchAll();
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="listStyle.css">
    <title>Gestion Magasin</title>
</head>
<body>
    <header class="entete">
        <div class="content">
            <a href="entreeProduct.php">ENTREE</a>
            <a href="sortiesProduct.php">SORTIE</a>
            <a href="index.php">STOCK</a>
            <a href="deconnexion.php">DECONNEXION</a>
        </div>
    </header>
    <div class="container">
        <h2>LISTE DES SORTIES</h2>
        <table class="tab">
            <thead>
                <tr>
                    <th>REFERENCE</th>
                    <th>LIBELLE</th>
                    <th>QUANTITE</th>
                    <th>DATE DE SORTIE</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tab as $t) { ?>
                    <tr>
                        <td><?php echo $t['reference'];?> </td>
                        <td><?php echo $t['libelle'];?> </td>
                        <td><?php echo $t['quantite_sortie'];?> </td>
                        <td><?php echo $t['date_sortie'];?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>