<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "c4_db";

$koneksi = mysqli_connect($server, $user, $pass, $db) or die(mysqli_error($koneksi));


//jika tombol simpan di klik
if (isset($_POST['simpan'])) {
    //uji data akan diedit atau simpan baru
    if ($_GET['hal'] == "edit") {
        //data akan di edit
        $edit = mysqli_query($koneksi, "UPDATE registrasikelas set 
                                            nis = '$_POST[tnis]',
                                            idKelas = '$_POST[tnamasiswa]',
                                            tahunAjaran = '$_POST[ttanggalLahirSiswa]',
                                            nip_guru_wali = '$_POST[tjenisKelaminSiswa]'
                                            WHERE nis = '$_GET[id]'
                                            ");
        if ($edit) //edit sukses
        {
            echo "<script>
                        alert('Edit data SUKSES');
                        document.location='siswa.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Edit data GAGAL');
                        document.location='siswa.php';
                    </script>";
        }
    } else {
        //data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO registrasikelas (nis, idKelas, tahunAjaran, nip_guru_wali) 
                                            VALUES ('$_POST[tnis]',
                                                    '$_POST[tidKelas]',
                                                    '$_POST[ttahunAjaran]',
                                                    '$_POST[tnip_guru_wali]')
                                                    ");
        if ($simpan) {
            echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='registrasi.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='regiskelas.php';
                    </script>";
        }
    }
}
//uji coba jika tombol edit or hapus
if (isset($_GET['hal'])) {
    //tampil data yang akan di edit
    if ($_GET['hal'] == "edit") {
        //tampil data diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM registrasikelas WHERE nis= '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan ditampung ke variable
            $vvnis = $data['nis'];
            $vvid = $data['idKelas'];
            $vvthnajar = $data['tahunAjaran'];
            $vvnipguru = $data['nip_guru_wali'];
        }
    } else if ($_GET['hal'] == "hapus") {
        ///hapus
        $hapus = mysqli_query($koneksi, "DELETE FROM registrasikelas WHERE nis = '$_GET[id]' ");
        if ($hapus) {
            echo "<script>
                        alert('Hapus data SUKSES');
                        document.location='siswa.php';
                    </script>";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>CRUD KELOMPOK C4</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="text-center">CRUD KELOMPOK C4</h1>
        <!--awal cardform-->
        <div class="card mt-3">
            <div class="card-header bg-pimary text-white">
                Form Registrasi Kelas
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>nis</label>
                        <input type="text" name="tnis" value="<?= @$$vvnis ?>" class="form-control" placeholder="input nis" required>
                    </div>
                    <div class="form-group">
                        <label>idKelas</label>
                        <input type="text" name="tidKelas" value="<?= @$vvnama ?>" class="form-control" placeholder="nama idkelas" required>
                    </div>
                    <div class="form-group">
                        <label>tahunAjaran</label>
                        <input type="text" name="ttahunAjaran" value="<?= @$vvjenis ?>" class="form-control" placeholder="input Tahun ajaran" required>
                    </div>
                    <div class="form-group">
                        <label>nip_guru_wali</label>
                        <input type="text" name="tnip_guru_wali" value="<?= @$vvjenis ?>" class="form-control" placeholder="input nip guru wali" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                </form>
            </div>
        </div>
        <!--akhir-->

    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>