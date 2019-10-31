<?php

require 'log.class.php';
require 'resize-class/resize-class.php';

class Ex
{

  public function searchEx($searchName)
  {

    $log        = new Log();
    $searchName = trim($searchName);

    $pdo  = getConnection();
    $stmt = $pdo->prepare('SELECT name, codEx, photo FROM ex WHERE name LIKE :search');
    $stmt->bindParam(':search', $searchName);
    $stmt->execute();

    $exs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($exs as $ex) {
      echo '<br><br><div class="card bg-dark mx-auto text-warning col" style="max-width: 540px;">
            <div class="row no-gutters">
              <div class="mx-auto col-md-3 col-6"><br>
              <button class="btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#photo' . $ex['codEx'] . '""> <img src="' . $ex['photo'] . '" class="card-img rounded-circle border border-warning" alt="..."> </button>
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">' . $ex["name"] . '</h5>
                  <ul class="list-group col-12">';
      $log->listLog($ex['codEx']);
      echo '<li class="list-group-item bg-dark"><form mehtod="post" action="createLog.php">
                  <input type="hidden" name="codEx" value="' . $ex['codEx'] . '">
                  <input type="hidden" name="url" value="' . $searchName . '">
                  <div class="input-group">
  <div class="input-group-prepend">
    <span class="input-group-text">note</span>
  </div>
  <textarea class="form-control" required id="log" name="log" aria-label="note"></textarea>
</div>
                  </li>

                  <button type="submit" class="btn btn-warning">add note</button>
                  </form>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal fade" id="photo' . $ex['codEx'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">photo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form action="changePhoto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="codEx" value="' . $ex['codEx'] . '">
      <div class="input-group">
      <div class="">
        <input type="file" class="btn col-12 mx-auto"  name="photo" aria-describedby="inputGroupFileAddon04" required>
        <!-- <label class="custom-file-label" for="inputGroupFile04">Choose file</label> -->
      </div>
      <input type="hidden" name="url" value="' . $searchName . '">
        <button class="btn btn-warning col-12" type="submit" id="inputGroupFileAddon04">save photo</button>
      </div>
    </div>
</form>
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

  public function addPhoto($codEx, $nameEx)
  {
    if (($_FILES['photo']['name']) && $_FILES['photo']['error'] == 0) {
      $name_tmp = $_FILES['photo']['tmp_name'];
      $name     = $_FILES['photo']['name'];
      list($width, $height) = getimagesize($name_tmp);

      if (($width <= 250) and ($height <= 250)) {
        header("Location: search.php?name=$nameEx&error=true");
      } else {
        $extension   = pathinfo($name, PATHINFO_EXTENSION);
        $name        = md5(uniqid(time())) . '.' . $extension;
        $destination = 'user/photo/' . $name;

        if (!strstr('.jpg; .jpeg; .gif; .png', $extension)) {
          header("Location: search.php?name=$nameEx&error=true");
        } else {
          move_uploaded_file($name_tmp, $destination);
          $connection = GetConnection();
          $stmt       = $connection->prepare('UPDATE ex SET photo = :photo WHERE codEx = :codEx');
          $stmt->bindParam(':photo', $destination);
          $stmt->bindParam(':codEx', $codEx);
          $stmt->execute();

          header("Location: search.php?name=$nameEx");
        }
      }

      $resizeObj = new resize($destination);
      $resizeObj->resizeImage(500, 500, 'crop');
      $resizeObj->saveImage($destination, 100);
    }else{
      header("Location: search.php?name=$nameEx&error=true");
    }
  }

  public function registerEx($nameEx)
  {

    $pdo  = getConnection();
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
