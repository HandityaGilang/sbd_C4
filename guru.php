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
        $edit = mysqli_query($koneksi, "UPDATE guru set 
                                            nip = '$_POST[tnip]',
                                            namaGuru = '$_POST[tnamaGuru]',
                                            tanggal_lahir_guru = '$_POST[ttanggal_lahir_guru]',
                                            Jenis_kelamin_guru = '$_POST[tJenis_kelamin_guru]',
                                            alamat_guru = '$_POST[talamat_guru]',
                                            no_tlpn_guru = '$_POST[tno_tlpn_guru]'
                                            WHERE nip = '$_GET[id]'
                                            ");
        if ($edit) //edit sukses
        {
            echo "<script>
                        alert('Edit data SUKSES');
                        document.location='guru.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Edit data GAGAL');
                        document.location='guru.php';
                    </script>";
        }
    } else {
        //data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO guru (nip, namaGuru, tanggal_lahir_guru, Jenis_kelamin_guru, alamat_guru, no_tlpn_guru) 
                                            VALUES ('$_POST[tnip]',
                                                    '$_POST[tnamaGuru]',
                                                    '$_POST[ttanggal_lahir_guru]',
                                                    '$_POST[tJenis_kelamin_guru]',
                                                    '$_POST[talamat_guru]',
                                                    '$_POST[tno_tlpn_guru]')
                                                    ");
        if ($simpan) {
            echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='guru.php';
                    </script>";
        } else {
            echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='guru.php';
                    </script>";
        }
    }
}
//uji coba jika tombol edit or hapus
if (isset($_GET['hal'])) {
    //tampil data yang akan di edit
    if ($_GET['hal'] == "edit") {
        //tampil data diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM guru WHERE nip= '$_GET[id]' ");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan ditampung ke variable
            $vvnip = $data['nip'];
            $vvnama = $data['namaGuru'];
            $vvtgl = $data['tanggal_lahir_guru'];
            $vvjenis = $data['Jenis_kelamin_guru'];
            $vvalamat = $data['alamat_guru'];
            $vvnomer = $data['no_tlpn_guru'];
        }
    } else if ($_GET['hal'] == "hapus") {
        ///hapus
        $hapus = mysqli_query($koneksi, "DELETE FROM guru WHERE nip = '$_GET[id]' ");
        if ($hapus) {
            echo "<script>
                        alert('Hapus data SUKSES');
                        document.location='guru.php';
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
                Form input Data Guru
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label>nip</label>
                        <input type="text" name="tnip" value="<?= @$$vvnip ?>" class="form-control" placeholder="input nip" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Guru</label>
                        <input type="text" name="tnamaGuru" value="<?= @$vvnama ?>" class="form-control" placeholder="nama Guru" required>
                    </div>
                    <div class="form-group">
                        <label>tanggal lahir guru</label>
                        <input type="date" name="ttanggal_lahir_guru" value="<?= @$vvtgl ?>" class="form-control" placeholder="input tanggal lahir" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis kelamin</label>
                        <select class="form-control" name="tJenis_kelamin_guru">
                            <option value="<?= @$vvjenis ?>"><?= @$vvjenis ?></option>
                            <option value="L">L</option>
                            <option value="P">P</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label> alamat guru</label>
                        <input type="text" name="talamat_guru" value="<?= @$vvalamat ?>" class="form-control" placeholder="input Alamat" required>
                    </div>
                    <div class="form-group">
                        <label> no telepon</label>
                        <input type="text" name="tno_tlpn_guru" value="<?= @$vvnomer ?>" class="form-control" placeholder="input Nomor telepon" required>
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
                        <th>NIP</th>
                        <th>Nama Guru</th>
                        <th>tanggal_lahir_guru</th>
                        <th>Jenis_kelamin_guru</th>
                        <th>alamat_guru</th>
                        <th>no_tlpn_guru</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * From guru order by nip desc");
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $data['nip'] ?></td>
                            <td><?= $data['namaGuru'] ?></td>
                            <td><?= $data['tanggal_lahir_guru'] ?></td>
                            <td><?= $data['Jenis_kelamin_guru'] ?></td>
                            <td><?= $data['alamat_guru'] ?></td>
                            <td><?= $data['no_tlpn_guru'] ?></td>
                            <td>
                                <a href="guru.php?hal=edit&id=<?= $data['nip'] ?>" class="btn btn-warning">Update</a>
                                <a href="guru.php?hal=hapus&id=<?= $data['nip'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
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