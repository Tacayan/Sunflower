<?php
require 'header.php';
require 'ex.class.php';
require 'connection.php';

$ex = new ex();

?>

<script>
            $('#inputGroupFile04').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            })
        </script>

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

$ex->searchEx($_GET['name']);

require 'footer.php';

?>