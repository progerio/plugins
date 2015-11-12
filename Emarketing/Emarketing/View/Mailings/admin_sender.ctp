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
    ->addCrumb(__d('croogo', '2º Passo', array(
    'admin' => true,
    'controller' => "mailings",
    'action' => 'admin_next'
)))
    ->addCrumb(__d('croogo', 'Enviando', '/' . $this->request->url));
?>
<?php $this->start('actions'); ?>

<?php $this->end(); ?>


<div class="row-fluid">

	<div class="span6">
	<div class="thumbnails">
    
    <div class="thumbnail">
    <?php echo $mailing['Mailing']['body']; ?>
    </div>
    </div>
 </div>
	<div class="span5">
		<div id="results">
		<?php echo $this->Form->create('Form1', array('name' => 'Form', 'type' => 'get', 'url' => array('plugin' => 'emarketing', 'admin' => true, 'controller' => 'mailings', 'action' => 'sender', 'mailing' => $mailing_id)))?>
		<?php echo $this->Form->end();?>
		<p>Nome: <?php echo $result['Outbox']['nome'];?></p>
		<p>E-mail<<?php echo $result['Outbox']['to'];?> </p>
		<?php ?></div>

	</div>
</div>
<script type="text/javascript">
    function submeter() {
        document.Form.submit();
    }
    window.setTimeout("submeter()", 1000);
</script>

