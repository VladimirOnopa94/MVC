<select class="lang_switcher custom-select" style="width: 110px;" onchange="window.location.replace('/language/' + this.value);">
	<?php foreach ($langs as $key => $lang) { ?>
			<option <?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] == $key) { echo 'selected'; } ?> value="<?php echo $key; ?>">
				<?php echo $lang['name']; ?>
			</option>
	<?php } ?>
</select>