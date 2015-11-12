<?php
$this->Html->script(array('Revista.editions'), false);
$this->Html->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Revista Novo Enfoque'), array('action' => 'index'))
        ->addCrumb(__d('croogo', 'Adicionar'), '/' . $this->request->here);
?>
<?php echo $this->Form->create('Edition'); ?>
<div class="row-fluid">
    <div class="span8">
        <?php
        echo $this->Form->hidden('id');
        echo $this->Form->input('titulo', array('label' => 'Titulo','class'=>'span10'));
        echo $this->Form->input('intro', array('label' => 'Texto introdutório','type'=>'textarea'));
        echo $this->Form->input('banner', array('label' => 'Imagem de capa'));
        echo $this->Form->input('descricao', array('type' => 'textarea', 'label' => 'Descrição'));
        echo $this->Form->input('params', array('type' => 'textarea', 'label' => 'links'));
        echo $this->Form->input('status',array('type'=>'checkbox','label'=>'status'));
       
        ?>
    </div>
    <div class="span4">
        <?php
        echo $this->Html->beginBox(__d('croogo', '#')) . $this->Form->button(__d('croogo', 'Salvar'), array('button' => 'default')) . $this->Html->link(__d('croogo', 'Cancelar'), array('action' => 'index'), array('button' => 'danger')) . $this->Html->endBox();
        $this->Croogo->adminBoxes();
        ?>
    </div>
</div>