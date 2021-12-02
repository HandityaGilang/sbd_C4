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
            if($_GET['hal']== "list")
            {
                //tampil data diedit
                $tampil = mysqli_query($koneksi, "SELECT * FROM presensimapel INNER JOIN siswa ON presensimapel.nis = siswa.nis WHERE siswa.nis = '$_GET[id]' ");
                $data = mysqli_fetch_array($tampil);
                if($data)
                {
               
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
        <a class="btn btn-danger" href="./index.php">Kembali</a>
        <div class="card">
    <div class="card-header bg-primary text-white">
<!--awal tabel-->
<div class="card mt-3">
    <div class="card-header bg-success text-white">
        Data Kehadiran  
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>No.</th>
                <th>Nama Siswa.</th>
                <th>IDKelasMapel</th>
                <th>Tanggal Pertemuan</th>
                <th>Keterangan</th>
            </tr>
            <?php
                $no = 1;
                $tampil = mysqli_query($koneksi, "SELECT * FROM presensimapel INNER JOIN siswa ON presensimapel.nis = siswa.nis WHERE siswa.nis = '$_GET[id]' ");
                while($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
                <td><?=$no++;?></td>
                <td><?=$data['namasiswa']?></td>
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
