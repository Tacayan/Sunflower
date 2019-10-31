<?php
require 'header.php';
require 'ex.class.php';
require 'connection.php';

$ex = new ex();

?>

	<br><br>
	<div class="card container bg-dark text-warning">
		<div class="card-header">
			Search Ex
		</div>
		<div class="card-body">
			<form method="get" action="search.php">
				<div class="form-group">
					<label for="search">ex's name</label>
					<input type="text" class="form-control" required id="search" name="name" placeholder="Full Name" value="<?php echo $_GET['name'] ?>">
				</div>
				<button type="submit" class="btn btn-warning">search</button>
			</form>
		</div>
	</div>

	<?php
	
	if(isset($_GET['error']))
		echo '<br><br><div class="alert alert-warning col-6 mx-auto" role="alert">
		Houve um erro ao salvar imagem
	  </div>';

	$ex->searchEx($_GET['name']);

	require 'footer.php';

	?>