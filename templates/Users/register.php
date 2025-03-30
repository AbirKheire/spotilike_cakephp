<?php if ($user->getErrors()): ?>
    <div class="alert alert-danger" style="padding: 10px; background-color: #f8d7da; color: #721c24; border-radius: 5px; margin-bottom: 15px;">
        <strong></strong> Field error
        <ul>
            <?php foreach ($user->getErrors() as $field => $errors): ?>
                <?php foreach ($errors as $error): ?>
                    <li><?= h($error) ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?= $this->Form->create($user) ?>
    <?= $this->Form->control('username', ['label' => 'Username']) ?>
    <?= $this->Form->control('email', ['label' => 'Email']) ?>
    <?= $this->Form->control('password', ['label' => 'Password']) ?>
    <?= $this->Form->button('Register') ?>
<?= $this->Form->end() ?>
