<?php

echo $this->Form->create("User",array('action'=>'login')) ?>
<div class="form-group has-feedback">
    <?php echo $this->Form->input('username',array('placeholder'=>'Usuario','label'=>false,  'class'=>'form-control')) ?>
    <span class="glyphicon glyphicon-user form-control-feedback"></span>
</div>
<div class="form-group has-feedback">
    <?php echo $this->Form->input('password',array('placeholder'=>'Senha','label'=>false,  'class'=>'form-control')) ?>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>
<div class="row">
    <div class="col-xs-8"></div>
    <div class="col-xs-4">
            <?php echo $this->Form->submit('Entrar',array('class'=>'btn btn-primary btn-block btn-flat')) ?>
    </div><!-- /.col -->
</div>
 <?php echo $this->Form->end() ?>
 <?php echo $this->Html->link('Esqueci minha senha!', "#", array('escape'=>false)); ?>
