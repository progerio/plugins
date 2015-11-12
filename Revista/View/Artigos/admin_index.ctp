<?php
$this->extend('/Common/admin_index');
$this->Html->script(array('Revista.editions'), false);
$this->Html->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Revista Novo Enfoque'), array('plugin' => 'revista', 'controller' => 'editions'))
        ->addCrumb(__d('croogo', 'Artigos'), '/' . $this->request->url);
?>
<?php $this->start('actions'); ?>
<?php
echo $this->Croogo->adminAction(__d('croogo', 'Novo Artigo'), array('action' => 'add','edicao'=>$edicao_id), array('button' => 'success'));
?>
<?php $this->end(); ?>
<?php
//echo $this->element('admin/artigos_search');
echo $this->Form->create('Artigo', array('url' => array('controller' => 'artigos', 'action' => 'process'), 'class' => 'form-inline'));
echo $this->Form->hidden('edicao_id', array('value' => $edicao_id));
?>
<div class="row-fluid">
    <div class="span12">

        <?php
        $tableHeaders = $this->Html->tableHeaders(array(
            '',
            $this->Paginator->sort('id', __d('croogo', 'Id')),
            $this->Paginator->sort('titulo', __d('croogo', 'Titulo')),
            $this->Paginator->sort('resumo', __d('croogo', 'Resumo')),
            $this->Paginator->sort('autores', __d('croogo', 'Autores')),
            'Arquivo',
            $this->Paginator->sort('status', __d('croogo', 'Status')),
            ''
        ));
        $rows = array();
        foreach ($Artigos as $artigo):
            $actions = array();
            $actions[] = $this->Croogo->adminRowActions($artigo['Artigo']['id']);
            $actions[] = $this->Croogo->adminRowAction('', array('action' => 'moveup', $artigo['Artigo']['id'], $edicao_id), array('icon' => 'chevron-up', 'tooltip' => __d('croogo', 'Move up')));
            $actions[] = $this->Croogo->adminRowAction('', array('action' => 'movedown', $artigo['Artigo']['id'],$edicao_id), array('icon' => 'chevron-down', 'tooltip' => __d('croogo', 'Move down')));
            $actions[] = $this->Croogo->adminRowAction('', array('action' => 'add', $artigo['Artigo']['id'],'edicao'=>$edicao_id), array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item')));
            $actions[] = $this->Croogo->adminRowAction('', '#Artigo' . $artigo['Artigo']['id'] . 'Id', array('icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item'), 'rowAction' => 'delete'), __d('croogo', 'Are you sure?'));

            $actions = $this->Html->div('item-actions', implode(' ', $actions));
            $rows[] = array(
                $this->Form->checkbox('Artigo.' . $artigo['Artigo']['id'] . '.id'),
                $artigo['Artigo']['id'],
                $artigo['Artigo']['titulo'],
                $artigo['Artigo']['resumo'],
                $artigo['Artigo']['autores'],
                $artigo['Artigo']['arquivo'],
                $this->element('admin/toggle', array(
                    'id' => $artigo['Artigo']['id'],
                    'status' => (bool) $artigo['Artigo']['status'],
                )),
                $actions
            );
        endforeach;
        ?>
        <table class="table table-striped table-bordered">
            <thead>
                <?php echo $tableHeaders; ?>
            </thead>
            <tbody>
                <?php echo $this->Html->tableCells($rows); ?>
            </tbody>
        </table>
        <div class="row-fluid">
            <div id="bulk-action" class="control-group">
                <?php
                echo $this->Form->input('Artigo.action', array(
                    'label' => false,
                    'div' => 'input inline',
                    'options' => array('publish' => __d('croogo', 'Publish'), 'unpublish' => __d('croogo', 'Unpublish'), 'delete' => __d('croogo', 'Delete'),
                    ),
                    'empty' => true,
                ));
                ?>
                <div class="controls">
                    <?php
                    $jsVarName = uniqid('confirmMessage_');
                    echo $this->Form->button(__d('croogo', 'Enviar'), array(
                        'type' => 'button',
                        'onclick' => sprintf('return Artigos.confirmProcess(app.%s)', $jsVarName),
                    ));
                    $this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
