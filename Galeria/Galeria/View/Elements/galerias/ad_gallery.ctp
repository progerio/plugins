<?php echo $this->Html->script('../galeria/js/galleries/ADGallery/lib/jquery.ad-gallery-custom.js', array('plugin'=>'gallery')); ?>
<?php echo $this->Html->css('../galeria/js/galleries/ADGallery/lib/jquery.ad-gallery-custom.css', array(), array('plugin'=>'gallery')); ?>
<?php  
$configGallery = $Gallery['Config']['Galeria']['params'];
$galleryName = 'galeria_'.$Gallery['Config']['Galeria']['id'];
if(!isset($configGallery['height']) || !$configGallery['height']){
	$configGallery['height'] = (($configGallery['width']*70)/100);
}
$configGallery['width'] .='px';
$configGallery['height'] .='px';
?>
<script type="text/javascript">
    $(function() {
        var galleries = $('#<?php echo $galleryName; ?>').adGallery({
        	effect: '<?php echo $configGallery['effect']; ?>',
        	slideshow: {
        	    autostart: <?php echo $configGallery['autostart']; ?>,
        	    enable: <?php echo $configGallery['control']; ?>,
        	}
        });
        $('#switch-effect').change(function() {
            galleries[0].settings.effect = $(this).val();
            return false;
		});
	});
</script>
<style>
#<?php echo $galleryName; ?> {
    /* background: #000 !important; */
}
.ad-gallery .ad-info{
display:none;
}
</style>

<div id="<?php echo $galleryName; ?>" class="ad-gallery" style="width:<?php echo $configGallery['width']; ?>;">
      <div class="ad-image-wrapper"  style="height:<?php echo $configGallery['height']; ?>;"></div>
      <div class="ad-controls"></div>
      <div class="ad-nav">
        <div class="ad-thumbs">
          <ul class="ad-thumb-list">
                <?php
                if ($Gallery['Photos'] <> null):
                    $ViewGallery = null;
                        $I = 0;
                        foreach ($Gallery['Photos'] as $key => $value):
                        $value['GalleryPhoto']['params'] = json_decode($value['GalleryPhoto']['params'], true);
                            $I++;
                            $Name = 'galeria' . $I;
                            $ViewGallery .= '<li>';
                            //$Image = $DirImg . $value['image'];
                            $Image = 'http://'.$_SERVER['HTTP_HOST'].$value['GalleryPhoto']['params']['path'];
                            //$Thumb = $DirImg . $value['thumb'];
                            $Thumb = 'http://'.$_SERVER['HTTP_HOST'].$value['GalleryPhoto']['params']['thumb'];
                            $ViewGallery .= $this->Html->link($this->Html->image($Thumb, array('escape' => false, 'title' => $value['GalleryPhoto']['params']['description'])), $Image, array('escape' => false, 'class' => $Name, 'title' => $value['GalleryPhoto']['params']['description']));
                            $ViewGallery .= '</li>';
                        endforeach;
                    echo $ViewGallery;
                endif;
                ?>
            </ul>
            <div style="clear:both;"></div>
        </div>
    </div>
</div>