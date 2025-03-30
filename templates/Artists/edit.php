<?php
/**
 * @var \App\View\AppView
 * @var \App\Model\Entity\Artist 
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $artist->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $artist->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Artists'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="artists form content">
            <?= $this->Form->create($artist) ?>
            <fieldset>
                <legend><?= __('Edit Artist') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('bio');
                    echo $this->Form->control('player');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
