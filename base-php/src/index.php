<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Mon blog</title>
</head>

<body>

<p>Derniers articles du blog :</p>

<h2>Nouvel article</h2>
<form action="insertarticle.php" method="POST" enctype="multipart/form-data">
    <p>Titre de l'article: <input type="text" name="title" /></p>
    <p>Commentaire: <br /><textarea name="commentaire" rows="10" cols="50"></textarea></p>
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <p>Choisissez une photo avec une taille inférieure à 2 Mo.</p>
    <input type="file" name="photo">
    <br /><br />
    <input type="submit" name="ok" value="Envoyer">
</form>
<br />

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

// Get the five last comments
$req = $bdd->query('SELECT id, title

, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM billets ORDER BY date_creation DESC LIMIT 0, 5');

while ($donnees = $req->fetch())
{
    ?>
    <div class="news">
        <h3>
            <?php echo htmlspecialchars($donnees['titre']); ?>
            <em>le <?php echo $donnees['date_creation_fr']; ?></em>
        </h3>

        <p>
            <?php
            // display the article
            echo nl2br(htmlspecialchars($donnees['contenu']));
            ?>
            <br />
            <em><a href="comments.php?article=<?php echo $donnees['id']; ?>">Commentaires</a></em>
        </p>
    </div>
    <?php
}
$req->closeCursor();
?>
</body>
</html>