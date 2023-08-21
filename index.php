<?php 

session_start();
if (@$_SESSION["autoriser"] != "oui") {
    header("location:login.php");
    exit();
}

?>
<?php
    include("connexion.php");
    $req=$pdo->prepare("SELECT * FROM stock");
    $req->setFetchMode(PDO::FETCH_ASSOC);
    $req->execute();
    $tab = $req->fetchAll();
   
?>

<?php

@$id = $_GET['id'];

        if (isset($id)) {

                include("connexion.php");
                $r=$pdo->prepare("DELETE FROM stock WHERE id= ?");
                $r->execute(array($id));
                header("location:index.php");

            }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="listStyle.css">
    <title>Gestion Magasin</title>
</head>
<body>
    <header class="entete">
        <div class="content">
            <a href="entreeProduct.php">ENTREE</a>
            <a href="sortiesProduct.php">SORTIE</a>
            <a href="archiveProduct.php">ARCHIVE</a>
            <a href="deconnexion.php">DECONNEXION</a>
        </div>
    </header>
    <div class="container">
        <h2>Liste des Produits disponibles en stock</h2>
        <table class="tab">
            <thead>
                <tr>
                    <th>REFERENCE</th>
                    <th>LIBELLE</th>
                    <th>QUANTITE</th>
                    <th>DATE D'ENREGISTREMENT</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tab as $t) { ?>
                    <tr>
                        <td><?php echo $t['reference'];?> </td>
                        <td><?php echo $t['libelle'];?> </td>
                        <td><?php echo $t['quantite'];?> </td>
                        <td><?php echo $t['date'];?> </td>
                        <td><a href="updateProduct.php?id=<?=$t['id']?>"><i class="fa-solid fa-pen-to-square fa-2xl"></i></a>
                            <a href="index.php?id=<?=$t['id']?>"><i class="fa-solid fa-trash-can fa-2xl" style="color: #ec2222;"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>