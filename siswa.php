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
        $edit = mysqli_query($koneksi, "UPDATE siswa set 
                                            nis = '$_POST[tnis]',
                                            namasiswa = '$_POST[tnamasiswa]',
                                            tanggalLahirSiswa = '$_POST[ttanggalLahirSiswa]',
                                            jenisKelaminSiswa = '$_POST[tjenisKelaminSiswa]',
                                            alamatSiswa = '$_POST[talamatSiswa]',
                                            noTlpnSiswa = '$_POST[tnoTlpnSiswa]',
                                            NamaOrangTua = '$_POST[tNamaOrangTua]',
                                            kodeJurusan = '$_POST[tkodeJurusan]'
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
        $simpan = mysqli_query($koneksi, "INSERT INTO siswa (nis, namasiswa, tanggalLahirSiswa, jenisKelaminSiswa, alamatSiswa, noTlpnSiswa, NamaOrangTua, kodeJurusan) 
                                            VALUES ('$_POST[tnis]',
                                                    '$_POST[tnamasiswa]',
                                                    '$_POST[ttanggalLahirSiswa]',
                                                    '$_POST[tjenisKelaminSiswa]',
                                                    '$_POST[talamatSiswa]',
                                                    '$_POST[tnoTlpnSiswa]',
                                                    '$_POST[tNamaOrangTua]',
                                                    '$_POST[tkodeJurusan]')
                                                    ");
        if ($simpan) {
            echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='siswa.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='siswa.php';
                    </script>";
        }
    }
}
//uji coba jika tombol edit or hapus
if (isset($_GET['hal'])) {
    //tampil data yang akan di edit
    if ($_GET['hal'] == "edit") {
        //tampil data diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis= '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan ditampung ke variable
            $vvnis = $data['nis'];
            $vvnama = $data['namasiswa'];
            $vvtgl = $data['tanggalLahirSiswa'];
            $vvjenis = $data['jenisKelaminSiswa'];
            $vvalamat = $data['alamatSiswa'];
            $vvnoTlpnSiswa = $data['noTlpnSiswa'];
            $vvNamaOrangTua = $data['NamaOrangTua'];
            $vvkodeJurusan = $data['kodeJurusan'];
        }
    } else if ($_GET['hal'] == "hapus") {
        ///hapus
        $hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE nis = '$_GET[id]' ");
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
                Form Siswa
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>nis</label>
                        <input type="text" name="tnis" value="<?= @$$vvnis ?>" class="form-control" placeholder="input nis" required>
                    </div>
                    <div class="form-group">
                        <label>nama siswa</label>
                        <input type="text" name="tnamasiswa" value="<?= @$vvnama ?>" class="form-control" placeholder="nama Siswa" required>
                    </div>
                    <div class="form-group">
                        <label>tanggal Lahir Siswa</label>
                        <input type="date" name="ttanggalLahirSiswa" value="<?= @$vvjenis ?>" class="form-control" placeholder="input tanggal lahir" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis kelamin Siswa</label>
                        <select class="form-control" name="tjenisKelaminSiswa">
                            <option value="<?= @$vvjenis ?>"><?= @$vvjenis ?></option>
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" name="talamatSiswa" value="<?= @$vvalamat ?>" class="form-control" placeholder="input Alamat" required>
                    </div>
                    <div class="form-group">
                        <label> no telepon Siswa</label>
                        <input type="text" name="tnoTlpnSiswa" value="<?= @$vvnoTlpnSiswa ?>" class="form-control" placeholder="input Nomor telepon" required>
                    </div>
                    <div class="form-group">
                        <label> NamaOrangTua</label>
                        <input type="text" name="tNamaOrangTua" value="<?= @$vvNamaOrangTua ?>" class="form-control" placeholder="input Nama Orangtua" required>
                    </div>
                    <div class="form-group">
                        <label> kode Jurusan</label>
                        <input type="text" name="tkodeJurusan" value="<?= @$vvkodeJurusan ?>" class="form-control" placeholder="input kode jurusan" required>
                    </div>
                    <a class="btn btn-danger" href="../menu.php">Kembali</a>
                    <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
                    <button type="reset" class="btn btn-danger" name="reset">Kosongkan Data</button>

                </form>
            </div>
        </div>
        <!--akhir-->

        <!--awal tabel-->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                Data Guru
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>tanggal Lahir Siswa</th>
                        <th>Jenis kelamin Siswa</th>
                        <th>alamat Siswa</th>
                        <th>No tlpn Siswa</th>
                        <th>NamaOrangTua</th>
                        <th>kode Jurusan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * From siswa order by nis asc");
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nis'] ?></td>
                            <td><?= $data['namasiswa'] ?></td>
                            <td><?= $data['tanggalLahirSiswa'] ?></td>
                            <td><?= $data['jenisKelaminSiswa'] ?></td>
                            <td><?= $data['alamatSiswa'] ?></td>
                            <td><?= $data['noTlpnSiswa'] ?></td>
                            <td><?= $data['NamaOrangTua'] ?></td>
                            <td><?= $data['kodeJurusan'] ?></td>
                            <td>
                                <a class="btn btn-danger" href="../menu.php">Kembali</a>
                                <a href="siswa.php?hal=edit&id=<?= $data['nis'] ?>" class="btn btn-warning">Update</a>
                                <a href="siswa.php?hal=hapus&id=<?= $data['nis'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
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

</html>