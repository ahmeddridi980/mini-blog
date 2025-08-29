<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("INSERT INTO articles (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);

    header("Location: index.php");
    exit;
}
?>
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel Article | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --light: #f8fafc;
            --dark: #1e293b;
            --success: #10b981;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        
        header {
            background: var(--primary);
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 28px;
        }
        
        .subtitle {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .form-container {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--secondary);
        }
        
        input[type="text"], textarea {
            width: 100%;
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
        }
        
        textarea {
            min-height: 200px;
            resize: vertical;
        }
        
        .btn {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--primary);
        }
        
        .back-link::before {
            content: "←";
            margin-right: 8px;
        }
        
        @media (max-width: 600px) {
            .container {
                border-radius: 0;
            }
            
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Ajouter un article</h1>
            <p class="subtitle">Remplissez le formulaire pour publier un nouvel article</p>
        </header>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="title">Titre de l'article</label>
                    <input type="text" id="title" name="title" placeholder="Entrez un titre accrocheur" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea id="content" name="content" placeholder="Rédigez le contenu de votre article ici..." required></textarea>
                </div>
                
                <div class="btn-container">
                    <button type="submit" class="btn">Publier l'article</button>
                </div>
            </form>
            
            <div class="btn-container">
                <a href="index.php" class="back-link">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</body>
</html>
