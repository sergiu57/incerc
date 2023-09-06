<?php include('functions.php'); 
      if(!isset($_SESSION['simvideo_user']['email'])){
        header("Location: index.php");
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>SimVideo - Acasa abonamente</title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">

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
            <h1>Acasa</h1>
          </div>
          <h2 class="section-title">Noutati abonamente</h2>
            <div class="row">
              <?php  
                $sql_videoclipuri = "SELECT * FROM videoclipuri ORDER BY id DESC";
                $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                $videoclipuri = mysqli_fetch_all($result_videoclipuri, MYSQLI_ASSOC);
                foreach($videoclipuri as $videoclip):
              ?>
              <?php  
                  $myid = $user['id'];
                  $id_creator = $videoclip['id_creator'];
                  $sql_abonat = "SELECT * FROM abonamente WHERE id_abonat = '$myid' AND id_creator = '$id_creator'";
                  $result_abonat = mysqli_query($db, $sql_abonat);
              if($result_abonat->num_rows > 0):
              ?>
              <div class="col-12 col-md-4 col-lg-4">
                <article class="article article-style-c">
                  <div class="article-header">
                    <?php if (!empty($videoclip['thumbnail'])): ?>
                      <div class="article-image" data-background="videoclipuri/<?php echo $videoclip['uniqid'] ?>/<?php echo $videoclip['thumbnail']; ?>">
                    <?php else: ?>
                      <div class="article-image" data-background="videoclipuri/poster.jpg">
                    <?php endif ?>
                    </div>
                  </div>
                  <div class="article-details">
                    <div class="article-category"><a><?php echo $videoclip['durata']; ?></a> <div class="bullet"></div> <a><?php echo $videoclip['vizualizari']; ?> vizualizari</a> <div class="bullet"></div> <a><?php echo $videoclip['data']; ?></a></div>
                    <div class="article-title">
                      <h2><a href="video.php?uniqid=<?php echo $videoclip['uniqid']; ?>"><?php echo $videoclip['titlu']; ?></a></h2>
                    </div>
                    <?php  
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
              </div>
              <?php endif ?>
              <?php endforeach ?>
            </div>
        </section>
      </div>
    </div>
  </div>
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