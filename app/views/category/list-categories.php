<?php foreach ($categories as $key => $category) { ?>
		
	<div class="jumbotron jumbotron-fluid">
	  <div class="container">
	  	<a href='<?php echo url('category/'.$category->url) ?>'>
	    	<h1 class="display-4"><?php echo $category->name ?></h1>
	    </a>
	    <p class="lead"><?php echo $category->description ?></p>
	  </div>
	</div>

<?php } 
