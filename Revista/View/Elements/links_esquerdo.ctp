<?php
  //pr($edicaoAtual);exit();
   if(isset($edicaoAtual['Params'])){
       foreach($edicaoAtual['Params'] as $k => $link){
           echo $this->Html->link($k , $link.'/edicao:'.$edicaoAtual['Edition']['id'], array('class'=>'menuLeftLink','escape'=>false));
       }
   } 
    
//    
//        echo $this->Html->link('Sobre a Novo Enfoque', '/edicao/sobre/' . $Edicao['Edition']['id'], array('class' => "menuLeftLink", 'escape' => false));
//        echo $this->Html->link('Apresenta&ccedil;&atilde;o', '/edicao/apresentacao/' . $Edicao['Edition']['id'], array('class' => "menuLeftLink", 'escape' => false));
//        echo $this->Html->link('Editorial', '/edicao/editorial/' . $Edicao['Edition']['id'], array('class' => "menuLeftLink", 'escape' => false));
//        echo $this->Html->link('Artigos', '/edicao/artigos/' . $Edicao['Edition']['id'], array('class' => "menuLeftLink", 'escape' => false));
//        echo $this->Html->link('Normas para publicação', '/edicao/paginas/normas-publicacao/' . $Edicao['Edition']['id'], array('class' => "menuLeftLink", 'escape' => false));
//        echo $this->Html->link('Links', '/edicao/links/' . $Edicao['Edition']['id'], array('class' => "menuLeftLink", 'escape' => false));
?>        