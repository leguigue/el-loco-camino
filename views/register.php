<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <form action="/register" method="post">
        <div>
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        </div>
        <div>
        <br><label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" required>
        </div>
        <br><button type="submit">S'inscrire</button>
    </form>
</body>
</html>