<div id="smooth_div_scroll">
<?php echo $this->Html->css('../galeria/js/galleries/SmoothDivScroll/css/smoothDivScroll.css', array(), array('plugin'=>'galeria')); ?>
<style type="text/css">
#makeMeScrollable {
	width: 100%;
	height: 330px;
	position: relative;
}

#makeMeScrollable div.scrollableArea img {
	position: relative;
	float: left;
	margin: 0;
	padding: 0;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-o-user-select: none;
	user-select: none;
	-webkit-border-radius: 5px 5px 5px 5px;
	margin:0 2px 0 2px;
	width: 497px;
	height: 330px;
}
</style>

<div id="makeMeScrollable">
<?php foreach ($Gallery['Photos'] as $gallery):
$gallery['GalleryPhoto']['params'] = json_decode($gallery['GalleryPhoto']['params'], true); 
?>
	<?php echo $this->Html->link($this->Html->image($gallery['GalleryPhoto']['params']['path'], array('plugin'=>'galeria')), $gallery['GalleryPhoto']['params']['link'], array('escape'=>false, 'title'=>$gallery['GalleryPhoto']['params']['title'], 'alt'=>$gallery['GalleryPhoto']['params']['title'])); ?>
	<?php endforeach; ?>
	<div class="clearboh"></div>
</div>
<?php echo $this->Html->script('../galeria/js/galleries/SmoothDivScroll/js/jquery-ui-1.8.18.custom.min.js', array('plugin'=>'gallery')); ?>
<?php echo $this->Html->script('../galeria/js/galleries/SmoothDivScroll/js/jquery.mousewheel.min.js', array('plugin'=>'gallery')); ?>
<?php echo $this->Html->script('../galeria/js/galleries/SmoothDivScroll/js/jquery.smoothdivscroll-1.2-min.js', array('plugin'=>'gallery')); ?>

<script type="text/javascript">
		$(document).ready(function () {
			$("div#makeMeScrollable").smoothDivScroll({
				mousewheelScrolling: true,
				manualContinuousScrolling: true,
				visibleHotSpotBackgrounds: "always",
				autoScrollingMode: "onstart"
			});
		});
</script>

</div>