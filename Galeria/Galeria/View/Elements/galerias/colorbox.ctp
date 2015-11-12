<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<?php echo $this->Html->script('../galeria/js/galleries/Colorbox/jquery.colorbox.js', array('plugin'=>'galeria')); ?>
<?php echo $this->Html->css('../galeria/js/galleries/Colorbox/colorbox.css', array(), array('plugin'=>'galeria')); ?>
<script>
	$(document).ready(function(){
		$(".group1").colorbox({rel:'group1'});
	});
</script>
<style>
.colorbox-list ul li{
	list-style-type: none;
	float:left;
	margin: 10px;
}
.colorbox-list ul li a img {
	width:100px;
}
</style>
<div  class="colorbox-list">
<ul>
<?php foreach ($Gallery['Photos'] as $gallery): ?>
<?php $gallery['GalleryPhoto']['params'] = json_decode($gallery['GalleryPhoto']['params'], true);?>
	<li>
		<a class="group1" href="<?php echo $gallery['GalleryPhoto']['params']['path']; ?>" title="<?php echo $gallery['GalleryPhoto']['params']['title']; ?>">
			<img src="<?php echo $gallery['GalleryPhoto']['params']['thumb']; ?>"/>
		</a>
	</li>
	<?php endforeach; ?>
</ul>
<div class="clear"></div>
</div>