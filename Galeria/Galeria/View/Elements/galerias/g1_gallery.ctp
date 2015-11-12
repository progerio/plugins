<?php echo $this->Html->script('../galeria/js/galleries/G1Gallery/1.4.2.js', array('plugin'=>'galeria')); ?>
<?php echo $this->Html->script('../galeria/js/galleries/G1Gallery/1.8.7.js', array('plugin'=>'galeria')); ?>
<?php echo $this->Html->script('../galeria/js/galleries/G1Gallery/pack1.js', array('plugin'=>'galeria')); ?>
<?php echo $this->Html->css('../galeria/js/galleries/G1Gallery/style.css', array(), array('plugin'=>'galeria')); ?>
<!-- ---------------------------------------------------------------------------- -->
<div class="ct-box-destaque-carrossel">
	<div id="globo_destaque_carrossel" class="globo-destaque-carrossel glb-hl-style-bottom-right">
		<div id="globo-carrossel-passos" class="globo-carrossel-passos">
			<?php $key = 0; foreach ($Gallery['Photos'] as $key=>$gallery): $key++;
				$gallery['GalleryPhoto']['params'] = json_decode($gallery['GalleryPhoto']['params'], true);
			 ?>
			<div class="conteudo-extra">
			<?php if($key == 1){?>
				<div class="globo-carrossel-passo globo-carrossel-invisivel sem-veja-mais" style="z-index: 99;display: block;opacity: 1;">
			<?php }else{ ?>
				<div class="globo-carrossel-passo sem-veja-mais" style="z-index: 98;display: block;opacity: 0;">
			<?php }?>
					<div class="destaque-carrossel glb-hl-style-bottom-right">
						 <img class="globo-carrossel-foto" src="<?php echo $gallery['GalleryPhoto']['params']['path']; ?>" />
						 <a href="<?php echo $gallery['GalleryPhoto']['params']['link'];?>" class="globo-carrossel-titulo">
						 	<span class="globo-carrossel-titulo-texto">
						 		<?php echo $gallery['GalleryPhoto']['params']['description']; ?>
						 	</span>
						   	<span class="globo-carrossel-subtitulo-texto">
						    	<?php echo $gallery['GalleryPhoto']['params']['description']; ?> 
						    </span>
						 </a>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<ul class="globo-carrossel-navegacao">
		<?php $key2 = 0;foreach ($Gallery['Photos'] as $gallery): $key2++;
			$gallery['GalleryPhoto']['params'] = json_decode($gallery['GalleryPhoto']['params'], true);
		?>
			<?php if($key2 == 1){?>
			<li class="item-<?php echo $key2; ?> lista-atual">
			<?php }else{ ?>
			<li class="item-<?php echo $key2; ?>">
			<?php }?>
				<span class="chapeu-thumb">
					<?php echo $gallery['GalleryPhoto']['params']['categoria']; ?>
				</span>
				<div class="mask-mouseover">
					<a class="cor-produto-background" href="#">
						<?php echo $gallery['GalleryPhoto']['params']['comentario']; ?>
					</a>
				</div>
			</li>
			<?php endforeach; ?>

		</ul>
		<div class="globo-carrossel-thumbs-container">
			<div id="globo-carrossel-thumbs" class="globo-carrossel-thumbs qtn-5-thumbs">
			<?php $key3 = 0; foreach ($Gallery['Photos'] as $gallery): $key3++;
				$gallery['GalleryPhoto']['params'] = json_decode($gallery['GalleryPhoto']['params'], true);
			?>
			<?php if($key3 == 1){?>
			<div class="globo-carrossel-thumb thumb-<?php echo $key3; ?> thumb-atual" data-index="<?php echo $key3; ?>">
			<?php }else{ ?>
			<div class="globo-carrossel-thumb thumb-<?php echo $key3; ?>" data-index="<?php echo $key3; ?>">
			<?php } ?>
					<div class="globo-carrossel-thumb-content">
						<img class="globo-carrossel-thumb-img" src="<?php echo $gallery['GalleryPhoto']['params']['path']; ?>" style="opacity: 1;" />
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('../galeria/js/galleries/G1Gallery/pack2.js', array('plugin'=>'galeria')); ?>