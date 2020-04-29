<?php

$to = 'florent.sartout.lebon@outlook.com';

/* Si le bouton d'envoi est actionne */
if(isset($_POST['send']))
{
	
	/* Vérification que le champ l'adresse e-mail est rempli */
    if(empty($_POST['e_mail']))
    {
        echo 'Veuillez renseigner votre adresse e-mail';
    }

    else
    {
        /* Vérification que l'adresse e-mail est valide */
        if(!preg_match('#^[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?@[a-z0-9_-]+((\.[a-z0-9_-]+){1,})?\.[a-z]{2,}$#i', $_POST['e_mail']))
        {
            echo 'L\'adresse e-mail entrée est incorrecte';
        }

        else
        {
            /* Vérification que les champs prenom, nom et objet sont remplis */
            if(empty($_POST['firstname'] AND $_POST['name'] AND $_POST['subject']))
            {
                echo 'Veuillez renseigner les champs obligatoires';
            }

            else
            {
                /* Vérification que le champ du message est rempli */
                if(empty($_POST['message'])) 
                {
                    echo 'Veuillez insérer votre message';
                }

                /* Envoi du mail si tout est correct */
                else
                {
                    
                    $header = 'MIME-Version: 1.0<br />';
                    $header .= 'Content-type: text/html; charset=UTF-8<br />';
                    $header .= 'From: ' . $_POST['e_mail'] . '<br />';

                    $subject = htmlspecialchars($_POST['subject']);

                    $message = '<p>Prénom : ' . htmlspecialchars($_POST['firstname']) . '<br />
                    Nom : ' . htmlspecialchars($_POST['name']) . '<br />
                    E-mail : ' . htmlspecialchars($_POST['e_mail']) . '<br />
                    Téléphone : ' . htmlspecialchars($_POST['phone_number']) . '<br /><br />
                    Objet : ' . htmlspecialchars($_POST['subject']) . '<br /><br />
                    ' . htmlspecialchars($_POST['message']) . '</p>';

                    
                    if(mail($to, $subject, nl2br($message), $header))
                    {
                    	header('location:/gbaf/contact.php');
                    }

                    else 
                    {
                        echo 'Une erreur est survenue, votre mail n\'a pas été envoyé';
                    }
                }
            }
        }
    }
}







?>