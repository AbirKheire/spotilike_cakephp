
<?php if ($this->Flash->render()): ?>
    <div id="toast" class="toast-success">
        <?= $this->Flash->render() ?>
    </div>
<?php endif; ?>

<style>
.toast-success {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #28a745;
    color: white;
    padding: 15px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    z-index: 9999;
    animation: fadeInOut 4s forwards;
    font-weight: bold;
}

@keyframes fadeInOut {
    0% { opacity: 0; transform: translateY(-10px); }
    10% { opacity: 1; transform: translateY(0); }
    90% { opacity: 1; transform: translateY(0); }
    100% { opacity: 0; transform: translateY(-10px); }
}
</style>



<?= $this->Form->create($request) ?>

<?= $this->Form->control('type', [
    'options' => ['artist' => 'Artiste', 'album' => 'Album'],
    'label' => 'Type de demande',
    'id' => 'type-select'
]) ?>

<?= $this->Form->control('content_name', ['label' => 'Nom']) ?>
<?= $this->Form->control('content_genre', ['label' => 'Genre']) ?>

<!-- Champ artiste à afficher seulement si "album" est sélectionné -->
<div id="artist-select-wrapper" style="display: none;">
    <?= $this->Form->control('artist_id', [
        'label' => 'Artiste existant',
        'options' => $artistsList,
        'disabled' => true,
        'empty' => '-- Sélectionner un artiste --'
    ]) ?>

    <!-- Champ readonly pour stocker le nom sélectionné -->
    <?= $this->Form->control('artist_name', [
        'label' => 'Nom de l’artiste sélectionné',
        'readonly' => true
    ]) ?>
</div>

<?= $this->Form->control('release_year', ['label' => 'Année de sortie']) ?>
<?= $this->Form->control('spotify_url', ['label' => 'URL Spotify']) ?>

<?= $this->Form->button('Envoyer la demande') ?>
<?= $this->Form->end() ?>

<script>
    const typeSelect = document.getElementById('type-select');
    const artistWrapper = document.getElementById('artist-select-wrapper');
    const artistField = document.getElementById('artist-id');
    const artistNameField = document.getElementById('artist-name');

    function toggleArtistField() {
        const isAlbum = typeSelect.value === 'album';
        artistWrapper.style.display = isAlbum ? 'block' : 'none';
        artistField.disabled = !isAlbum;
        artistNameField.disabled = !isAlbum;
    }

    function syncArtistName() {
        const selectedOption = artistField.options[artistField.selectedIndex];
        artistNameField.value = selectedOption.text;
    }

    document.addEventListener('DOMContentLoaded', () => {
        toggleArtistField();
        syncArtistName();
    });

    typeSelect.addEventListener('change', toggleArtistField);
    artistField.addEventListener('change', syncArtistName);
</script>
