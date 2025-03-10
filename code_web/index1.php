<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smarttech - Gestion CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Pour les icônes -->
    <style>
        /* Style général de la page */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Dégradé bleu profond */
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* En-tête */
        header {
            width: 100%;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5); /* Fond semi-transparent */
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            font-size: 2.5rem;
            color: #fff;
        }

        /* Conteneur principal */
        .container {
            max-width: 800px;
            width: 100%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1); /* Fond semi-transparent */
            border-radius: 15px;
            backdrop-filter: blur(10px); /* Effet de flou */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-top: 100px; /* Pour éviter que le contenu ne chevauche l'en-tête */
        }

        /* Tableau de bord */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        /* Boutons du tableau de bord */
        .bouton-dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            font-size: 1.2rem;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .bouton-dashboard i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .bouton-dashboard:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-5px);
        }

        /* Boutons de paramètres et déconnexion */
        .bouton-utilisateur {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 10px;
        }

        .bouton-utilisateur a {
            color: #fff;
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .bouton-utilisateur a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <h1>Bienvenue dans le site de Smarttech</h1>
    </header>

    <!-- Boutons de paramètres et déconnexion -->
    <div class="bouton-utilisateur">
        <a href="parametres.php" title="Paramètres"><i class="fas fa-cog"></i></a>
        <a href="deconnexion.php" title="Déconnexion"><i class="fas fa-sign-out-alt"></i></a>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <h2>Tableau de Bord</h2>
        <div class="dashboard">
            <a href="clients.php" class="bouton-dashboard">
                <i class="fas fa-users"></i>
                Gestion des Clients
            </a>
            <a href="documents.php" class="bouton-dashboard">
                <i class="fas fa-file-alt"></i>
                Gestion des Documents
            </a>
            <a href="employes.php" class="bouton-dashboard">
                <i class="fas fa-briefcase"></i>
                Gestion des Employés
            </a>
            <a href="services.php" class="bouton-dashboard">
                <i class="fas fa-cogs"></i>
                Accéder aux Services
            </a>
        </div>
    </div>
</body>
</html>

