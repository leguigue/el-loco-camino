<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>FromTom</title>
</head>
<body>
<div class="container">
    <header class="header">
        <h1>Bienvenue dans le fromage</h1>
        <a href="/logout" class="logout-btn">Déconnexion</a>
    </header>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message success"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="message error"><?php echo $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <section class="create-post">
        <h2>Créer un nouveau post</h2>
        <form action="/addPost" method="post" class="create-post-form">
            <div>
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="content">Contenu :</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <button type="submit">Publier</button>
        </form>
    </section>

    <section class="posts">
        <h2>Posts récents</h2>
        <?php if (isset($posts) && !empty($posts)): ?>
            <?php foreach ($posts as $post): ?>
                <article class="post" id="post-<?php echo $post->getId(); ?>">
                    <?php if (isset($_GET['edit']) && $_GET['edit'] == $post->getId() && $_SESSION['user_id'] == $post->getUserId()): ?>
                        <form action="/editPost" method="post" class="edit-post-form">
                            <input type="hidden" name="post_id" value="<?php echo $post->getId(); ?>">
                            <div>
                                <label for="edit-title-<?php echo $post->getId(); ?>">Titre :</label>
                                <input type="text" id="edit-title-<?php echo $post->getId(); ?>" name="title" value="<?php echo htmlspecialchars($post->getTitle()); ?>" required>
                            </div>
                            <div>
                                <label for="edit-content-<?php echo $post->getId(); ?>">Contenu :</label>
                                <textarea id="edit-content-<?php echo $post->getId(); ?>" name="content" required><?php echo htmlspecialchars($post->getContent()); ?></textarea>
                            </div>
                            <button type="submit">Enregistrer les modifications</button>
                            <a href="/">Annuler</a>
                        </form>
                    <?php else: ?>
                        <h3><?php echo htmlspecialchars($post->getTitle()); ?></h3>
                        <p><?php echo htmlspecialchars($post->getContent()); ?></p>
                        <small>Publié par : <?php echo htmlspecialchars($post->getUsername()); ?> le <?php echo $post->getCreatedAt(); ?></small>
                        <?php if ($post->isModified()): ?>
                            <small>(modifié)</small>
                        <?php endif; ?>
                        
                        <div class="post-actions">
                            <form action="/toggleLike" method="post">
                                <input type="hidden" name="target_id" value="<?php echo $post->getId(); ?>">
                                <input type="hidden" name="type" value="post">
                                <button type="submit">
                                    <?php echo LikeRepository::hasUserLiked($_SESSION['user_id'], $post->getId(), 'post') ? 'Je n\'aime plus' : 'J\'aime'; ?> 
                                    (<?php echo LikeRepository::getLikeCount($post->getId(), 'post'); ?>)
                                </button>
                            </form>
                            
                            <?php if ($_SESSION['user_id'] == $post->getUserId()): ?>
                                <a href="/?edit=<?php echo $post->getId(); ?>">Modifier</a>
                                <form action="/deletePost" method="post" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?');">
                                    <input type="hidden" name="post_id" value="<?php echo $post->getId(); ?>">
                                    <button type="submit">Supprimer</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="comments">
                        <h4>Commentaires:</h4>
                        <?php foreach ($post->getComments() as $comment): ?>
                            <div class="comment" id="comment-<?php echo $comment['id']; ?>">
                                <?php if ($comment['deleted']): ?>
                                    <p><em>Commentaire supprimé</em></p>
                                <?php elseif (isset($_GET['editComment']) && $_GET['editComment'] == $comment['id'] && $_SESSION['user_id'] == $comment['user_id']): ?>
                                    <form action="/editComment" method="post" class="edit-comment-form">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                        <textarea name="content" required><?php echo htmlspecialchars($comment['content']); ?></textarea>
                                        <button type="submit">Enregistrer</button>
                                        <a href="/">Annuler</a>
                                    </form>
                                <?php else: ?>
                                    <p>
                                        <strong><?php echo htmlspecialchars($comment['username'] ?? 'Utilisateur inconnu'); ?>:</strong>
                                        <?php echo htmlspecialchars($comment['content']); ?>
                                    </p>
                                    <small>
                                        Publié le <?php echo $comment['created_at']; ?>
                                        <?php if ($comment['modified']): ?>(modifié)<?php endif; ?>
                                    </small>
                                    
                                    <div class="comment-actions">
                                        <form action="/toggleLike" method="post">
                                            <input type="hidden" name="target_id" value="<?php echo $comment['id']; ?>">
                                            <input type="hidden" name="type" value="comment">
                                            <button type="submit">
                                                <?php echo LikeRepository::hasUserLiked($_SESSION['user_id'], $comment['id'], 'comment') ? 'Je n\'aime plus' : 'J\'aime'; ?> 
                                                (<?php echo LikeRepository::getLikeCount($comment['id'], 'comment'); ?>)
                                            </button>
                                        </form>
                                        
                                        <?php if ($_SESSION['user_id'] == $comment['user_id']): ?>
                                            <a href="/?editComment=<?php echo $comment['id']; ?>">Modifier</a>
                                            <form action="/deleteComment" method="post" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                                <button type="submit">Supprimer</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Formulaire de réponse au commentaire -->
                                    <form action="/addComment" method="post" class="reply-form">
                                        <input type="hidden" name="post_id" value="<?php echo $post->getId(); ?>">
                                        <input type="hidden" name="parent_id" value="<?php echo $comment['id']; ?>">
                                        <textarea name="content" required placeholder="Répondre à ce commentaire"></textarea>
                                        <button type="submit">Répondre</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <form action="/addComment" method="post" class="add-comment-form">
                            <input type="hidden" name="post_id" value="<?php echo $post->getId(); ?>">
                            <textarea name="content" required placeholder="Ajouter un commentaire"></textarea>
                            <button type="submit">Commenter</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun post disponible.</p>
        <?php endif; ?>
    </section>
</div>
</body>
</html>