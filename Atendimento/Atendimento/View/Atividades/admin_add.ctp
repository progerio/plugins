<?php
$this->set('title_for_layout', 'Atividade');
$this->extend('/Common/default');
?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Atividades <small></small></h3>
    </div><!-- /.box-header -->
    <div class="mailbox-controls">
    </div>
    <?php echo $this->Form->create('Atividade', array()); ?>
    <div class="box-body ">
        <?php
        echo $this->Form->hidden('ID_Atividade');
        echo $this->Form->input('NM_Atividade', array('label' => 'Atividade', 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->input('ID_Usuario', array('label' => 'Usuario','options' =>$usuarios,'empty'=>' ','div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->hidden('DH_Cadastro',array('value'=>date('Y-m-d H:i:s')));
        if(isset($this->request->data['Atividade']['ID_Atividade'])){
            echo '<label> Cadastro :  </label>';
            echo $this->Form->hidden('DH_Cadastro', array('value'=>$this->request->data['Atividade']['DH_Cadastro']));
            echo '<p>' .$this->Time->format('d/m/Y H:i:s', $this->request->data['Atividade']['DH_Cadastro']). '</p>';
            echo '<p></p>';
        }
        echo $this->Form->input('TX_Atividade', array('type' => 'textarea', 'label' => 'Descrição da Atividade', 'rows' => 4, 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->input('ID_Projeto', array('label' => 'Projeto', 'options' => $projetos, 'empty'=>' ', 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->input('ID_Funcionario', array('type' => 'select', 'label' => 'Funcionario', 'options' => $funcionarios, 'empty'=>' ', 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->input('NR_Prioridade', array('label' => 'Prioridade', 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->input('QT_Esforco_Previsto', array('label' => 'Previsto', 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->input('ID_Situacao_Atividade', array('label' => 'Situação', 'options' =>$situacoes, 'div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->submit('Salvar', array('class' => 'btn btn-success'));
        echo $this->Form->end();
        ?>
    </div>
</div>