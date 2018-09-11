
<?php
if(!empty($liens_img)){
	foreach ($liens_img as $value) {
?>
		<div class="col-lg-6 col-md-6 col-sm-12 img_overlay" style="margin:0;padding: 0;margin:0;">
			<a <?php echo 'href="'.implode($value).'"'  ?> data-fancybox="images lien_img" >
			  	<div class="overlay">
	            	<h1 class="text">Voir en grand</h1>
	          	</div>
			 		<img <?php echo 'src="'.implode($value).'"' ?> alt="img" class="img-responsive img-port" style="width:100%; height: 100%;">
			</a>
		</div>
<?php
	}
}
?>
