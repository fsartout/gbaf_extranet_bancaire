<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Connexion</title>

		<?php include("style_configuration_page.php"); ?>

    </head>

    <body>

    	<!-- CORPS -->

    	<div id="login_container">

            <img src="picture/gbaf.png" alt="Logo du GBAF" id="login_logo" />

    		<h1>CONNEXION</h1>

            <form method="post" action="index.php">

                <fieldset>

    	    		<input type="text" name="username" placeholder="Identifiant" required="" />

                    <input type="password" name="password" placeholder="Mot de passe" required="" />

                    <!-- TRAITEMENT DU FORMULAIRE DE CONNEXION -->

                    <?php

                    /* Verification des variable $_POST */
                    if (isset($_POST['username'], $_POST['password']))
                    {
                        
                        /* Connexion a la BDD */
                        include('php_processing/database_connection.php');

                        /* Recuperation des informations utilisateurs */
                        $result = $bdd -> prepare('SELECT * FROM account WHERE username = :username');

                        $result -> execute(array('username' => $_POST['username']));

                        $data_login = $result -> fetch();

                        /* Verification de l'identifiant et du mot de passe haché */
                        $if_password_correct = password_verify($_POST['password'], $data_login['password']);

                        /* Si le bouton d'envoi est actionné */
                        if (isset($_POST['send']))
                        {

                            /* Si il y a une valeur incorrect, affichage de l'erreur */
                            if (!$data_login)
                            {

                            ?>

                                <div id="error_message">

                                    <p>
                                        <?php echo 'L\'identifiant ou le mot de passe est incorrect !'; ?>
                                    </p>

                                </div>

                            <?php

                            }

                            /* Si les valeurs du mot de passe sont correct mais qu'il manque la valeur "question secrete" dans la BDD, démarrage de la session et redirection vers la page compte */
                            elseif ($if_password_correct AND empty($data_login['question']))
                            {
                                session_start();
                                $_SESSION['id_user'] = $data_login['id_user'];
                                $_SESSION['password'] = $data_login['password'];

                                header('Location:account_first_connection_test.php');
                            }

                            else
                            {

                                /* Si les valeurs du mot de passe sont correct, démarrage de la session et redirection vers la page d'accueil */
                                if ($if_password_correct)
                                {
                                    session_start();
                                    $_SESSION['id_user'] = $data_login['id_user'];
                                    $_SESSION['firstname'] = $data_login['firstname'];
                                    $_SESSION['name'] = $data_login['name'];
                                    $_SESSION['username'] = $data_login['username'];
                                    $_SESSION['password'] = $data_login['password'];
                                    $_SESSION['question'] = $data_login['question'];
                                    $_SESSION['answer'] = $data_login['answer'];

                                    header('Location:homepage.php');
                                }

                                /* Si il y a une valeur incorrect, affichage de l'erreur */
                                else
                                {

                                ?>

                                    <div id="error_message">

                                        <p>
                                            <?php echo 'L\'identifiant ou le mot de passe est incorrect !'; ?>
                                        </p>

                                    </div>

                                <?php

                                }

                            }

                        }

                        /* Arret de l'analyse de la BDD */
                        $result -> closeCursor();

                    }

                    ?>

                    <!-- TRAITEMENT DU FORMULAIRE DE CONNEXION -->

                    <input type="submit" name="send" value="CONNEXION" />

                    <p>
                        <a href="forgot_password_username.php">Mot de passe oublié ?</a>
                    </p>

                </fieldset>

	    	</form>

	    </div>

    	<!-- CORPS -->

    </body>

</html>