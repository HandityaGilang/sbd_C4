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
                $edit = mysqli_query($koneksi, "UPDATE kelas set 
                                                idkelas = '$_POST[idkelas]',
                                                deskripsikelas = '$_POST[DeskripsiKelas]'
                                                WHERE idkelas = '$_GET[id]'
                                                ");
                if($edit) //edit sukses
                {
                    echo "<script>
                            alert('Edit data SUKSES');
                            document.location='index.php';
                        </script>";
                }
                else
                {
                    echo "<script>
                            alert('Edit data GAGAL');
                            document.location='index.php';
                        </script>";
                }
            }else
            {
                //data akan disimpan baru
                $simpan = mysqli_query($koneksi, "INSERT INTO kelas (idkelas, deskripsikelas) 
                                                VALUES ('$_POST[idkelas]',
                                                        '$_POST[DeskripsiKelas]')
                                                        ");
                if($simpan)
                {
                    echo "<script>
                            alert('Simpan data SUKSES');
                            document.location='index.php';
                        </script>";
                }
                else
                {
                    echo "<script>
                            alert('Simpan data GAGAL');
                            document.location='index.php';
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
                $tampil = mysqli_query($koneksi, "SELECT * FROM kelas WHERE idkelas= '$_GET[id]' ");
                $data = mysqli_fetch_array($tampil);
                if($data)
                {
                    //jika data ditemukan ditampung ke variable
                    $vvkelas = $data['idkelas'];
                    $vvdeskripsi = $data['deskripsikelas'];
                }
            }
            else if($_GET['hal']=="hapus")
            {
                ///hapus
                $hapus = mysqli_query($koneksi, "DELETE FROM kelas WHERE idkelas = '$_GET[id]' ");
                if($hapus){
                    echo "<script>
                            alert('Hapus data SUKSES');
                            document.location='index.php';
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
        Form input Kelas
    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="form-group">
                <label>idKelas</label>
                <input type="text" name="idkelas" value="<?=@$vvkelas?>" class="form-control" placeholder="input kelas" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Kelas</label>
                <input type="text" name="DeskripsiKelas" value="<?=@$vvdeskripsi?>" class="form-control" placeholder="Deskripsi kelas" required>
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
        Data Kelas
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Kelas.</th>
                <th>Deskripsi Kelas</th>
                <th>Aksi</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * From Kelas order by idkelas desc");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['idkelas']?></td>
                <td><?=$data['deskripsikelas']?></td>
                <td>
                    <a href="listsistwa.php?hal=list&id=<?=$data['idkelas']?>" class="btn btn-warning">Lihat siswa</a>
                    <a href="index.php?hal=edit&id=<?=$data['idkelas']?>" class="btn btn-warning">Update</a>
                    <a href="index.php?hal=hapus&id=<?=$data['idkelas']?>" 
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