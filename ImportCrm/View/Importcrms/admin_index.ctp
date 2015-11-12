<div>
<h2>Importar Arquivo</h2>
       <?php
            echo $this->Form->create('Import',array('type'=>'file'));
            echo $this->Form->file('arquivo',array('div'=>false));
            echo $this->Form->submit('Enviar');
            echo $this->Form->end();
?>

</div>