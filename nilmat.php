<?php
//koneksi
session_start();
include("koneksi.php");

if (isset($_POST['simpan'])) {
  $id_alter   = $_POST['altern'];
  $id_krit   = $_POST['krit'];
  $nilai_kr = $_POST['nilai_kr'];

$tambah = $koneksi->query('SELECT * FROM tab_topsis');



  $masuk = "INSERT INTO tab_topsis (id_alternatif, id_kriteria, nilai) VALUES ('".$id_alter."','".$id_krit."','".$nilai_kr."')";
  $buat  = $koneksi->query($masuk);

  echo "<script>alert('Input Data Berhasil') </script>";
  echo "<script>window.location.href = \"nilmat.php\" </script>";


}

//pemberian kode id secara otomatis
// $carikode = $koneksi->query("SELECT id_nilai FROM tab_nilai") or die(mysqli_error());
// $datakode = $carikode->fetch_array();
// $jumlah_data = mysqli_num_rows($carikode);

// if ($datakode) {
//   $nilaikode = substr($jumlah_data[0], 1);
//   $kode = (int) $nilaikode;
//   $kode = $jumlah_data + 1;
//   $kode_otomatis = str_pad($kode, 0, STR_PAD_LEFT);
// } else {
//   $kode_otomatis = "1";
// }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SPK MOORA</title>
    <!--bootstrap-->
    <link href="tampilan/css/bootstrap.min.css" rel="stylesheet">

  </head>
  <body>

    <!--menu-->
    <nav class="navbar navbar-default navbar-custom">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">SPK Metode Moora</a>
        </div>

        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="kriteria.php">Kriteria</a>
            </li>
            <li>
              <a href="alternatif.php">Alternatif</a>
            </li>
            <li>
              <a href="nilmat.php">Nilai Matriks</a>
            </li>
            <li>
              <a href="hastop.php">Hasil Moora</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!--tabel-tabel dan form-->
    <div class="container"> <!--container-->
      <div class="row"> <!--row-->
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading text-center">
              Nilai Matriks
            </div>

            <div class="panel-body">
              <!--form pengisian-->
              <div class="row">
                <div class="col-lg-6 col-lg-offset-3">
                  <div class="panel panel-default">
                    <div class="panel-heading text-center">
                      Alternatif
                    </div>

                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">
                          <form class="form" action="nilmat.php" method="post">
                          
                            <div class="form-group">
                              <select class="form-control" name="altern">
                                <option>Nama Alternatif</option>
                                <?php
                                //ambil data dari database
                                $nama = $koneksi->query('SELECT * FROM tab_alternatif ORDER BY nama_alternatif');
                                while ($datalter = $nama->fetch_array())
                                {
                                  echo "<option value=\"$datalter[id_alternatif]\">$datalter[nama_alternatif]</option>\n";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <select class="form-control" name="krit">
                                <option>Nama Kriteria</option>
                                <?php
                                //ambil data dari database
                                $krit = $koneksi->query('SELECT * FROM tab_kriteria ORDER BY nama_kriteria');
                                while ($datakrit = $krit->fetch_array())
                                {
                                  echo "<option value=\"$datakrit[id_kriteria]\">$datakrit[nama_kriteria]</option>\n";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <input class="form-control" type="text" name="nilai_kr" placeholder="Nilai">
                            </div>
                            <div class="form-group">
                              <input class="btn btn-success" type="submit" name="simpan" value="Process">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              <!--tabel-tabel-->
              <div class="row">
                <!--tabel alternatif-->
                <div class="col-xs-6 col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading text-center">
                      Tabel Alternatif
                    </div>

                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">

                          <?php
                           $sql = $koneksi->query('SELECT * FROM tab_alternatif');
                           ?>
                          <table class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>ID Alternatif</th>
                                <th>Nama Alternatif</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              while ($row = $sql->fetch_array()) {
                                echo ("<tr><td align=\"center\">".$row[0]."</td>");
                                echo ("<td align=\"left\">".$row[1]."</td>");
                                echo "</tr>";
                              }
                               ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <!--tabel kriteria-->

                <div class="col-xs-6 col-md-4">
                  <div class="panel panel-default">
                    <div class="panel-heading text-center">
                      Tabel Kriteria
                    </div>

                    <div class="panel-body">
                      <div class="row">
                        <div class="col-lg-12">

                          <?php
                          $sql = $koneksi->query('SELECT * FROM tab_kriteria');
                           ?>
                          <table class="table table-striped table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>ID Kriteria</th>
                                <th>Nama Kriteria</th>
                                <th>Bobot</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              while ($row = $sql->fetch_array()) {
                                echo ("<tr><td align=\"center\">".$row[0]."</td>");
                                echo ("<td align=\"left\">".$row[1]."</td>");
                                echo ("<td align=\"left\">".$row[2]."</td>");
                                echo "</tr>";
                              }
                               ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        </div>
        </div> <!--row-->
        </div> <!--container-->

        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Tabel Pemberian Nilai
                </div>

                <div class="panel-body">
                  <?php
                  //pemanggilan data, matra dan pangkat
                  $sql = $koneksi->query("SELECT * FROM tab_topsis
                  JOIN tab_alternatif ON tab_topsis.id_alternatif=tab_alternatif.id_alternatif
                  JOIN tab_kriteria ON tab_topsis.id_kriteria=tab_kriteria.id_kriteria") or die (mysql_error());
                   ?>
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>NO</th>
                        <th>ALTERNATIF</th>
                        <th>KRITERIA</th>
                        <th>NILAI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no=1;
                      //menampilkan data
                      while ($row = $sql->fetch_array())
                      {
                        $nmkriteria   =$row['nama_kriteria'];
                        echo ("<tr><td align=\"center\">".$no."</td>");
                        echo ("<td align=\"left\">".$row[4]."</td>");
                        echo ("<td align=\"left\">".$nmkriteria."</td>");
                        echo ("<td align=\"left\">".$row[2]."</td>");
                        echo "</tr>";
                        $no++;
                      }
                       ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> <!--row-->
        </div> <!--container-->

        <!--tabel penentuan nilai-->
        <div class="container"> <!--container-->
          <div class="row">
            <div class="col-lg-4">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Tabel Pigmentasi
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th align="center">Sub Kriteria</th>
                        <th>Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Sangat Pigmented</td>
                        <td>4</td>
                      </tr>
                      <tr>
                        <td>Cukup Pigmented</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td>Kurang Pigmented</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td>Tidak Pigmented</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Tabel Ketahanan
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th align="center">Sub Kriteria</th>
                        <th>Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Sangat Tahan</td>
                        <td>4</td>
                      </tr>
                      <tr>
                        <td>Cukup Tahan</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td>Kurang Tahan</td>
                        <td>2</td>
                      </tr>
                      <tr>
                        <td>Tidak Tahan</td>
                        <td>1</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="panel panel-default">
                <div class="panel-heading">
                  Tabel Transferproof
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th align="center">Sub Kriteria</th>
                        <th>Nilai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Transferproof</td>
                        <td>1</td>
                      </tr>
                      <tr>
                        <td>Tidak Transferproof</td>
                        <td>0</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div><!--container-->

        <!--footer-->
        <footer class="text-center">
          <div class="footer-below">
            <div class="container">
              <div class="row">
                <div class="col-lg-12">
                <em>Tugas Akhir SPK Metode Moora <br> Arin Kistia - Nabila Kamilia</em>
                </div>
              </div>
            </div>
          </div>
        </footer>

       

    // if (isset($_POST['simpan'])) {
    //   $id_nilai   = $_POST['id_nilai'];
    //   $id_alter   = $_POST['altern'];
    //   $id_krit   = $_POST['krit'];
    //   $nilai_kr = $_POST['nilai_kr'];
      
    //   $sql    = "SELECT * FROM tab_nilai";
    //   $tambah = $koneksi->query($sql);

    //   if ($row = $tambah->fetch_row()) {
    //     $masuk = "INSERT INTO tab_nilai VALUES ('".$id_nilai."','".$id_alter."','".$id_krit."','".$nilai_kr."')";
    //     $buat  = $koneksi->query($masuk);

    //   }
    // }

     

        <!--plugin-->
        <script src="tampilan/js/bootstrap.min.js"></script>

  </body>
</html>
