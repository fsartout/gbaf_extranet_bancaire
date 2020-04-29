<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8" />

        <title>GBAF - Acteurs et partenaires - Présentation</title>

		<?php include("style_configuration_page.php"); ?>

    </head>

    <body>

        <!-- INCLUSION DU HEADER -->

        <?php include("header.php"); ?>

        <!-- INCLUSION DU HEADER -->

        <?php

        $_GET['id_actor'] = (int) $_GET['id_actor'];

        /* Si la variable est remplie et correct */
        if (!empty($_GET['id_actor']))
        {

        ?>

        <!-- CORPS -->

        <div id="actors_description_container">

        	<section id="actors_presentation">

                <!-- RECUPERATION DE LA DESCRIPTION ACTEUR / PARTENAIRE -->

                <?php

                /* Connexion a la BDD */
                include('php_processing/database_connection.php');

                $result = $bdd -> prepare('SELECT * FROM actor WHERE id_actor = :id_actor');

                $result -> execute(array('id_actor' => $_GET['id_actor']));

                $data_actor_description = $result -> fetch();

                {

                ?>

                <div id="actors_logo">
                    <img src="<?php echo $data_actor_description['logo']; ?>" alt="Logo acteurs / partenaires" />
                </div>

        		<h2>
                    <?php echo htmlspecialchars($data_actor_description['actor']) ?>
                </h2>

        		<p>
                    <?php echo nl2br(htmlspecialchars($data_actor_description['description'])) ?>
                </p>

                <?php

                }

                /* Arret de l'analyse de la BDD */
                $result -> closeCursor();

                ?>
        		
        	</section>

            <section id="comment_container">

                <form method="post" action="">

                    <fieldset>

                        <div id="comment_option">

                        <!-- ESPACE COMMENTAIRE -->

                            <!-- AFFICHAGE DU NOMBRE DE COMMENTAIRES -->

                            <?php

                            /* Connexion a la BDD */
                            include('php_processing/database_connection.php');

                            /* Recuperation de toutes les lignes de la table */
                            $result = $bdd -> prepare('SELECT * FROM post WHERE id_actor = :id_actor');

                            $result -> execute(array('id_actor' => $_GET['id_actor']));

                            $result -> rowCount();

                            $data_comment_number = $result -> rowCount();

                            {

                            ?>

                            <div id="comments_number">
                                <p><?php echo $data_comment_number; ?> Commentaire(s)</p>
                            </div>

                            <?php

                            }

                            /* Arret de l'analyse de la BDD */
                            $result -> closeCursor();

                            ?>

                            <!-- AFFICHAGE DES BOUTONS POUR LAISSER UN COMMENTAIRE ET LIKER / DISLIKER EN FONCTION DE L'ETAT UTILISATEUR -->

                            <?php

                            /* Verification des variable $_SESSION */
                            if (isset($_SESSION['id_user']))

                            {

                                /* Connexion a la BDD */
                                include('php_processing/database_connection.php');

                                /* Recuperation des informations utilisateurs et acteurs pour acceder à l'espace commentaire */
                                $result = $bdd -> prepare('SELECT * FROM post WHERE id_user = :id_user AND id_actor = :id_actor');

                                $result -> execute(array('id_user' => $_SESSION['id_user'], 'id_actor' => $_GET['id_actor']));

                                $data_comment_button = $result -> fetch();

                                /* Si un commentaire utilisateur n'existe pas */
                                if (!$data_comment_button)
                                {

                                ?>
                                <div id="new_comment_button">
                                    <a href="actors_description_post.php?id_actor=<?php echo $_GET['id_actor']; ?>">
                                        <p>
                                            NOUVEAU COMMENTAIRE
                                        </p>
                                    </a>
                                </div>

                                <!-- AFFICHAGE DES LIKES / DISLIKES -->

                                <?php

                                /* Connexion a la BDD */
                                include('php_processing/database_connection.php');

                                /* Recuperation du nombre de likes */
                                $result = $bdd -> prepare('SELECT * FROM vote WHERE id_actor = :id_actor AND vote = 1');

                                $result -> execute(array('id_actor' => $_GET['id_actor']));

                                $likes_number = $result -> rowCount();

                                /* Recuperation du nombre de dislikes */
                                $result = $bdd -> prepare('SELECT * FROM vote WHERE id_actor = :id_actor AND vote = 2');

                                $result -> execute(array('id_actor' => $_GET['id_actor']));

                                $dislikes_number = $result -> rowCount();

                                ?>

                                <div id="like_dislike_button_content">

                                    <?php

                                    /* Connexion a la BDD */
                                    include('php_processing/database_connection.php');

                                    /* Recuperation des valeurs likes / dislikes */
                                    $result = $bdd -> prepare('SELECT * FROM vote
                                        WHERE id_actor = :id_actor
                                        AND id_user = :id_user
                                        AND vote = 1');

                                    $result -> execute(array(
                                        'id_actor' => $_GET['id_actor'],
                                        'id_user' => $_SESSION['id_user']));

                                    $likes = $result -> fetch();

                                    $result = $bdd -> prepare('SELECT * FROM vote
                                        WHERE id_actor = :id_actor
                                        AND id_user = :id_user
                                        AND vote = 2');

                                    $result -> execute(array(
                                        'id_actor' => $_GET['id_actor'],
                                        'id_user' => $_SESSION['id_user']));

                                    $dislikes = $result -> fetch();

                                    ?>

                                    <?php

                                    if ($likes != 0)
                                    {

                                    ?>

                                        <div id="like_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=1">

                                                <p>
                                                    <?php echo $likes_number; ?>
                                                </p>

                                                <img src="picture/icon/like_blue.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    else
                                    {

                                    ?>

                                        <div id="like_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=1">

                                                <p>
                                                    <?php echo $likes_number; ?>
                                                </p>

                                                <img src="picture/icon/like_black.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    ?>

                                    <?php

                                    if ($dislikes != 0)
                                    {

                                    ?>

                                        <div id="dislike_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=2">

                                                <p>
                                                    <?php echo $dislikes_number; ?>
                                                </p>

                                                <img src="picture/icon/dislike_red.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    else
                                    {

                                    ?>

                                        <div id="dislike_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=2">

                                                <p>
                                                    <?php echo $dislikes_number; ?>
                                                </p>

                                                <img src="picture/icon/dislike_black.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    ?>

                                </div>

                                <?php
                                
                                }

                                /* Si un commentaire utilisateur existe */
                                else
                                {
                                
                                ?>

                                <div id="new_comment_button">
                                    <a href="actors_description_post.php?id_actor=<?php echo $_GET['id_actor']; ?>">
                                        <p>
                                            MODIFIER VOTRE COMMENTAIRE
                                        </p>
                                    </a>
                                </div>

                                <!-- AFFICHAGE DES LIKES / DISLIKES -->

                                <?php

                                /* Connexion a la BDD */
                                include('php_processing/database_connection.php');

                                /* Recuperation du nombre de likes */
                                $result = $bdd -> prepare('SELECT * FROM vote WHERE id_actor = :id_actor AND vote = 1');

                                $result -> execute(array('id_actor' => $_GET['id_actor']));

                                $likes_number = $result -> rowCount();

                                /* Recuperation du nombre de dislikes */
                                $result = $bdd -> prepare('SELECT * FROM vote WHERE id_actor = :id_actor AND vote = 2');

                                $result -> execute(array('id_actor' => $_GET['id_actor']));

                                $dislikes_number = $result -> rowCount();

                                ?>

                                <div id="like_dislike_button_content">

                                    <?php

                                    /* Connexion a la BDD */
                                    include('php_processing/database_connection.php');

                                    /* Recuperation des valeurs likes / dislikes */
                                    $result = $bdd -> prepare('SELECT * FROM vote
                                        WHERE id_actor = :id_actor
                                        AND id_user = :id_user
                                        AND vote = 1');

                                    $result -> execute(array(
                                        'id_actor' => $_GET['id_actor'],
                                        'id_user' => $_SESSION['id_user']));

                                    $likes = $result -> fetch();

                                    $result = $bdd -> prepare('SELECT * FROM vote
                                        WHERE id_actor = :id_actor
                                        AND id_user = :id_user
                                        AND vote = 2');

                                    $result -> execute(array(
                                        'id_actor' => $_GET['id_actor'],
                                        'id_user' => $_SESSION['id_user']));

                                    $dislikes = $result -> fetch();

                                    ?>

                                    <?php

                                    if ($likes != 0)
                                    {

                                    ?>

                                        <div id="like_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=1">

                                                <p>
                                                    <?php echo $likes_number; ?>
                                                </p>

                                                <img src="picture/icon/like_blue.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    else
                                    {

                                    ?>

                                        <div id="like_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=1">

                                                <p>
                                                    <?php echo $likes_number; ?>
                                                </p>

                                                <img src="picture/icon/like_black.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    ?>

                                    <?php

                                    if ($dislikes != 0)
                                    {

                                    ?>

                                        <div id="dislike_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=2">

                                                <p>
                                                    <?php echo $dislikes_number; ?>
                                                </p>

                                                <img src="picture/icon/dislike_red.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    else
                                    {

                                    ?>

                                        <div id="dislike_button">

                                            <a href="php_processing/actors_description_likes_dislikes_processing.php?id_actor=<?php echo $_GET['id_actor']; ?>&likes_dislikes=2">

                                                <p>
                                                    <?php echo $dislikes_number; ?>
                                                </p>

                                                <img src="picture/icon/dislike_black.png">

                                            </a>

                                        </div>

                                    <?php

                                    }

                                    ?>

                                </div>

                                <?php
                                
                                }

                            }

                            /* Si la connexion utilisateur n'existe pas */
                            else
                            {
                            
                            ?>

                            <div id="new_comment_button">
                                <a href="index.php">
                                    <p>
                                        CONNECTEZ-VOUS POUR LAISSER UN COMMENTAIRE
                                    </p>
                                </a>
                            </div>

                            <?php
                            
                            }

                            ?>

                        </div>

                        <!-- AFFICHAGE DES COMMENTAIRES UTILISATEURS -->

                        <?php

                        /* Connexion a la BDD */
                        include('php_processing/database_connection.php');

                        /* Recuperation du contenu des commentaires avec jointure de table */
                        $result = $bdd -> prepare('SELECT account.firstname, post.id_post, post.id_user, post.post, DATE_FORMAT(date_add, \'%d/%m/%Y à %Hh%i\') AS french_comment_date FROM post INNER JOIN account ON post.id_user = account.id_user WHERE id_actor = :id_actor ORDER BY date_add DESC');

                        $result -> execute(array('id_actor' => $_GET['id_actor']));

                        while ($data_comment = $result -> fetch())

                        {

                        ?>

                        <div id="comment_content_container">

                            <p id="firstname_comment"> 
                                <?php echo htmlspecialchars($data_comment['firstname']); ?>
                            </p>

                            <p id="date_comment">
                                <?php echo $data_comment['french_comment_date']; ?>
                            </p>

                            <p id="user_comment">
                                <?php echo nl2br(htmlspecialchars($data_comment['post'])); ?>
                            </p>

                        </div>

                        <?php

                        }

                        $result -> closeCursor();

                        ?>

                        <!-- AFFICHAGE DES COMMENTAIRES UTILISATEURS -->

                    </fieldset>

                </form>
                
            </section>

        </div>

        <!-- CORPS -->

        <?php

        }

        /* Si la variable est incomplete ou incorrect */
        elseif (empty($get_id_actor))
        {

            header('location:index.php');

        }

        ?>

        <!-- INCLUSION DU FOOTER -->

        <?php include("footer.php"); ?>

        <!-- INCLUSION DU FOOTER -->

    </body>

</html>