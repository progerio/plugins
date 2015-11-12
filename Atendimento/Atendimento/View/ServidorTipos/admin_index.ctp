<?php
$this->set('title_for_layout', 'Tipo de Servidores');
$this->extend('/Common/default_atendimento');
?>
<?php
echo $this->Html->scriptBlock('
    function checkAll(e) {
        var boxes = document.getElementsByTagName("input");
        for (var x = 0; x < boxes.length; x++) {
            var obj = boxes[x];
            if (obj.type == "checkbox") {
                if (obj.name != "chkAll")
                    obj.checked = e.checked;
            }
        }
    }');
?>
<?php echo $this->Form->create('ServidorTipo', array('url' => array('controller' => $this->request->controller, 'action' => 'process'))); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Itens Tipo Servidor</h3>
        <div class="mailbox-controls">
            <?php echo $this->Html->link('Novo Tipo', array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-primary')); ?>
        </div>
    </div>    
    <table class="table table-striped ">
        <thead>
            <tr>
                <th>ID</th>
                <th width="80%">TIPO DE SERVIDOR</th>
                <th>AÇÕES</th>
                <th class="no-print "style="text-align: right" ><?php echo $this->Form->checkbox('todos', array('div' => false, 'label' => false, 'title' => 'Selecionar Todos', 'id' => 'todos', 'onclick' => 'checkAll(this)')) ?></th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($servidorTipos as $tipo) { ?>
                <tr>
                    <td><?php echo $tipo['ServidorTipo']['id_tipo_servidor'] ?></td>
                    <td><?php echo $tipo['ServidorTipo']['nm_tipo_servidor'] ?></td>
                    <td><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'add', $tipo['ServidorTipo']['id_tipo_servidor']), array('class' => 'btn btn-default no-print','title'=>'clique para editar','escape'=>false)) ?>
                        <?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $tipo['ServidorTipo']['id_tipo_servidor']), array('class' => 'btn btn-default no-print','title'=>'clique para excluir','escape'=>false), 'Deseja realmente excluir?') ?></td>
                    <td width="2">
                        <?php
                        echo $this->Form->checkbox('Process.data.' . $tipo['ServidorTipo']['id_tipo_servidor'] . '.check', array('class' => 'toselect no-print', 'title' => 'clique para excluir o item!'));
                        ?>
                    </td>   
                </tr>
            </tbody>
        <?php } ?> 
    </table>
    <div class="box-footer clearfix">
        <div class="row">
            <div class="col-md-4">
                <div class="pull-left">
                    <div class="input-group">
                        <?php
                        echo $this->Form->input('Process.action', array(
                            'class' => 'form-control no-print',
                            'label' => false,
                            'div' => false,
                            'options' => array(
                                'delete' => 'Excluir',
                            ),
                            'empty' => 'Selecione a ação...',
                        ));
                        ?>
                        <span class="input-group-btn">
                            <?php echo $this->Form->submit('Executar', array('class' => 'btn btn-default, btn-success no-print')); ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-8 no-print">

            </div>
        </div>
    </div>
    <?php echo $this->Form->end() ?>
    <?php //echo $this->element('Atendimento.paginacao'); ?>
</div>