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

                $result -> closeCursor();

                ?>
        		
        	</section>

            <section id="comment_container">

            	<form method="post" action="actors_description_post.php?id_actor=<?php echo $data_actor_description['id_actor']; ?>">

                    <fieldset>

                        <!-- AFFICHER EN PHP -->

                        <?php

                        /* Connexion a la BDD */
                        include('php_processing/database_connection.php');

                        /* Recuperation du commentaire de l'utilisateur */
                        $result = $bdd -> prepare('SELECT * FROM post WHERE id_actor = :id_actor');

                        $result -> execute(array('id_actor' => $_GET['id_actor']));

                        $data_user_comment = $result -> fetch();

                        /* Si l'utilisateur est connecte */
                        if (isset($_SESSION['id_user'],
                            $_SESSION['firstname'],
                            $_SESSION['name'],
                            $_SESSION['username'],
                            $_SESSION['password'],
                            $_SESSION['question'],
                            $_SESSION['answer']))
                        {

                            /* Si l'utilisateur a laisse un commentaire */
                            if ($data_user_comment['post'])
                            {

                            ?>

                                <textarea name="message" placeholder="Insérez votre message ici..." required=""><?php echo $data_user_comment['post']; ?></textarea>

                                <!-- MISE A JOUR DU COMMENTAIRE -->

                                <?php

                                if (isset($_POST['send']))
                                {

                                    if ($data_user_comment['post'])
                                    {

                                        $change_post = $bdd -> prepare('UPDATE post SET
                                            date_add = NOW(),
                                            post = :post
                                            WHERE id_user = :id_user
                                            AND id_actor = :id_actor');

                                        $change_post -> execute(array(
                                            'post' => $_POST['message'],
                                            'id_user' => $_SESSION['id_user'],
                                            'id_actor' => $_GET['id_actor']));

                                    }

                                    header('location:actors_description_post.php?id_actor=' . $_GET['id_actor'] . '');

                                }

                                ?>

                                <input type="submit" name="send" value="MODIFIER" id="send_button" />

                                <div id="cancel_button">
                                    <a href="actors_description.php?id_actor=<?php echo $data_actor_description['id_actor']; ?>">
                                    <p>RETOUR</p>
                                    </a>
                                </div>

                            <?php

                            }

                            /* Si l'utilisateur n'a pas laisse de commentaire */
                            else
                            {

                            ?>

                                <textarea name="message" placeholder="Insérez votre message ici..." required=""></textarea>

                                <!-- ENVOYER UN COMMENTAIRE -->

                                <?php

                                if (isset($_POST['send']))
                                {

                                    if (!$data_user_comment['post'])
                                    {

                                        $insert_new_post = $bdd -> prepare('INSERT INTO post VALUES(NULL, :id_user, :id_actor, NOW(), :post)');

                                        $insert_new_post -> execute(array(
                                            'id_user' => $_SESSION['id_user'],
                                            'id_actor' => $_GET['id_actor'],
                                            'post' => $_POST['message']));

                                    }

                                    header('location:actors_description_post.php?id_actor=' . $_GET['id_actor'] . '');

                                }

                                ?>

                                <input type="submit" name="send" value="ENVOYER" id="send_button" />

                                <div id="cancel_button">
                                    <a href="actors_description.php?id_actor=<?php echo $data_actor_description['id_actor']; ?>">
                                    <p>RETOUR</p>
                                    </a>
                                </div>

                            <?php

                            }

                        }

                        /* Sinon, affichage du bouton de connection */
                        else
                        {

                        ?>

                            <textarea name="message" placeholder="Insérez votre message ici..." required=""></textarea>

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