<h2>Add an album</h2>

<?= $this->Form->create($album) ?>

<?= $this->Form->control('title', ['label' => "Album's title"]) ?>
<?= $this->Form->control('release_year', ['label' => 'Release year']) ?>
<?= $this->Form->control('spotify_url', ['label' => 'Spotify Link']) ?>
<?= $this->Form->control('artist_id', [
    'label' => 'Related Artist',
    'options' => $artists,
    'empty' => 'Select an artist'
]) ?>

<?= $this->Form->button('Add') ?>
<?= $this->Form->end() ?>
