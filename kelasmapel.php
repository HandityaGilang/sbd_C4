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
        $edit = mysqli_query($koneksi, "UPDATE jadwal set 
                                            nis = '$_POST[tnis]',
                                            idKelas  = '$_POST[tidKelas]',
                                            tahunAjaran = '$_POST[ttahunAjaran]',
                                            nip_guru_wali = '$_POST[tnip_guru_wali]'
                                            WHERE nis = '$_GET[id]'
                                            ");
        if ($edit) //edit sukses
        {
            echo "<script>
                        alert('Edit data SUKSES');
                        document.location='jadwal.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Edit data GAGAL');
                        document.location='jadwal.php';
                    </script>";
        }
    } else {
        //data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO registrasikelas (idKelasMataPelajaran, idKelas, idMapel, nip, idJadwal, tahunAjaran) 
                                            VALUES ('$_POST[tidKelasMataPelajaran]',
                                                    '$_POST[tidKelas]',
                                                    '$_POST[tidMapel]',
                                                    '$_POST[ttnip]',
                                                    '$_POST[tidJadwal]',
                                                    '$_POST[ttahunAjaran]')
                                                    ");
        if ($simpan) {
            echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='kelasmapel.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='kelasmapel.php';
                    </script>";
        }
    }
}
//uji coba jika tombol edit or hapus
if (isset($_GET['hal'])) {
    //tampil data yang akan di edit
    if ($_GET['hal'] == "edit") {
        //tampil data diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE idjadwal= '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan ditampung ke variable
            $vvidKelasMataPelajaran = $data['idKelasMataPelajaran'];
            $vvidKelas = $data['idKelas'];
            $vvidMapel = $data['idMapel'];
            $vvnip = $data['nip'];
            $vvidJadwal = $data['idJadwal'];
            $vvtahunAjaran = $data['tahunAjaran'];
        }
    } else if ($_GET['hal'] == "hapus") {
        ///hapus
        $hapus = mysqli_query($koneksi, "DELETE FROM registrasikelas WHERE nis = '$_GET[id]' ");
        if ($hapus) {
            echo "<script>
                        alert('Hapus data SUKSES');
                        document.location='registrasi.php';
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
        <div class="card">
            <div class="card-header bg-primary text-white">
                Form Registrasi Kelas
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>idKelasMataPelajaran</label>
                        <input type="text" name="tidKelasMataPelajaran" value="<?= @$vvidKelasMataPelajaran ?>" class="form-control" placeholder="input id kelas mata pelajaran" required>
                    </div>
                    <div class="form-label-group">
                        <label> idKelas </label>
                        <?php
                        $s = "select * from kelas";
                        $query = mysqli_query($koneksi, $s) or die($s);
                        ?>
                        <select name="tidKelas" id="kelas" class="form-control">
                            <option value="">Pilih Kelas</option>
                            <?php
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) :;
                            ?>

                                <option value="<?php echo $row['idkelas']; ?>"><?php echo $row['deskripsikelas']; ?></option>
                            <?php
                            endwhile;
                            ?>
                        </select>
                    </div>
                    <div class="form-label-group">
                        <label> idMapel </label>
                        <?php
                        $s = "select * from matapelajaran";
                        $query = mysqli_query($koneksi, $s) or die($s);
                        ?>
                        <select name="tidMapel" id="idMapel" class="form-control">
                            <option value="">Pilih Mapel</option>
                            <?php
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) :;
                            ?>

                                <option value="<?php echo $row['idMapel']; ?>"><?php echo $row['namaMapel']; ?></option>
                            <?php
                            endwhile;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>nip</label>
                        <input type="text" name="tnip" value="<?= @$vvnip ?>" class="form-control" placeholder="input nip" required>
                    </div>
                    <div class="form-label-group">
                        <label> idMapel </label>
                        <?php
                        $s = "select * from jadwal";
                        $query = mysqli_query($koneksi, $s) or die($s);
                        ?>
                        <select name="tidjadwal" id="idjadwal" class="form-control">
                            <option value="">idjadwal</option>
                            <?php
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) :;
                            ?>

                                <option value="<?php echo $row['idjadwal']; ?>"><?php echo $row['hari']; ?>-<?php echo $row['sesi']; ?></option>
                            <?php
                            endwhile;
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>tahun Ajaran</label>
                        <input type="text" name="ttahunAjaran" value="<?= @$vvtahunAjaran ?>" class="form-control" placeholder="input tahun ajaran" required>
                    </div>
                    <a class="btn btn-danger" href="../menu.php">Kembali</a>
                    <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                    <button type="reset" class="btn btn-danger" name="reset">Kosongkan Data</button>

                </form>
            </div>
        </div>
        <!--akhir-->
        <!--daftar list guru-->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    List Guru yang ada
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>NIS</th>
            <th>Nama Guru</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * FROM guru ");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nip']?></td>
            <td><?=$data['namaGuru']?></td>
            <td>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
  </div>
</div>

        <!--awal tabel-->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                List Siswa yang ada
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>id kelas mata pelajran</th>
                        <th>id kelas</th>
                        <th>id Mapel</th>
                        <th>nip</th>
                        <th>id jadwal</th>
                        <th>Tahun Ajaran</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * FROM kelasmatapelajaran ");
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['idKelasMataPelajaran'] ?></td>
                            <td><?= $data['idKelas'] ?></td>
                            <td><?= $data['idMapel'] ?></td>
                            <td><?= $data['nip'] ?></td>
                            <td><?= $data['idJadwal'] ?></td>
                            <td><?= $data['tahunAjaran'] ?></td>
                            <td>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        <!--akhir-->

    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>