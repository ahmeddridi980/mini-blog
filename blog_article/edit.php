<?php
require 'config.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Article introuvable !");
}

// Récupérer l'article existant
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    die("Article introuvable !");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE articles SET title=?, content=? WHERE id=?");
    $stmt->execute([$title, $content, $id]);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article | Mini Blog</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --light: #f8fafc;
            --dark: #1e293b;
            --warning: #f59e0b;
            --warning-dark: #d97706;
            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
            background: var(--warning);
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }
        
        header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--warning), var(--warning-dark));
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
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
            display: flex;
            align-items: center;
            gap: 8px;
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
            border-color: var(--warning);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
        }
        
        textarea {
            min-height: 250px;
            resize: vertical;
            line-height: 1.7;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn-warning {
            background: var(--warning);
            color: white;
        }
        
        .btn-warning:hover {
            background: var(--warning-dark);
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }
        
        .btn-secondary {
            background: var(--secondary);
            color: white;
        }
        
        .btn-secondary:hover {
            background: #475569;
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }
        
        .btn-container {
            display: flex;
            gap: 15px;
            margin-top: 25px;
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .back-link:hover {
            color: var(--warning);
        }
        
        .char-count {
            text-align: right;
            font-size: 14px;
            color: var(--secondary);
            margin-top: 5px;
        }
        
        @media (max-width: 600px) {
            .container {
                border-radius: 0;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .btn-container {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-edit"></i> Modifier l'article</h1>
            <p class="subtitle">Mettez à jour le contenu de votre article</p>
        </header>
        
        <div class="form-container">
            <form method="POST" id="articleForm">
                <div class="form-group">
                    <label for="title"><i class="fas fa-heading"></i> Titre de l'article</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($article['title']) ?>" required>
                    <div class="char-count"><span id="titleCharCount">0</span>/120 caractères</div>
                </div>
                
                <div class="form-group">
                    <label for="content"><i class="fas fa-align-left"></i> Contenu</label>
                    <textarea id="content" name="content" required><?= htmlspecialchars($article['content']) ?></textarea>
                    <div class="char-count"><span id="contentCharCount">0</span>/5000 caractères</div>
                </div>
                
                <div class="btn-container">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Compteur de caractères
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');
        const titleCharCount = document.getElementById('titleCharCount');
        const contentCharCount = document.getElementById('contentCharCount');
        
        // Initialiser les compteurs
        titleCharCount.textContent = titleInput.value.length;
        contentCharCount.textContent = contentInput.value.length;
        
        // Mettre à jour les compteurs lors de la saisie
        titleInput.addEventListener('input', () => {
            titleCharCount.textContent = titleInput.value.length;
            
            // Limiter à 120 caractères
            if (titleInput.value.length > 120) {
                titleInput.value = titleInput.value.substring(0, 120);
                titleCharCount.textContent = 120;
            }
        });
        
        contentInput.addEventListener('input', () => {
            contentCharCount.textContent = contentInput.value.length;
            
            // Limiter à 5000 caractères
            if (contentInput.value.length > 5000) {
                contentInput.value = contentInput.value.substring(0, 5000);
                contentCharCount.textContent = 5000;
            }
        });
        
        // Confirmation avant de quitter si des modifications ont été faites
        let formChanged = false;
        const initialTitle = titleInput.value;
        const initialContent = contentInput.value;
        
        titleInput.addEventListener('input', () => {
            formChanged = titleInput.value !== initialTitle || contentInput.value !== initialContent;
        });
        
        contentInput.addEventListener('input', () => {
            formChanged = titleInput.value !== initialTitle || contentInput.value !== initialContent;
        });
        
        window.addEventListener('beforeunload', (e) => {
            if (formChanged) {
                e.preventDefault();
                e.returnValue = '';
            }
        });
        
        // Réinitialiser formChanged lors de la soumission
        document.getElementById('articleForm').addEventListener('submit', () => {
            formChanged = false;
        });
    </script>
</body>
</html>