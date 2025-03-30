<h1>Add a new artist</h1>

<?= $this->Form->create($artist) ?>

    <?= $this->Form->control('name', ['label' => "Artist's name"]) ?>
    <?= $this->Form->control('bio', ['label' => 'Biography']) ?>
    <?= $this->Form->control('player', ['label' => 'Spotify Link']) ?>
    <?= $this->Form->button('Add') ?>
<?= $this->Form->end() ?>
