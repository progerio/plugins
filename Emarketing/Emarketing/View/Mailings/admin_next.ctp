<?php
$this->extend('/Common/admin_index');
$this->Html->addCrumb('', '/admin', array(
    'icon' => 'home'
))
    ->addCrumb(__d('croogo', 'E-mail Marketing'), array(
    'admin' => true,
    'plugin' => 'emarketing',
    'controller' => 'mailings',
    'action' => 'index'
))
    ->addCrumb(__d('croogo', 'Criar E-mail'), array(
    'admin' => true,
    'plugin' => 'emarketing',
    'controller' => 'mailings',
    'action' => 'add'
))
    ->addCrumb(__d('croogo', '2º Passo', '/' . $this->request->url));
?>
<?php $this->start('actions'); ?>

<?php $this->end(); ?>


<div class="row-fluid">
<?php
echo $this->Form->create('Sent', array(
    'url' => array(
        'controller' => 'mailings',
        'action' => 'admin_send'
    )
));
echo $this->Form->hidden('mailing_id', array(
    'value' => $mailing_id
));
?>
<div class="span6">
<div class="thumbnails">
    
    <div class="thumbnail">
    <?php echo $mailing['Mailing']['body']; ?>
    </div>
    </div>
    
 </div>
	<div class="span5">
		<table class="table table-bordered ">
<?php
$rows = array();
foreach ($mailings as $val) {
    $rows[] = array(
        $val['Outbox']['nome'],
        $val['Outbox']['to']
    );
}
echo $this->Html->tableCells($rows);
?>
 </table>
<?php
echo $this->Form->input('teste', array(
    'type' => 'checkbox',
    'label' => __d('croogo', 'Deseja enviar e-mail teste?'),
    'class' => false
));
echo $this->Form->submit('Enviar');
?>
</div>
</div>