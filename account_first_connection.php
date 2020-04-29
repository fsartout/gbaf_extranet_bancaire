<?php

session_start();

/* Connexion a la BDD */
include('php_processing/database_connection.php');

/* Recuperation des identifiants utilisateurs */
$result = $bdd -> prepare('SELECT * FROM account WHERE id_user = :id_user');

$result -> execute(array('id_user' => $_SESSION['id_user']));

$page_access = $result -> fetch();

if (empty($page_access['firstname'])
    AND empty($page_access['name'])
    AND empty($page_access['question'])
    AND empty($page_access['answer']))
{

?>

<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Mon compte</title>

        <?php include("style_configuration_page.php"); ?>
        
    </head>

    <body>

        <!-- CORPS -->

        <div id="account_first_connection_container">

            <img src="picture/gbaf.png" alt="Logo du GBAF" id="account_first_connection_logo" />

            <h1>MON COMPTE</h1>

            <form method="post" action="account_first_connection.php">

                <fieldset>
                
                    <input type="text" name="firstname" placeholder="(*) Prénom" autofocus="" required="" />

                    <input type="text" name="name" placeholder="(*) Nom" required="" />

                    <input type="text" name="username" placeholder="(*) Nom d'utilisateur" required="" />

                    <input type="password" name="new_password" placeholder="(*) Nouveau mot de passe" required="" />

                    <input type="password" name="password_confirmation" placeholder="(*) Confirmation du nouveau mot de passe" required="" />

                    <input type="text" name="secret_question" placeholder="(*) Renseignez votre question secrète" required="" />

                    <input type="text" name="answer" placeholder="(*) Réponse à votre question secrète" required="" />

                    <?php

                    /* Si le bouton ENREGISTRER est active */
                    if (isset($_POST['send']))
                    {

                        /* Connexion a la BDD */
                        include('php_processing/database_connection.php');

                        /* Recuperation des identifiants utilisateurs */
                        $result = $bdd -> prepare('SELECT * FROM account WHERE username = :username');

                        $result -> execute(array('username' => $_POST['username']));

                        $data_user = $result -> fetch();

                        /* Si l'identifiant existe et est identique */
                        if ($data_user)
                        {

                        ?>

                            <div id="error_message">

                                <p>
                                    <?php echo 'L\'identifiant existe déjà !'; ?>
                                </p>

                            </div>

                        <?php

                        }

                        /* Recuperation des mots de passe dans des variables */
                        $new_password = $_POST['new_password'];

                        $password_confirmation = $_POST['password_confirmation'];

                        $password_correct = $new_password == $password_confirmation;

                        /* Si la confirmation du mot de passe est incorrect */
                        if (!$password_correct)
                        {

                        ?>

                            <div id="error_password_confirmation">

                                <p>
                                    <?php echo 'Erreur lors de la confirmation du mot de passe !'; ?>
                                </p>

                            </div>

                        <?php

                        }

                        elseif (!$data_user AND $password_correct)
                        {
                          
                            $password_hach = password_hash($_POST['password_confirmation'], PASSWORD_DEFAULT);

                            $change_account_data = $bdd -> prepare('UPDATE account SET
                                firstname = :firstname,
                                name = :name,
                                username = :username,
                                password = :password,
                                question = :question,
                                answer = :answer
                                WHERE id_user = :id_user');

                            $change_account_data -> execute(array(
                                'firstname' => $_POST['firstname'],
                                'name' => $_POST['name'],
                                'username' => $_POST['username'],
                                'password' => $password_hach,
                                'question' => $_POST['secret_question'],
                                'answer' => $_POST['answer'],
                                'id_user' => $_SESSION['id_user']));

                            session_start();
                            $_SESSION['id_user'] = $_SESSION['id_user'];
                            $_SESSION['firstname'] = $_POST['firstname'];
                            $_SESSION['name'] = $_POST['name'];
                            $_SESSION['username'] = $_POST['username'];
                            $_SESSION['password'] = $password_hach;
                            $_SESSION['question'] = $_POST['secret_question'];
                            $_SESSION['answer'] = $_POST['answer'];

                            header('location:homepage.php');

                        }

                    }

                    ?>

                    <input type="submit" name="send" value="ENREGISTRER" />

                    <p class="required_fields">
                        (*) Tous les champs doivent être renseignés.
                    </p>

                </fieldset>

            </form>

            <div id="account_index_button">
                            
                <a href="index.php">
                <p>RETOUR</p>
                </a>

            </div>

        </div>

        <!-- CORPS -->

    </body>

</html>

<?php

}

/* Si la variable de session n'existe pas */
else
{

    header('location:index.php');

}

?>