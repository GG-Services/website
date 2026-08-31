<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $telephone = htmlspecialchars(trim($_POST["telephone"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $formation = htmlspecialchars(trim($_POST["formation"]));

    // Paramètres de l'e-mail
    $to = "ste.gg.services@gmail.com";
    $subject = "Nouvelle Inscription - GGS";
    
    // Corps du message
    $message = "Nouvelle demande d'inscription reçue depuis le site GGS :\n\n";
    $message .= "Nom & Prénom : " . $nom . "\n";
    $message .= "Téléphone : " . $telephone . "\n";
    $message .= "E-mail : " . $email . "\n";
    $message .= "Formation souhaitée : " . $formation . "\n";

    // En-têtes
    $headers = "From: " . $email . "\r\n" .
               "Reply-To: " . $email . "\r\n" .
               "X-Mailer: PHP/" . phpversion();

    // Envoi de l'e-mail
    if (mail($to, $subject, $message, $headers)) {
        echo "<script>
                alert('Merci ! Votre pré-inscription a été enregistrée avec succès. Notre équipe vous contactera sous peu.');
                window.location.href = 'index.html';
              </script>";
    } else {
        echo "<script>
                alert('Une erreur est survenue lors de l\'envoi. Veuillez réessayer.');
                window.history.back();
              </script>";
    }
} else {
    // Redirection si l'accès se fait sans POST
    header("Location: index.html");
    exit;
}
?>