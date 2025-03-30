<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Album $album
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Album'), ['action' => 'edit', $album->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Album'), ['action' => 'delete', $album->id], ['confirm' => __('Are you sure you want to delete # {0}?', $album->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Albums'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Album'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="albums view content">
            <h3><?= h($album->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($album->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Player') ?></th>
                    <td><?= h($album->player) ?></td>
                </tr>
                <tr>
                    <th><?= __('Artist') ?></th>
                    <td><?= $album->hasValue('artist') ? $this->Html->link($album->artist->name, ['controller' => 'Artists', 'action' => 'view', $album->artist->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($album->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Year') ?></th>
                    <td><?= $this->Number->format($album->year) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($album->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($album->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Favorites') ?></h4>
                <?php if (!empty($album->favorites)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Album Id') ?></th>
                            <th><?= __('Artist Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($album->favorites as $favorite) : ?>
                        <tr>
                            <td><?= h($favorite->id) ?></td>
                            <td><?= h($favorite->user_id) ?></td>
                            <td><?= h($favorite->album_id) ?></td>
                            <td><?= h($favorite->artist_id) ?></td>
                            <td><?= h($favorite->created) ?></td>
                            <td><?= h($favorite->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Favorites', 'action' => 'view', $favorite->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Favorites', 'action' => 'edit', $favorite->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Favorites', 'action' => 'delete', $favorite->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $favorite->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>