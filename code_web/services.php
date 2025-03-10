<?php
// Inclure la connexion à la base de données (si nécessaire)
require 'db.php';

// Traitement du formulaire RDP
if (isset($_POST['rdp_connect'])) {
    $rdp_host = $_POST['rdp_host'];
    $rdp_user = $_POST['rdp_user'];
    $rdp_password = $_POST['rdp_password'];

    // Logique de connexion RDP (exemple simple)
    echo "<p style='color: green;'>Connexion RDP réussie à $rdp_host avec l'utilisateur $rdp_user.</p>";
}

// Traitement du formulaire VNC
if (isset($_POST['vnc_connect'])) {
    $vnc_host = $_POST['vnc_host'];
    $vnc_user = $_POST['vnc_user'];
    $vnc_password = $_POST['vnc_password'];

    // Logique de connexion VNC (exemple simple)
    echo "<p style='color: green;'>Connexion VNC réussie à $vnc_host avec l'utilisateur $vnc_user.</p>";
}

// Traitement du formulaire noVNC
if (isset($_POST['novnc_connect'])) {
    $novnc_host = $_POST['novnc_host'];
    $novnc_user = $_POST['novnc_user'];
    $novnc_password = $_POST['novnc_password'];

    // Logique de connexion noVNC (exemple simple)
    echo "<p style='color: green;'>Connexion noVNC réussie à $novnc_host avec l'utilisateur $novnc_user.</p>";
}

// Traitement du formulaire FTP
if (isset($_POST['ftp_upload'])) {
    $ftp_host = $_POST['ftp_host'];
    $ftp_user = $_POST['ftp_user'];
    $ftp_password = $_POST['ftp_password'];
    $ftp_file = $_FILES['ftp_file'];

    // Connexion au serveur FTP
    $conn = ftp_connect($ftp_host);
    if ($conn && ftp_login($conn, $ftp_user, $ftp_password)) {
        // Téléverser le fichier
        if (ftp_put($conn, $ftp_file['name'], $ftp_file['tmp_name'], FTP_BINARY)) {
            echo "<p style='color: green;'>Fichier transféré avec succès !</p>";
        } else {
            echo "<p style='color: red;'>Erreur lors du transfert du fichier.</p>";
        }
        ftp_close($conn);
    } else {
        echo "<p style='color: red;'>Erreur de connexion au serveur FTP.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Services</title>
    <!-- Inclure FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Reset des styles par défaut */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Style général du corps de la page */
        /* Style général du corps de la page */
body {
    background: linear-gradient(135deg, #1e3c72, #2a5298); /* Dégradé bleu profond */
    color: #333; /* Conserver la couleur du texte d'origine */
    line-height: 1.6;
    padding: 20px;
}
        }

        /* Conteneur principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        /* Animation d'apparition */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Titres */
        h1, h2 {
            color: #444;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5em;
            text-align: center;
        }

        h2 {
            font-size: 2em;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        /* Boutons de service */
        .btn-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background-color: #28a745; /* Couleur verte comme le bouton "Ajouter" */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.2em;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #218838; /* Couleur au survol */
            transform: translateY(-5px);
        }

        /* Formulaires */
        .form-container {
            margin-top: 20px;
            display: none; /* Masqué par défaut */
            animation: slideDown 0.5s ease-in-out;
        }

        .form-container.active {
            display: block; /* Afficher le formulaire actif */
        }

        /* Animation de défilement */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }

        form button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gestion des Services</h1>

        <!-- Boutons de service -->
        <div class="btn-container">
            <button class="btn" onclick="showForm('rdp')">
                <i class="fas fa-desktop"></i> Connexion RDP
            </button>
            <button class="btn" onclick="showForm('vnc')">
                <i class="fas fa-tv"></i> Connexion VNC
            </button>
            <button class="btn" onclick="showForm('novnc')">
                <i class="fas fa-globe"></i> Connexion noVNC
            </button>
            <button class="btn" onclick="showForm('ftp')">
                <i class="fas fa-file-upload"></i> Transfert FTP
            </button>
        </div>

        <!-- Formulaire RDP -->
        <div id="rdp-form" class="form-container">
            <h2><i class="fas fa-desktop"></i> Connexion RDP</h2>
            <form method="POST" action="">
                <input type="text" name="rdp_host" placeholder="Adresse du serveur" required>
                <input type="text" name="rdp_user" placeholder="Nom d'utilisateur" required>
                <input type="password" name="rdp_password" placeholder="Mot de passe" required>
                <button type="submit" name="rdp_connect">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
        </div>

        <!-- Formulaire VNC -->
        <div id="vnc-form" class="form-container">
            <h2><i class="fas fa-tv"></i> Connexion VNC</h2>
            <form method="POST" action="">
                <input type="text" name="vnc_host" placeholder="Adresse du serveur" required>
                <input type="text" name="vnc_user" placeholder="Nom d'utilisateur" required>
                <input type="password" name="vnc_password" placeholder="Mot de passe" required>
                <button type="submit" name="vnc_connect">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
        </div>

        <!-- Formulaire noVNC -->
        <div id="novnc-form" class="form-container">
            <h2><i class="fas fa-globe"></i> Connexion noVNC</h2>
            <form method="POST" action="">
                <input type="text" name="novnc_host" placeholder="Adresse du serveur" required>
                <input type="text" name="novnc_user" placeholder="Nom d'utilisateur" required>
                <input type="password" name="novnc_password" placeholder="Mot de passe" required>
                <button type="submit" name="novnc_connect">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
        </div>

        <!-- Formulaire FTP -->
        <div id="ftp-form" class="form-container">
            <h2><i class="fas fa-file-upload"></i> Transfert FTP</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="text" name="ftp_host" placeholder="Adresse du serveur" required>
                <input type="text" name="ftp_user" placeholder="Nom d'utilisateur" required>
                <input type="password" name="ftp_password" placeholder="Mot de passe" required>
                <input type="file" name="ftp_file" required>
                <button type="submit" name="ftp_upload">
                    <i class="fas fa-upload"></i> Transférer
                </button>
            </form>
        </div>
    </div>

    <script>
        // Fonction pour afficher le formulaire correspondant au service sélectionné
        function showForm(service) {
            // Masquer tous les formulaires
            document.querySelectorAll('.form-container').forEach(form => {
                form.classList.remove('active');
            });

            // Afficher le formulaire correspondant
            document.getElementById(`${service}-form`).classList.add('active');
        }
    </script>
</body>
</html>
