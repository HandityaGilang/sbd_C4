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
                                            idKelasMapel  = '$_POST[tidKelasMapel]',
                                            nilaiKKM = '$_POST[tnilaiKKM]',
                                            nilaiPengetahuan = '$_POST[tnilaiPengetahuan]',
                                            nilaiKetrampilan = '$_POST[tnilaiKetrampilan]'
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
            $simpan = mysqli_query($koneksi, "INSERT INTO registrasimapel (nis, idKelasMapel, nilaiKKM, nilaiPengetahuan, PredikatPengetahuan, nilaiKetrampilan, PredikatKetrampilan) 
                                            VALUES ('$_POST[tnis]',
                                                    '$_POST[tidKelasMapel]',
                                                    '$_POST[tnilaiKKM]',
                                                    '$_POST[tnilaiPengetahuan]',
                                                    '$_POST[tPredikatPengetahuan]',
                                                    '$_POST[tnilaiKetrampilan]',
                                                    '$_POST[tPredikatKetrampilan]')
                                                    ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='regismapel.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='regismapel.php';
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
                $vvnis = $data['nis'];
                $vvidKelasMapel = $data['idKelasMapel'];
                $vvnilaiKKM = $data['nilaiKKM'];
                $vvnilaiPengetahuan = $data['nilaiPengetahuan'];
                $vvnilaiKetrampilan = $data['nilaiKetrampilan'];
            }
        }
        else if($_GET['hal']=="hapus")
        {
            ///hapus
            $hapus = mysqli_query($koneksi, "DELETE FROM registrasimapel WHERE nis = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus data SUKSES');
                        document.location='regismapel.php';
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
    Form Registrasi Nilai Mapel
  </div>
  <div class="card-body">
    <form method="POST" action="">
        <div class="form-group">
            <label>nis</label>
            <input type="text" name="tnis" value="<?=@$vvnis?>" class="form-control" placeholder="input id" required>
        </div>
        <div class="form-label-group">
                        <label> idKelasMataPelajaran </label>
                        <?php
                        $s = "select * from kelasmatapelajaran";
                        $query = mysqli_query($koneksi,$s) or die($s);
                        ?>
                        <select name="tidKelasMapel" id="idKelasMapel" class="form-control">
                        <option value="">Pilih idKelasMataPelajaran</option>
                            <?php 
                                while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)):; 
                            ?>

                            <option value="<?php echo $row['idKelasMataPelajaran'];?>"><?php echo $row['idKelasMataPelajaran'];?></option>
                        <?php 
                            endwhile;
                        ?>
                        </select>
                    </div>
        <div class="form-group">
            <label>nilai KKM</label>
            <input type="text" name="tnilaiKKM" value="<?=@$vvnilaiKKM?>" class="form-control" placeholder="input nilai" required>
        </div>
        <div class="form-group">
            <label>nilai Pengetahuan</label>
            <input type="text" name="tnilaiPengetahuan" value="<?=@$vvnilaiPengetahuan?>" class="form-control" placeholder="input nilai" required>
        </div>
        <div class="form-group">
            <label>Predikat Pengetahuan</label>
            <input type="text" name="tPredikatPengetahuan" value="<?=@$vvnilaiPengetahuan?>" class="form-control" placeholder="input Predikat" required>
        </div>
        <div class="form-group">
            <label>nilai Ketrampilan</label>
            <input type="text" name="tnilaiKetrampilan" value="<?=@$vvnilaiKetrampilan?>" class="form-control" placeholder="input nilai" required>
        </div>
        <div class="form-group">
            <label>Predikat Ketrampilan</label>
            <input type="text" name="tPredikatKetrampilan" value="<?=@$vvnilaiPengetahuan?>" class="form-control" placeholder="input Predikat" required>
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
        </tr>
        <?php endwhile; ?>
    </table>
  </div>
</div>
 <!--awal tabel-->
 <div class="card mt-3">
  <div class="card-header bg-dark text-white">
    Data Nilai Siswa
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>idKelasMapel</th>
            <th>idKelas</th>
            <th>Nilai KKM</th>
            <th>Nilai Pengetahuan</th>
            <th>Predikat</th>
            <th>Nilai Ketrampilan</th>
            <th>Predikat</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * From registrasimapel order by nis asc");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nis']?></td>
            <td><?=$data['idKelasMapel']?></td>
            <td><?=$data['nilaiKKM']?></td>
            <td><?=$data['nilaiPengetahuan']?></td>
            <td><?=$data['PredikatPengetahuan']?></td>
            <td><?=$data['nilaiKetrampilan']?></td> 
            <td><?=$data['PredikatKetrampilan']?></td>
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