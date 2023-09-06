<?php
    session_start();
	$db = mysqli_connect('localhost', 'root', '', 'simvideo');

	if(isset($_POST['creare_cont'])){
        creare_cont();
    }
    function creare_cont(){
        global $db;
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $email = $_POST['email'];
        $telefon = $_POST['telefon'];
        $parola1 = $_POST['parola1'];
        $parola2 = $_POST['parola2'];
        $sql1 = "SELECT * FROM utilizatori WHERE email = '$email'";
        $result1 = mysqli_query($db, $sql1);
        if($result1->num_rows > 0){
            header("Location: creare-cont.php?eroare=email");
            exit();
        }
        if($parola1 != $parola2){
            header("Location: creare-cont.php?eroare=parola");
            exit();
        }
        $parola = password_hash($parola1, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilizatori (nume, prenume, email, telefon, parola) VALUES ('$nume', '$prenume', '$email', '$telefon', '$parola')";
        mysqli_query($db, $sql);
        header("Location: conectare.php?succes=cont");
        ecit();
    }

    if(isset($_POST['conectare'])){
        conectare();
    }
    function conectare(){
        global $db;
        $email = $_POST['email'];
        $parola = $_POST['parola'];

        $sql = "SELECT * FROM utilizatori where email = '$email'";
        $result = $db->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $parola_db = $row['parola'];
            if(password_verify($parola, $parola_db) != 1){
                header("Location: conectare.php?eroare=parola");
            }else{
                $logged_in_user = $row;
                $_SESSION['simvideo_user'] = $logged_in_user;
                $email = $_SESSION['simvideo_user']['email'];
                header('location: index.php');
            }
        }else{
            header("Location: conectare.php?eroare=cont");
        }
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['simvideo_user']);
        header("location: index.php");
    }

    if(isset($_POST['modificare_parola'])){
        modificare_parola();
    }

    function modificare_parola(){
        global $db;
        $email = $_SESSION['simvideo_user']['email'];
        $parola1 = $_POST['parola1'];
        $parola2 = $_POST['parola2'];
        if($parola1 != $parola2){
            header("Location: edit-profil.php?eroare=parola");
        }else{
            $parola = password_hash($parola1, PASSWORD_DEFAULT);
            $sql1 = "UPDATE utilizatori SET parola = '$parola' WHERE email = '$email'";
            mysqli_query($db, $sql1);
            header("Location: edit-profil.php?succes=parola");
            exit();
        }
    }


    if(isset($_POST['edit_profil'])){
		edit_profil();
	}
	function edit_profil(){
		global $db;
		$nume = $_POST['nume'];
		$prenume = $_POST['prenume'];
		$telefon = $_POST['telefon'];
		$email = $_POST['email'];
		$descriere = $_POST['descriere'];
		if(file_exists($_FILES['imagine']['tmp_name'])){
			$sql0 = "SELECT * FROM utilizatori WHERE email = '$email'";
			$result0 = mysqli_query($db, $sql0);
			$row0 = $result0->fetch_assoc();
			$folder = "utilizatori";
			$fisv = $folder . "/" . $row0['imagine'];
            unlink($fisv);
	        $imagine_ut = basename($_FILES['imagine']['name']);
	        $extension = end(explode(".", $imagine_ut));
	        $prod = uniqid();
	        $imagine = $prod .".".$extension;
	        $img_upload = $folder . "/" . $imagine;
	        move_uploaded_file($_FILES['imagine']['tmp_name'], $img_upload);
	        $sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', telefon = '$telefon', imagine = '$imagine', descriere = '$descriere' WHERE email = '$email'";
	        mysqli_query($db, $sql);
	    }else{
	    	$sql = "UPDATE utilizatori SET nume = '$nume', prenume = '$prenume', telefon = '$telefon', descriere = '$descriere' WHERE email = '$email'";
	        mysqli_query($db, $sql);
	    }
		header("Location: edit-profil.php?succes=profil");
		exit();
	}

    if(isset($_POST['edit_video'])){
        edit_video();
    }
    function edit_video(){
        global $db;
        $uniqid = $_POST['uniqid'];
        $titlu = $_POST['titlu'];
        $descriere = $_POST['descriere'];
        $status = $_POST['status'];
        if(file_exists($_FILES['imagine']['tmp_name'])){
            $sql0 = "SELECT * FROM videoclipuri WHERE uniqid = '$uniqid'";
            $result0 = mysqli_query($db, $sql0);
            $row0 = $result0->fetch_assoc();
            $folder = "videoclipuri/". $uniqid;
            $fisv = $folder . "/" . $row0['thumbnail'];
            unlink($fisv);
            $imagine_ut = basename($_FILES['imagine']['name']);
            $extension = end(explode(".", $imagine_ut));
            $prod = uniqid();
            $imagine = $prod .".".$extension;
            $img_upload = $folder . "/" . $imagine;
            move_uploaded_file($_FILES['imagine']['tmp_name'], $img_upload);
            $sql = "UPDATE videoclipuri SET titlu = '$titlu', descriere = '$descriere', thumbnail = '$imagine', status = '$status' WHERE uniqid = '$uniqid'";
            mysqli_query($db, $sql);
        }else{
            $sql = "UPDATE videoclipuri SET titlu = '$titlu', descriere = '$descriere', status = '$status' WHERE uniqid = '$uniqid'";
            mysqli_query($db, $sql);
        }
        header("Location: edit-video.php?uniqid=$uniqid&succes=edit");
        exit();
    }

    if(isset($_POST['stergere_video'])){
        stergere_video();
    }
    function stergere_video(){
        global $db;
        $uniqid = $_POST['uniqid'];
        $id = $_POST['id'];

        $sql = "DELETE FROM aprecieri WHERE id_videoclip = '$id'";
        mysqli_query($db, $sql);

        $sql1 = "DELETE FROM comentarii WHERE id_videoclip = '$id'";
        mysqli_query($db, $sql1);

        $sql2 = "DELETE FROM videoclipuri WHERE id = '$id'";
        mysqli_query($db, $sql2);

        $folder = "videoclipuri/" . $uniqid;
        array_map('unlink', glob("$folder/*.*"));
        rmdir($folder);

        header("Location: videoclipurile-mele.php?succes=stergere");
        exit();
    }

    if(isset($_POST['dezabonare_abonamente'])){
        dezabonare_abonamente();
    }
    function dezabonare_abonamente(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];

        $sql = "DELETE FROM abonamente WHERE id_creator = '$id_creator' AND id_abonat = '$myid'";
        mysqli_query($db, $sql);

        header("Location: abonamente.php?succes=dezabonare");
        exit();
    }

    if(isset($_POST['abonare_profil'])){
        abonare_profil();
    }
    function abonare_profil(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];

        $sql = "INSERT INTO abonamente (id_abonat, id_creator) VALUES ('$myid', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: profil.php?id=$id_creator");
        exit();
    }

    if(isset($_POST['dezabonare_profil'])){
        dezabonare_profil();
    }
    function dezabonare_profil(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];

        $sql = "DELETE FROM abonamente WHERE id_creator = '$id_creator' AND id_abonat = '$myid'";
        mysqli_query($db, $sql);

        header("Location: profil.php?id=$id_creator");
        exit();
    }

    if(isset($_POST['abonare_video'])){
        abonare_video();
    }
    function abonare_video(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "INSERT INTO abonamente (id_abonat, id_creator) VALUES ('$myid', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&succes=abonare");
        exit();
    }

    if(isset($_POST['dezabonare_video'])){
        dezabonare_video();
    }
    function dezabonare_video(){
        global $db;
        $id_creator = $_POST['id_creator'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "DELETE FROM abonamente WHERE id_creator = '$id_creator' AND id_abonat = '$myid'";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&succes=dezabonare");
        exit();
    }

    if(isset($_POST['apreciere_video'])){
        apreciere_video();
    }
    function apreciere_video(){
        global $db;
        $id_video = $_POST['id_video'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];
        $id_creator = $_POST['id_creator'];

        $sql = "INSERT INTO aprecieri (id_videoclip, id_utilizator, id_creator) VALUES ('$id_video', '$myid', '$id_creator')";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&succes=apreciere");
        exit();
    }

    if(isset($_POST['dezapreciere_video'])){
        dezapreciere_video();
    }
    function dezapreciere_video(){
        global $db;
        $id_video = $_POST['id_video'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "DELETE FROM aprecieri WHERE id_videoclip = '$id_video' AND id_utilizator = '$myid'";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&succes=dezapreciere");
        exit();
    }

    if(isset($_POST['adauga_comentariu'])){
        adauga_comentariu();
    }
    function adauga_comentariu(){
        global $db;
        $id_video = $_POST['id_video'];
        $myid = $_SESSION['simvideo_user']['id'];
        $uniqid_video = $_POST['uniqid_video'];
        $id_creator = $_POST['id_creator'];
        $comentariu = $_POST['comentariu'];
        date_default_timezone_set('Europe/Bucharest');
        $data = date("d-m-Y H:i", strtotime('now'));
        $sql = "INSERT INTO comentarii (id_videoclip, id_creator, id_comentator, comentariu, data) VALUES ('$id_video', '$id_creator', '$myid', '$comentariu', '$data')";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&succes=comentariu");
        exit();
    }

    if(isset($_POST['stergere_comentariu'])){
        stergere_comentariu();
    }
    function stergere_comentariu(){
        global $db;
        $id = $_POST['id'];
        $uniqid_video = $_POST['uniqid_video'];

        $sql = "DELETE FROM comentarii WHERE id = '$id'";
        mysqli_query($db, $sql);

        header("Location: video.php?uniqid=$uniqid_video&succes=stergere_comentariu");
        exit();
    }