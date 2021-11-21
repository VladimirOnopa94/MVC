
<?php if (!empty($users)) { ?>
	<table class="table">
	  <thead>
	    <tr>
	      <th scope="col">#</th>
	      <th scope="col">name</th>
	      <th scope="col">Last</th>
	      <th scope="col">Handle</th>
	      <th scope="col">City</th>
	    </tr>
	  </thead>
	  <tbody>
		<?php foreach ($users as $key => $user) { ?>
			<tr>
		      <th scope="row"><?php echo $user['id']; ?></th>
		      <th scope="row"><?php echo $user['name']; ?></th>
		      <td><?php echo $user['address']; ?></td>
		      <td><?php echo $user['lastname']; ?></td>
		      <td><?php echo $user['city']; ?></td>
		    </tr>
		<?php } ?>
		  </tbody>
		</table>
<?php }?>


<?php 	if ($users) {
	app\components\widgets\PaginationW::widget($total, $page, $limit );
} ?>
