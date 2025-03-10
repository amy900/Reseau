<?php
// Inclure la connexion à la base de données
require 'db.php';

// Initialiser les variables de message
$error = "";
$success = "";

// Ajouter un employé
if (isset($_POST['ajouter_employe'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    try {
        $sql = "INSERT INTO employes (nom, prenom, email, poste, telephone, adresse) VALUES (:nom, :prenom, :email, :poste, :telephone, :adresse)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'poste' => $poste,
            'telephone' => $telephone,
            'adresse' => $adresse
        ]);
        
        // Envoyer un email de confirmation
        if (sendConfirmationEmail($email, $prenom, $email)) {
            $success = "Employé ajouté avec succès et email de confirmation envoyé!";
        } else {
            $success = "Employé ajouté avec succès, mais l'envoi de l'email a échoué.";
        }
    } catch (PDOException $e) {
        $error = "Erreur lors de l'ajout de l'employé: " . $e->getMessage();
    }
}

// Modifier un employé
if (isset($_POST['modifier_employe'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    try {
        $sql = "UPDATE employes SET nom = :nom, prenom = :prenom, email = :email, poste = :poste, telephone = :telephone, adresse = :adresse WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'poste' => $poste,
            'telephone' => $telephone,
            'adresse' => $adresse
        ]);
        $success = "Employé modifié avec succès !";
    } catch (PDOException $e) {
        $error = "Erreur lors de la modification de l'employé: " . $e->getMessage();
    }
}

// Supprimer un employé
if (isset($_GET['supprimer_employe'])) {
    $id = $_GET['supprimer_employe'];
    try {
        $sql = "DELETE FROM employes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $success = "Employé supprimé avec succès !";
    } catch (PDOException $e) {
        $error = "Erreur lors de la suppression de l'employé: " . $e->getMessage();
    }
}

// Récupérer les employés
$sql = "SELECT * FROM employes";
$stmt = $pdo->query($sql);
$employes = $stmt->fetchAll(PDO::FETCH_ASSOC);

function sendConfirmationEmail($to, $prenom, $email) {
    $from = "mail@smarttech.sn";
    $subject = 'Confirmation d\'inscription';
    
    // Message en HTML pour une meilleure présentation
    $message_html = '
    <html>
    <head>
        <title>Confirmation d\'inscription</title>
    </head>
    <body>
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
            <h2 style="color: #333;">Bienvenue sur la plateforme Smarttech!</h2>
            <p>Bonjour ' . htmlspecialchars($prenom) . ',</p>
            <p>Votre compte a été créé avec succès.</p>
            <p>Voici vos informations de connexion :</p>
            <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <p><strong>Nom d\'utilisateur :</strong> ' . htmlspecialchars($email) . '</p>
            </div>
            <p>Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
            <p>Cordialement,<br>L\'équipe Smarttech</p>
        </div>
    </body>
    </html>';
    
    // Message alternatif en texte brut
    $message_text = "Bienvenue sur la plateforme Smarttech!\n\n";
    $message_text .= "Bonjour " . $prenom . ",\n\n";
    $message_text .= "Voici vos informations de connexion :\n";
    $message_text .= "Nom d'utilisateur : " . $email . "\n\n";
    $message_text .= "Pour des raisons de sécurité, nous vous recommandons de changer votre mot de passe après votre première connexion.\n";
    $message_text .= "Cordialement,\nL'équipe Smarttech";
    
    // En-têtes de l'e-mail
    $headers = "From: $from\r\n";
    $headers .= "Reply-To: $from\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"boundary\"\r\n";
    
    // Corps du message avec les deux versions (texte et HTML)
    $body = "--boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= $message_text . "\r\n\r\n";
    $body .= "--boundary\r\n";
    $body .= "Content-Type: text/html; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
    $body .= $message_html . "\r\n\r\n";
    $body .= "--boundary--";
    
    // Envoi de l'e-mail via la fonction mail()
    return mail($to, $subject, $body, $headers);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés</title>
    <link rel="stylesheet" href="main1.css">
</head>
<body>
    <div class="container">
        <h2>Gestion des Employés</h2>

        <?php if ($error): ?>
            <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
        <?php endif; ?>

        <!-- Formulaire pour ajouter ou modifier un employé -->
        <form method="POST">
            <input type="hidden" name="id" value="<?= isset($_GET['modifier_employe']) ? $_GET['modifier_employe'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= isset($_GET['modifier_employe']) ? htmlspecialchars($employes[array_search($_GET['modifier_employe'], array_column($employes, 'id'))]['nom']) : '' ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= isset($_GET['modifier_employe']) ? htmlspecialchars($employes[array_search($_GET['modifier_employe'], array_column($employes, 'id'))]['prenom']) : '' ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?= isset($_GET['modifier_employe']) ? htmlspecialchars($employes[array_search($_GET['modifier_employe'], array_column($employes, 'id'))]['email']) : '' ?>" required>
            <input type="text" name="poste" placeholder="Poste" value="<?= isset($_GET['modifier_employe']) ? htmlspecialchars($employes[array_search($_GET['modifier_employe'], array_column($employes, 'id'))]['poste']) : '' ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= isset($_GET['modifier_employe']) ? htmlspecialchars($employes[array_search($_GET['modifier_employe'], array_column($employes, 'id'))]['telephone']) : '' ?>">
            <input type="text" name="adresse" placeholder="Adresse" value="<?= isset($_GET['modifier_employe']) ? htmlspecialchars($employes[array_search($_GET['modifier_employe'], array_column($employes, 'id'))]['adresse']) : '' ?>">
            <?php if (isset($_GET['modifier_employe'])): ?>
                <button type="submit" name="modifier_employe">Modifier</button>
            <?php else: ?>
                <button type="submit" name="ajouter_employe">Ajouter</button>
            <?php endif; ?>
        </form>

        <!-- Tableau pour afficher les employés -->
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Poste</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($employes as $employe): ?>
            <tr>
                <td><?= $employe['id'] ?></td>
                <td><?= htmlspecialchars($employe['nom']) ?></td>
                <td><?= htmlspecialchars($employe['prenom']) ?></td>
                <td><?= htmlspecialchars($employe['email']) ?></td>
                <td><?= htmlspecialchars($employe['poste']) ?></td>
                <td><?= htmlspecialchars($employe['telephone']) ?></td>
                <td><?= htmlspecialchars($employe['adresse']) ?></td>
                <td>
                    <a href="?modifier_employe=<?= $employe['id'] ?>">Modifier</a>
                    <a href="?supprimer_employe=<?= $employe['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet employé?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
