<?php
// Inclure la connexion à la base de données
require 'db.php';

// Traitement du formulaire d'ajout de client
if (isset($_POST['ajouter_client'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    // Requête d'insertion
    $sql = "INSERT INTO clients (nom, prenom, email, telephone) VALUES (:nom, :prenom, :email, :telephone)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone
    ]);

    echo "<p class='success'>Client ajouté avec succès !</p>";
}

// Modifier un client
if (isset($_POST['modifier_client'])) {
    $id = $_POST['id'];
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    $telephone = htmlspecialchars($_POST['telephone']);

    $sql = "UPDATE clients SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone
    ]);
    echo "<p class='success'>Client modifié avec succès !</p>";
}

// Supprimer un client
if (isset($_GET['supprimer_client'])) {
    $id = $_GET['supprimer_client'];
    $sql = "DELETE FROM clients WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    echo "<p class='success'>Client supprimé avec succès !</p>";
}

// Récupérer tous les clients
$sql = "SELECT * FROM clients";
$stmt = $pdo->query($sql);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Clients</title>
    <link rel="stylesheet" href="main1.css"> <!-- Assurez-vous que ce fichier existe -->
</head>
<body>
    <div class="container">
        <h2>Gestion des Clients</h2>

        <!-- Formulaire pour ajouter ou modifier un client -->
        <form method="POST">
            <input type="hidden" name="id" value="<?= isset($_GET['modifier_client']) ? $_GET['modifier_client'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom" value="<?= isset($_GET['modifier_client']) ? $clients[array_search($_GET['modifier_client'], array_column($clients, 'id'))]['nom'] : '' ?>" required>
            <input type="text" name="prenom" placeholder="Prénom" value="<?= isset($_GET['modifier_client']) ? $clients[array_search($_GET['modifier_client'], array_column($clients, 'id'))]['prenom'] : '' ?>" required>
            <input type="email" name="email" placeholder="Email" value="<?= isset($_GET['modifier_client']) ? $clients[array_search($_GET['modifier_client'], array_column($clients, 'id'))]['email'] : '' ?>" required>
            <input type="text" name="telephone" placeholder="Téléphone" value="<?= isset($_GET['modifier_client']) ? $clients[array_search($_GET['modifier_client'], array_column($clients, 'id'))]['telephone'] : '' ?>" required>
            <?php if (isset($_GET['modifier_client'])): ?>
                <button type="submit" name="modifier_client">Modifier</button>
            <?php else: ?>
                <button type="submit" name="ajouter_client">Ajouter</button>
            <?php endif; ?>
        </form>

        <!-- Affichage des clients -->
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['id']) ?></td>
                <td><?= htmlspecialchars($client['nom']) ?></td>
                <td><?= htmlspecialchars($client['prenom']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['telephone']) ?></td>
                <td>
                    <a href="?modifier_client=<?= $client['id'] ?>" class="btn-modifier">Modifier</a>
                    <a href="?supprimer_client=<?= $client['id'] ?>" class="btn-supprimer">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
