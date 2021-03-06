<?php
//cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {

    if (isset($_REQUEST['submit'])) {

        //validasi form kosong
        if (
            $_REQUEST['no_surat'] == "" || $_REQUEST['tgl_surat'] == "" || $_REQUEST['klasifikasi'] == "" || $_REQUEST['klasifikasi1'] == "" || $_REQUEST['jenis_surat'] == ""
        ) {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">
                                window.location.href="./admin.php?page=ns&act=edit&id_ns=' . $id_ns . '";
                              </script>';
        } else {

            $id_ns = $_REQUEST['id_ns'];
            $no_surat = $_REQUEST['no_surat'];
            $klasifikasi = $_REQUEST['klasifikasi'];
            $klasifikasi1 = $_REQUEST['klasifikasi1'];
            $jenis_surat = $_REQUEST['jenis_surat'];
            $tgl_surat = $_REQUEST['tgl_surat'];
            $id_user = $_SESSION['admin'];

            //validasi input data
             //validasi form kosong
        if ($_REQUEST['no_surat'] == "" || $_REQUEST['tgl_surat'] == "" || $_REQUEST['klasifikasi'] == "" || $_REQUEST['klasifikasi1'] == "" || $_REQUEST['jenis_surat'] == "") {
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
            echo '<script language="javascript">
                            window.location.href="./admin.php?page=ns&act=edit&id_ns=' . $id_ns . '";
                          </script>';
        } else {

            //validasi input data
            if (!preg_match("/^[a-zA-Z0-9.\/ -]*$/", $no_surat)) {
                $_SESSION['no_suratr'] = 'Form No Surat hanya boleh mengandung karakter huruf, angka, spasi, titik(.), minus(-) dan garis miring(/)';
                echo '<script language="javascript">window.history.back();</script>';
            } else {
                if (!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $klasifikasi)) {
                    $_SESSION['klasifikasi'] = 'Form klasifikasi hanya boleh mengandung karakter huruf, angka, spasi dan titik(.)';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    if (!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $klasifikasi1)) {
                        $_SESSION['klasifikasi1'] = 'Form klasifikasi1 hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {
                        if (!preg_match("/^[0-9.-]*$/", $tgl_surat)) {
                            $_SESSION['tgl_suratr'] = 'Form Tanggal Surat hanya boleh mengandung angka dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if (!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $jenis_surat)) {
                                $_SESSION['jenis_surat'] = 'Form jenis_surat hanya boleh mengandung  huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {
                                $a = "UPDATE tbl_nomor_surat SET no_surat='$no_surat', tgl_surat='$tgl_surat', klasifikasi='$klasifikasi', klasifikasi1='$klasifikasi1', jenis_surat='$jenis_surat', id_user='$id_user' WHERE id_ns='$id_ns'";
                                $query = mysqli_query($config, $a);

                                if ($query == true) {
                                    $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                    header("Location: ./admin.php?page=ns");
                                    die();
                                } else {
                                    $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                    echo '<script language="javascript">window.history.back();</script>';
                                }
                                        
                                    
                                }
                            }
                        }
                    }
                }
            }
        }
    } else {

        $id_ns = mysqli_real_escape_string($config, $_REQUEST['id_ns']);
        $a = "SELECT id_ns, klasifikasi, no_surat, klasifikasi1, tgl_surat, jenis_surat, id_user FROM tbl_nomor_surat WHERE id_ns='$id_ns'";
        $query = mysqli_query($config, $a);
        list($id_ns, $klasifikasi, $no_surat, $klasifikasi1, $tgl_surat, $jenis_surat, $id_user) = mysqli_fetch_array($query);

        if ($_SESSION['id_user'] != $id_user and $_SESSION['id_user'] != 1) {
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk mengedit data ini");
                    window.location.href="./admin.php?page=tsm";
                  </script>';
        } else { ?>

            <!-- Row Start -->
            <div class="row">
                <!-- Secondary Nav START -->
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light"><a href="#" class="judul"><i class="material-icons">edit</i> Edit Registrasi Nomor Surat</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
                <!-- Secondary Nav END -->
            </div>
            <!-- Row END -->

            <?php
            if (isset($_SESSION['errQ'])) {
                $errQ = $_SESSION['errQ'];
                echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errQ . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                unset($_SESSION['errQ']);
            }
            if (isset($_SESSION['errEmpty'])) {
                $errEmpty = $_SESSION['errEmpty'];
                echo '<div id="alert-message" class="row">
                            <div class="col m12">
                                <div class="card red lighten-5">
                                    <div class="card-content notif">
                                        <span class="card-title red-text"><i class="material-icons md-36">clear</i> ' . $errEmpty . '</span>
                                    </div>
                                </div>
                            </div>
                        </div>';
                unset($_SESSION['errEmpty']);
            }
            ?>

            <!-- Row form Start -->
            <div class="row jarak-form">

                <!-- Form START -->
                <form class="col s12" method="POST" action="?page=ns&act=edit" enctype="multipart/form-data">

                    <!-- Row in form START -->
                    <div class="row">
                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">receipt</i>
                                <input id="no_surat" type="text" class="validate" name="no_surat" value="<?php echo $no_surat; ?>" name="no_surat" required>
                                <?php
                                if (isset($_SESSION['no_surat'])) {
                                    $no_suratr = $_SESSION['no_surat'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $no_suratr . '</div>';
                                    unset($_SESSION['no_surat']);
                                }
                                if (isset($_SESSION['errDup'])) {
                                    $errDup = $_SESSION['errDup'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $errDup . '</div>';
                                    unset($_SESSION['errDup']);
                                }
                                ?>
                                <label for="no_surat">Nomor Surat</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">date_range</i>
                                <input id="tgl_surat" type="text" name="tgl_surat" class="datepicker" value="<?php echo $tgl_surat; ?>" name="tgl_surat" required>
                                <?php
                                if (isset($_SESSION['tgl_surat'])) {
                                    $tgl_suratr = $_SESSION['tgl_surat'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $tgl_surat . '</div>';
                                    unset($_SESSION['tgl_surat']);
                                }
                                ?>
                                <label for="tgl_surat">Tanggal Surat</label>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">filter_1</i><label>Klasifikasi</label><br />
                                <div class="input-field col s12">
                                    <select name="klasifikasi" id="klasifikasi" value="<?php echo $klasifikasi; ?>" name="klasifikasi" required>
                                        <option value="" disabled selected>Choose your option</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>
                                </div>

                                <?php
                                if (isset($_SESSION['klasifikasi'])) {
                                    $klasifikasi = $_SESSION['klasifikasi'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $klasifikasi . '</div>';
                                    unset($_SESSION['klasifikasi']);
                                }
                                ?>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">filter_2</i><label>Klasifikasi 1</label><br />
                                <div class="input-field col s12">
                                    <select name="klasifikasi1" id="klasifikasi1" value="<?php echo $klasifikasi1; ?>" name="klasifikasi1" required>
                                        <option value="" disabled selected>Choose your option</option>
                                        <option value="1">Option 1</option>
                                        <option value="2">Option 2</option>
                                        <option value="3">Option 3</option>
                                    </select>

                                </div>
                                <?php
                                if (isset($_SESSION['klasifikasi1'])) {
                                    $klasifikasi = $_SESSION['klasifikasi1'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $klasifikasi1 . '</div>';
                                    unset($_SESSION['klasifikasi1']);
                                }
                                ?>
                            </div>

                            <div class="input-field col s6">
                                <i class="material-icons prefix md-prefix">low_priority</i><label>Jenis Surat</label><br />
                                <div class="input-field col s12">
                                    <select name="jenis_surat" id="jenis_surat" value="<?php echo $jenis_surat; ?>" name="jenis_surat" required>
                                        <?php
                                        $sql = mysqli_query($config, "SELECT nama FROM tbl_jenis");
                                        while ($data = mysqli_fetch_array($sql))
                                            echo '<option value=' . $data['nama'] . '>' . $data['nama'] . '</option>';
                                        ?>
                                    </select>
                                </div>
                                <?php
                                if (isset($_SESSION['jenis_surat'])) {
                                    $sifat = $_SESSION['jenis_surat'];
                                    echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">' . $sifat . '</div>';
                                    unset($_SESSION['jenis_surat']);
                                }
                                ?>
                            </div>
                        </div>
                    <!-- Row in form END -->

                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=ns" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>

                </form>
                <!-- Form END -->

            </div>
            <!-- Row form END -->

<?php
        }
    }
}
?>