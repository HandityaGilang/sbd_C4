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
            $edit = mysqli_query($koneksi, "UPDATE jurusan set 
                                            kodeJurusan = '$_POST[tkodeJurusan]',
                                            namaJurusan = '$_POST[tnamaJurusan]'
                                            WHERE kodeJurusan = '$_GET[id]'
                                            ");
            if($edit) //edit sukses
            {
                echo "<script>
                        alert('Edit data SUKSES');
                        document.location='jurusan.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Edit data GAGAL');
                        document.location='jurusan.php';
                    </script>";
            }
        }else
        {
            //data akan disimpan baru
            $simpan = mysqli_query($koneksi, "INSERT INTO jurusan (kodeJurusan, namaJurusan) 
                                            VALUES ('$_POST[tkodeJurusan]',
                                                    '$_POST[tnamaJurusan]')
                                                    ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='jurusan.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='jurusan.php';
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
            $tampil = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE kodeJurusan= '$_GET[id]' ");
            $data = mysqli_fetch_array($tampil);
            if($data)
            {
                //jika data ditemukan ditampung ke variable
                $vvjurusan = $data['kodeJurusan'];
                $vvnama = $data['namaJurusan'];
            }
        }
        else if($_GET['hal']=="hapus")
        {
            ///hapus
            $hapus = mysqli_query($koneksi, "DELETE FROM jurusan WHERE kodeJurusan = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus data SUKSES');
                        document.location='jurusan.php';
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
    Form input jurusan
  </div>
  <div class="card-body">
    <form method="POST" action="">
        <div class="form-group">
            <label>kodeJurusan</label>
            <input type="text" name="tkodeJurusan" value="<?=@$vvjurusan?>" class="form-control" placeholder="input kode jurusan" required>
        </div>
        <div class="form-group">
            <label>nama Jurusan</label>
            <input type="text" name="tnamaJurusan" value="<?=@$vvnama?>" class="form-control" placeholder="Nama Jurusan" required>
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
    Data daftar Jurusan
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>Jurusan</th>
            <th>Nama Jurusan</th>
            <th>Aksi</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * From jurusan order by kodeJurusan desc");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['kodeJurusan']?></td>
            <td><?=$data['namaJurusan']?></td>
            <td>
                <a href="jurusan.php?hal=edit&id=<?=$data['kodeJurusan']?>" class="btn btn-warning">Update</a>
                <a href="jurusan.php?hal=hapus&id=<?=$data['kodeJurusan']?>" 
                onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
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