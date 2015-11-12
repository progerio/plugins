<?php

$this->Html->script(array('Revista.editions'), false);
$this->Html->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Revista Novo Enfoque'), array('controller'=>'editions','action' => 'index'))
        ->addCrumb(__d('croogo', 'Artigos'), array('action' => 'index','edicao'=>$edicao_id))
        ->addCrumb(__d('croogo', 'Adicionar'), '/' . $this->request->here);
?>

<?php // echo $this->Form->create('Artigo',array('type'=>'file','url'=>array('controller'=>'artigos','action'=>'admin_add'))); ?>
<?php echo $this->Form->create('Artigo',array('type'=>'file')); ?>
<div class="row-fluid">
    <div class="span8">
        <?php
        echo $this->Form->hidden('id');
        echo $this->Form->hidden('edicao_id',array('value'=>$edicao_id));
        echo $this->Form->hidden('weight');
        echo $this->Form->input('titulo', array('label' => 'Titulo','class'=>'span10'));
        echo $this->Form->input('resumo', array('label' => 'Resumo','type'=>'textarea'));
        echo $this->Form->input('autores', array('type'=>'textarea','label' => 'Autores'));
        echo $this->Form->input('arquivo', array('type' => 'file', 'label' => 'Arquivo:'));
        echo $this->Form->input('status', array('type' => 'checkbox', 'label' => 'status'));
       
        ?>
    </div>
    <div class="span4">
        <?php
        echo $this->Html->beginBox(__d('croogo', '#')) . $this->Form->button(__d('croogo', 'Salvar'), array('button' => 'default')) . $this->Html->link(__d('croogo', 'Cancelar'), array('action' => 'index','edicao'=>$edicao_id), array('button' => 'danger')) . $this->Html->endBox();
        $this->Croogo->adminBoxes();
        ?>
    </div>
</div>
