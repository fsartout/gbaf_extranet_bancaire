<?php

session_start();

?>

<header>
	
	<div id="header_container">

		<a href="homepage.php">
		<img src="picture/gbaf.png" alt="Logo du GBAF" />
		</a>

		<div id="header_all_user_information">

			<div id="header_user_information">
				
				<!-- RÉCUPÉRATION DES INFORMATIONS DE L'UTILISATEUR (PHP) -->

				<?php

				/* Si les valeurs de session existent */
				if (isset($_SESSION['id_user'],
					$_SESSION['name'],
					$_SESSION['firstname'],
					$_SESSION['username'],
					$_SESSION['password'],
					$_SESSION['question'],
					$_SESSION['answer']))
				{

				?>

					<p>
						<a href="account.php">
							<span class="header_firstname"><?php echo htmlspecialchars($_SESSION['firstname']); ?></span> 
							<span class="header_name"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
						</a>
					</p>

				<?php

				}

				/* Si les valeurs de session n'existent pas */
				else
				{

				?>

				<p>
					<span class="header_hello">Veuillez vous connecter<br />pour accéder à toutes les fonctionnalités</span>
				</p>

				<?php

				}

				?>

			</div>

			<?php

			/* Si les valeurs de session existent */
			if (isset($_SESSION['name'], $_SESSION['firstname']))
			{

			?>

			<div id="header_logout_button">

				<!-- PROCÉDURE DE DÉCONNEXION (PHP) -->

				<a href="php_processing/logout_processing.php">
					<p>DÉCONNEXION</p>
				</a>

			</div>

		</div>

		<?php

		}

		/* Si les valeurs de session n'existent pas */
		else
		{

		?>

			<div id="header_login_button">

				<!-- PROCÉDURE DE CONNEXION (PHP) -->

				<a href="index.php">
					<p>CONNEXION</p>
				</a>

			</div>

		<?php

		}

		?>

	</div>

</header>