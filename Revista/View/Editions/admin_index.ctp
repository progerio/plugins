<?php
$this->extend('/Common/admin_index');
$this->Html->script(array('Revista.editions'), false);
$this->Html->addCrumb('', '/admin', array('icon' => 'home'))
        ->addCrumb(__d('croogo', 'Revista Novo Enfoque'), '/' . $this->request->url);
?>
<?php $this->start('actions'); ?>
<?php
echo $this->Croogo->adminAction(__d('croogo', 'Nova Edição'), array('action' => 'add'), array('button' => 'success'));
?>
<?php $this->end(); ?>
<?php
//echo $this->element('admin/editions_search');
echo $this->Form->create('Edition', array('url' => array('controller' => 'editions', 'action' => 'process'), 'class' => 'form-inline'));
?>
<div class="row-fluid">
    <div class="span12">
        
            <?php
            $tableHeaders = $this->Html->tableHeaders(array(
                '',
                $this->Paginator->sort('id', __d('croogo', 'Id')),
                $this->Paginator->sort('titulo', __d('croogo', 'Titulo')),
                $this->Paginator->sort('descricao', __d('croogo', 'Descrição')),
                $this->Paginator->sort('status', __d('croogo', 'Status')),
                ''
            ));
            $rows = array();
            foreach($editions as $edition):
 
                $actions = array();
                $actions[] = $this->Croogo->adminRowActions($edition['Edition']['id']);
                $actions[] = $this->Croogo->adminRowAction('', array('controller'=>'artigos','action' => 'index','edicao'=> $edition['Edition']['id']), array('icon' => 'bookmark', 'tooltip' => __d('croogo', 'Visualize os artigos')));
                $actions[] = $this->Croogo->adminRowAction('',
					array('controller' => 'editions', 'action' => 'links',	'?' => array('edition_id' => $edition['Edition']['id'])),
					array('icon' => 'zoom-in', 'tooltip' => __d('croogo', 'View links'))
				);
                $actions[] = $this->Croogo->adminRowAction('', array('action' => 'add', $edition['Edition']['id']), array('icon' => 'pencil', 'tooltip' => __d('croogo', 'Edit this item')));
                $actions[] = $this->Croogo->adminRowAction('', '#Edition' . $edition['Edition']['id'] . 'Id', array('icon' => 'trash', 'tooltip' => __d('croogo', 'Remove this item'), 'rowAction' => 'delete'), __d('croogo', 'Are you sure?'));
                $actions = $this->Html->div('item-actions', implode(' ', $actions));
               $rows[] = array(
                   $this->Form->checkbox('Edition.' . $edition['Edition']['id'] . '.id'),
                   $edition['Edition']['id'],
                   $edition['Edition']['titulo'],
                   $edition['Edition']['descricao'],
                   $this->element('admin/toggle', array(
                                'id' => $edition['Edition']['id'],
                                'status' => (bool) $edition['Edition']['status'],
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
                echo $this->Form->input('Edition.action', array(
                    'label' =>false,
                    'div' => 'input inline',
                    'options' => array( 'publish' => __d('croogo', 'Publish'), 'unpublish' => __d('croogo', 'Unpublish'), 'delete' => __d('croogo', 'Delete'),
                    ),
                    'empty' => true,
                ));
                ?>
                <div class="controls">
                    <?php
                    $jsVarName = uniqid('confirmMessage_');
                    echo $this->Form->button(__d('croogo', 'Enviar'), array(
                        'type' => 'button',
                        'onclick' => sprintf('return Editions.confirmProcess(app.%s)', $jsVarName),
                    ));
                    $this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
