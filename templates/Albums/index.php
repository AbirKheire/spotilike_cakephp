/ templates/Albums/index.php
<h1>All albums</h1>

<?= $this->Html->link(
    'Ajouter un album',
    ['action' => 'add'],
    ['class' => 'button', 'style' => 'margin-bottom: 20px; display: inline-block; padding: 10px; background-color: #1DB954; color: white; border-radius: 5px; text-decoration: none;']
) ?>

<div style="display: flex; flex-wrap: wrap; gap: 20px;">
    <?php foreach ($albums as $album): ?>
        <div style="border: 1px solid #ccc; border-radius: 8px; padding: 10px; width: 300px; background: #f9f9f9;">
            <h3><?= h($album->title) ?> (<?= h($album->release_year) ?>)</h3>
            <p><strong>Artiste :</strong> <?= h($album->artist->name) ?></p>

            <?php if (!empty($album->spotify_url)): ?>
                <iframe
                    style="border-radius:12px"
                    src="https://open.spotify.com/embed/album/<?= h(trim(parse_url($album->spotify_url, PHP_URL_PATH), '/')) ?>"
                    width="100%"
                    height="80"
                    frameborder="0"
                    allowtransparency="true"
                    allow="encrypted-media">
                </iframe>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>