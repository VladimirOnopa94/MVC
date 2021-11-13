<?php if (isset($breadcrumbs)) { ?>
	<div class="breadcrumbs">
		<?php foreach ($breadcrumbs as $key => $breadcrumb) { ?>
			<?php if (isset($breadcrumb['href']) && !empty($breadcrumb['href'])) { ?>
				<a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['name']; ?></a>
				<?php if (isset($breadcrumb['delimiter'])) { echo $breadcrumb['delimiter'];} ?>
			<?php }else{ ?>
				<span><?php echo $breadcrumb['name']; ?></span>
				<?php if (isset($breadcrumb['delimiter'])) { echo $breadcrumb['delimiter'];} ?>
			<?php } ?>
			
		<?php } ?>
	</div>
<?php } ?>
