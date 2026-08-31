<?php
// Vérifier que la requête provient bien de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupération et sécurisation des données
    $nom = isset($_POST['nom']) ? htmlspecialchars(strip_tags(trim($_POST['nom']))) : '';
    $telephone = isset($_POST['telephone']) ? htmlspecialchars(strip_tags(trim($_POST['telephone']))) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $formation = isset($_POST['formation']) ? htmlspecialchars(strip_tags(trim($_POST['formation']))) : '';
    
    // Vérifier les champs obligatoires
    if (empty($nom) || empty($telephone) || empty($email) || empty($formation) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Veuillez remplir tous les champs correctement.";
        exit;
    }

    // Configuration de l'email
    $to = "ste.gg.services@gmail.com";
    $subject = "Nouvelle Inscription GGS : " . $formation;
    
    // Corps du message en HTML
    $message = "
    <html>
    <head>
        <title>Nouvelle Inscription - GGS</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            h2 { color: #f97316; }
            .details { background: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb; }
            p { margin: 8px 0; }
        </style>
    </head>
    <body>
        <h2>Détails de la nouvelle inscription</h2>
        <div class='details'>
            <p><strong>Nom & Prénom :</strong> {$nom}</p>
            <p><strong>Téléphone :</strong> {$telephone}</p>
            <p><strong>E-mail :</strong> {$email}</p>
            <p><strong>Formation souhaitée :</strong> {$formation}</p>
        </div>
    </body>
    </html>
    ";

    // En-têtes pour envoyer un email au format HTML
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // En-têtes supplémentaires
    $headers .= "From: GGS Inscriptions <noreply@gg-services.com>" . "\r\n";
    $headers .= "Reply-To: {$email}" . "\r\n";
    
    // Envoi de l'email
    if (mail($to, $subject, $message, $headers)) {
        http_response_code(200);
        echo "Succès";
    } else {
        http_response_code(500);
        echo "Erreur lors de l'envoi de l'email.";
    }
} else {
    // Si la méthode n'est pas POST
    http_response_code(403);
    echo "Méthode non autorisée.";
}
?>