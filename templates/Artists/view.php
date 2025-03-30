<h2><?= h($artist->name) ?></h2>

<p><strong>Description :</strong> <?= h($artist->description) ?></p>

<h3>Albums</h3>
<?php if (!empty($artist->albums)): ?>
    <ul>
        <?php foreach ($artist->albums as $album): ?>
            <li>
                <strong><?= h($album->title) ?></strong> (<?= h($album->release_year) ?>)

                <?php if (!empty($album->spotify_id)): ?>
                    <div style="margin-top: 5px; margin-bottom: 15px;">
                        <iframe
                            style="border-radius:12px"
                            src="https://open.spotify.com/embed/album/<?= h($album->spotify_id) ?>"
                            width="300"
                            height="80"
                            frameborder="0"
                            allowtransparency="true"
                            allow="encrypted-media">
                        </iframe>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No album found</p>
<?php endif; ?>
