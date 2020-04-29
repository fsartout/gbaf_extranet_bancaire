<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Contact</title>

        <?php include("style_configuration_page.php"); ?>
        
    </head>

    <body>
    	
    	<!-- INCLUSION DU HEADER -->

    	<?php include("header.php"); ?>

    	<!-- INCLUSION DU HEADER -->

    	<!-- CORPS -->

    	<div id="contact_container">

    		<h1>CONTACT</h1>

    		<p>
    			Pour toutes informations complémentaires, veuillez nous adresser votre demande via le formulaire ci-dessous :
    		</p>

    		<form method="post" action="php_processing/contact_processing.php">

                <fieldset>

    	    		<input type="text" name="firstname" placeholder="(*) Prénom" required="" />

    	    		<input type="text" name="name" placeholder="(*) Nom" required="" />

    	    		<input type="email" name="e_mail" placeholder="(*) Adresse e-mail" required="" />

    	    		<input type="tel" name="phone_number" placeholder="Numéro de téléphone" />

                    <input type="text" name="subject" placeholder="(*) Objet de votre demande" required="" />

    	    		<textarea name="message" placeholder="(*) Insérez votre message ici..." required=""></textarea>

    	    		<input type="submit" name="send" value="ENVOYER" />

                    <p class="required_fields">
                        (*) Tous les champs doivent être renseignés.
                    </p>

                </fieldset>

	    	</form>

            <div id="contact_home_button">
                            
                <a href="homepage.php">
                <p>RETOUR À L'ACCUEIL</p>
                </a>

            </div>

	    </div>

    	<!-- CORPS -->

    	<!-- INCLUSION DU FOOTER -->

    	<?php include("footer.php"); ?>

    	<!-- INCLUSION DU FOOTER -->

    </body>

</html>