<?php
// Inclure la connexion à la base de données
require 'db.php';

// Ajouter un document
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter'])) {
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $taille = $_POST['taille'];

    $sql = "INSERT INTO documents (nom, type, taille) VALUES (:nom, :type, :taille)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nom' => $nom, 'type' => $type, 'taille' => $taille]);
}

// Supprimer un document
if (isset($_GET['supprimer'])) {
    $id = $_GET['supprimer'];
    $sql = "DELETE FROM documents WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
}

// Modifier un document
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier'])) {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $type = $_POST['type'];
    $taille = $_POST['taille'];

    $sql = "UPDATE documents SET nom = :nom, type = :type, taille = :taille WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id, 'nom' => $nom, 'type' => $type, 'taille' => $taille]);
}

// Récupérer tous les documents
$sql = "SELECT id, nom, type, taille, date_upload FROM documents ORDER BY date_upload DESC";
$stmt = $pdo->query($sql);
$documents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Documents</title>
    <link rel="stylesheet" href="main1.css"> <!-- Assurez-vous que le fichier CSS est le même -->
</head>
<body>
    <div class="container">
        <h2>Gestion des Documents</h2>

        <!-- Formulaire pour ajouter ou modifier un document -->
        <form method="POST" action="documents.php">
            <input type="hidden" name="id" value="<?= isset($_GET['modifier']) ? $_GET['modifier'] : '' ?>">
            <input type="text" name="nom" placeholder="Nom du document" value="<?= isset($_GET['modifier']) ? $documents[array_search($_GET['modifier'], array_column($documents, 'id'))]['nom'] : '' ?>" required>
            <input type="text" name="type" placeholder="Type du document" value="<?= isset($_GET['modifier']) ? $documents[array_search($_GET['modifier'], array_column($documents, 'id'))]['type'] : '' ?>" required>
            <input type="number" name="taille" placeholder="Taille (en octets)" value="<?= isset($_GET['modifier']) ? $documents[array_search($_GET['modifier'], array_column($documents, 'id'))]['taille'] : '' ?>" required>
            <?php if (isset($_GET['modifier'])): ?>
                <button type="submit" name="modifier">Modifier</button>
            <?php else: ?>
                <button type="submit" name="ajouter">Ajouter</button>
            <?php endif; ?>
        </form>

        <!-- Tableau pour afficher les documents -->
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Taille (octets)</th>
                    <th>Date d'Upload</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($documents) > 0): ?>
                    <?php foreach ($documents as $document): ?>
                        <tr>
                            <td><?= htmlspecialchars($document['id']) ?></td>
                            <td><?= htmlspecialchars($document['nom']) ?></td>
                            <td><?= htmlspecialchars($document['type']) ?></td>
                            <td><?= htmlspecialchars($document['taille']) ?></td>
                            <td><?= htmlspecialchars($document['date_upload']) ?></td>
                            <td>
                                <a href="?modifier=<?= $document['id'] ?>">Modifier</a>
                                <a href="?supprimer=<?= $document['id'] ?>" class="btn-supprimer">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">Aucun document trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
