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
                                            idjadwal = '$_POST[tidjadwal]',
                                            hari = '$_POST[thari]',
                                            sesi = '$_POST[tsesi]'
                                            WHERE idjadwal = '$_GET[id]'
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
            $simpan = mysqli_query($koneksi, "INSERT INTO jadwal (idjadwal, hari, sesi) 
                                            VALUES ('$_POST[tidjadwal]',
                                                    '$_POST[thari]',
                                                    '$_POST[tsesi]')
                                                    ");
            if($simpan)
            {
                echo "<script>
                        alert('Simpan data SUKSES');
                        document.location='jadwal.php';
                    </script>";
            }
            else
            {
                echo "<script>
                        alert('Simpan data GAGAL');
                        document.location='jadwal.php';
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
            $hapus = mysqli_query($koneksi, "DELETE FROM jadwal WHERE idjadwal = '$_GET[id]' ");
            if($hapus){
                echo "<script>
                        alert('Hapus data SUKSES');
                        document.location='jadwal.php';
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
    Form Jadwal
  </div>
  <div class="card-body">
    <form method="POST" action="">
        <div class="form-group">
            <label>idjadwal</label>
            <input type="text" name="tidjadwal" value="<?=@$$vvjadwal?>" class="form-control" placeholder="input id" required>
        </div>
        <div class="form-group">
            <label>hari</label>
            <input type="text" name="thari" value="<?=@$vvhari?>" class="form-control" placeholder="input hari" required>
        </div>
        <div class="form-group">
            <label>sesi</label>
            <input type="text" name="tsesi" value="<?=@$vvsesi?>" class="form-control" placeholder="input sesi" required>
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
    Data Jadwal
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>No.</th>
            <th>idjadwal</th>
            <th>Hari</th>
            <th>Sesi</th>
            <th>Aksi</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * From jadwal order by idjadwal asc");
            while($data = mysqli_fetch_array($tampil)) :
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['idjadwal']?></td>
            <td><?=$data['hari']?></td>
            <td><?=$data['sesi']?></td>
            <td>
                <a href="jadwal.php?hal=edit&id=<?=$data['idjadwal']?>" class="btn btn-warning">Update</a>
                <a href="jadwal.php?hal=hapus&id=<?=$data['idjadwal']?>" 
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