<h1>Verify Code</h1>

<?= $this->Form->create(null, ['type' => 'post']) ?>
<div>
    <?= $this->Form->control('code', ['label' => 'Enter Verification Code', 'placeholder' => '123456', 'required' => true]) ?>
</div>
<div>
    <?= $this->Form->button(__('Submit')) ?>
</div>
<?= $this->Form->end() ?>

<?php if ($this->Flash->render()) : ?>
    <div class="alert alert-info">
        <?= $this->Flash->render() ?>
    </div>
<?php endif; ?>