<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Mot de passe oublié ?</title>

		<?php include("style_configuration_page.php"); ?>

    </head>

    <body>
    	
    	<!-- CORPS -->

    	<div id="forgot_password_container">

            <img src="picture/gbaf.png" alt="Logo du GBAF" id="forgot_password_logo" />

    		<h1>MOT DE PASSE OUBLIÉ ?</h1>

    		<form method="post" action="forgot_password_username.php">

                <fieldset>

                    <input type="text" name="username" placeholder="(*) Nom d'utilisateur" required="" />

                    <?php

                    if (isset($_POST['send']))
                    {

                        /* Connexion a la BDD */
                        include('php_processing/database_connection.php');

                        /* Recuperation de la valeur du champ username et comparaison avec celui de la BDD */
                        $result = $bdd -> prepare('SELECT * FROM account WHERE username = :username');

                        $result -> execute(array('username' => $_POST['username']));

                        $data_user = $result -> fetch();

                        /* Si l'identifiant n'existe pas */
                        if ($data_user == 0)
                        {

                        ?>

                            <div id="error_message">

                                <p>
                                    <?php echo 'L\'identifiant n\'existe pas !'; ?>
                                </p>

                            </div>

                        <?php

                        }

                        /* Si l'identifiant existe mais que l'utilisateur n'a pas renseigne une question secrete */
                        elseif (isset($data_user) AND empty($data_user['question']))
                        {

                        ?>

                            <div id="error_message">

                                <p>
                                    <?php echo 'Vous ne pouvez changer votre mot de passe pour le moment !'; ?>
                                </p>

                            </div>

                        <?php 

                        }

                        else
                        {
                            
                            session_start();
                            $_SESSION['id_user'] = $data_user['id_user'];
                            $_SESSION['name'] = $data_user['name'];
                            $_SESSION['firstname'] = $data_user['firstname'];
                            $_SESSION['username'] = $data_user['username'];
                            $_SESSION['password'] = $data_user['password'];
                            $_SESSION['question'] = $data_user['question'];
                            $_SESSION['answer'] = $data_user['answer'];

                            header('location:forgot_password_change_password.php');

                        }

                    }

                    ?>

    	    		<input type="submit" name="send" value="ENVOYER" />

                </fieldset>

	    	</form>

            <div id="forgot_password_login_page_button">
                            
                <a href="index.php">
                <p>
                    RETOUR
                </p>
                </a>

            </div>

	    </div>

    	<!-- CORPS -->

    </body>

</html>