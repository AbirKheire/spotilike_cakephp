<h1>List of the albums and the artists </h1>
<?php foreach ($artists as $artist): ?>
    <div style="margin-bottom: 30px; padding: 15px; border: 1px solid #ccc; border-radius: 8px; background: #fff;">
        <h2><?= h($artist->name) ?></h2>

        <?php if (!empty($artist->albums)): ?>

            <?php if (!empty($artist->spotify_url)): ?>
                <?php
                    $spotifyPath = parse_url($artist->spotify_url, PHP_URL_PATH); 
                    $segments = explode('/', trim($spotifyPath, '/')); 
                    $spotifyType = $segments[1] ?? ''; 
                    $spotifyId = $segments[2] ?? ''; 
                ?>
                
                <?php if ($spotifyType === 'artist' && !empty($spotifyId)): ?>
                    <iframe
                        style="border-radius:12px; margin-top: 10px; margin-bottom: 15px"
                        src="https://open.spotify.com/embed/artist/<?= h($spotifyId) ?>"
                        width="300"
                        height="80"
                        frameborder="0"
                        allowtransparency="true"
                        allow="encrypted-media">
                    </iframe>
                <?php endif; ?>
            <?php endif; ?>

       
            <ul style="list-style: none; padding-left: 0;">
                <?php foreach ($artist->albums as $album): ?>
                    <li style="margin-bottom: 10px;">
                        <strong><?= h($album->title) ?> (<?= h($album->release_year) ?>)</strong><br>
                        
                        <?php if (!empty($album->spotify_url)): ?>
                            <?php
                                $albumSpotifyPath = parse_url($album->spotify_url, PHP_URL_PATH); 
                                $albumSegments = explode('/', trim($albumSpotifyPath, '/'));
                                $albumSpotifyId = $albumSegments[2] ?? '';
                            ?>
                            <?php if (!empty($albumSpotifyId)): ?>
                                <iframe
                                    style="border-radius:12px; margin-top: 5px"
                                    src="https://open.spotify.com/embed/album/<?= h($albumSpotifyId) ?>"
                                    width="300"
                                    height="80"
                                    frameborder="0"
                                    allowtransparency="true"
                                    allow="encrypted-media">
                                </iframe>
                            <?php endif; ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php else: ?>
            <p><em>No album found</em></p>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
