<?php
// EMR Data
$params = json_decode($argv[1]);

$base_url = $argv[2]; // Base_url
$title = "ASESMEN AWAL MEDIS GIGI DAN MULUT RAWAT JALAN";
$static_label = json_decode($argv[3]);

function render_option($selected, $option)
{
    if (is_array($selected)) {
        return in_array($option, $selected) ? $option : "<s>$option</s>";
    }
    return (strpos((string)$selected, $option) !== false) ? $option : "<s>$option</s>";
}
?>
<?php
function tanggal_indo($tanggal) {
    if (empty($tanggal)) return '';

    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
    ];

    $pecah = explode('-', $tanggal);

    if (count($pecah) !== 3) return $tanggal;

    return ltrim($pecah[2], '0') . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        body, h1, h2, h3, h4, h5, h6, p, ol, ul {
            margin: 0;
            padding: 0;
            font-weight: normal;
        }

        body {
            font: 12pt times new roman;
            size: f4;
            padding-bottom: 10px;
        }

        /* PERBAIKAN CSS UNTUK PDF PAGE BREAK */
        /* Menambahkan !important agar rule ini menimpa pengaturan default mesin PDF */
        table, tbody, thead, tfoot, tr, td, th, div, p, span, ul, ol, li {
            page-break-inside: auto !important;
            page-break-after: auto !important;
            page-break-before: auto !important;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        thead {
            display: table-header-group; /* Agar header tabel berulang jika pindah halaman */
        }

        tfoot {
            display: table-footer-group;
        }

        td, th {
            word-wrap: break-word; /* Mencegah teks meluber keluar batas tabel */
            overflow-wrap: break-word;
            vertical-align: top; /* Pastikan teks rata atas jika nantinya terpotong beda halaman */
        }
        /* AKHIR PERBAIKAN CSS PAGE BREAK */

        th td {
            width: 30px;
        }

        td {
            /* height: 25px; <-- Fix height dinonaktifkan karena sering mencegah page-break natural di PDF */
            padding-top: 3px; 
            padding-bottom: 3px;
        }

        .table-bordered,
        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 0.2em;
        }
        
        .table-border-no-top,
        .table-border-no-top th,
        .table-border-no-top td {
            border-top: none;
            border-bottom: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            padding: 0.2em;
        }
        
        .table-border-no-bottom,
        .table-border-no-bottom th,
        .table-border-no-bottom td {
            border-bottom: none;
            border-top: 1px solid black;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            padding: 0.2em;
        }
        
        .table-border-no-top-bottom,
        .table-border-no-top-bottom th,
        .table-border-no-top-bottom td {
            border-top: none;
            border-bottom: none;
            border-left: 1px solid black;
            border-right: 1px solid black;
            border-collapse: collapse;
            padding: 0.2em;
        }
        
        .table-border-outline {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 0.2em;
        }
        
        .table-borderless,
        .table-borderless th,
        .table-borderless td,
        .table-border-outline th,
        .table-border-outline td {
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
            text-align: right;
            text-wrap: nowrap;
            white-space: nowrap;
        }

        .flex-text-end {
            display: table-cell;
            text-align: left;
            text-wrap: nowrap;
            white-space: nowrap;
        }

        .flex-text {
            display: table-cell;
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

        .w100 { width: 100%; }
        .w80 { width: 80%; }
        .w70 { width: 70%; }
        .w65 { width: 65%; }
        .w60 { width: 60%; }
        .w55 { width: 55%; }
        .w50 { width: 50%; }
        .w45 { width: 45%; }
        .w40 { width: 40%; }
        .w35 { width: 35%; }
        .w30 { width: 30%; }
        .w25 { width: 25%; }
        .w20 { width: 20%; }
        .w15 { width: 15%; }
        .w10 { width: 10% }
        .w5 { width: 5% }
        .w3 { width: 3% }
        .w1 { width: 1% }

        .ttd-img {
            width: 200px;
            height: 120px;
            object-fit: contain;
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

        .pagebreak-avoid {
            page-break-inside: avoid !important;
        }
        
        .text-header{
            font-size:14pt;
        }
        
        .text-title{
            font-size:14pt;
        }
        
        .text-paragraph{
            font-size: 12pt;
        }
    </style>
</head>

<body>
    <!--START KOP-->
    <table class="table-bordered" style="margin-top: 10px; border-bottom: none;">
        <tr>
            <td valign="top" align="left" width="50%" style="border-right: none; padding: 2px;">
                <table class="table-borderless">
                    <tr>
                        <td align="left" valign="top" width="30%">
                            <img id="logo" style="width:80px; height:80px;" src="<?= $base_url; ?>/images/rs/LogoRS.png">
                        </td>
                        <td align="left" style=" line-height: 1.2;">
                            <p class="text-header"><b><?php echo $static_label->hospital_agency ?? '' ?></b></p>
                            <p class="text-header"><b><?php echo $static_label->hospital_name ?? '' ?></b></p>
                            <p class="text-paragraph"><?php echo $static_label->hospital_address ?? '' ?></p>
                            <p class="text-paragraph">
                                <?= !empty($static_label->hospital_email) ? "e-mail : " . $static_label->hospital_email : '' ?>
                                <?= !empty($static_label->hospital_web) ? "website : " . $static_label->hospital_web : '' ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
            <td valign="top" width="50%" style="padding: 10px;">
                <div style="border:1px solid black;  padding: 5px; ">
                    <table class="table-borderless text-paragraph" style=" width: 80%; line-height: 1;">
                        <tr>
                            <td valign="top" width="30%">Nama</td>
                            <td valign="top" width="2%">:</td>
                            <td valign="top"><?= $params->pasien->nama ?? "" ?></td>
                        </tr>
                        <tr>
                            <td valign="top">No. RM</td>
                            <td valign="top">:</td>
                            <td valign="top"><?= $params->pasien->no_rm ?? "" ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Jenis Kelamin</td>
                            <td valign="top">:</td>
                            <td valign="top"><?= $params->pasien->kelamin ?? "" ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Alamat</td>
                            <td valign="top">:</td>
                            <td valign="top"><?= $params->pasien->alamat  ?? "" ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Tempat Lahir</td>
                            <td valign="top">:</td>
                            <td valign="top"><?= $params->pasien->tempat_lahir  ?? "" ?></td>
                        </tr>
                        <tr>
                            <td valign="top">Tanggal Lahir</td>
                            <td valign="top">:</td>
                            <td valign="top"><?= $params->pasien->tanggal_lahir_indo ?? "" ?></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <!--END KOP-->

    <!-- TITLE -->
    <table class="table-bordered" style="margin-top: -1px; border-bottom: none;">
        <tr>
            <td align="center" class="text-title" style="background-color: #d9d9d9;">
                <b>ASESMEN AWAL MEDIS GIGI DAN MULUT RAWAT JALAN</b>
            </td>
        </tr>
    </table>

    <!-- TANGGAL & JAM -->
    <table class="table-bordered" style="margin-top: -1px; border-bottom: none;">
        <tr>
            <td >
                <table class="table-borderless">
                    <tr>
                        <td width="50%" style="padding-right:8px">
                            <div class="flex-container" >
                                <span >Tanggal : </span>
                                <div class="flex-dotted" style="margin-left:8px">
                                    <span><?= $params->pasien->tanggal_indo ?? "" ?></span>
                                </div>
                            </div>
                        </td>
                        <td width="50%">
                            <div class="flex-container" style="padding-right:8px">
                                <span >Jam : </span>
                                <div class="flex-dotted" style="margin-left:8px">
                                    <span><?= $params->pasien->jam ?? "" ?> WIB</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- SUMBER DATA DLL -->
    <table class="table-bordered" style="margin-top: -1px; border-bottom: none;">
        <tr>
            <td>
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="20%">Sumber Data</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <div class="flex-container">
                                <?php
                                $sumber_data_checkbox = trim($params->sumber_data_checkbox ?? '');
                                $riwayat_alergi = trim($params->vital_sign->alergi ?? '');
                                $hamil = trim($params->hamil ?? '');
                                ?>
                                <input type="checkbox" <?php echo ($sumber_data_checkbox == 'Autoanamnesis') ? 'checked' : ''; ?> />
                                <span style="margin-top: 8px;">Autoanamnesis</span>
                                
                                <input type="checkbox" <?php echo ($sumber_data_checkbox == 'Alloanamnesis') ? 'checked' : ''; ?> />
                                <span style="margin-top: 8px;">Alloanamnesis</span>
                                
                                <span style="margin-left:20px" >dengan : </span>
                                <div class="flex-dotted" style="margin-left:8px">
                                    <span><?= $params->sumber_data_dengan ?? '' ?></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" width="20%">Riwayat Alergi</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <div style="border-bottom: 2px dotted black; min-height: 1.5em; padding-bottom: 2px; width: 100%;">
                                <?= nl2br(htmlspecialchars($riwayat_alergi ?? '')) ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Hamil</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <div style="border-bottom: 2px dotted black; min-height: 1.5em; padding-bottom: 2px; width: 100%;">
                                <?= nl2br(htmlspecialchars($hamil ?? '')) ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Bubungan dengan pasien</td>
                        <td valign="top">:</td>
                        <td valign="top">
                            <div style="border-bottom: 2px dotted black; min-height: 1.5em; padding-bottom: 2px; width: 100%;">
                                <span><?= $params->hubungan_dengan_pasien ?? '' ?></span>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- KELUHAN DLL -->
    <table class="table-border-no-bottom text-paragraph" style="margin-top: -1px; ">
        <tr>
            <td style="padding: 4px;">
                <table class="table-borderless" style="line-height: 2;">
                    <tr>
                        <td valign="top" width="3%"><b>1.</b></td>
                        <td valign="top" width="35%"><b>KELUHAN UTAMA</b></td>
                        <td valign="top" width="2%"><b>:</b></td>
                        <td valign="top"><?= $params->vital_sign->keluhan_utama  ?? "" ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td valign="top"><b>2.</b></td>
                        <td valign="top"><b>RIWAYAT PENYAKIT SEKARANG</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top"><?= $params->vital_sign->anamnesis  ?? "" ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 15px;"></td>
                    </tr>
                    <!--<tr>-->
                    <!--    <td valign="top"><b>3.</b></td>-->
                    <!--    <td valign="top"><b>ALLOANAMNESA</b></td>-->
                    <!--    <td valign="top"><b>:</b></td>-->
                    <!--    <td valign="top">
                    <?php 
                    //$params->alloanamnesa ?? "" 
                    ?>
                    </td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                    <!--    <td colspan="4" style="height: 15px;"></td>-->
                    <!--</tr>-->
                    <tr>
                        <td valign="top"><b>3.</b></td>
                        <td valign="top"><b>RIWAYAT PENYAKIT DAHULU</b></td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top"><?= $params->riwayat_penyakit_dahulu  ?? "" ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td valign="top" width="3%"><b>4.</b></td>
                        <td valign="top" width="35%"><b>RIWAYAT PENGGUNAAN OBAT</b></td>
                        <td valign="top" width="2%"><b>:</b></td>
                        <td valign="top">
                            <?= nl2br($params->resep_freetext ?? '') ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td valign="top"><b>5.</b></td>
                        <td valign="top"><b>PEMERIKSAAN FISIK</b></td>
                        <td valign="top" colspan="2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td valign="top">Keadaan Umum</td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top"><?= $params->vital_sign->pemeriksaan_fisik ?? "" ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td valign="top">Kesadaran</td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top"><?= $params->vital_sign->kesadaran ?? "" ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 5px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom text-paragraph" style="margin-top: -1px; ">
        <tr>
            <td style="padding: 4px;">
                <table class="table-borderless" style="line-height: 2;">
                    <tr>
                        <td width="3%"></td>
                        <td valign="top" width="35%">Pemeriksaan Objektif</td>
                        <td valign="top" width="2%"><b>:</b></td>
                        <td valign="top" ><?= $params->pemeriksaan_objektif ?? "" ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 5px;"></td>
                    </tr>
                    <tr>
                        <td width="3%"></td>
                        <td valign="top" width="35%">EO (Ekstra Oral)</td>
                        <td valign="top" width="2%"><b>:</b></td>
                        <td valign="top"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td valign="top" colspan="3"><?= $params->ekstra_oral ?? "" ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top-bottom" >
        <tr>
            <td style="padding:10px"  >
                <p>Intra Oral :</p>
                <br />
                <img 
                    src="<?= $base_url; ?>/images/keterangan_odontogram_1.png"
                    style="width:100%; height:auto; object-fit:contain;"
                >
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top-bottom" >
        <tr>
            <td style="padding:10px"  >
                <img 
                    src="<?= $base_url; ?>/images/keterangan_odontogram_3.png"
                    style="width:100%; height:auto; object-fit:contain;"
                >
                <img 
                    src="<?= $base_url; ?>/images/keterangan_odontogram_2.png"
                    style="width:100%; height:auto; object-fit:contain;"
                >
                <hr />
                <?php if (!empty($params->odontogram_stroke)) : ?>
                    <img 
                        src="<?= $params->odontogram_stroke ?? "" ?>" 
                        style="width:100%; height:auto; object-fit:contain; padding-left:10px"
                    >
                <?php endif; ?>
                <div style="padding:4px;">
                    <b>Keterangan :</b><br>
                    <p><?= nl2br(htmlspecialchars($params->odontogram_keterangan_freetext ?? '')) ?></p>
                </div>
            </td>
        </tr>
    </table>

    <!-- NEXT SECTION -->
    <table class="table-border-no-bottom" style=" border-bottom: none;">
        <tr>
            <td style="padding: 10px;">
                <table class="table-borderless" style="line-height: 2;">
                    <tr>
                        <td width="20%" valign="top" >Oklusi</td>
                        <td width="2%" valign="top" ><b>:</b></td>
                        <td valign="top">
                            <?= render_option($params->oklusi, 'Normal Bite') ?> /
                            <?= render_option($params->oklusi, 'Cross Bite') ?> /
                            <?= render_option($params->oklusi, 'Steep Bite') ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td  valign="top">Torus Palatinus</td>
                        <td  valign="top"><b>:</b></td>
                        <td valign="top">
                            <?= render_option($params->torus_platinus, 'Tidak Ada') ?> /
                            <?= render_option($params->torus_platinus, 'Kecil') ?> /
                            <?= render_option($params->torus_platinus, 'Sedang') ?> /
                            <?= render_option($params->torus_platinus, 'Besar') ?> /
                            <?= render_option($params->torus_platinus, 'Multiple') ?>
                        </td>
                    </tr>
                    <tr>
                        <td  valign="top">Torus Mandibula</td>
                        <td  valign="top"><b>:</b></td>
                        <td valign="top">
                            <?= render_option($params->torus_mandibula, 'Tidak Ada') ?> /
                            <?= render_option($params->torus_mandibula, 'Kecil') ?> /
                            <?= render_option($params->torus_mandibula, 'Sedang') ?> /
                            <?= render_option($params->torus_mandibula, 'Besar') ?> /
                            <?= render_option($params->torus_mandibula, 'Multiple') ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Palatum</td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top">
                            <?= render_option($params->palatum, 'Dalam') ?> /
                            <?= render_option($params->palatum, 'Sedang') ?> /
                            <?= render_option($params->palatum, 'Rendah') ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Diastema</td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" style="border-bottom: 1px dotted black;">
                            <?= render_option($params->diastema, 'Tidak Ada') ?> /
                            <?= render_option($params->diastema, 'Ada') ?>
                            &nbsp;&nbsp;&nbsp;&nbsp; <?= $params->diastema_detail ?? "" ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Gigi Anomali</td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" style="border-bottom: 1px dotted black;">
                            <?= render_option($params->gigi_anomali, 'Tidak Ada') ?> /
                            <?= render_option($params->gigi_anomali, 'Ada') ?>
                            &nbsp;&nbsp;&nbsp;&nbsp; <?= $params->gigi_anomali_detail ?? "" ?>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Lain-lain</td>
                        <td valign="top"><b>:</b></td>
                        <td valign="top" style="border-bottom: 1px dotted black;">
                            <?= $params->lain_lain ?? "" ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom" style=" border-bottom: none;">
        <tr>
            <td style="padding-left:10px; padding-right:10px; padding-bottom:10px">
                <table class="table-borderless" style="line-height: 2;">
                    <tr>
                        <td valign="top" width="35%">Jumlah dan jenis foto yang diambil &nbsp; <b>:</b></td>
                        <td valign="top" style="border-bottom: 1px dotted black;">
                            <?= $params->jumlah_dan_jenis_foto_yang_diambil ?? "" ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- IMAGE SECTION -->    
    <table class="table-bordered" style="margin-top: -1px; width: 100%;">
        <tr>
            <td style="padding: 10px;">
                <table class="table-borderless" style="width: 100%;">
                    <tr>
                        <td width="40%" align="center" style="padding: 10px; border-right: 1px solid black; vertical-align: top;">
                            
                            <div style="width: 300px; height: 230px; margin: 0 auto; 
                                        background-image: url('<?= $base_url; ?>/images/mulut.jpeg'); 
                                        background-size: 300px 230px; 
                                        background-repeat: no-repeat; 
                                        background-position: center top;">
                                
                                <?php if (!empty($params->image_canvas->canvas1->stroke)): ?>
                                    <img src="<?= $params->image_canvas->canvas1->stroke ?>" 
                                         style="width: 300px; height: 230px; display: block; margin: 0; padding: 0;">
                                <?php endif; ?>
    
                            </div>
    
                        </td>
                        <td width="60%" valign="top" style="padding: 10px;">
                            <span style="font-size: 12pt;">Deskripsi lesi / kelainan yang ditemukan:</span><br><br>
                            <div>
                                <?= nl2br($params->deskripsi_lesi ?? '') ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!--HASIL PEMERIKSAAAN PENUNJANG-->
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>7.</b></td>
                        <td valign="top" width="35%"><b>HASIL PEMERIKSAAN PENUNJANG : </b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%">a.</td>
                        <td valign="top" width="20%">Laboratorium</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->laboratorium_freetext ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%">b.</td>
                        <td valign="top" width="20%">Radiologi</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->radiologi_freetext ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%">c.</td>
                        <td valign="top" width="20%">EKG</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->ekg_freetext ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%">d.</td>
                        <td valign="top" width="20%">Lain-lain</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->lain_lain_freetext ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    
    <!--DIAGNOSIS SECTION-->
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>8.</b></td>
                        <td valign="top" width="35%"><b>DIAGNOSIS : </b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="22%">Diagnosa Kerja</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->diagnosa_masuk_group ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="22%">Diagnosa Banding</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->diagnosa_banding_group ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding-left:36px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="22%">Diagnosis Tambahan / Sekunder</td>
                        <td valign="top" width="1%">:</td>
                        <td valign="top">
                            <?= nl2br($params->diagnosa_sekunder_group ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>9.</b></td>
                        <td valign="top" width="35%"><b>MASALAH MEDIS : </b></td>
                    </tr>
                    <tr>
                        <td colspan="2"> 
                            <?= nl2br($params->masalah_medis ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>10.</b></td>
                        <td valign="top" width="35%"><b>MASALAH KEPERAWATAN : </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?= nl2br($params->masalah_keperawatan ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>11.</b></td>
                        <td valign="top" width="35%"><b>SASARAN / TARGET TERAPI  : </b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?= nl2br($params->sasaran ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>12.</b></td>
                        <td valign="top" width="35%"><b>RENCANA ASUHAN / TERAPI / STANDING ORDER : </b></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left:40px">
                            <?= nl2br($params->tindakan_group ?? '') ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>13.</b></td>
                        <td valign="top" width="35%"><b>RENCANA PEMULANGAN DAN TINDAK LANJUT PERAWATAN PASIEN  : </b></td>
                    </tr>
                </table>
                <div style="padding-left:38px">
                    <table class="table-bordered">
                        <tr>
                            <td valign="top" width="40%">
                                <table class="table-borderless">
                                    <tr>
                                        <td style="padding-left:5px">
                                            <?php
                                            $checkbox_rawat_jalan = trim($params->checkbox_rawat_jalan);
                                            ?>
                                            <input type="checkbox" <?php echo ($checkbox_rawat_jalan) ? 'checked' : ''; ?> />
                                            <span style="margin-top: 8px;">Rawat Jalan</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:5px">
                                            <?php
                                            $checkbox_rawat_inap = trim($params->checkbox_rawat_inap);
                                            ?>
                                            <input type="checkbox" <?php echo ($checkbox_rawat_inap) ? 'checked' : ''; ?> />
                                            <span style="margin-top: 8px;">Rawat Inap</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="table-borderless">
                                                <tr>
                                                    <td valign="top" width="50%">
                                                        <?php
                                                        $checkbox_dpjp_ranap = trim($params->checkbox_dpjp_ranap);
                                                        ?>
                                                        <input type="checkbox" <?php echo ($checkbox_dpjp_ranap) ? 'checked' : ''; ?> />
                                                        <span style="margin-top: 8px;">DPJP Rawat Inap </span>
                                                    </td>
                                                    <td valign="top" width="1%">:</td>
                                                    <td valign="top">
                                                        <?= $params->dpjp_ranap ?? "" ?> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Rujuk Ke :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="table-borderless">
                                                <tr>
                                                    <td valign="top" width="50%">
                                                        <?php
                                                        $checkbox_dokter_spesialis = trim($params->checkbox_dokter_spesialis);
                                                        ?>
                                                        <input type="checkbox" <?php echo ($checkbox_dokter_spesialis) ? 'checked' : ''; ?> />
                                                        <span style="margin-top: 8px;">Dokter/Dokter Spesialis </span>
                                                    </td>
                                                    <td valign="top" width="1%">:</td>
                                                    <td valign="top">
                                                        <?= $params->dokter_spesialis ?? "" ?> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="table-borderless">
                                                <tr>
                                                    <td valign="top" width="50%">
                                                        <?php
                                                        $checkbox_rs_rujukan = trim($params->checkbox_rs_rujukan);
                                                        ?>
                                                        <input type="checkbox" <?php echo ($checkbox_rs_rujukan) ? 'checked' : ''; ?> />
                                                        <span style="margin-top: 8px;">RS </span>
                                                    </td>
                                                    <td valign="top" width="1%">:</td>
                                                    <td valign="top">
                                                        <?= $params->rs_rujukan ?? "" ?> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table class="table-borderless">
                                                <tr>
                                                    <td valign="top" width="50%">
                                                        <?php
                                                        $checkbox_puskesmas = trim($params->checkbox_puskesmas);
                                                        ?>
                                                        <input type="checkbox" <?php echo ($checkbox_puskesmas) ? 'checked' : ''; ?> />
                                                        <span style="margin-top: 8px;">Puskesmas </span>
                                                    </td>
                                                    <td valign="top" width="1%">:</td>
                                                    <td valign="top">
                                                        <?= $params->puskesmas ?? "" ?> 
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:5px">
                                            <?php
                                            $checkbox_dokter_keluarga = trim($params->checkbox_dokter_keluarga);
                                            ?>
                                            <input type="checkbox" <?php echo ($checkbox_dokter_keluarga) ? 'checked' : ''; ?> />
                                            <span style="margin-top: 8px;">Dokter Keluarga</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:5px">
                                            <?php
                                            $checkbox_homecare = trim($params->checkbox_homecare);
                                            ?>
                                            <input type="checkbox" <?php echo ($checkbox_homecare) ? 'checked' : ''; ?> />
                                            <span style="margin-top: 8px;">Homecare</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td valign="top" width="30%">
                                <table class="table-borderless">
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Ruang :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <?= !empty($params->pasien->bangsal) ? $params->pasien->bangsal . ' - ' : '' ?>
                                            <?= !empty($params->pasien->ruang) ? 'Ruang ' . $params->pasien->ruang . ' - ' : '' ?>
                                            <?= !empty($params->pasien->kelas) ? $params->pasien->kelas : '' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:8px"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Kontrol klinik / Homecare :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <?= $params->kontrol_klinik  ?? "" ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td valign="top" width="30%">
                                <table class="table-borderless">
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Indikasi :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <?= $params->indikasi  ?? "" ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:8px"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Tanggal :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <?= $params->tanggal_rencana_pemulangan_indo  ?? "" ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-bottom">
        <tr>
            <td style="padding:4px 8px 0px 8px">
                <table class="table-borderless">
                    <tr>
                        <td valign="top" width="1%"><b>14.</b></td>
                        <td valign="top" width="35%"><b>EDUKASI PASIEN ( Edukasi awal, disampaikan tentang dignosis, rencana dan tujuan terapi )  : </b></td>
                    </tr>
                </table>
                <div style="padding-left:38px">
                    <table class="table-bordered">
                        <tr>
                            <td valign="top" width="40%">
                                <table class="table-borderless">
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Edukasi :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <?= $params->edukasi  ?? "" ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="height:8px"></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:6px">
                                            <p>Edukasi Awal, disampaikan Kepada :</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:5px">
                                            <?php
                                            $edukasi_awal_disampaikan = trim($params->edukasi_awal_disampaikan);
                                            ?>
                                            <input type="checkbox" <?php echo ($edukasi_awal_disampaikan == "pasien") ? 'checked' : ''; ?> />
                                            <span style="margin-top: 8px;">Pasien</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:5px">
                                            <div class="flex-container">
                                                <input type="checkbox" <?php echo ($edukasi_awal_disampaikan == "keluarga") ? 'checked' : ''; ?> />
                                                <span style="margin-top: 8px;">Keluarga Pasien, nama :</span>
                                                <span class="flex-dotted"><?= $params->nama_keluarga_pasien  ?? "" ?></span>
                                                <span style="margin-top: 8px;">Hubungan dengan pasien :</span>
                                                <span class="flex-dotted"><?= $params->hubungan_dengan_pasien_edukasi  ?? "" ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left:5px">
                                            <div class="flex-container">
                                                <input type="checkbox" <?php echo ($edukasi_awal_disampaikan == "tidak") ? 'checked' : ''; ?> />
                                                <span style="margin-top: 8px;"> Tidak dapat memberi edukasi kepada pasien atau keluarga, karena</span>
                                                <span class="flex-dotted"><?= $params->alasan_tidak_dapat_memberi_edukasi  ?? "" ?></span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    
    <table class="table-border-no-top" style="padding-top:10px">
        <tr>
            <td align="center" style="width: 50%; border-right:none; padding-top:20px; padding-bottom:20px">
                <p style="margin-top : 28px">Dokter</p>
                <?php if (!empty($params->ttd_data->dokter_stroke)) : ?>
                    <img src="<?= $params->ttd_data->dokter_stroke ?>" style="height: 90px; width: auto; display: block; margin: 10px auto;">
                <?php else : ?>
                    <div style="height: 100px; margin: 10px auto;"></div>
                <?php endif; ?>
                <p><?= $params->ttd_data->dokter ?></p>
            </td>
            <td align="center" style="width: 50%; border-left:none; padding-top:20px; padding-bottom:20px">
                   <span> <?= $static_label->hospital_city ?>, <?= $params->ttd_data->tanggal_indo ?>, Jam : <?= $params->ttd_data->jam ?> </span>
                <p>Pasien / Penerima Penjelasan</p>
                <?php if (!empty($params->ttd_data->pasien_stroke)) : ?>
                    <img src="<?= $params->ttd_data->pasien_stroke ?>" style="height: 90px; width: auto; display: block; margin: 10px auto;">
                <?php else : ?>
                    <div style="height: 100px; margin: 10px auto;"></div>
                <?php endif; ?>
                <p><?= $params->ttd_data->pasien ?></p>
            </td>
            
            
        </tr>
    </table>
    
    <!-- CORET SECTION -->
    <table class="table-borderless" style="margin-top: 5px;">
        <tr>
            <td style="font-size: 10pt; padding: 5px 10px; line-height: 1.5;">
                <b>*Coret yang tidak perlu</b><br>
                Beri tanda ( ✔ ) pada kotak ( ☐ ) sesuai pilihan
            </td>
        </tr>
    </table>
</body>

</html>