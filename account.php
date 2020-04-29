<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Mon compte</title>

        <?php include("style_configuration_page.php"); ?>
        
    </head>

    <body>
    	
    	<!-- INCLUSION DU HEADER -->

    	<?php include("header.php"); ?>

    	<!-- INCLUSION DU HEADER -->

        <?php

        /* Si la variable de session existe */
        if (isset(
            $_SESSION['id_user'],
            $_SESSION['firstname'],
            $_SESSION['name'],
            $_SESSION['username'],
            $_SESSION['password'],
            $_SESSION['question'],
            $_SESSION['answer']))
        {

        ?>

    	<!-- CORPS -->

    	<div id="account_container">

    		<h1>MON COMPTE</h1>

    		<form method="post" action="account.php">

                <fieldset>

        	    	<input type="text" name="firstname" placeholder="(*) Prénom" value="<?php echo htmlspecialchars($_SESSION['firstname']); ?>" required="" />

        	    	<input type="text" name="name" placeholder="(*) Nom" value="<?php echo htmlspecialchars($_SESSION['name']); ?>" required="" />

                    <input type="text" name="username" placeholder="Identifiant : <?php echo htmlspecialchars($_SESSION['username']); ?>" />

                    <input type="password" name="new_password" placeholder="Nouveau mot de passe" />

                    <input type="password" name="password_confirmation" placeholder="Confirmation du nouveau mot de passe" />

                    <input type="text" name="secret_question" placeholder="(*) Renseignez votre question secrète" value="<?php echo htmlspecialchars($_SESSION['question']); ?>" required="" />

                    <input type="text" name="answer" placeholder="(*) Réponse à votre question secrète" value="<?php echo htmlspecialchars($_SESSION['answer']); ?>" required="" />

                    <?php

                    /* Si le bouton ENREGISTRER est active */
                    if (isset($_POST['send']))
                    {

                        /* Connexion a la BDD */
                        include('php_processing/database_connection.php');

                        /* Si le champ identifiant est vide */
                        if (empty($_POST['username']))
                        {

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

                            /* Sinon enregistre dans la BDD */
                            else
                            {

                                $password_hach = password_hash($_POST['password_confirmation'], PASSWORD_DEFAULT);

                                $change_account_data = $bdd -> prepare('UPDATE account SET
                                    firstname = :firstname,
                                    name = :name,
                                    password = :password,
                                    question = :question,
                                    answer = :answer
                                    WHERE id_user = :id_user');

                                $change_account_data -> execute(array(
                                    'firstname' => $_POST['firstname'],
                                    'name' => $_POST['name'],
                                    'password' => $password_hach,
                                    'question' => $_POST['secret_question'],
                                    'answer' => $_POST['answer'],
                                    'id_user' => $_SESSION['id_user']));

                                session_start();
                                $_SESSION['id_user'] = $_SESSION['id_user'];
                                $_SESSION['firstname'] = $_POST['firstname'];
                                $_SESSION['name'] = $_POST['name'];
                                $_SESSION['username'] = $_SESSION['username'];
                                $_SESSION['password'] = $password_hach;
                                $_SESSION['question'] = $_POST['secret_question'];
                                $_SESSION['answer'] = $_POST['answer'];

                                header('location:homepage.php');

                            }

                        }

                        /* Sinon, si les champs du nouveau mot de passe et de la confirmation du nouveau mot de passe est vide */
                        elseif (empty($_POST['new_password']) AND empty($_POST['password_confirmation']))
                        {

                            /* Connexion a la BDD */
                            include('php_processing/database_connection.php');

                            /* Recuperation des identifiants utilisateurs */
                            $result = $bdd -> prepare('SELECT * FROM account WHERE username = :username');

                            $result -> execute(array('username' => $_POST['username']));

                            $data_username = $result -> fetch();

                            /* Si l'identifiant existe et est identique */
                            if ($data_username)
                            {

                            ?>

                                <div id="error_message">

                                    <p>
                                        <?php echo 'L\'identifiant existe déjà !'; ?>
                                    </p>

                                </div>

                            <?php

                            }

                            /* Sinon enregistre dans la BDD */
                            else
                            {

                                $change_account_data = $bdd -> prepare('UPDATE account SET
                                    firstname = :firstname,
                                    name = :name,
                                    username = :username,
                                    question = :question,
                                    answer = :answer
                                    WHERE id_user = :id_user');

                                $change_account_data -> execute(array(
                                    'firstname' => $_POST['firstname'],
                                    'name' => $_POST['name'],
                                    'username' => $_POST['username'],
                                    'question' => $_POST['secret_question'],
                                    'answer' => $_POST['answer'],
                                    'id_user' => $_SESSION['id_user']));

                                session_start();
                                $_SESSION['id_user'] = $_SESSION['id_user'];
                                $_SESSION['firstname'] = $_POST['firstname'];
                                $_SESSION['name'] = $_POST['name'];
                                $_SESSION['username'] = $_POST['username'];
                                $_SESSION['password'] = $_SESSION['password'];
                                $_SESSION['question'] = $_POST['secret_question'];
                                $_SESSION['answer'] = $_POST['answer'];

                                header('location:homepage.php');

                            }

                        }

                        /* Sinon enregistre tous les champs dans la BDD */
                        else
                        {

                            /* Connexion a la BDD */
                            include('php_processing/database_connection.php');

                            /* Recuperation des identifiants utilisateurs */
                            $result = $bdd -> prepare('SELECT * FROM account WHERE username = :username');

                            $result -> execute(array('username' => $_POST['username']));

                            $data_username = $result -> fetch();

                            /* Si l'identifiant existe et est identique */
                            if ($data_username)
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

                            /* Sinon, si l'identifiant n'existe pas et si la confirmation du mot de passe est correct */
                            elseif (!$data_username AND $password_correct)
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

                    }

                    ?>

                    <input type="submit" name="send" value="ENREGISTRER" />

                    <p class="required_fields">
                        (*) Tous les champs doivent être renseignés.
                    </p>

                </fieldset>

	    	</form>

            <div id="account_home_button">
                            
                <a href="homepage.php">
                <p>RETOUR À L'ACCUEIL</p>
                </a>

            </div>

	    </div>

    	<!-- CORPS -->

        <?php

        }

        /* Si la variable de session n'existe pas */
        else
        {

            header('location:index.php');

        }

        ?>

    	<!-- INCLUSION DU FOOTER -->

    	<?php include("footer.php"); ?>

    	<!-- INCLUSION DU FOOTER -->

    </body>

</html>