<div class="attachments index">
    <h2><?php echo $title_for_layout; ?></h2>
    <div class="actions">
        
        <ul>
        
        <?php if(isset($this->params['named']['gallery'])){ ?>
            <li><?php echo $this->Html->link(__('Inserir Foto'), array('action'=>'addPhoto', 'gallery'=>$this->params['named']['gallery'])); ?></li>
            <li><?php echo $this->Html->link(__('Importar Fotos'), array('action'=>'importar','gallery'=>$this->params['named']['gallery'])); ?></li>
            <li><?php echo $this->Html->link(__('Voltar'), array('action'=>'index')); ?></li>
            <?php }else{ ?>
            <li><?php echo $this->Html->link(__('Nova Galeria'), array('action'=>'addGallery')); ?></li>
            <?php } ?>
        </ul>
    </div>

    <table cellpadding="0" cellspacing="0">
    <?php
    if(isset($this->params['named']['gallery'])){
    	
        $tableHeaders = $this->Html->tableHeaders(array(
            $this->Paginator->sort('id'),
            '&nbsp;',
            $this->Paginator->sort('title'),
            __('URL'),
            __('Actions'),
        ));
        echo $tableHeaders;

        $rows = array();
        
        foreach ($attachments AS $attachment) {
     		$attachment['Photo']['params'] = json_decode($attachment['Photo']['params'], true);
            $actions  = $this->Html->link(__('Edit'), array('action' => 'editPhoto','gallery'=>$this->params['named']['gallery'],$attachment['Photo']['id']));
            $actions .= ' ' . $this->Html->link(__('Delete'), array('action' => 'deletePhoto',$attachment['Photo']['id']), null, __('Você tem certeza?'));           
                $thumbnail = $this->Html->link($this->Upload->resize($attachment['Photo']['params']['path'], $slug_gallery, 200, 300), '#', array(
                    'onclick' => "selectURL('".$attachment['Photo']['params']['path']."');",
                    'escape' => false,
                ));
               /*if (!file_exists($attachment['Photo']['path'])) {
                $thumbnail = $this->Html->image('/img/icons/page_white.png') . ' ' . $attachment['Photo']['title'] . ' (' . $this->Filemanager->filename2ext($attachment['Photo']['slug']) . ')';
                $thumbnail = $this->Html->link($thumbnail, '#', array(
                    'onclick' => "selectURL('".$attachment['Photo']['slug']."');",
                    'escape' => false,
                ));
            }*/

            $rows[] = array(
                $attachment['Photo']['id'],
                $thumbnail,
                $attachment['Photo']['params']['title'],
                $this->Html->link('Vizualizar', '/'.$attachment['Photo']['params']['path'], array('escape'=>false, 'target'=>'_blank')),
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    }else{
    	$tableHeaders = $this->Html->tableHeaders(array(
            $this->Paginator->sort('id'),
            $this->Paginator->sort('title'),
            __('Actions'),
        ));
        echo $tableHeaders;
        $rows = array();
    	foreach ($attachments AS $attachment) {
    		$actions  = $this->Html->link(__('Fotos'), array(
    				'action' => 'index','gallery'=>$attachment['Galeria']['id']), array('escape'=>false
    			
    		));
    		$actions  .= $this->Html->link(__('Edit'), array(
                'action' => 'addGallery',
                $attachment['Galeria']['id'],
            ));
            $actions .= ' ' . $this->Html->link(__('Delete'), array(
                'action' => 'deleteGallery',
                $attachment['Galeria']['id']
            ), null, __('Você tem certeza?'));
    		$rows[] = array(
                $attachment['Galeria']['id'],
                $this->Html->link($attachment['Galeria']['title'], array('gallery'=>$attachment['Galeria']['id']), array('escape'=>false)),
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    }
    ?>
    </table>
</div>

<div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
