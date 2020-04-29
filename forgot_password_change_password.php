<?php

session_start();

if (isset($_SESSION['id_user'],
    $_SESSION['name'],
    $_SESSION['firstname'],
    $_SESSION['username'],
    $_SESSION['password'],
    $_SESSION['question'],
    $_SESSION['answer']))

{

?>

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

    		<form method="post" action="forgot_password_change_password.php">

                <fieldset>

                	<?php

                	/* Connexion a la BDD */
	                include('php_processing/database_connection.php');

	                $id_user = $_SESSION['id_user'];

	                $result = $bdd -> prepare('SELECT * FROM account WHERE id_user = :id_user');

	                $result -> execute(array('id_user' => $id_user));

	                $data_user = $result -> fetch();

	                /* Si la variable id_user existe */
                	if (isset($data_user['id_user']))
                	{
                		
                	?>

	                    <div id='secret_question_display'>

			                <p>
			                	<?php echo htmlspecialchars($data_user['question']); ?>
			                </p>

			            </div>

	                <?php

	               	}

	                ?>

	                <input type="text" name="answer" placeholder="(*) Réponse à votre question secrète" required="" />

	                <input type="password" name="new_password" placeholder="(*) Nouveau mot de passe" required="" />

	                <input type="password" name="password_confirmation" placeholder="(*) Confirmation du nouveau mot de passe" required="" />

	                <?php

	                if (isset($_POST['send']))
	                {

		               	/* Connexion a la BDD */
		               	include('php_processing/database_connection.php');

		               	/* Recuperation des valeurs question secrete et reponse */
		               	$result = $bdd -> prepare('SELECT * FROM account WHERE question = :question AND answer = :answer');

		               	$result -> execute(array('question' => $data_user['question'], 'answer' => $_POST['answer']));

						$data_answer = $result -> fetch();

						$answer_correct = $_POST['answer'] == $data_answer['answer'];
						
						/* Si la reponse est incorrect */                     
						if (!$answer_correct)
						{

						?>

							<div id="error_message">

								<p>
									<?php echo 'La réponse n\'est pas correct !'; ?>
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

						/* Sinon si la reponse a la question secrete et le mot de passe sont correct */
						elseif ($answer_correct AND $password_correct)
						{

							$password_hach = password_hash($_POST['password_confirmation'], PASSWORD_DEFAULT);

							$change_account_data = $bdd -> prepare('UPDATE account SET password = :password WHERE id_user = :id_user');

                            $change_account_data -> execute(array('password' => $password_hach, 'id_user' => $data_user['id_user']));

                            header('location:index.php');

                            session_destroy();

						}

					}


					?>

    	    		<input type="submit" name="send" value="ENREGISTRER" />

                </fieldset>

	    	</form>

            <div id="forgot_password_login_page_button">
                            
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