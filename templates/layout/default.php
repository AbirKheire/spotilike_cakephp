<?php
/**
 * Spotiflow : Plateforme de gestion musicale
 * @var \App\View\AppView $this
 */
$appName = 'Spotiflow';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $appName ?> - <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <!-- Chargement de ton CSS artistique -->
    <?= $this->Html->css(['normalize.min', 'fonts', 'spotiflow']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Spoti</span>flow</a>
        </div>
        <div class="top-nav-links">
            <?php
            $authUser = $this->request->getSession()->read('Auth');

            if ($authUser) {
                echo '<span style="margin-right: 15px;">👤 Connectée en tant que <strong>' . h($authUser['username']) . '</strong></span>';
                echo $this->Html->link('Déconnexion', ['controller' => 'Users', 'action' => 'logout']);

                if ($authUser['role'] === 'user') {
                    echo ' | ' . $this->Html->link('📄 Mes demandes', ['controller' => 'Requests', 'action' => 'myRequests']);
                    echo ' | ' . $this->Html->link('➕ Proposer un ajout', ['controller' => 'Requests', 'action' => 'add']);
                }

                if ($authUser['role'] === 'admin') {
                    echo ' | ' . $this->Html->link('📋 Gérer les demandes', ['controller' => 'Requests', 'action' => 'index']);
                }

                echo ' | ' . $this->Html->link('📊 Statistiques', ['controller' => 'Stats', 'action' => 'index']);
            } else {
                echo $this->Html->link('Connexion', ['controller' => 'Users', 'action' => 'login']);
                echo ' | ' . $this->Html->link('Inscription', ['controller' => 'Users', 'action' => 'register']);
            }
            ?>
        </div>
    </nav>

    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>

    <footer>
    </footer>
</body>
</html>
