<div class="full image">
<?php

$id = get_sub_field("image");	
$url = get_sub_field("url");

$startURL = !empty($url) ? '<a href='.$url.'>' : '';
$endURL   = !empty($url) ? '</a>' : '';

if(get_post_mime_type($id) == 'image/svg+xml'){
	
?>
	<!--<script type="text/javascript">
		$(document).ready(function(){
			
			$('#svg-<?php echo $id;?>').svg({
				loadURL: '<?php echo wp_get_attachment_url($id) ; ?>',
				changeSize : true,
				onLoad : svgLoaded
			});
						
		});
	
		function svgLoaded(){
			origW = $('#svg-<?php echo $id;?> svg').width();
			origH = $('#svg-<?php echo $id;?> svg').height();
			ratio = origW/origH;
			
			$('#svg-<?php echo $id;?> svg').attr('ratio',ratio);
			
			newW = $('#svg-<?php echo $id;?>').width();
			newH = newW / ratio;
						
			$('#svg-<?php echo $id;?> svg').attr('width',newW);
			$('#svg-<?php echo $id;?> svg').attr('height',newH);
		}
	</script>-->
	<object id="svg-<?php echo $id;?>" width="100%" height="100%" data="<?php echo wp_get_attachment_url($id) ; ?>"></object>
	<!--<div id="svg-<?php echo $id;?>" class="svg"></div>-->
	

		
<?php

}else{
	
?>
	<?php echo $startURL;?><img src="<?php echo wp_get_attachment_url($id); ?>" alt="Image"/><?php echo $endURL;?>
<?php

}

?>
</div>
