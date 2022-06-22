<?php
//koneksi
session_start();
include ("koneksi.php");

$tampil = $koneksi->query("SELECT b.nama_alternatif,c.nama_kriteria,a.nilai,c.bobot
      FROM
        tab_topsis a
        JOIN
          tab_alternatif b USING(id_alternatif)
        JOIN
          tab_kriteria c USING(id_kriteria)");

$data      =array();
$kriterias =array();
$bobot     =array();
$nilai_kuadrat =array();
$sample=array();

if ($tampil) {
  while($row=$tampil->fetch_object()){
    if(!isset($data[$row->nama_alternatif])){
      $data[$row->nama_alternatif]=array();
    }
    if(!isset($data[$row->nama_alternatif][$row->nama_kriteria])){
      $data[$row->nama_alternatif][$row->nama_kriteria]=array();
    }
    if(!isset($nilai_kuadrat[$row->nama_kriteria])){
      $nilai_kuadrat[$row->nama_kriteria]=0;
    }
    $bobot[$row->nama_kriteria]=$row->bobot;
    $data[$row->nama_alternatif][$row->nama_kriteria]=$row->nilai; // tabel hastop
    $nilai_kuadrat[$row->nama_kriteria]+=pow($row->nilai,2);
    $kriterias[]=$row->nama_kriteria;
  }
}

$kriteria     =array_unique($kriterias);
$jml_kriteria =count($kriteria);
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
          <a class="navbar-brand" href="index.php">SPK Metode Topsis</a>
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

    <!--tabel-tabel-->
    <div class="container"> <!--container-->
      <div class="row">
      	<div class="col-lg-8 col-lg-offset-2">
      	  <div class="panel panel-default">
      	    <div class="panel-heading">
              Matriks Kriteria 
      	    </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th rowspan='3'>No</th>
                    <th rowspan='3'>Alternatif</th>
                    <th rowspan='3'>Nama</th>
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                  </tr>
                  <tr>
                    <?php
                    // foreach($kriteria as $k)
                    //   echo "<th>$k</th>\n";

                    foreach ($sample as $id_sample => $value) {
                      foreach ($kriteria as $id_kriteria => $value) {
                        echo $sample[$id_sample][$id_kriteria]." ";
                      }
                      echo "<br>";
                    }
                    ?>

                  </tr>
                  <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                      echo "<th>K$n</th>";
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <th>A$i</th>
                      <td>$nama</td>";
                    foreach($kriteria as $k){
                      echo "<td align='center'>$krit[$k]</td>";
                    }
                    echo "</tr>\n";
                  }
                  ?>
                </tbody>
              </table>
            </div>
      	  </div>
      	</div>
      </div>

      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              Matriks Normalisasi (X<sub>ij</sub>)
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th rowspan='3'>No</th>
                    <th rowspan='3'>Alternatif</th>
                    <th rowspan='3'>Nama</th>
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                  </tr>
                  <tr>
                    <?php
                    // foreach($kriteria as $k)
                    //   echo "<th>$k</th>\n";

                    $normal=$sample;
                    $nama_alternatif = array();
                    foreach($kriteria as $id_kriteria=>$k){
                      $pembagi=0;
                      foreach($nama_alternatif as $id_alternatif=>$a){
                        $pembagi+=pow($sample[$id_alternatif][$id_kriteria],2);
                      }
                      foreach($nama_alternatif as $id_alternatif=>$a){
                        $normal[$id_alternatif][$id_kriteria]/=sqrt($pembagi);
                      }
                    }
                    ?>
                  </tr>
                  <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                      echo "<th>K$n</th>";
                    ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <th>A{$i}</th>
                      <td>{$nama}</td>";
                    foreach($kriteria as $k){
                      echo "<td align='center'>".round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)."</td>";
                    }
                    echo
                     "</tr>\n";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              Matriks Normalisasi Terbobot
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <!-- menampilkan data -->
              <thead>
                  <tr>
                    <th rowspan='3'>No</th>
                    <th rowspan='3'>Alternatif</th>
                    <th rowspan='3'>Nama</th>
                    <th colspan='<?php echo $jml_kriteria;?>'>Kriteria</th>
                  </tr>
                  <tr>
                    <?php
                    foreach($kriteria as $k)
                      echo "<th>$k</th>\n";
                    ?>
                  </tr>
                  <tr>
                    <?php
                    for($n=1;$n<=$jml_kriteria;$n++)
                      echo "<th>K$n</th>";
                    ?>
                  </tr>
                </thead>
                
                <!-- proses normalisasi matrix -->
                <tbody>
                  <?php
                  $i=0;
                  $normal=array();
                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <th>A{$i}</th>
                      <td>{$nama}</td>";
                      
                      foreach($kriteria as $k){
                      // $pembagi=0;
                      // foreach($alternatif as $id_siswa=>$a){
                      //   $pembagi+=pow($sample[$id_siswa][$id_kriteria],2);
                      // }
                      // foreach($alternatif as $id_alternatif=>$a){
                      //   $normal[$id_alternatif][$id_kriteria]/=sqrt($pembagi);
                      // }
                      $y[$k][$i-1]=round(($krit[$k]/sqrt($nilai_kuadrat[$k])),4)*$bobot[$k];
                      echo "<td align='center'>".$y[$k][$i-1]."</td>";
                      
                    }                    
                    echo
                     "</tr>\n";
                  }
                  foreach ($kriteria as $k) {
                    echo $k;
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              Penentuan Nilai Yi
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Alternatif</th>
                    <th>Max</th>
                    <th>Min</th>
                    <th>Yi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  
                  $i=0;
                  // $optimasi=array();

                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <td>{$nama}</td>";
                      
                      $min[$i-1] = $y['Harga'][$i-1];
                        
                      $max[$i-1] = ($y['Pigmentasi'][$i-1])+($y['Variasi Shade'][$i-1])+($y['Ketahanan'][$i-1])+($y['Transferproof'][$i-1]);

                      $yi[$i-1] = $max[$i-1] - $min[$i-1];
                      
                      
                      
                      echo "<td align='center'>".$max[$i-1]."</td>";
                      echo "<td align='center'>".$min[$i-1]."</td>";
                      echo "<td align='center'>".$yi[$i-1]."</td>";

                      // foreach($kriteria as $k){

                      

                      //   echo "<td align='center'>".$max[$k][$i-1]."</td>";
                      //   // echo "<td align='center'>".$min[$k][$i-1]."</td>";                        
                      // }

                      // foreach($kriteria as $k){

                      //   if ($k == 'Harga') {
                      //     $min[$k][$i-1] = $y[$k][$i-1];
                      //   } else {
                      //     $max[$k][$i-1] = $y[$k][$i];
                      //   }

                      //   // echo "<td align='center'>".$max[$k][$i-1]."</td>";
                      //   echo "<td align='center'>".$min[$k][$i-1]."</td>";

                        
                      // }
                      
                      echo
                     "</tr>\n";
                   
                  }

                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <div class="panel panel-default">
            <div class="panel-heading">
              Perankingan
            </div>
            <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Alternatif</th>
                    <th>Nama</th>
                    <th>Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i=0;
                  // $V=array();

                  arsort($yi);
                  $index=key($yi);
                  
                  foreach($data as $nama=>$krit){
                    echo "<tr>
                      <td>".(++$i)."</td>
                      <th>A{$i}</th>
                      <td>{$nama}</td>";
                    foreach($kriteria as $k){
                      $yi[$i-1];
                    }
                    echo "<td>{$yi[$i-1]}</td></tr>\n";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <div class="panel-heading">
              Urut
            </div>
            <!-- <div class="panel-body">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Alternatif</th>
                    <th>Nama</th>
                    <th>Nilai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // $i=0;
                  // $V=array();

                  // //--mengurutkan data secara descending dengan tetap mempertahankan key/index array-nya
                  // arsort($yi);
                  // //-- mendapatkan key/index item array yang pertama
                  // $index=key($yi,SORT_DESC,$yi);
                  
                  // foreach($data as $nama=>$krit){
                  //   echo "<tr>
                  //     <td>".(++$i)."</td>
                  //     <th>A{$i}</th>
                  //     <td>{$nama}</td>";
                  //   foreach($kriteria as $k){
                  //     // $V[$i-1]=$yi[$i-1];
                      
                  //     foreach ($yi as $id_yi => $value) {
                  //       echo $yi[$id_yi][0].$id_yi."<br>".$yi[$id_yi];
                        
                  //     }
                  //   }
                  //   echo "<td>{$yi[$i-1]}</td></tr>\n";
                  // }


                  ?>
                </tbody>
              </table>
            </div> -->
          </div>
        </div>
      </div>
    </div> <!--container-->

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

    <!--plugin-->
    <script src="tampilan/js/bootstrap.min.js"></script>

  </body>
</html>
