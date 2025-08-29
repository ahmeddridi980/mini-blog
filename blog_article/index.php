<?php
require 'config.php';
$stmt = $pdo->query("select * from article");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Blog | Accueil</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --light: #f8fafc;
            --dark: #1e293b;
            --success: #10b981;
            --border: #e2e8f0;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--primary);
            font-size: 32px;
        }
        
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }
        
        .articles-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .article-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .article-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }
        
        .article-content {
            padding: 20px;
            flex-grow: 1;
        }
        
        .article-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 12px;
            color: var(--dark);
        }
        
        .article-text {
            color: var(--secondary);
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background: var(--light);
            border-top: 1px solid var(--border);
        }
        
        .article-date {
            font-size: 14px;
            color: var(--secondary);
        }
        
        .article-actions {
            display: flex;
            gap: 15px;
        }
        
        .action-btn {
            color: var(--secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .action-btn:hover {
            color: var(--primary);
        }
        
        .edit-btn:hover {
            color: var(--primary);
        }
        
        .delete-btn:hover {
            color: #ef4444;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            grid-column: 1 / -1;
        }
        
        .empty-state i {
            font-size: 48px;
            color: var(--secondary);
            margin-bottom: 20px;
        }
        
        .empty-state p {
            font-size: 18px;
            color: var(--secondary);
            margin-bottom: 25px;
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .articles-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-blog"></i> Mini Blog</h1>
            <a href="create.php" class="btn-primary">
                <i class="fas fa-plus"></i> Nouvel Article
            </a>
        </header>
        
        <div class="articles-container">
            <?php if (count($articles) > 0): ?>
                <?php foreach ($articles as $article): ?>
                    <div class="article-card">
                        <div class="article-content">
                            <h2 class="article-title"><?= htmlspecialchars($article['title']) ?></h2>
                            <p class="article-text"><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                        </div>
                        <div class="article-meta">
                            <span class="article-date">
                                <i class="far fa-calendar"></i> <?= date('d/m/Y', strtotime($article['created_at'])) ?>
                            </span>
                            <div class="article-actions">
                                <a href="edit.php?id=<?= $article['id'] ?>" class="action-btn edit-btn">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="delete.php?id=<?= $article['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Supprimer cet article ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-file-alt"></i>
                    <p>Aucun article pour le moment</p>
                    <a href="create.php" class="btn-primary">
                        <i class="fas fa-plus"></i> Créer le premier article
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Confirmation de suppression améliorée
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ? Cette action est irréversible.')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>



