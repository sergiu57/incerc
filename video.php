<?php include('functions.php'); 
      if(isset($_GET['uniqid'])){
        $uniqid = $_GET['uniqid'];
        $sql_video = "SELECT * FROM videoclipuri WHERE uniqid = '$uniqid'";
        $result_video = mysqli_query($db, $sql_video);
        if($result_video->num_rows > 0){
          $video = $result_video->fetch_assoc();
        }else{
          header("Location: index.php");
        }
      }else{
        header("Location: index.php");
      }
?>
<?php  
  $vizualizari = $video['vizualizari'];
  $vizualizari2 = $vizualizari + 1;
  $sql_vizualizare = "UPDATE videoclipuri SET vizualizari = '$vizualizari2' WHERE uniqid = '$uniqid'";
  mysqli_query($db, $sql_vizualizare);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - <?php echo $video['titlu']; ?></title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <?php include('navigation.php') ?>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Vizualizare videoclip</h1>
          </div>
            <?php if(isset($_GET['succes'])): ?>
              <?php if($_GET['succes'] == 'abonare'): ?>
                <div class="alert alert-success">Te-ai abonat cu succes.</div>
              <?php endif ?>
              <?php if($_GET['succes'] == 'dezabonare'): ?>
                <div class="alert alert-success">Te-ai dezabonat cu succes.</div>
              <?php endif ?>
              <?php if($_GET['succes'] == 'apreciere'): ?>
                <div class="alert alert-success">Videoclipul a fost apreciat cu succes.</div>
              <?php endif ?>
              <?php if($_GET['succes'] == 'dezapreciere'): ?>
                <div class="alert alert-success">Videoclipul a fost dezapreciat cu succes.</div>
              <?php endif ?>
              <?php if($_GET['succes'] == 'comentariu'): ?>
                <div class="alert alert-success">Comentariul a fost adaugat cu succes.</div>
              <?php endif ?>
              <?php if($_GET['succes'] == 'stergere_comentariu'): ?>
                <div class="alert alert-success">Comentariul a fost sters cu succes.</div>
              <?php endif ?>
            <?php endif ?>
            <div class="row">
              <div class="col-12 col-md-9 col-lg-9">
                <article class="article article-style-c">
                  <div>
                    <video controls class="video w-100" poster="videoclipuri/<?php echo $video['uniqid'] ?>/<?php echo $video['thumbnail']; ?>">
                      <source src="videoclipuri/<?php echo $uniqid; ?>/<?php echo $video['video']; ?>" type="video/mp4"></source>
                    </video>
                  </div>
                  <div class="article-details">
                    <div class="article-title">
                      <h2><a class="text-primary" style="font-size: 20px;"><?php echo $video['titlu']; ?></a></h2>
                    </div>
                    <div class="article-category"><a><?php echo $video['vizualizari']; ?> vizualizari</a> <div class="bullet"></div> <a><?php echo $video['data']; ?></a></div>
                    <div class="row align-items-center">
                      <div class="col-6">
                        <?php  
                          $id_creator = $video['id_creator'];
                          $sql_creator = "SELECT * FROM utilizatori WHERE id = '$id_creator'";
                          $result_creator = mysqli_query($db, $sql_creator);
                          $creator = $result_creator->fetch_assoc();
                        ?>
                        <div class="article-user d-flex">
                          <?php if(!empty($creator['imagine'])): ?> 
                          <img alt="image" src="utilizatori/<?php echo $creator['imagine']; ?>" style="width: 80px; height: 80px;">
                          <?php else: ?>
                          <img alt="image" src="assets/img/vizitator.png" style="width: 80px; height: 80px;">
                          <?php endif ?>
                          <div class="article-user-details">
                            <div class="user-detail-name">
                              <a href="profil.php?id=<?php echo $id_creator; ?>"><?php echo $creator['nume'] . " " . $creator['prenume']; ?></a>
                            </div>
                            <?php  
                              $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_creator'";
                              $result_abonati = mysqli_query($db, $sql_abonati);
                            ?>
                            <div class="text-job"><?php echo $result_abonati->num_rows; ?> Abonati</div>
                            <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
                            <form method="POST" action="video.php">
                              <input type="text" name="id_creator" value="<?php echo $id_creator; ?>" class="d-none">
                              <input type="text" name="uniqid_video" value="<?php echo $uniqid; ?>" class="d-none">
                              <?php  
                                  $myid = $user['id'];
                                  $sql_abonat = "SELECT * FROM abonamente WHERE id_abonat = '$myid' AND id_creator = '$id_creator'";
                                  $result_abonat = mysqli_query($db, $sql_abonat);
                              if($result_abonat->num_rows > 0):
                              ?>
                              <button class="btn btn-danger mt-1 btn-sm" name="dezabonare_video">Dezabonare</button>
                              <?php else: ?>
                              <button class="btn btn-primary mt-1 btn-sm" name="abonare_video">Abonare</button>
                              <?php endif ?>
                            </form>
                            <?php endif ?>
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="buttons-video text-right">
                          <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
                          <form method="POST" action="video.php">
                            <input type="text" name="id_video" value="<?php echo $video['id']; ?>" class="d-none">
                            <input type="text" name="id_creator" value="<?php echo $video['id_creator']; ?>" class="d-none">
                            <input type="text" name="uniqid_video" value="<?php echo $uniqid; ?>" class="d-none">
                            <?php  
                              $id_video = $video['id'];
                              $sql_apreciat = "SELECT * FROM aprecieri WHERE id_utilizator = '$myid' AND id_videoclip = '$id_video'";
                              $result_apreciat = mysqli_query($db, $sql_apreciat);
                              if($result_apreciat->num_rows > 0):
                            ?>
                            <button class="btn btn-success" type="submit" name="dezapreciere_video"><i class="far fa-heart"></i> Apreciat</button>
                            <?php else: ?>
                            <button class="btn btn-secondary" type="submit" name="apreciere_video"><i class="far fa-heart"></i> Apreciere</button>
                            <?php endif ?>
                          </form>
                          <?php endif ?>
                        </div>
                      </div>
                    </div>
                    <p style="font-size: 16px;" class="mt-5"><?php echo $video['descriere']; ?></p>
                  </div>
                </article>
                <div class="card">
                  <?php  
                      $id_video = $video['id'];
                      $sql_comentarii = "SELECT * FROM comentarii WHERE id_videoclip = '$id_video'";
                      $result_comentarii = mysqli_query($db, $sql_comentarii);
                  ?>
                  <div class="card-header">
                    <h4>Comentarii (<?php echo $result_comentarii->num_rows; ?>)</h4>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled list-unstyled-border list-unstyled-noborder">
                      <?php if(isset($_SESSION['simvideo_user']['email'])): ?>
                      <li class="media">
                        <?php if(!empty($user['imagine'])): ?>
                        <img alt="image" class="mr-3 rounded-circle" width="70" src="utilizatori/<?php echo $user['imagine']; ?>">
                        <?php else: ?>
                        <img alt="image" src="assets/img/vizitator.png" width="70" class="mr-3 rounded-circle">
                        <?php endif ?>
                        <div class="media-body">
                          <div class="media-title mb-1"><?php echo $user['nume'] . " " .$user['prenume']; ?></div>
                          <form method="POST" action="video.php">
                            <input type="text" name="id_video" value="<?php echo $video['id']; ?>" class="d-none">
                            <input type="text" name="id_creator" value="<?php echo $video['id_creator']; ?>" class="d-none">
                            <input type="text" name="uniqid_video" value="<?php echo $uniqid; ?>" class="d-none">
                            <div class="form-group">
                              <textarea class="form-control" name="comentariu" style="height: 100px !important;" placeholder="Comentariul tau"></textarea>
                            </div>
                            <div class="text-right mt-0">
                              <button class="btn btn-primary" type="submit" name="adauga_comentariu">Adauga</button>
                            </div>
                          </form>
                        </div>
                      </li>
                      <?php endif ?>
                      <?php  
                          $comentarii = mysqli_fetch_all($result_comentarii, MYSQLI_ASSOC);
                      foreach($comentarii as $comentariu):
                      ?>
                      <li class="media">
                        <?php  
                          $id_comentator = $comentariu['id_comentator'];
                          $sql_comentator = "SELECT * FROM utilizatori WHERE id = '$id_comentator'";
                          $result_comentator = mysqli_query($db, $sql_comentator);
                          $comentator = $result_comentator->fetch_assoc();    
                        ?>
                        <?php if(!empty($comentator['imagine'])): ?>
                        <img alt="image" class="mr-3 rounded-circle" width="70" src="utilizatori/<?php echo $comentator['imagine']; ?>">
                        <?php else: ?>
                        <img alt="image" class="mr-3 rounded-circle" width="70" src="assets/img/vizitator.png">
                        <?php endif ?>
                        <div class="media-body">
                          <div class="media-title mb-1"><?php echo $comentator['nume'] . " " . $comentator['prenume']; ?></div>
                          <div class="text-time"><?php echo $comentariu['data']; ?></div>
                          <div class="media-description text-muted"><?php echo $comentariu['comentariu']; ?></div>
                          <?php if(isset($_SESSION['simvideo_user']['id'])): ?>
                          <?php if($id_creator == $user['id'] || $id_comentator == $user['id']): ?>
                          <div class="media-links">
                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#stergere<?php echo $comentariu['id']; ?>">Stergere</button>
                          </div>
                          <?php endif ?>
                          <?php endif ?>
                        </div>
                      </li>
                      <?php endforeach ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-3 col-lg-3">
                <?php  
                  $id_video = $video['id'];
                  $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE id != '$id_video' ORDER BY id DESC LIMIT 5";
                  $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                  $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
                  foreach($videoclipuri as $videoclip):
                ?>
                <article class="article article-style-c">
                  <div class="article-header" style="height: 170px;">
                    <?php if (!empty($videoclip['thumbnail'])): ?>
                    <div class="article-image" data-background="videoclipuri/<?php echo $videoclip['uniqid'] ?>/<?php echo $videoclip['thumbnail']; ?>" style="height: 170px;">
                    </div>
                    <?php else: ?>
                    <div class="article-image" data-background="videoclipuri/poster.jpg" style="height: 170px;">
                    </div>
                    <?php endif ?>
                  </div>
                  <div class="article-details">
                    <div class="article-category"><a><?php echo $videoclip['durata']; ?></a> <div class="bullet"></div> <a><?php echo $videoclip['vizualizari']; ?> vizualizari</a> <div class="bullet"></div> <a><?php echo $videoclip['data']; ?></a></div>
                    <div class="article-title">
                      <h2><a href="video.php?uniqid=<?php echo $videoclip['uniqid']; ?>" style="font-size: 16px;"><?php echo $videoclip['titlu']; ?></a></h2>
                    </div>
                    <?php  
                      $id_creator = $videoclip['id_creator'];
                      $sql_creator = "SELECT * FROM utilizatori WHERE id = '$id_creator'";
                      $result_creator = mysqli_query($db, $sql_creator);
                      $creator = $result_creator->fetch_assoc();
                    ?>
                    <div class="article-user">
                      <?php if(!empty($creator['imagine'])): ?> 
                      <img alt="image" src="utilizatori/<?php echo $creator['imagine']; ?>">
                      <?php else: ?>
                      <img alt="image" src="assets/img/vizitator.png">
                      <?php endif ?>
                      <div class="article-user-details">
                        <div class="user-detail-name">
                          <a href="profil.php?id=<?php echo $id_creator; ?>"><?php echo $creator['nume'] . " " . $creator['prenume']; ?></a>
                        </div>
                        <?php  
                          $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_creator'";
                          $result_abonati = mysqli_query($db, $sql_abonati);
                        ?>
                        <div class="text-job"><?php echo $result_abonati->num_rows; ?> Abonati</div>
                      </div>
                    </div>
                  </div>
                </article>
                <?php endforeach ?>
              </div>
            </div>
        </section>
      </div>
    </div>
  </div>
  <?php
  foreach($comentarii as $comentariu):
  ?>
  <div class="modal fade" id="stergere<?php echo $comentariu['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Stergere comentariul</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="video.php">
          <input type="text" name="uniqid_video" value="<?php echo $uniqid; ?>" class="d-none">
          <input type="text" name="id" value="<?php echo $comentariu['id']; ?>" class="d-none">
          <div class="modal-body text-center">
            <i class="fas fa-exclamation-circle text-danger" style="font-size: 50px;"></i>
            <p>Esti sigur ca vrei sa stergi comentariul <font class="text-primary"><?php echo $comentariu['comentariu']; ?></font>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Nu</button>
            <button type="submit" class="btn btn-danger" name="stergere_comentariu">Da</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php endforeach ?>
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/main.js"></script>
  
  <script src="assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
  <script src="assets/modules/chart.min.js"></script>
  <script src="assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="assets/modules/summernote/summernote-bs4.js"></script>
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <script src="assets/js/page/index-0.js"></script>
  <script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="assets/js/page/components-user.js"></script>
  
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>