<?php if($langs && count($langs) > 1){ ?>
<select class="lang_switcher custom-select" style="width: 110px;" onchange="window.location.replace('/language/' + this.value);">
	<?php foreach ($langs as $key => $lang) { ?>
			<option <?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] == $key) { echo 'selected'; } ?> value="<?php echo $key; ?>">
				<?php echo $lang['name']; ?>
			</option>
	<?php } ?>
</select>
<?php }else{  ?>
	<ul class="navbar-nav">
		<li class="nav-link"><?php echo $langs[0]['name']; ?></li> 
	</ul>
<?php } ?>
