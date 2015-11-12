<?php
$this->set('title_for_layout', 'Tipo Servidor');
$this->extend('/Common/default');
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Tipo Servidor <small></small></h3>
    </div><!-- /.box-header -->
    <div class="mailbox-controls">
    </div>
    <?php echo $this->Form->create('ServidorTipo', array()); ?>
    <div class="box-body ">
        <?php
        echo $this->Form->hidden('id_tipo_servidor');
        echo $this->Form->input('nm_tipo_servidor', array('label' => 'Nome', 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->submit('Salvar', array('class' => 'btn btn-success'));
        echo $this->Form->end();
        ?>
    </div>
</div>