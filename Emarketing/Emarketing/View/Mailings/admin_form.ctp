<?php
$this->extend('/Common/admin_edit');

$this->Html->addCrumb('', '/admin', array(
    'icon' => 'home'
))->addCrumb(__d('croogo', 'Emarketing'), array(
    'plugin' => 'emarketing',
    'controller' => 'mailings',
    'action' => 'index'
));

if ($this->request->params['action'] == 'admin_edit') {
    $this->Html->addCrumb($this->request->data['Mailing']['title'], '/' . $this->request->url);
}

if ($this->request->params['action'] == 'admin_add') {
    $this->Html->addCrumb(__d('croogo', 'Criar E-mail'), '/' . $this->request->url);
}

echo $this->Form->create('Mailing',array('enctype'=>'multipart/form-data','action'=>'admin_add'));

?>
<div class="row-fluid">
	<div class="span8">

		<ul class="nav nav-tabs">
		<?php
echo $this->Croogo->adminTab(__d('croogo', 'Mensagem'), '#menu-basic');
// echo $this->Croogo->adminTab(__d('croogo', 'Lista'), '#menu-misc');
echo $this->Croogo->adminTabs();
?>
		</ul>

		<div class="tab-content">
			<div id="menu-basic" class="tab-pane">
			<?php

echo $this->Form->input('id');
echo $this->Form->hidden('from', array(
    'value' => 'progerio@castelobranco.br'
));

$this->Form->inputDefaults(array(
    'class' => 'span10'
));
echo $this->Form->input('title', array(
    'label' => __d('croogo', 'Title')
));
 echo $this->Form->input('file', array('type' => 'file', 'label' => false ));

echo $this->Form->input('body', array(
    'type' => 'textarea',
    'label' => false
));

echo $this->Form->hidden('status',array('value'=>0));
?>
			</div>

			<div id="menu-misc" class="tab-pane">
			<?php

?>
			</div>

			<?php echo $this->Croogo->adminTabs(); ?>
		</div>
	</div>

	<div class="span4">
		<?php
echo $this->Html->beginBox('') .


 $this->Form->button(__d('croogo', 'Avançar'), array(
    'button' => 'default'
), array(
    'class' => 'success'
)) . $this->Html->link(__d('croogo', 'Cancel'), array(
    'action' => 'index'
), array(
    'button' => 'danger'
)) . $this->Html->endBox();

$this->Croogo->adminBoxes();
?>
	</div>

</div>
<?php echo $this->Form->end(); ?>
