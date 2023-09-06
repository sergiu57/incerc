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
  <title>SimVideo - Editare profil</title>
  <link href="assets/img/logo-min.png" rel="icon">

  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/jquery-selectric/selectric.css">
  <link rel="stylesheet" href="assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">

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
            <h1>Setari profil</h1>
          </div>
          <div class="section-body">
            <h2 class="section-title">Salut, <?php echo $user['prenume']; ?>!</h2>  
            <?php if(isset($_GET['succes'])): ?>
                <?php if($_GET['succes'] == 'parola'): ?>
                  <div class="alert alert-success">Parola ta a fost modificata cu succes.</div>
                <?php endif ?>
                <?php if($_GET['succes'] == 'profil'): ?>
                  <div class="alert alert-success">Informatiile profilului au fost modificate cu succes.</div>
                <?php endif ?>
              <?php endif ?>
              <?php if(isset($_GET['eroare'])): ?>
                <?php if($_GET['eroare'] == 'parola'): ?>
                  <div class="alert alert-danger">Parolele introduse nu coincid.</div>
                <?php endif ?>
              <?php endif ?>
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                  <div class="profile-widget-header">  
                    <?php if(!empty($user['imagine'])): ?>                   
                    <img alt="image" src="utilizatori/<?php echo $user['imagine']; ?>" class="rounded-circle profile-widget-picture">
                    <?php else: ?>
                    <img alt="image" src="assets/img/vizitator.png" class="rounded-circle profile-widget-picture">
                    <?php endif ?>
                    <div class="profile-widget-items">
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Abonati</div>
                        <?php  
                            $id_user = $user['id'];
                            $sql_abonati = "SELECT * FROM abonamente WHERE id_creator = '$id_user'";
                            $result_abonati = mysqli_query($db, $sql_abonati);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_abonati->num_rows; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Videoclipuri</div>
                        <?php  
                            $sql_videoclipuri = "SELECT * FROM videoclipuri WHERE id_creator = '$id_user'";
                            $result_videoclipuri = mysqli_query($db, $sql_videoclipuri);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_videoclipuri->num_rows; ?></div>
                      </div>
                      <div class="profile-widget-item">
                        <div class="profile-widget-item-label">Aprecieri</div>
                        <?php  
                            $sql_aprecieri = "SELECT * FROM aprecieri WHERE id_creator = '$id_user'";
                            $result_aprecieri = mysqli_query($db, $sql_aprecieri);
                        ?>
                        <div class="profile-widget-item-value"><?php echo $result_aprecieri->num_rows; ?></div>
                      </div>
                    </div>
                  </div>
                  <div class="profile-widget-description">
                    <div class="profile-widget-name"><?php echo $user['nume'] . " " . $user['prenume']; ?></div>
                    <?php echo $user['descriere']; ?>
                  </div>
                </div>
                <div class="card">
                  <form method="post" action="edit-profil.php">
                    <div class="card-header">
                      <h4>Editare parola</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">     
                          <div class="form-group col-md-12 col-12">
                            <label>Parola noua</label>
                            <input type="password" class="form-control" name="parola1" required>
                          </div>
                          <div class="form-group col-md-12 col-12">
                            <label>Parola noua</label>
                            <input type="password" class="form-control" name="parola2" required>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right mt-0 pt-0">
                      <button class="btn btn-primary" type="submit" name="modificare_parola">Salveaza modificarile</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                  <form method="post" action="edit-profil.php" enctype="multipart/form-data">
                    <div class="card-header">
                      <h4>Editare profil</h4>
                    </div>
                    <div class="card-body">
                        <div class="row"> 
                          <div class="col-md-12 mb-4">
                            <div id="image-preview" class="image-preview">
                              <label for="image-upload" id="image-label">Imagine profil</label>
                              <input type="file" name="imagine" id="image-upload" />
                            </div>
                          </div>                              
                          <div class="form-group col-md-6 col-12">
                            <label>Nume</label>
                            <input type="text" class="form-control" name="nume" value="<?php echo $user['nume']; ?>" required>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Prenume</label>
                            <input type="text" class="form-control" name="prenume" value="<?php echo $user['prenume']; ?>" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-6 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" readonly>
                          </div>
                          <div class="form-group col-md-6 col-12">
                            <label>Telefon</label>
                            <input type="text" class="form-control" name="telefon" value="<?php echo $user['telefon']; ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-12">
                            <label>Despre mine</label>
                            <textarea class="form-control" name="descriere" style="height: 150px !important;"><?php echo $user['descriere']; ?></textarea>
                          </div>
                        </div>
                    </div>
                    <div class="card-footer text-right mt-0 pt-0">
                      <button class="btn btn-primary" name="edit_profil">Salveaza modificarile</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
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
  <script src="assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="assets/modules/upload-preview/assets/js/jquery.uploadPreview.min.js"></script>

  <script src="assets/js/page/index-0.js"></script>
  <script src="assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
  <script src="assets/js/page/components-user.js"></script>
  <script src="assets/js/page/features-post-create.js"></script>
  
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>