<div class="attachments form">
	<h2>
	<?php echo $title_for_layout; ?>
	</h2>
	<div class="tabs">
		<ul>
			<li><a href="#attachment-main">Adicionar Foto</a>
			</li>
			<?php echo $this->Layout->adminTabs(); ?>
		</ul>

		<div id="attachment-main">
		<?php
		$formUrl = array('controller' => 'galerias', 'action' => 'editPhoto', $this->params['pass'][0], 'gallery'=>$this->params['named']['gallery']);
		echo $this->Form->create('Photo', array('url' => $formUrl));
		?>
			<fieldset>
			<?php
			echo $this->Form->hidden('Photo.id', array('value'=>$this->params['pass'][0]));
            echo $this->Form->input('Photo.params.title',array('label'=>'Título:'));
            echo $this->Form->input('Photo.params.description',array('label'=>'Descrição:'));
            echo $this->Form->input('Photo.params.categoria',array('label'=>'Categoria:'));
            echo $this->Form->input('Photo.params.comentario',array('label'=>'Comentário:'));
            echo $this->Form->input('Photo.params.link',array('label'=>'Link:'));
			?>
			</fieldset>
		</div>

		<?php echo $this->Layout->adminTabs(); ?>
	</div>
</div>

<div class="buttons">
<?php
echo $this->Form->end(__('Save'));
echo $this->Html->link(__('Cancel'), array(
           'action' => 'index',
           'gallery'=> $this->params['named']['gallery'],
), array(
            'class' => 'cancel',
));
?>
</div>
