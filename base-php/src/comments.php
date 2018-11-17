<?php


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mon blog</title>
	<link href="style.css" rel="stylesheet" />
    </head>

    <body>
        <h1>Mon super blog !</h1>
        <p><a href="index.php">Retour à la liste des billets</a></p>

<?php
// Connexion to the database
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}

// Recup article
$req = $bdd->prepare('SELECT id, title, content FROM article WHERE id = ?');
$req->execute(array($_GET['billet']));
$donnees = $req->fetch();
?>

<div class="news">
    <h3>
        <?php echo htmlspecialchars($donnees['titre']); ?>
        <em>le <?php echo $donnees['date_creation_fr']; ?></em>
    </h3>

    <p>
    <?php
    echo nl2br(htmlspecialchars($donnees['contents']));
    ?>
    </p>
</div>

<h2>Commentaires</h2>

<?php
$req->closeCursor(); // free the cursor for the next query

// get comments
$req = $bdd->prepare('SELECT author, content, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') FROM comments WHERE id_article = ?');
$req->execute(array($_GET['article']));

while ($donnees = $req->fetch())
{
?>
<p><strong><?php echo htmlspecialchars($donnees['author']); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>
<p><?php echo nl2br(htmlspecialchars($donnees['comments'])); ?></p>
<?php
} // Loop end
$req->closeCursor();
?>
</body>
</html>