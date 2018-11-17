
<?php

echo "<form method=\"post\">
    <label>Pseudo: <input type=\"text\" name=\"username\"/></label><br/>
    <label>Mot de passe: <input type=\"password\" name=\"password\"/></label><br/>
    <label>Confirmation du mot de passe: <input type=\"password\" name=\"passe2\"/></label><br/>
    <input type=\"submit\" value=\"S'inscrire\"/>
</form>";
/* Indique le bon format des entêtes (par défaut apache risque de les envoyer au standard ISO-8859-1) */

header('Content-type: text/html; charset=UTF-8');

/* Création d'une fonction - utilisée dans la récupération des variables - qui teste la configuration get_magic_quotes_gpc du serveur.
Si oui, supprime avec la fonction stripslashes les antislashes "\" insérés dans les chaines de caractère des variables gpc (GET, POST, COOKIE) */
function Verif_magicquotes ($chain)
{
    if (get_magic_quotes_gpc()) $chain = stripslashes($chain);

    return $chain;
}

/* Initialisation du message de réponse */
$message = null;


/* Si le formulaire est envoyé */
if (isset($_POST['username']))
{

    /* Récupération des variables issues du formulaire
    Teste l'existence les données post en vérifiant qu'elles existent, qu'elles sont non vides et non composées uniquement d'espaces.
    (Ce dernier point est facultatif et l'on pourrait se passer d'utiliser la fonction trim())
    En cas de succès, on applique notre fonction Verif_magicquotes pour (éventuellement) nettoyer la variable */
    $pseudo = (isset($_POST['username']) && trim($_POST['username']) != '')? Verif_magicquotes($_POST['username']) : null;
    $pass = (isset($_POST['pass']) && trim($_POST['pass']) != '')? Verif_magicquotes($_POST['pass']) : null;


    /* Si $pseudo et $pass différents de null */
    if(isset($pseudo,$pass))
    {
        /* Connexion au serveur : dans cet exemple, en local sur le serveur d'évaluation
        A MODIFIER avec vos valeurs */
        $hostname = "localhost";
        $database = "blog_bdd";
        $username = "root";
        $password = "";


// Vérification de la validité des informations

// Hachage du mot de passe
$pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);

// Insertion
$req = $bdd->prepare('INSERT INTO membres(pseudo, pass, email, date_inscription) VALUES(:pseudo, :pass, :email, CURDATE())');
$req->execute(array(
    'pseudo' => $pseudo,
    'pass' => $pass_hache));



            /* Si l'insertion s'est faite correctement (une requête d'insertion retourne "true" en cas de succès, je peux donc utiliser
            l'opérateur de comparaison strict '==='  c.f. http://fr.php.net/manual/fr/language.operators.comparison.php) */
            if ($inser_exec === true)
            {
                /* Démarre la session et enregistre le pseudo dans la variable de session $_SESSION['login']
                qui donne au visiteur la possibilité de se connecter.  */
                session_start();
                $_SESSION['login'] = $pseudo;

                /* A MODIFIER Remplacer le '#' par l'adresse de votre page de destination, sinon ce lien indique la page actuelle. */
                $message = 'Votre inscription est enregistrée. <a href = "#">Cliquez ici pour vous connecter</a>';
            }
        }
        else
        {   /* Le pseudo est déjà utilisé */
            $message = 'Ce pseudo est déjà utilisé, changez-le.';
        }
    }
    else
    {    /* Au moins un des deux champs "pseudo" ou "mot de passe" n'a pas été rempli */
        $message = 'Les champs "Pseudo" et "Mot de passe" doivent être remplis.';
    }
?>
