<?php

require 'log.class.php';

class Ex
{

	public function searchEx($searchName)
	{

		$log = new Log();
		$searchName = trim($searchName);

		$pdo = getConnection();
		$stmt = $pdo->prepare('SELECT name, codEx FROM ex WHERE name LIKE :search');
		$stmt->bindParam(':search', $searchName);
		$stmt->execute();

		$exs = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($exs as $ex) {
			if (@!$exs['photo']) {
				$photo = 'https://nativapps.com/wp-content/uploads/2017/12/icon-person.png';
			}

			echo '<br><br><div class="card bg-dark mx-auto text-warning container" style="max-width: 640px;">
			<div class="row no-gutters">
			  <div class="col-md-4">
				<img src="' . $photo . '" class="card-img" alt="...">
			  </div>
			  <div class="col-md-8">
				<div class="card-body">
				  <h5 class="card-title">' . $ex["name"] . '</h5>
				  <ul class="list-group">';
			$log->listLog($ex['codEx']);
			echo '<li class="list-group-item bg-dark"><form mehtod="post" action="createLog.php">
				  <input type="hidden" name="codEx" value="' . $ex['codEx'] . '">
				  <input type="hidden" name="url" value="' . $searchName . '">
				  <input type="text" class="form-control" required id="log" name="log" placeholder="note"></li>
				  <button type="submit" class="btn btn-warning">add note</button>
				  </form>';
			echo '</ul>
				</div>
			  </div>
			</div>
		  </div>';
		}

		if (!count($exs)) {
			echo '<br><br><div class="alert alert-warning mx-auto container" role="alert"> there is no ex with that name registered <br><button data-toggle="modal" data-target="#confirm" type="button" class="btn btn-warning float-left">register ex</button></div>';
			echo '<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog" role="document">
			  <div class="modal-content">
				<div class="modal-header">
				  <h5 class="modal-title"">Is the name correct?</h5>
				  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>
				<div class="modal-body">
				<form mehtod="get" action="register.php">
				<input type="text" class="form-control" required id="search" name="name" placeholder="Full Name" value="' . $searchName . '">
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-secondary" data-dismiss="modal">no</button>
				  <button type="submit" class="btn btn-warning">yes</button>
				  </form>
				</div>
			  </div>
			</div>
		  </div>';
		} else {
			echo '<br><br><div class="alert alert-warning mx-auto container" role="alert"> didnt find your ex? <br><button data-toggle="modal" data-target="#confirm" type="button" class="btn btn-warning float-left">register ex</button></div>';
			echo '<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title"">Is the name correct?</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
				  <form mehtod="get" action="register.php">
				  <input type="text" class="form-control" required id="search" name="name" placeholder="Full Name" value="' . $searchName . '">
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">no</button>
					<button type="submit" class="btn btn-warning">yes</button>
					</form>
				  </div>
				</div>
			  </div>
			</div>';
		}
	}

	// public function addPhoto()
	// {
	// 	if (($_FILES['photo']['name']) && $_FILES['photo']['error'] == 0) {
	// 		$name_tmp = $_FILES['photo']['tmp_name'];
	// 		$name = $_FILES['photo']['name'];
	// 		list($width, $height) = getimagesize($name_tmp);

	// 		if (($width <= 250) and ($height <= 250)) {
	// 			$_SESSION['announcement'] = 'Imagem muito pequena';
	// 			header('Location: profile.php');
	// 		} else {
	// 			$extension = pathinfo($name, PATHINFO_EXTENSION);
	// 			$name = md5(uniqid(time())) . '.' . $extension;
	// 			$destination = 'user/photo/' . $name;

	// 			if (!strstr('.jpg; .jpeg; .gif; .png', $extension)) {
	// 				header('Location: profile.php');
	// 			} else {
	// 				move_uploaded_file($name_tmp, $destination);
	// 				$connection = GetConnection();
	// 				$stmt = $connection->prepare('UPDATE ex SET photo = :photo WHERE codEx = :codEx');
	// 				$stmt->bindParam(':photo', $destination);
	// 				$stmt->bindParam(':codEx', $codEx);
	// 				$stmt->execute();
	// 			}
	// 		}
	// 	}
	// }

	public function registerEx($nameEx)
	{

		$pdo = getConnection();
		$stmt = $pdo->prepare('INSERT INTO ex(name) VALUES(:name)');
		$stmt->bindParam(':name', $nameEx);
		if ($stmt->execute()) {
			header("Location: search.php?name=$nameEx");
		}
	}

	function __construct()
	{

		$pdo = getConnection();
	}
}
