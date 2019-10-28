<?php
require 'header.php';

?><br><br>

<style>
	footer {
		bottom: 0px;
		width: 100%;
		position: fixed;
	}
</style>

<div class="card container bg-dark text-warning">
	<div class="card-header">
		Search ex
	</div>
	<div class="card-body">
		<form mehtod="get" action="search.php">
			<div class="form-group">
				<label for="search">ex's name</label>
				<input type="text" class="form-control" required id="search" name="name" placeholder="Full name">
			</div>
			<button type="submit" class="btn btn-warning">search</button>
		</form>
	</div>
</div>

<?php

require 'footer.php';
