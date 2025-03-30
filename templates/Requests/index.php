<h2>📥 Demandes en attente</h2>

<table>
    <thead>
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Genre</th>
            <th>Utilisateur</th>
            <th>Lien Spotify</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($requests as $request): ?>
            <?php $content = json_decode($request->content, true); ?>
            <tr>
                <td><?= h($request->type === 'album' ? 'Album' : 'Artiste') ?></td>
                <td><?= h($content['name'] ?? '-') ?></td>
                <td><?= h($content['genre'] ?? '-') ?></td>
                <td><?= h($request->user->username ?? '-') ?></td>
                <td>
                    <?php if (!empty($content['spotify_url'])): ?>
                        <a href="<?= h($content['spotify_url']) ?>" target="_blank">🔗 Écouter</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?= match($request->status) {
                        'pending' => '⏳ En attente',
                        'accepted' => '✅ Acceptée',
                        'rejected' => '❌ Rejetée',
                        default => '-'
                    }; ?>
                </td>
                <td>
                    <?php if ($request->status === 'pending'): ?>
                        <?= $this->Html->link('✅ Valider', ['action' => 'accept', $request->id], ['class' => 'button']) ?>
                        <?= $this->Html->link('❌ Rejeter', ['action' => 'reject', $request->id], [
                            'class' => 'button',
                            'confirm' => 'Tu es sûre de refuser cette demande ?'
                        ]) ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
