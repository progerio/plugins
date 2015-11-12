<?php
$this->set('title_for_layout', 'Atividades');
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

<?php echo $this->Form->create('Atividade', array('url' => array('controller' => $this->request->controller, 'action' => 'process'))); ?>
<div class="box">
    <div class="box-header with-border">
<!--        <h3 class="box-title">Atividades</h3>-->
        <div class="mailbox-controls">
            <?php echo $this->Html->link('Nova Atividade', array('action' => 'add'), array('escape' => false, 'class' => 'btn btn-primary')) ?>
        </div>
    </div
   <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Atividade</th>
                <th>Usuario</th>
                <th>Cadastro em</th>
                <th>Descrição</th>
                <th>Projeto</th>
                <th>Funcionario</th>
                <th>Prioridade</th>
                <th>Previsto</th>
                <th>Situacao</th>
                <th></th>
                <th class="no-print "style="text-align: right" ><?php echo $this->Form->checkbox('todos', array('div' => false, 'label' => false, 'title' => 'Selecionar Todos', 'id' => 'todos', 'onclick' => 'checkAll(this)')) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($atividades as $atividade) { ?>
                <tr>
                    <td><?php echo $atividade['Atividade']['ID_Atividade'] ?></td>
                    <td><?php echo $atividade['Atividade']['NM_Atividade'] ?></td>
                    <td><?php echo $atividade['Atividade']['NM_Usuario'] ?></td>
                    <td><?php echo $this->Time->format('d/m/Y H:i:s', $atividade['Atividade']['DH_Cadastro']) ?></td>
                    <td><?php echo $atividade['Atividade']['TX_Descricao'] ?></td>
                    <td><?php echo $atividade['Atividade']['ID_Projeto'] ?></td>
                    <td><?php echo $atividade['Atividade']['NM_Funcionario'] ?></td>
                    <td><?php echo $atividade['Atividade']['NR_Prioridade'] ?></td>
                    <td><?php echo $atividade['Atividade']['QT_Esforco_Previsto'] ?></td>
                    <td><?php echo $atividade['Atividade']['NM_Situacao_Atividade'] ?></td>
                    <td width="10%"><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('action' => 'add', $atividade['Atividade']['ID_Atividade']), array('class' => 'btn btn-default no-print','escape'=>false,'title'=>'clique para editar')) ?>
                        <?php echo $this->Html->link('<i class="fa fa-trash"></i>', array('action' => 'delete', $atividade['Atividade']['ID_Atividade']), array('class' => 'btn btn-default  no-print', 'escape'=>false,'title'=>'clique para excluir'), 'Deseja realmente excluir?') ?></td>
                    <td width="2">
                        <?php
                        echo $this->Form->checkbox('Process.data.' . $atividade['Atividade']['ID_Atividade'] . '.check', array('class' => 'toselect no-print', 'title' => 'clique para excluir o item!'));
                        ?>
                    </td>   
                </tr>
            <?php } ?>
        </tbody>
    </table>
   </div>
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
</div>