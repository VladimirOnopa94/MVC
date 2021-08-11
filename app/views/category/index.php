<ul>
	<?php 
	if ($categorys) {
		foreach ($categorys as $key => $category) { ?>
			 <li><?php echo $category['category_id'] ?></li>
		<?php } 
	}else{
		echo 'Ничего не найдено';
	}
	?>
</ul>