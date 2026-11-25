<?php
// EMR Data
$params = json_decode($argv[1]);

$base_url = $argv[2]; // Base_url
$title = "PEMBERIAN INFORMASI TINDAKAN KEDOKTERAN";
$static_label = json_decode($argv[3]);

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title ?></title>
</head>
<style>
.pagebreak {
    page-break-before: always;
}

body {
    /* font: 13pt times new roman;
    size: f4;
    padding-bottom: 10px; */
	font-family: sans-serif;
	font-size: 13pt;
	line-height: 1.3;
}

.allign {
    text-align: right;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th td {
    width: 30px;
}

td {
    height: 20px;
	vertical-align: top;
}

.space {
    padding-top: 20px;
}

.img100px {
    width: 100px;
    height: 100px;
}

.ttd-image {
    margin-top: 5px;
    margin-bottom: 5px;
    width: 100%;
    height: 100px;
}

.borderr-hitam {
    border: 3px;
    width: 100px;
}

.space-left {
    margin-left: 40px;
}

.dot {
    border-bottom: 1px dotted black;
    margin-top: 9px;
}

.line {
    text-decoration: overline;
    width: 100%;
}

.underline {
    text-decoration: underline;
}

.centerr {
    text-align: center;
}
.middle {
    vertical-align: middle;
}

.tbl-full {
    width: 100%;
}

.borderr {
    border: 1px solid black;
}

.ml-1 {
    margin-left: 10px;
}

.prg {
    /* text-align: justify; */
    text-justify: inter-word;
}

.boldd {
    font-weight: bold;
}

.pagee {
    /*width: 210mm;*/
    /*height: 290mm;*/
    margin: auto;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
}

.tdlonggar {
    padding-top: 5px;
    padding-bottom: 5px;
}

.ml-2 {
    margin-left: 20px;
}

.ml-3 {
    margin-left: 30px;
}

.container {
    display: flex;
    gap: 20px; /* Atur jarak antara div */
    align-items: center; /* Atur untuk membuat sejajar secara vertikal */
    justify-content: flex-start; /* Pilih perataan horizontal yang sesuai */
}

.box {
    display: flex;
    flex-direction: column;
    align-items: center; /* Agar gambar dan teks berada di tengah */
}

.text-bottom {
	vertical-align: bottom;
}

.ttd-img {
	width: 120px;
	height: 100px;
	object-fit: contain; /* atau contain tergantung kebutuhan */
}

</style>

<body>
    <div class="pagee">
        <table border="0">
            <tr>
                <td align="right">RM 15.14a</td>
            </tr>
        </table>
        <table class="tbl-full">
            <tr class="borderr tdlonggar">
                <td class="borderr" width="20%" style="vertical-align: middle">
					<center>
						<img style="width: 100px" src="<?= $base_url; ?>/images/rs/LogoRS.png">
					</center>
                </td>
                <td class="borderr" width="35%">
					<center><h4 style="margin: 0"><?php echo $static_label->hospital_name; ?></h4></center>
					<!--<center><h4 style="margin: 0"><?php echo $static_label->hospital_name2; ?></h4></center>-->
                    <center><small><?php echo $static_label->hospital_address; ?> </small></center>
                    <center><small>Tlp. <?php echo $static_label->hospital_phone; ?></small></center>
                    <center><small>Email. <?php echo $static_label->hospital_email; ?></small></center>
				</td>
                <td class="borderr" width="45%">
                    <table>
                        <tr>
                            <td class="col-sm" width="34%">No. RM</td>
                            <td width="1%">:</td>
                            <td><?php echo $params->pasien->no_rm; ?></td>
                        </tr>
                        <tr>
                            <td class="col-sm">Nama Pasien</td>
                            <td>:</td>
                            <td><?php echo $params->pasien->nama; ?></td>
                        </tr>
                        <tr>
                            <td class="col-sm">Tanggal Lahir</td>
                            <td>:</td>
                            <td><?php echo $params->pasien->tanggal_lahir_indo; ?></td>
                        </tr>
                        <tr>
                            <td class="col-sm">Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php
                                if (strtoupper($params->pasien->kelamin)  == 'L') {
                                    echo "Laki-laki";
                                } else if (strtoupper($params->pasien->kelamin) == 'P') {
                                    echo "Perempuan";
                                } else {
                                    echo '';
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td class="centerr borderr tdlonggar">
                    <b><?php echo $title; ?></b>
                </td>
            </tr>
        </table>
        <table class="tbl-full">
            <tr class="borderr tdlonggar">
				<td colspan="2" class="borderr">
					<div class="ml-1">PEMBERIAN INFORMASI</div>
				</td>
			</tr>
        </table>
        <table class="tbl-full">
            <tr class="borderr tdlonggar">
                <td width="33.7%" class="borderr" colspan="2">
                    <div class="ml-1">Dokter Pelaksana Tindakan</div>
                </td>
                <td  class="borderr" colspan="2"><?php echo $params->dokter_pelaksana; ?></td>
            </tr>
            <tr class="borderr tdlonggar">
                <td class="borderr" colspan="2">
                    <div class="ml-1">Pemberi Informasi</div>
                </td>
                <td class="borderr" colspan="2">
                    <?php echo $params->ttd_data->dokter; ?>
                </td>
            </tr>
            <tr class="borderr tdlonggar">
                <td class="borderr" colspan="2">
                    <div class="ml-1">Penerima Informasi / pemberian persetujuan *</div>
                </td>
                <td class="borderr" colspan="2">
                    <?php echo $params->ttd_data->penerima; ?>
                </td>
            </tr>
            <tr class="tdlonggar">
                <td width="3%" class="borderr centerr boldd tdlonggar">
                    NO
                </td>
                <td width="30%" class="borderr centerr boldd">
                    JENIS INFORMASI
                </td>
                <td width="54%" class="borderr centerr boldd">
                    ISI INFORMASI
                </td>
                <td width="13%" class="borderr centerr boldd">
                    TANDA (V)
                </td>
            </tr>
            <?php $no = 1; ?>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">Diagnosa (WD&DD)</div>
                </td>
                <td class="borderr ml-1">
                    <?php echo nl2br($params->jenis_informasi->diagnosa->isi_informasi); ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->diagnosa->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Dasar Diagnosa
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->dasar_diagnosa->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->dasar_diagnosa->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Tindakan Kedokteran
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->tindakan_kedokteran->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->tindakan_kedokteran->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Indikasi Tindakan
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo nl2br($params->jenis_informasi->indikasi_tindakan->isi_informasi); ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->indikasi_tindakan->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Tata Cara
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo nl2br($params->jenis_informasi->tata_cara->isi_informasi); ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->tata_cara->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Tujuan
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->tujuan->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->tujuan->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Resiko
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->risiko->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->risiko->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Komplikasi
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo nl2br($params->jenis_informasi->komplikasi->isi_informasi); ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->komplikasi->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Prognosis
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->prognosis->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->prognosis->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Alternatif & Risiko
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->alternatif->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->alternatif->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
            <tr>
                <td class="borderr centerr ">
                    <?php echo $no++ . '.'; ?>
                </td>
                <td class="borderr">
                    <div class="ml-1">
                        Lain-lain
                    </div>
                </td>
                <td class="borderr ml-1">
                    <?php echo $params->jenis_informasi->lain_lain->isi_informasi; ?>
                </td>
                <td class="borderr centerr middle">
                    <?php echo ($params->jenis_informasi->lain_lain->tanda == "Ya" ? "V" : ""); ?>
                </td>
            </tr>
        </table>
        <table class="tbl-full">
            <tr>
                <td width="70%" class="borderr">
                    <div class="ml-1 prg">
                        Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan
                        memberikan kesempatan untuk bertanya dan atau berdiskusi
                    </div>
                </td>
                <td class="centerr borderr">
                    Tanda tangan Dokter 
                    <div class="ttd-image">
                        <img src="<?php echo $params->ttd_data->dokter_stroke  ?>" style="height: 100px; width: auto; display: block; margin: 10px auto;">
                    </div> 
                    <?php echo $params->ttd_data->dokter ?>
                </td>
            </tr>
            <tr>
                <td width="70%" class="borderr">
                    <div class="ml-1 prg">
                        Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas yang saya beri tanda / paraf di kolom kanannya, dan telah memahaminya.
                    </div>
                </td>
                <td class="centerr borderr">
                    Tanda tangan Pasien/Keluarga
                    <div class="ttd-image">
                        <img src="<?php echo $params->ttd_data->penerima_stroke  ?>" style="height: 100px; width: auto; display: block; margin: 10px auto;" >
                    </div> 
                    <?php echo $params->ttd_data->penerima; ?>

                </td>
            </tr>
            <tr>
                <td colspan="2" class="borderr prg">
                    * Bila pasien tidak kompeten atau tidak mampu menerima informasi, maka penerima informasi adalah
                    wali/keluarga terdekat
                </td>
            </tr>
        </table>

    </div>
    

    <div class="pagebreak">
        <table border="0">
            <tr>
                <td align="right">RM 15.14a</td>
            </tr>
        </table>
        <table class="tbl-full borderr">
            <tr>
                <td class="borderr">
                    <center><B>PERNYATAAN <br> PERSETUJUAN TINDAKAN KEDOKTERAN</B></center>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="ml-1">
                        Yang bertanda tangan di bawah ini, saya* :
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="ml-2">
                        <tr>
                            <td width="18%">Nama</td>
							<td width="1%">:</td>
							<td>
								<?php echo $params->ttd_data->menyatakan; ?>
							</td>
                        </tr>
                        <tr>
							<td>Umur</td>
							<td>:</td>
							<td>
								<?php echo !empty($params->penolakan_tindakan_kedokteran->yang_bertandatangan->umur) ? $params->penolakan_tindakan_kedokteran->yang_bertandatangan->umur . " Tahun" : ""; ?>
							</td>
                        </tr>
                        <tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td>
								<?php 
                                    $kelamin = $params->penolakan_tindakan_kedokteran->yang_bertandatangan->kelamin;
                                    echo ($kelamin == 'L' ? "Laki-laki" : ($kelamin == 'P' ? "Perempuan" : ""));
                                ?>
							</td>
                        </tr>
                        <tr>
							<td>Alamat</td>
							<td>:</td>
							<td>
								<?php echo $params->penolakan_tindakan_kedokteran->yang_bertandatangan->alamat; ?>
							</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="prg ml-1">
                        Dengan ini menyatakan PERSETUJUAN untuk dilakukan tindakan :
                        <?php echo $params->penolakan_tindakan_kedokteran->tindakan; ?> 
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="prg ml-1">
                        Terhadap <?php echo !empty($params->penolakan_tindakan_kedokteran->terhadap->value) ? $params->penolakan_tindakan_kedokteran->terhadap->value . " Saya* :" : " Saya* :"; ?>

                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="ml-2">
						<tr>
                            <td width="18%">Nama</td>
							<td width="1%">:</td>
							<td>
								<?php echo $params->penolakan_tindakan_kedokteran->terhadap->nama; ?>
							</td>
                        </tr>
                        <tr>
							<td>Umur</td>
							<td>:</td>
							<td>
								<?php echo !empty($params->penolakan_tindakan_kedokteran->terhadap->umur) ? $params->penolakan_tindakan_kedokteran->terhadap->umur . " Tahun" : ""; ?>
							</td>
                        </tr>
                        <tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td>
								<?php 
                                    $kelamin = $params->penolakan_tindakan_kedokteran->terhadap->kelamin;
                                    echo ($kelamin == 'L' ? "Laki-laki" : ($kelamin == 'P' ? "Perempuan" : ""));
                                ?>
							</td>
                        </tr>
                        <tr>
							<td>Alamat</td>
							<td>:</td>
							<td>
								<?php echo $params->penolakan_tindakan_kedokteran->terhadap->alamat; ?>
							</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="prg ml-1" style="margin-top: 3px">
                        Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti diatas
                        kepada saya, termasuk resiko dan komplikasi yang mungkin timbul.
                    </div>
                    <div class="prg ml-1" style="margin-top: 3px">
                        Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, maka keberhasilan
                        tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan yang
                        Maha Esa.
                    </div>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
					<table class="ml-2">
						<tr>
							<td>
								<?php echo $static_label->hospital_city; ?>, <?php echo $params->ttd_data->tanggal_indo; ?>
							</td>
                        </tr>
						<tr>
							<td>
								Pukul, <?php echo !empty($params->ttd_data->jam) ? $params->ttd_data->jam . " WIB" : ""; ?>
							</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <!--start ttd-->
                <td>
                    <table>
                        <tr>
                            <td class="centerr" width="33.3%">
                                Yang Menyatakan
                            </td>
                            <td colspan="2" class="centerr" width="66.3%">
                                Saksi-saksi
                            </td>
                            <!--<td class="centerr" width="33.3%">-->
                            <!--    Saksi 2-->
                            <!--</td>-->
                            <!--<td class="centerr" width="50%">-->
                            <!--    Dokter-->
                            <!--</td>-->
                        </tr>
                        <tr>
                            <td class="centerr">
								<img src="<?php echo $params->ttd_data->menyatakan_stroke ?>" style="height: 100px; width: auto; display: block; margin: 10px auto;">
                            </td>
                            <td class="centerr" width="33.3%">
								<img src="<?php echo $params->ttd_data->saksi1_stroke ?>" style="height: 100px; width: auto; display: block; margin: 10px auto;">
                            </td>
                            <td class="centerr" width="33.3%">
								<img src="<?php echo $params->ttd_data->saksi2_stroke ?>" style="height: 100px; width: auto; display: block; margin: 10px auto;">
                            </td>
                            <!--<td class="centerr">-->
								<!--<img src="<?php echo $params->ttd_data->dokter_stroke ?>" style="height: 100px; width: auto; display: block; margin: 10px auto;">-->
                            <!--</td>-->
                        </tr>
                        <tr>
                            <td class="centerr">
								<?php echo $params->ttd_data->menyatakan; ?>
                            </td>
                            <td class="centerr">
								<?php echo $params->ttd_data->saksi1; ?>
                            </td>
                            <td class="centerr">
								<?php echo $params->ttd_data->saksi2; ?>
                            </td>
                            <!--<td class="centerr">-->
                    			<!--<?php echo $params->ttd_data->dokter; ?>-->
                            <!--</td>-->
                        </tr>
                    </table>
                </td>
                <!--end ttd-->
            </tr>
        </table>
    </div>
</body>