<?= $this->Form->create() ?>
<fieldset>
    <legend><?= __('Request Verification Code') ?></legend>
    <?= $this->Form->control('phone', ['label' => 'Phone Number']) ?>
</fieldset>
<?= $this->Form->button(__('Send Code')) ?>
<?= $this->Form->end() ?>