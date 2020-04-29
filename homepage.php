<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Présentation</title>

		<?php include("style_configuration_page.php"); ?>

    </head>

    <body>
    	
        <!-- INCLUSION DU HEADER -->

        <?php include("header.php"); ?>

        <!-- INCLUSION DU HEADER -->

        <!-- CORPS -->

        <div id="homepage_container">

        	<section id="homepage_hero">

        		<h1>GBAF</h1>

        		<p>
                    Le Groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 grands groupes français :
                </p>

                    <ul>
                        
                        <li>BNP Paribas</li>
                        <li>BPCE</li>
                        <li>Crédit Agricole</li>
                        <li>Crédit Mutuel-CIC</li>
                        <li>Société Générale</li>
                        <li>La Banque Postale</li>

                    </ul>

                <p>
                    Même s’il existe une forte concurrence entre ces entités, elles vont toutes travailler de la même façon pour gérer près de 80 millions de comptes sur le territoire national.
                </p>

                <p>
                    Le GBAF est le représentant de la profession bancaire et des assureurs sur tous les axes de la réglementation financière française. Sa mission est de promouvoir l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.
                </p>
        		
        	</section>

            <div id="homepage_divider_bar"></div>

        	<section>
        		
        		<h2>Nos acteurs et partenaires</h2>

        		<p>
                    Vous retrouverez, ci-après, la liste de nos acteurs / partenaires afin que vous puissiez prendre connaissance de leur services, et leur laisser un commentaire :
                </p>

                <!-- RECUPERATION DES DESCRIPTIONS ACTEURS / PARTENAIRES -->

                <?php

                /* Connexion a la BDD */

                include('php_processing/database_connection.php');

                /* Recuperation des informations acteurs / partenaires */

                $result = $bdd -> query('SELECT * FROM actor ORDER BY actor');

                /* Affichage des descriptifs */

                while ($data = $result -> fetch())

                {

                ?>

                <div id="actors_description">
                    
                    <div id="actors_logo">
                        <img src="<?php echo $data['logo']; ?>" alt="Logo acteurs / partenaires" />
                    </div>

                    <div>
                        <h3>
                            <?php

                                echo htmlspecialchars($data['actor']);

                            ?>
                        </h3>

                        <p>
                            <?php

                                $description = $data['description'];
                                $extract = substr($description, 0, 125);
                                echo (htmlspecialchars($extract));
                                echo '...'

                            ?>
                        </p>
                    </div>

                    <div id="read_more">
                        <a href="actors_description.php?id_actor=<?php echo $data['id_actor']; ?>">
                        <p>Lire la suite</p>
                        </a>
                    </div>

                </div>

                <?php

                }

                /* Arret de l'analyse de la BDD */
                $result -> closeCursor();

                ?>

        	</section>

        </div>

        <!-- CORPS -->

        <!-- INCLUSION DU FOOTER -->

        <?php include("footer.php"); ?>

        <!-- INCLUSION DU FOOTER -->

    </body>

</html>