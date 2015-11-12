<?php
$Gallery = $this->requestAction(array('plugin'=>'galeria', 'controller'=>'galerias', 'action'=>'viewGallery', $galeria_id), array());
echo $this->element('galerias'.DS.$Gallery['Config']['Galeria']['type'], array('Gallery'=>$Gallery), array('plugin'=>'galeria'));
?>