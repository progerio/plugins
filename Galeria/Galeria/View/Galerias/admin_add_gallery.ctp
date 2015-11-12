<div class="attachments form">
<h2><?php echo $title_for_layout; ?></h2>
    <div class="tabs">
        <ul>
            <li><a href="#attachment-main">Galeria</a></li>
            <?php echo $this->Layout->adminTabs(); ?>
        </ul>

        <div id="attachment-main">
        <?php
            echo $this->Form->create('Galeria', array('action'=>'addGallery'));
        ?>
            <fieldset>
            <?php
            if(@$this->request->data['Galeria']['id'] <> null){
            	echo $this->Form->hidden('id', array('value' => $this->request->data['Galeria']['id']));
            }
                echo $this->Form->input('title', array('label' => 'Título'));
                echo $this->Form->input('slug', array('label' => 'Slug'));
                echo $this->Form->input('type', array('label' => 'Tipo', 'options'=>array(
                'ad_gallery'=>'AD Gallery',
                'g1_gallery'=>'G1 Gallery',
                'colorbox'=>'Colorbox',
                'smooth_div_scroll'=>'Smooth Div Scroll',
                )));
                echo $this->Form->input('description', array('label' => 'Descrição'));
                echo $this->Form->input('Galeria.params.width',array('label'=>'Largura:'));
				echo $this->Form->input('Galeria.params.height',array('label'=>'Altura:'));
				echo $this->Form->input('Galeria.params.autostart',array('label'=>'Início Automático:', 'options'=>array(
					true=>'Sim',
					false=>'Não',
				)));
				echo $this->Form->input('Galeria.params.control',array('label'=>'Exibir Controle (Play e Pause):', 'options'=>array(
					true=>'Sim',
					false=>'Não',
				)));
				echo $this->Form->input('Galeria.params.effect',array('label'=>'Efeito de Transição:', 'options'=>array(
					'none'=>'Nenhum',	
					'slide-hori'=>'Slide Horizontal',
					'slide-vert'=>'Slide Vertical',
					'fade'=>'Fade',
					'resize'=>'Resize'
				)));
            ?>
            </fieldset>
        </div>

        <?php echo $this->Layout->adminTabs(); ?>
        </div>
    </div>

    <div class="buttons">
    <?php
        echo $this->Form->end('Salvar');
        echo $this->Html->link('Cancelar', array(
           'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
	?>
	</div>