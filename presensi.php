<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "c4_db";

$koneksi = mysqli_connect($server, $user, $pass, $db) or die(mysqli_error($koneksi));


    //jika tombol simpan di klik
    if(isset($_POST['simpan']))
    {
        //uji data akan diedit atau simpan baru
        if($_GET['hal']=="edit")
        {
            //data akan di edit
            $edit = mysqli_query($koneksi, "UPDATE jadwal set 
                                            nis = '$_POST[tnis]',
                                            idKelas  = '$_POST[tidKelas]',
                                            tahunAjaran = '$_POST[ttahunAjaran]',
                                            nip_guru_wali = '$_POST[tnip_guru_wali]'
                                            WHERE nis = '$_GET[id]'
                                            ");
            if($edit) //edit sukses
            {
                echo "<script>
                        alert('Edit data SUKSES');
                        document.location='jadwal.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Edit data GAGAL');
                        document.location='jadwal.php';
                    </script>";
            }
        }else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO presensimapel (nis, idKelasMataPelajaran , tanggalpertemuan, 	Keterangan) 
                                            VALUES ('$_POST[tnis]',
                                                    '$_POST[tidKelasMataPelajaran]',
                                                    '$_POST[ttanggalpertemuan]',
                                                    '$_POST[tKeterangan]')
                                                    ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='presensi.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='presensi.php';
                    </script>";
            }
        }
        
    }
    //uji coba jika tombol edit or hapus
    if(isset($_GET['hal']))
    {
        //tampil data yang akan di edit
        if($_GET['hal']== "edit")
        {
            //tampil data diedit
            $tampil = mysqli_query($koneksi, "SELECT * FROM jadwal WHERE idjadwal= '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan ditampung ke variable
                $vvjadwal = $data['idjadwal'];
                $vvhari = $data['hari'];
                $vvsesi = $data['sesi'];
            }
        }
        else if($_GET['hal']=="hapus")
        {
            ///hapus
            $hapus = mysqli_query($koneksi, "DELETE FROM registrasikelas WHERE nis = '$_GET[id]' ");
            if($hapus){
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
    Form Registrasi Presensi
  </div>
  <div class="card-body">
    <form method="POST" action="">
        <div class="form-group">
            <label>nis</label>
            <input type="text" name="tnis" value="<?=@$$vvjadwal?>" class="form-control" placeholder="input nis" required>
        </div>
        <div class="form-label-group">
                        <label> idKelasMataPelajaran </label>
                        <?php
                        $s = "select * from kelasmatapelajaran";
                        $query = mysqli_query($koneksi, $s) or die($s);
                        ?>
                        <select name="tidKelasMataPelajaran" id="kelas" class="form-control">
                            <option value="">Pilih Kelas mata pelajaran</option>
                            <?php
                            while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) :;
                            ?>

                                <option value="<?php echo $row['idKelasMataPelajaran']; ?>"><?php echo $row['idKelasMataPelajaran']; ?></option>
                            <?php
                            endwhile;
                            ?>
                        </select>
                    </div>
        <div class="form-group">
            <label>tanggalpertemuan</label>
            <input type="date" name="ttanggalpertemuan" value="<?=@$vvsesi?>" class="form-control" placeholder="input tanggal pertemuan" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="tKeterangan" value="<?=@$vvsesi?>" class="form-control" placeholder="Hadir/Alpa" required>
        </div>
        <a class="btn btn-danger" href="../menu.php">Kembali</a>
        <button type="submit" class="btn btn-success" name="simpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name="reset">Kosongkan Data</button>
 
    </form>
  </div>
</div>
<!--akhir--> 
<!-- daftar idkelasmapel-->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    List ID KELAS MAPEL
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>id Kelas matapelajaran</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT idKelasMataPelajaran FROM kelasmatapelajaran ");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['idKelasMataPelajaran']?></td>
        </tr>
        <?php endwhile; ?>
    </table>
  </div>
</div>
<!--daftar list nis siswa-->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    List Siswa yang ada
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>idKelas</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * FROM registrasikelas INNER JOIN kelas ON registrasikelas.idKelas = kelas.idkelas INNER JOIN guru ON registrasikelas.nip_guru_wali = guru.nip INNER JOIN siswa ON registrasikelas.nis = siswa.nis");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nis']?></td>
            <td><?=$data['namasiswa']?></td>
            <td><?=$data['idkelas']?></td>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
  </div>
</div>
 <!--awal tabel-->
 <div class="card mt-3">
  <div class="card-header bg-dark text-white">
    Data presensi
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>Nis</th>
            <th>idKelasMataPelajaran</th>
            <th>Tanggal Pertemuan</th>
            <th>Keterangan</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * From presensimapel order by nis asc");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nis']?></td>
            <td><?=$data['idKelasMataPelajaran']?></td>
            <td><?=$data['tanggalpertemuan']?></td>
            <td><?=$data['Keterangan']?></td>
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