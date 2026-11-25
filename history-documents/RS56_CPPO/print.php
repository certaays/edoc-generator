<?php
// EMR Data
$params = json_decode($argv[1]);

$base_url = $argv[2]; // Base_url
$title = "CHEKLIST PREVERIFIKASI PASIEN OPERASI / TINDAKAN INVASIF";
$static_label = json_decode($argv[3]);


// nilai posisi dari form
$posisi = $params->posisi ?? '';
// kalau ternyata array (checkbox multiple)
if (is_array($posisi)) {
    $isKanan = in_array('Kanan', $posisi);
    $isKiri  = in_array('Kiri', $posisi);
} else {
    $isKanan = ($posisi === 'Kanan');
    $isKiri  = ($posisi === 'Kiri');
}

// Ambil data coretan jika ada
$image_canvas = $params->image_canvas ?? null;
$canvas1_image = isset($image_canvas->canvas1->image_base64) ? $image_canvas->canvas1->image_base64 : null;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
</head>
<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    ol,
    ul {
        margin: 0;
        padding: 0;
        font-weight: normal;
    }

    body {
        font: 14pt times new roman;
        size: f4;
        padding-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th td {
        width: 30px;
    }

    td {
        height: 25px;
    }

    .table-bordered,
    .table-bordered th,
    .table-bordered td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: .2em;
    }

    .table-borderless,
    .table-borderless th,
    .table-borderless td {
        border: none;
        border-collapse: collapse;
    }

    .img-logo {
        width: 250px;
        height: 70px;
    }

    .vertical-text {
        padding: 0;
        margin: 0;
        writing-mode: tb-rl;
        filter: flipv fliph;
        -webkit-transform: rotate(90deg);
        white-space: nowrap;
        text-orientation: mixed;
        font-weight: bold;
        text-align: center;
        vertical-align: middle;
    }
    
    .txt-vertical-1 {
				transform: translate(-40%, -50%) rotate(-90deg);
				-webkit-transform: translate(-40%, -50%) rotate(-90deg);
				position: absolute;
		}

		.txt-vertical-2 {
				transform: translate(-50%, -50%) rotate(-90deg);
				-webkit-transform: translate(-50%, -50%) rotate(-90deg);
				position: absolute;
		}

		.textbottomup {
				transform: rotate(180deg);
				writing-mode: vertical-rl;
				text-align: center;
		}

    .tanda-tangan {
        width: 100px;
        height: 100px;
    }

    .text {
        padding: 4px 0px;
    }

    .td-default {
        border: 1px solid black;
        padding: 0.5em 1em;
    }

    .td-borderless {
        border: 1px solid none;
        padding: 1em 1em;
    }

    .flex {
        display: table;
        width: 100%;
        box-sizing: border-box;
    }

    .flex-text-start {
        display: table-cell;
        ;
        text-align: right;
        text-wrap: nowrap;
        white-space: nowrap;
    }

    .flex-text-end {
        display: table-cell;
        ;
        text-align: left;
        text-wrap: nowrap;
        white-space: nowrap;
        white-space: nowrap;
    }

    .flex-text {
        display: table-cell;
        ;
        text-align: center;
        text-wrap: nowrap;
    }

    .flex-blank {
        display: table-cell;
        text-align: center;
    }

    .flex-dotted {
        display: table-cell;
        border-bottom: 2px dotted black;
        text-align: center;
    }

    .flex-solid {
        display: table-cell;
        border-bottom: 2px solid black;
        text-align: center;
    }

    .rectangle {
        display: inline-block;
        margin-right: 1em;
        border: 1px solid black;
        width: 11px;
        height: 11px;
    }

    .flex-container {
        padding: 0;
        margin: 0;
        width: 100%;
        list-style: none;
        -ms-box-orient: horizontal;
        -webkit-box-pack: left;
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -moz-flex;
        display: -webkit-flex;
        display: flex;
        flex-flow: row wrap;
        justify-content: space-between;
        align-items: stretch;
    }

    .flex-item {
        -webkit-flex-wrap: nowrap;
        flex-wrap: nowrap;
    }

    .flex-solid {
        display: -webkit-box;
        -webkit-box-pack: justify;
        flex: 1;
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        border-bottom: 1px solid black;
    }

    .flex-dotted {
        display: -webkit-box;
        -webkit-box-pack: justify;
        flex: 1;
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        border-bottom: 2px dotted black;
    }

    .flex-blank {
        display: -webkit-box;
        -webkit-box-pack: justify;
        flex: 1;
        -webkit-box-flex: 1;
        -webkit-flex: 1;
    }

    .w100 {
        width: 100%;
    }

    .w80 {
        width: 80%;
    }

    .w70 {
        width: 70%;
    }

    .w65 {
        width: 65%;
    }

    .w60 {
        width: 60%;
    }

    .w55 {
        width: 55%;
    }

    .w50 {
        width: 50%;
    }

    .w45 {
        width: 45%;
    }

    .w40 {
        width: 40%;
    }

    .w35 {
        width: 35%;
    }

    .w30 {
        width: 30%;
    }

    .w25 {
        width: 25%;
    }

    .w20 {
        width: 20%;
    }

    .w15 {
        width: 15%;
    }

    .w10 {
        width: 10%
    }

    .w5 {
        width: 5%
    }

    .w3 {
        width: 3%
    }

    .w1 {
        width: 1%
    }
    
    .ttd-img {
				width: 200px;
        height: 120px;
        object-fit: contain; /* atau contain tergantung kebutuhan */
    }

    .circle {
        display: inline-block;
        border: 2px solid black;
        border-radius: 50%;
        text-align: center;
        font-weight: bold;
        padding: 5px;
    }
    
    .pagebreak {
        min-height: 1px;
        page-break-before: always;
    }
    
    /* BARIS INI AKAN MENCEGAH TABEL TERPOTONG */
    .pagebreak-avoid {
        page-break-inside: avoid;
    }
    
    .table-kop{
        border: 1px solid #000;
    }
    
    .hospital-name,
    .hospital-agen {
        font-size: 18px;
    }

    .hospital-address, 
    .hospital-info {
        font-size: 14px;
    }
    
    .fs-small{
        font-size: 12px;
    }
    
    .canvas-image {
        width: 75%;
        max-width: 500px;
        height: auto;
        object-fit: contain;
        border: 1px solid #ccc;
    }
    
    @media print {
        table.no-break {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    
        table.no-break tr,
        table.no-break td,
        table.no-break th,
        table.no-break tbody {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    }

</style>

<body>
    <table class="table-kop">
        <tr>
            <td class="w10" align="center">
                <img style="width: 100%;padding: 5px;" src="<?= "$base_url/images/rs/LogoRS.png" ?>">
            </td>
            <td align="center" style="border-right: 1px solid #000;">
                <div class="hospital-agen">
                    <b><?php echo$static_label->hospital_agency ?></b>
                </div>
                <div class="hospital-name">
                    <b><?php echo $static_label->hospital_name; ?></b>
                </div>
                <div class="hospital-address">
                    <?php echo $static_label->hospital_address; ?>
                </div>
                <!--<div class="hospital-info">-->
                <!--    <p>e-mail : rsgmsoelastri@ums.ac.id website : http://rsgmsoelastri.umsac.id</p>-->
                <!--</div>-->
            </td>
            <td class="w40">
                <table style="font-size: 16px;">
                    <tr>
                        <td width="37%" valign="top" style="padding-left: 10px;padding-top: 10px;">No.RM</td>
                        <td width="3%" valign="top" style="padding-top: 10px;">:</td>
                        <td width="60%" valign="top" style="padding-top: 10px;"><?= $params->pasien->no_rm ?></td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding-left: 10px;">Nama</td>
                        <td valign="top">:</td>
                        <td valign="top"><?= $params->pasien->nama ?></td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding-left: 10px;">Tgl. Lahir</td>
                        <td valign="top">:</td>
                        <td valign="top"><?= $params->pasien->tanggal_lahir_indo ?></td>
                    </tr>
                    <tr>
                        <td valign="top" style="padding-left: 10px;padding-bottom: 10px;">Jenis Kelamin</td>
                        <td valign="top" style="padding-bottom: 10px;">:</td>
                        <td valign="top" style="padding-bottom: 10px;"><?= $params->pasien->kelamin ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table style="background-color: #909090;border-left: 1px solid #000;border-right: 1px solid #000;">
        <tr>
            <th style="padding: 8px;">CHEKLIST PREVERIFIKASI PASIEN OPERASI / TINDAKAN INVASIF</th>
        </tr>
    </table>
    
    <table class="table-bordered fs-small">
        <tr>
            <td width="60%" style="padding-left: 10px;">Jam Tiba di Kamar Operasi : <?= $params->jam_tiba ?></td>
            <td width="40%" style="padding-left: 10px;">Jam Keluar dari Kamar Operasi : <?= $params->jam_keluar ?></td>
        </tr>
    </table>
    
    <table class="table-bordered fs-small">
        <tr>
            <td width="40%" align="center">Ruang Rawat :</td>
            <td width="20%" align="center">Tanggal Operasi :</td>
            <td width="40%" align="center">Lokasi Tindakan	:</td>
        </tr>
    </table>
    
    <table class="table-bordered fs-small">
        <tr>
            <td width="40%" align="center"><?= $params->pasien->bangsal ?> - Ruang <?= $params->pasien->ruang ?> - <?= $params->pasien->kelas ?></td>
            <td width="20%" align="center"><?= $params->tanggal_operasi_indo ?></td>
            <td width="30%" align="center"><?= $params->lokasi_tindakan ?></td>
            <td width="5%" align="center">
                <?= $isKanan ? 'Kanan' : '<s>Kanan</s>' ?>
            </td>
            <td width="5%" align="center">
                <?= $isKiri ? 'Kiri' : '<s>Kiri</s>' ?>
            </td>
        </tr>
    </table>
    
    <!--<table class="table-bordered fs-small" style="background-color: #00cd82;">-->
    <!--    <tr>-->
    <!--        <td width="60%" align="center"><b>PRE OPERASI</b></td>-->
    <!--        <td width="40%" align="center"><b>PASCA OPERASI</b></td>-->
    <!--    </tr>-->
    <!--</table>-->
    
    <table class="table-bordered fs-small no-break" style="page-break-inside: avoid;break-inside: avoid;">
        <!--<thead style="background-color: #00cd82;">-->
            <!-- HEADER BARIS 1 -->
            <tr style="background-color: #00cd82;">
                <th colspan="5" align="center">PRE OPERASI</th>
                <th colspan="5" align="center">PASCA OPERASI</th>
            </tr>
    
            <!-- HEADER BARIS 2 -->
            <tr style="background-color: #00cd82;">
                <th width="40%" align="center">Kelengkapan</th>
                <th width="5%" align="center">RJ</th>
                <th width="5%" align="center">IGD</th>
                <th width="5%" align="center">RI</th>
                <th width="5%" align="center">OK</th>
    
                <th width="20%" align="center">Kelengkapan</th>
                <th width="5%" align="center">OK</th>
                <th width="5%" align="center">RR</th>
                <th width="5%" align="center">RI</th>
                <th width="5%" align="center">RJ</th>
            </tr>
        <!--</thead>-->
        <!--<tbody>-->
            <tr>
                <td style="padding-left: 10px;">Rekam Medis Pasien</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->rekam_medis) && $params->pre_operasi->rekam_medis === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->rekam_medis) && $params->pre_operasi->rekam_medis === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->rekam_medis) && $params->pre_operasi->rekam_medis === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->rekam_medis) && $params->pre_operasi->rekam_medis === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Kesadaran / nilai :</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->kesadaran) && $params->pasca_operasi->kesadaran === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->kesadaran) && $params->pasca_operasi->kesadaran === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->kesadaran) && $params->pasca_operasi->kesadaran === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->kesadaran) && $params->pasca_operasi->kesadaran === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Informed Consent  ditandatangani</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->informed) && $params->pre_operasi->informed === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->informed) && $params->pre_operasi->informed === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->informed) && $params->pre_operasi->informed === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->informed) && $params->pre_operasi->informed === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Rekam Medis Pasien</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->rekam_medis) && $params->pasca_operasi->rekam_medis === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->rekam_medis) && $params->pasca_operasi->rekam_medis === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->rekam_medis) && $params->pasca_operasi->rekam_medis === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->rekam_medis) && $params->pasca_operasi->rekam_medis === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Gelang Identitas terpasang</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gelang) && $params->pre_operasi->gelang === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gelang) && $params->pre_operasi->gelang === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gelang) && $params->pre_operasi->gelang === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gelang) && $params->pre_operasi->gelang === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Gelang Identitas terpasang</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->gelang) && $params->pasca_operasi->gelang === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->gelang) && $params->pasca_operasi->gelang === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->gelang) && $params->pasca_operasi->gelang === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->gelang) && $params->pasca_operasi->gelang === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Konsul Kardiologi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kardiologi) && $params->pre_operasi->kardiologi === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kardiologi) && $params->pre_operasi->kardiologi === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kardiologi) && $params->pre_operasi->kardiologi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kardiologi) && $params->pre_operasi->kardiologi === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Laporan Operasi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->operasi === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->operasi === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->operasi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->operasi === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Konsul Interna</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->intema) && $params->pre_operasi->intema === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->intema) && $params->pre_operasi->intema === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->intema) && $params->pre_operasi->intema === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->intema) && $params->pre_operasi->intema === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Laporan Anestesi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->anestesi === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->anestesi === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->anestesi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->anestesi) && $params->pasca_operasi->anestesi === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Konsul Paru</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->paru) && $params->pre_operasi->paru === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->paru) && $params->pre_operasi->paru === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->paru) && $params->pre_operasi->paru === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->paru) && $params->pre_operasi->paru === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Resep</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->resep) && $params->pasca_operasi->resep === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->resep) && $params->pasca_operasi->resep === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->resep) && $params->pasca_operasi->resep === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->resep) && $params->pasca_operasi->resep === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Konsul Anak</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anak) && $params->pre_operasi->anak === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anak) && $params->pre_operasi->anak === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anak) && $params->pre_operasi->anak === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anak) && $params->pre_operasi->anak === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Laporan Nosokomial</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->nosokomial) && $params->pasca_operasi->nosokomial === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->nosokomial) && $params->pasca_operasi->nosokomial === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->nosokomial) && $params->pasca_operasi->nosokomial === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->nosokomial) && $params->pasca_operasi->nosokomial === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Konsul Anestesi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anestesi) && $params->pre_operasi->anestesi === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anestesi) && $params->pre_operasi->anestesi === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anestesi) && $params->pre_operasi->anestesi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->anestesi) && $params->pre_operasi->anestesi === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Ringkasan Pulang</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pulang) && $params->pasca_operasi->pulang === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pulang) && $params->pasca_operasi->pulang === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pulang) && $params->pasca_operasi->pulang === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pulang) && $params->pasca_operasi->pulang === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Golongan darah & darah tersedia</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gol_darah) && $params->pre_operasi->gol_darah === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gol_darah) && $params->pre_operasi->gol_darah === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gol_darah) && $params->pre_operasi->gol_darah === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gol_darah) && $params->pre_operasi->gol_darah === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Form Pemeriksaan PA</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pemeriksaan) && $params->pasca_operasi->pemeriksaan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pemeriksaan) && $params->pasca_operasi->pemeriksaan === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pemeriksaan) && $params->pasca_operasi->pemeriksaan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->pemeriksaan) && $params->pasca_operasi->pemeriksaan === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Hasil laboratorium terlampir</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_lab) && $params->pre_operasi->hasil_lab === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_lab) && $params->pre_operasi->hasil_lab === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_lab) && $params->pre_operasi->hasil_lab === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_lab) && $params->pre_operasi->hasil_lab === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Bahan spesimen: Kultur, PA</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->bahan) && $params->pasca_operasi->bahan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->bahan) && $params->pasca_operasi->bahan === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->bahan) && $params->pasca_operasi->bahan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->bahan) && $params->pasca_operasi->bahan === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Hasil Radiologi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_rad) && $params->pre_operasi->hasil_rad === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_rad) && $params->pre_operasi->hasil_rad === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_rad) && $params->pre_operasi->hasil_rad === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->hasil_rad) && $params->pre_operasi->hasil_rad === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Hasil Radiologi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->hasil_rad) && $params->pasca_operasi->hasil_rad === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->hasil_rad) && $params->pasca_operasi->hasil_rad === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->hasil_rad) && $params->pasca_operasi->hasil_rad === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->hasil_rad) && $params->pasca_operasi->hasil_rad === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">USG</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->usg) && $params->pre_operasi->usg === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->usg) && $params->pre_operasi->usg === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->usg) && $params->pre_operasi->usg === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->usg) && $params->pre_operasi->usg === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">USG</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->usg) && $params->pasca_operasi->usg === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->usg) && $params->pasca_operasi->usg === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->usg) && $params->pasca_operasi->usg === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->usg) && $params->pasca_operasi->usg === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">CT Scan</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->scan) && $params->pre_operasi->scan === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->scan) && $params->pre_operasi->scan === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->scan) && $params->pre_operasi->scan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->scan) && $params->pre_operasi->scan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">CT Scan</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->scan) && $params->pasca_operasi->scan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->scan) && $params->pasca_operasi->scan === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->scan) && $params->pasca_operasi->scan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->scan) && $params->pasca_operasi->scan === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Puasa</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->puasa) && $params->pre_operasi->puasa === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->puasa) && $params->pre_operasi->puasa === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->puasa) && $params->pre_operasi->puasa === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->puasa) && $params->pre_operasi->puasa === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Transfusi darah</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->transfusi) && $params->pasca_operasi->transfusi === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->transfusi) && $params->pasca_operasi->transfusi === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->transfusi) && $params->pasca_operasi->transfusi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->transfusi) && $params->pasca_operasi->transfusi === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Kebersihan Pasien/mandi/(Antiseptic)</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kebersihan) && $params->pre_operasi->kebersihan === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kebersihan) && $params->pre_operasi->kebersihan === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kebersihan) && $params->pre_operasi->kebersihan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kebersihan) && $params->pre_operasi->kebersihan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Obat Pulang</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->obat) && $params->pasca_operasi->obat === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->obat) && $params->pasca_operasi->obat === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->obat) && $params->pasca_operasi->obat === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->obat) && $params->pasca_operasi->obat === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Area Operasi dicukur bila perlu menggunakan Clipper</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->area_operasi) && $params->pre_operasi->area_operasi === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->area_operasi) && $params->pre_operasi->area_operasi === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->area_operasi) && $params->pre_operasi->area_operasi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->area_operasi) && $params->pre_operasi->area_operasi === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;">Perawatan di rumah</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->perawatan) && $params->pasca_operasi->perawatan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->perawatan) && $params->pasca_operasi->perawatan === 'RR' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->perawatan) && $params->pasca_operasi->perawatan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pasca_operasi->perawatan) && $params->pasca_operasi->perawatan === 'RJ' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;font-size: 11px;">Perhiasan , Gigi palsu, Kontak Lensa, Hearing Aid dilepas</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->perhiasan) && $params->pre_operasi->perhiasan === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->perhiasan) && $params->pre_operasi->perhiasan === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->perhiasan) && $params->pre_operasi->perhiasan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->perhiasan) && $params->pre_operasi->perhiasan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;" rowspan="3" colspan="5" valign="top">
                    Catatan :
                    <p><?= $params->catatan ?></p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Tata rias & cat kuku dihapus</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->tata_rias) && $params->pre_operasi->tata_rias === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->tata_rias) && $params->pre_operasi->tata_rias === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->tata_rias) && $params->pre_operasi->tata_rias === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->tata_rias) && $params->pre_operasi->tata_rias === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Penandaan lokasi operasi (Site Marking )</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->penandaan) && $params->pre_operasi->penandaan === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->penandaan) && $params->pre_operasi->penandaan === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->penandaan) && $params->pre_operasi->penandaan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->penandaan) && $params->pre_operasi->penandaan === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Infus</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->infus) && $params->pre_operasi->infus === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->infus) && $params->pre_operasi->infus === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->infus) && $params->pre_operasi->infus === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->infus) && $params->pre_operasi->infus === 'OK' ? 'checked' : '' ?>>
                </td>
                <td rowspan="9" colspan="5" valign="top" align="center" style="padding: 4px;">
                    <?php if ($canvas1_image): ?>
                        <!-- Tampilkan gambar dengan coretan jika ada -->
                        <img src="<?= $canvas1_image ?>" class="canvas-image" style="width: 95%; max-width: 100%; height: auto;" alt="Checklist dengan Coretan">
                    <?php else: ?>
                        <!-- Tampilkan gambar default jika tidak ada coretan -->
                        <img src="<?= $base_url ?>/images/checklist_preoperasi_ok.png" style="width: 95%; max-width: 100%; height: auto;">
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Kateter</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kateter) && $params->pre_operasi->kateter === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kateter) && $params->pre_operasi->kateter === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kateter) && $params->pre_operasi->kateter === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kateter) && $params->pre_operasi->kateter === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Alat khusus / Implan tersedia</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->alat_khusus) && $params->pre_operasi->alat_khusus === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->alat_khusus) && $params->pre_operasi->alat_khusus === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->alat_khusus) && $params->pre_operasi->alat_khusus === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->alat_khusus) && $params->pre_operasi->alat_khusus === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Edukasi nyeri pasca operasi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->edukasi) && $params->pre_operasi->edukasi === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->edukasi) && $params->pre_operasi->edukasi === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->edukasi) && $params->pre_operasi->edukasi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->edukasi) && $params->pre_operasi->edukasi === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Kondisi Pasien Stabil</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kondisi) && $params->pre_operasi->kondisi === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kondisi) && $params->pre_operasi->kondisi === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kondisi) && $params->pre_operasi->kondisi === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->kondisi) && $params->pre_operasi->kondisi === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Form Transfer Internal</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->internal) && $params->pre_operasi->internal === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->internal) && $params->pre_operasi->internal === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->internal) && $params->pre_operasi->internal === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->internal) && $params->pre_operasi->internal === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">
                    Antibiotik Profilaksis diberikan 1 jam sebelum insisi
                    <input type="text" style="width: 200px; padding: 2px 4px; font-size: 13px;" value="<?= $params->pre_operasi->antibiotik_text ?? '' ?>">
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->antibiotik) && $params->pre_operasi->antibiotik === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->antibiotik) && $params->pre_operasi->antibiotik === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->antibiotik) && $params->pre_operasi->antibiotik === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->antibiotik) && $params->pre_operasi->antibiotik === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Suhu tubuh (&lt;38°C)</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->suhu) && $params->pre_operasi->suhu === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->suhu) && $params->pre_operasi->suhu === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->suhu) && $params->pre_operasi->suhu === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->suhu) && $params->pre_operasi->suhu === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Gula darah (&lt;200 mg/dl)</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gula_darah) && $params->pre_operasi->gula_darah === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gula_darah) && $params->pre_operasi->gula_darah === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gula_darah) && $params->pre_operasi->gula_darah === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->gula_darah) && $params->pre_operasi->gula_darah === 'OK' ? 'checked' : '' ?>>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Pemakaian Baju Operasi</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemkaian) && $params->pre_operasi->pemkaian === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemkaian) && $params->pre_operasi->pemkaian === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemkaian) && $params->pre_operasi->pemkaian === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemkaian) && $params->pre_operasi->pemkaian === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;" colspan="5">
                    Keterangan :
                    <p><?= nl2br(htmlspecialchars($params->keterangan ?? '')) ?></p>
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Pemberian tetes mata pre OP (ODC)</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemberian) && $params->pre_operasi->pemberian === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemberian) && $params->pre_operasi->pemberian === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemberian) && $params->pre_operasi->pemberian === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pemberian) && $params->pre_operasi->pemberian === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;" colspan="5">1. Beri tanda (V) area yang akan di operasi</td>
            </tr>
            <tr>
                <td style="padding-left: 10px;">Pesanan ICU tersedia bila perlu</td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pesanan) && $params->pre_operasi->pesanan === 'RJ' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pesanan) && $params->pre_operasi->pesanan === 'IGD' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pesanan) && $params->pre_operasi->pesanan === 'RI' ? 'checked' : '' ?>>
                </td>
                <td align="center">
                    <input type="checkbox"  <?=isset($params->pre_operasi->pesanan) && $params->pre_operasi->pesanan === 'OK' ? 'checked' : '' ?>>
                </td>
                <td style="padding-left: 10px;" colspan="5">2. Penulisan  tindakan operasi jelas & singkat</td>
            </tr>
            <tr>
                <td align="center" colspan="5">
                    <label><b>Nama & TTD Petugas</b></label>
                    <img src="<?= $params->ttd_data->petugas_pre_stroke ?>" class="tanda-tangan" style="display: block;margin-top: 10px">
                    <p style="margin-top: 10px">
                        <?= $params->ttd_data->petugas_pre ?>
                    </p>
                </td>
                <td align="center" colspan="5">
                    <label><b>Nama & TTD Petugas</b></label>
                    <img src="<?= $params->ttd_data->petugas_pra_stroke ?>" class="tanda-tangan" style="display: block;margin-top: 10px">
                    <p style="margin-top: 10px">
                        <?= $params->ttd_data->petugas_pra ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td align="center"><b>Pengantar</b></td>
                <td align="center" colspan="4"><b>Penerima</b></td>
                <td align="center"><b>Pengantar</b></td>
                <td align="center" colspan="4"><b>Penerima</b></td>
            </tr>
            <tr>
                <td align="center">
                    <!--<label><b>Nama & TTD Petugas</b></label>-->
                    <img src="<?= $params->ttd_data->pengantar_pre_stroke ?>" class="tanda-tangan" style="display: block;margin-top: 10px">
                    <p style="margin-top: 10px">
                        <?= $params->ttd_data->pengantar_pre ?>
                    </p>
                </td>
                <td align="center" colspan="4">
                    <!--<label><b>Nama & TTD Petugas</b></label>-->
                    <img src="<?= $params->ttd_data->penerima_pre_stroke ?>" class="tanda-tangan" style="display: block;margin-top: 10px">
                    <p style="margin-top: 10px">
                        <?= $params->ttd_data->penerima_pre ?>
                    </p>
                </td>
                <td align="center">
                    <!--<label><b>Nama & TTD Petugas</b></label>-->
                    <img src="<?= $params->ttd_data->pengantar_pra_stroke ?>" class="tanda-tangan" style="display: block;margin-top: 10px">
                    <p style="margin-top: 10px">
                        <?= $params->ttd_data->pengantar_pra ?>
                    </p>
                </td>
                <td align="center" colspan="4">
                    <!--<label><b>Nama & TTD Petugas</b></label>-->
                    <img src="<?= $params->ttd_data->penerima_pra_stroke ?>" class="tanda-tangan" style="display: block;margin-top: 10px">
                    <p style="margin-top: 10px">
                        <?= $params->ttd_data->penerima_pra ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="10" style="padding: 10px;">Berilah tanda (V) bila dilakukan, (-) bila tidak dilakukan <br /> Bila ada catatan yang perlu ditambah bisa mengisi pada kolom catatan</td>
            </tr>
        <!--</tbody>-->
    </table>
</body>

</html>