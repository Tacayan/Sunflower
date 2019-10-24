<?php

class Log
{

	public function listLog($codEx)
	{

		$pdo = getConnection();
		$stmt = $pdo->prepare('SELECT log FROM log WHERE codEx = :codEx');
		$stmt->bindParam('codEx', $codEx);
		$stmt->execute();

		$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($logs as $log) {
			echo '<li class="list-group-item bg-dark text-warning">' . $log['log'] . '</li>';
		}
	}

	public function createLog($log, $codEx, $url){

		$pdo = getConnection();
		$stmt = $pdo->prepare('INSERT INTO log(log, codEx) VALUES(:log, :codEx)');
		$stmt->bindParam(':log', $log);
		$stmt->bindParam(':codEx', $codEx);
		$stmt->execute();
		header("Location: search.php?name=$url");
		exit();
	}
}
