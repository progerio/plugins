<?php

$this->extend('/Common/admin_index');

$this->Html
	->addCrumb('', '/admin', array('icon' => 'home'))
	->addCrumb(__d('croogo', 'Emarketing'), '/' . $this->request->url);

?>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped">
			<?php
				$tableHeaders = $this->Html->tableHeaders(array(
				    '',
				    $this->Paginator->sort('id',__d('croogo', 'Id')),
					$this->Paginator->sort('title', __d('croogo', 'Title')),
				    $this->Paginator->sort('from', __d('croogo', 'Enviado por')),
				    $this->Paginator->sort('created', __d('croogo', 'Criado em')),
				    $this->Paginator->sort('status', __d('croogo', 'Status')),
					__d('croogo', 'Actions'),
				));
			?>
			<thead>
				<?php echo $tableHeaders; ?>
			</thead>

			<?php
			$rows = array();
			foreach ($marketings as $mailing):
				$actions = array();
			    $actions[] = $this->Croogo->adminRowActions($mailing['Mailing']['id']);
			    $actions[] = $this->Croogo->adminRowAction('', array(
			        'action' => 'edit',
			        $mailing['Mailing']['id']
			    ), array(
			        'icon' => 'pencil',
			        'tooltip' => __d('croogo', 'Edit this item')
			    ));
			    $actions[] = $this->Croogo->adminRowAction('', '#Mailing' . $mailing['Mailing']['id'] . 'Id', array(
			        'icon' => 'trash',
			        'tooltip' => __d('croogo', 'Remove this item'),
			        'rowAction' => 'delete'
			    ), __d('croogo', 'Are you sure?'));
			    $actions = $this->Html->div('item-actions', implode(' ', $actions));
			
			    $rows[] = array(
			        $this->Form->checkbox('Mailing.' . $mailing['Mailing']['id'] . '.id'),
			        $mailing['Mailing']['id'],
			        $mailing['Mailing']['title'],
			        $mailing['Mailing']['from'],
			        $mailing['Mailing']['created'],
			    
			        $this->element('admin/toggle', array(
			            'id' => $mailing['Mailing']['id'],
			            'status' => (bool) $mailing['Mailing']['status']
			        )),
			        $actions
			    );
			    
			endforeach;
			echo $this->Html->tableCells($rows);
			?>
		</table>
			<div class="row-fluid">
			<div id="bulk-action" class="control-group">
                <?php
                echo $this->Form->input('Mailing.action', array(
                    'label' => false,
                    'div' => 'input inline',
                    'options' => array(
                        'publish' => __d('croogo', 'Publish'),
                        'unpublish' => __d('croogo', 'Unpublish'),
                        'delete' => __d('croogo', 'Delete')
                    ),
                    'empty' => true
                ));
                ?>
                <div class="controls">
                    <?php
                    $jsVarName = uniqid('confirmMessage_');
                    echo $this->Form->button(__d('croogo', 'Enviar'), array(
                        'type' => 'button',
                        'onclick' => sprintf('return Mailing.confirmProcess(app.%s)', $jsVarName)
                    ));
                    $this->Js->set($jsVarName, __d('croogo', '%s selected items?'));
                    ?>
                </div>
			</div>
		</div>
	</div>
</div>
