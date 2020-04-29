<?php

session_start()

?>

<?php

/* Connexion a la BDD */
include('database_connection.php');

if (isset($_GET['id_actor'], $_GET['likes_dislikes']) AND !empty($_GET['id_actor']) AND !empty($_GET['likes_dislikes']))
{

	$id_actor = (int) $_GET['id_actor'];
	$likes_dislikes = (int) $_GET['likes_dislikes'];
	$id_user = $_SESSION['id_user'];

	/* Si le nombre de ligne de la variable id_actor est differente de 0 */
	if ($id_actor != 0) 
	{

		/* Si la variable $likes_dislikes est egale a 1 (likes), suppression de la valeur 2 (dislikes) */
		if ($likes_dislikes == 1)
		{

			$check_likes_dislikes = $bdd -> prepare('SELECT * FROM vote WHERE id_user = :id_user AND id_actor = :id_actor');

			$check_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			$delete_likes_dislikes = $bdd -> prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :id_actor AND vote = 2');

			$delete_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			/* Si la variable $likes_dislikes est egale a 1 (likes) et est deja existante dans la table, suppression de la ligne */
			if ($check_likes_dislikes -> rowCount() == 1) 
			{
				
				$delete_likes_dislikes = $bdd -> prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :id_actor AND vote = 1');

				$delete_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			}

			/* Si la variable $likes_dislikes est egale a 1 (likes) et est inexistante dans la table, ajout de la ligne */
			else
			{

				$insertion_likes_dislikes = $bdd -> prepare('INSERT INTO vote (id_user, id_actor, vote) VALUES (:id_user, :id_actor, 1)');

				$insertion_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			}

		}

		/* Si la variable $likes_dislikes est egale a 2 (dislikes), suppression de la valeur 1 (likes) */
		elseif ($likes_dislikes == 2)
		{

			$check_likes_dislikes = $bdd -> prepare('SELECT * FROM vote WHERE id_user = :id_user AND id_actor = :id_actor');

			$check_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			$delete_likes_dislikes = $bdd -> prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :id_actor AND vote = 1');

			$delete_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			/* Si la variable $likes_dislikes est egale a 2 (dislikes) et est deja existante dans la table, suppression de la ligne */
			if ($check_likes_dislikes -> rowCount() == 1) 
			{
				
				$delete_likes_dislikes = $bdd -> prepare('DELETE FROM vote WHERE id_user = :id_user AND id_actor = :id_actor AND vote = 2');

				$delete_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			}

			/* Si la variable $likes_dislikes est egale a 2 (dislikes) et est inexistante dans la table, ajout de la ligne */
			else
			{

				$insertion_likes_dislikes = $bdd -> prepare('INSERT INTO vote (id_user, id_actor, vote) VALUES (:id_user, :id_actor, 2)');

				$insertion_likes_dislikes -> execute(array('id_user' => $id_user, 'id_actor' => $id_actor));

			}

		}

		header('location:http://localhost/gbaf/actors_description.php?id_actor=' . $id_actor . '');

	}

	else
	{

		header('location:http://localhost/gbaf/homepage.php');

	}

}

else
{

	header('location:http://localhost/gbaf/homepage.php');

}

?>