pdo_mysql.default_socket = /opt/lampp/var/mysql/mysql

<?php

$db = null;

try {
    $config = include($_SERVER['DOCUMENT_ROOT'].'/php_simple/config.php');

    $db = new PDO("mysql:host=" . $config['database_host'] . ";dbname=" . $config['database_database'] . ";port=" . $config['database_port'], $config['database_user'], $config['database_password']);
    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    $db = null;
}
    <?php
    return array(
    'database_host' => 'localhost',
    'database_user' => 'root',
    'database_password' => 'root',
    'database_database' => 'blog',
    'database_port' => '3306',
);
<?php

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

<?php
    require($_SERVER['DOCUMENT_ROOT'].'/php_simple/app/db.php');

    $errors = [];

    require_once($_SERVER['DOCUMENT_ROOT'] . '/php_simple/app/form_utils.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);

        if (is_null($email) || $email == '') {
            $errors['email'] = 'email requis.';
        }

        if (is_null($password) || $password == '') {
            $errors['password'] = 'password requis';
        }

        if (empty($errors) && isset($db)) {
            try {
                $sql = "select id, email, name, password, image_extension, role_id, created_at, updated_at from users ";;

                $stmt = $db->prepare("$sql where email = :email LIMIT 1");
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch();

                if (!$user) {
                    $user = null;
                } else {

                    if(password_verify($password, $user['password'])) {
                        $_SESSION['user'] = $user;
                        header('Location: http://localhost/php_simple/index.php');
                    } else {
                        $user = null;
                    }
                }

                $db = null;
            } catch (Exception $exception) {
                echo $exception;
            }
        }
    }
?>

<?php
    session_start();
    include('bd/connexionDB.php');
 
    if (isset($_SESSION['id'])){
        header('Location: index.php');
        exit;
    }
 
    if(!empty($_POST)){
        extract($_POST);
        $valid = true;
 
        if (isset($_POST['oublie'])){
            $mail = htmlentities(strtolower(trim($mail))); // On récupère le mail afin d envoyer le mail pour la récupèration du mot de passe 
 
            // Si le mail est vide alors on ne traite pas
            if(empty($mail)){
                $valid = false;
                $er_mail = "Il faut mettre un mail";
            }
 
            if($valid){
                $verification_mail = $DB->query("SELECT nom, prenom, mail, n_mdp 
                    FROM utilisateur WHERE mail = ?",
                    array($mail));
                $verification_mail = $verification_mail->fetch();
 
                if(isset($verification_mail['mail'])){
                    if($verification_mail['n_mdp'] == 0){
                        // On génère un mot de passe à l'aide de la fonction RAND de PHP
                        $new_pass = rand();
 
                        // Le mieux serait de générer un nombre aléatoire entre 7 et 10 caractères (Lettres et chiffres)
                        $new_pass_crypt = crypt($new_pass, "$6$rounds=5000$macleapersonnaliseretagardersecret$");
                        // $new_pass_crypt = crypt($new_pass, "VOTRE CLÉ UNIQUE DE CRYPTAGE DU MOT DE PASSE");
 
                        $objet = 'Nouveau mot de passe';
                        $to = $verification_mail['mail'];
 
                        //===== Création du header du mail.
                        $header = "From: NOM_DE_LA_PERSONNE <no-reply@test.com> \n";
                        $header .= "Reply-To: ".$to."\n";
                        $header .= "MIME-version: 1.0\n";
                        $header .= "Content-type: text/html; charset=utf-8\n";
                        $header .= "Content-Transfer-Encoding: 8bit";
 
                        //===== Contenu de votre message
                        $contenu =  "<html>".
                            "<body>".
                            "<p style='text-align: center; font-size: 18px'><b>Bonjour Mr, Mme".$verification_mail['nom']."</b>,</p><br/>".
                            "<p style='text-align: justify'><i><b>Nouveau mot de passe : </b></i>".$new_pass."</p><br/>".
                            "</body>".
                            "</html>";
                        //===== Envoi du mail
                        mail($to, $objet, $contenu, $header);
                        $DB->insert("UPDATE utilisateur SET mdp = ?, n_mdp = 1 WHERE mail = ?", 
                            array($new_pass_crypt, $verification_mail['mail']));
                    }   
                }       
                header('Location: connexion.php');
                exit;
            }
        }
    }
?>

...
 
$req = $DB->query("SELECT * FROM utilisateur WHERE mail = ? AND mdp = ?",
                array($mail, crypt($mdp, "$6$rounds=5000$macleapersonnaliseretagardersecret$")));
                                // array($mail, crypt($mdp, "VOTRE CLÉ UNIQUE DE CRYPTAGE DU MOT DE PASSE")));
$req = $req->fetch();
 
// Si on a pas de résultat alors c'est qu'il n'y a pas d'utilisateur correspondant au couple mail / mot de passe
if (!isset($req['id'])){
        $valid = false;
        $er_mail = "Le mail ou le mot de passe est incorrecte";
 
}elseif($req['n_mdp'] == 1){ // On remet à zéro la demande de nouveau mot de passe s'il y a bien un couple mail / mot de passe
    $DB->insert("UPDATE utilisateur SET n_mdp = 0 WHERE id = ?", 
        array($req['id']));
}
...

<?php
// On démarre la session AVANT d'écrire du code HTML
session_start();

$user = null;

if(isset($_SESSION['user'])) {
    $user = [];
    $user['email'] = $_SESSION['user']['email'];
    $user['name'] = $_SESSION['user']['name'];
    $user['id'] = $_SESSION['user']['id'];
}

function login() {
    $user = [];
    $user['email'] = 'test@test.be';
    $user['name'] = 'test';
    $user['id'] = 1;
}

?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?php
            echo $user['name'];
        ?>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarScrollingDropdown">
        <li><a class="dropdown-item" href="">Modifier son profil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="http://localhost/php_simple/pages/users/logout.php">Déconnexion</a></li>
    </ul>
</li>