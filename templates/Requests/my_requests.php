<h2>Mes demandes</h2>

<?php if ($requests->isEmpty()): ?>
    <p>Tu n’as fait aucune demande pour le moment.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Nom</th>
                <th>Genre</th>
                <th>Spotify</th>
                <th>Statut</th>
                <th>Envoyée le</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
                <?php $content = json_decode($request->content, true); ?>
                <tr>
                    <td><?= h($request->type) ?></td>
                    <td><?= h($content['name'] ?? '-') ?></td>
                    <td><?= h($content['genre'] ?? '-') ?></td>
                    <td>
                        <?php if (!empty($content['spotify_url'])): ?>
                            <a href="<?= h($content['spotify_url']) ?>" target="_blank">Écouter</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            echo match ($request->status) {
                                'pending' => '⏳ En attente',
                                'accepted' => '✅ Acceptée',
                                'rejected' => '❌ Rejetée',
                                default => '-'
                            };
                        ?>
                    </td>
                    <td><?= $request->created->format('d/m/Y H:i') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
