<?php
// EMR Data
$params = json_decode($argv[1]);

$base_url = $argv[2]; // Base_url
$title = "FORMULIR ASUHAN GIZI ANAK";
$static_label = json_decode($argv[3]);

function tgl_indo($tanggal)
{
    if (empty($tanggal) || $tanggal === '0000-00-00') {
        return '';
    }

    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $timestamp = strtotime($tanggal);

    if ($timestamp === false) {
        return '';
    }

    $hari = date('j', $timestamp);
    $bulan_ke = date('n', $timestamp);
    $tahun = date('Y', $timestamp);

    return $hari . ' ' . $bulan[$bulan_ke] . ' ' . $tahun;
}

// Helper function untuk rendering checkbox [ ]
function render_box($checked) {
    return '<span class="box-check">' . ($checked ? '&#10003;' : '&nbsp;') . '</span>';
}

// Helper function untuk radio/bullet circle (o)
function render_radio($checked) {
    return '<span class="circle-radio">' . ($checked ? '&#9679;' : 'o') . '</span>';
}
?>

<!DOCTYPE html>
<html lang="id">

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
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            line-height: 1.2;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered,
        .table-bordered th,
        .table-bordered td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 3px 5px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }

        /* Custom Input Visual Styles */
        .box-check {
            display: inline-block;
            width: 13px;
            height: 13px;
            border: 1px solid black;
            text-align: center;
            line-height: 11px;
            font-size: 10px;
            font-weight: bold;
            vertical-align: middle;
            background-color: #fff;
        }

        .circle-radio {
            display: inline-block;
            font-size: 11px;
            font-weight: bold;
            vertical-align: middle;
            margin-right: 2px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <!-- ========================================== -->
    <!-- HALAMAN 1                                 -->
    <!-- ========================================== -->

    <!-- KOP RUMAH SAKIT HALAMAN 1 -->
    <table border="0" width="100%" style="border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="width: 55%; vertical-align: middle; text-align: left;">
                <table border="0" style="border-collapse: collapse;">
                    <tr>
                        <td style="width: 80px; text-align: center; vertical-align: middle;">
                            <img src="<?= $base_url . '/images/rs/LogoRs.png' ?>" style="width:70px; height:auto;" />
                        </td>
                        <td style="vertical-align: middle; padding-left: 10px;">
                            <span style="font-weight: bold; font-size: 18px; line-height: 1.2;">
                                <?= isset($static_label->hospital_name) ? $static_label->hospital_name : '' ?><br>
                            </span>
                            <span style="font-weight: bold; font-size: 18px; line-height: 1.2;">
                                <?= isset($static_label->hospital_city) ? $static_label->hospital_city : '' ?><br>
                            </span>
                            <span style="font-size: 14px;">
                                <?= isset($static_label->hospital_address) ? $static_label->hospital_address : '' ?><br>
                            </span>
                            <span style="font-weight: bold; font-size: 18px; line-height: 1.2;">
                                <?= isset($static_label->hospital_regency) ? $static_label->hospital_regency : '' ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 45%; vertical-align: top;">
                <table style="border:1px solid black; border-collapse:collapse; width:100%; font-size:10pt;">
                    <tr>
                        <td style="padding:1px 4px; width:30%; vertical-align: top;">No RM</td>
                        <td style="padding:1px 4px; width:2%; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; width:68%; vertical-align: top;">
                            <?= isset($params->pasien->no_rm) ? $params->pasien->no_rm : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px; vertical-align: top;">Nama Pasien</td>
                        <td style="padding:1px 4px; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; vertical-align: top;">
                            <?= isset($params->pasien->nama) ? $params->pasien->nama : '' ?>
                            <?php
                            $kelamin = isset($params->pasien->kelamin) ? $params->pasien->kelamin : '';
                            if ($kelamin == 'L' || $kelamin == 'Laki-laki') {
                                echo ' (L)';
                            } elseif ($kelamin == 'P' || $kelamin == 'Perempuan') {
                                echo ' (P)';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px; vertical-align: top;">Tanggal Lahir</td>
                        <td style="padding:1px 4px; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; vertical-align: top;">
                            <?= isset($params->pasien->tanggal_lahir) ? (function_exists('tgl_indo') ? tgl_indo($params->pasien->tanggal_lahir) : $params->pasien->tanggal_lahir) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px; vertical-align: top;">NIK</td>
                        <td style="padding:1px 4px; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; vertical-align: top;">
                            <?= isset($params->pasien->no_identitas) && !empty($params->pasien->no_identitas) ? $params->pasien->no_identitas : (isset($params->pasien->nik) ? $params->pasien->nik : (isset($params->external_link->px_data->no_identitas) ? $params->external_link->px_data->no_identitas : (isset($params->external_link->px_data->nik) ? $params->external_link->px_data->nik : ''))) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- JUDUL DOKUMEN -->
    <div class="text-center font-bold" style="font-size: 13pt; margin-top: 10px; margin-bottom: 8px;">
        FORMULIR ASUHAN GIZI ANAK
    </div>

    <!-- MAIN FORM TABLE HALAMAN 1 -->
    <table class="table-bordered" style="width: 100%;">
        <!-- ROW 1: Tanggal & DPJP -->
        <tr>
            <td style="width: 50%; vertical-align: top;">
                Tanggal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= isset($params->data_gizi->tanggal) ? $params->data_gizi->tanggal : '' ?>
            </td>
            <td style="width: 50%; vertical-align: top;">
                DPJP &nbsp;&nbsp;&nbsp;&nbsp;: <?= isset($params->ttd_data->dokter) ? $params->ttd_data->dokter : '' ?>
            </td>
        </tr>

        <!-- ROW 2: Diagnosa Medis -->
        <?php
            $freetext = isset($params->diagnosa_freetext) ? trim($params->diagnosa_freetext) : '';
            $auto_list = isset($params->diagnosa_list_autocomplete) ? (array)$params->diagnosa_list_autocomplete : [];
            
            $freetext_lines = [];
            if (!empty($freetext)) {
                $lines = preg_split('/\r\n|\r|\n/', $freetext);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!empty($line)) {
                        $freetext_lines[] = $line;
                    }
                }
            }

            $has_numbering = false;
            if (!empty($freetext_lines) && preg_match('/^\d+\.\s*/', $freetext_lines[0])) {
                $has_numbering = true;
            }

            $all_diag_output = [];
            $curr_num = 1;

            foreach ($freetext_lines as $fline) {
                if ($has_numbering) {
                    $all_diag_output[] = htmlspecialchars($fline);
                } else {
                    $all_diag_output[] = $curr_num . '. ' . htmlspecialchars($fline);
                }
                $curr_num++;
            }

            foreach ($auto_list as $auto_item) {
                $auto_item = (object)$auto_item;
                $icd = isset($auto_item->icd_x) ? $auto_item->icd_x : (isset($auto_item->kode_nama) ? $auto_item->kode_nama : '');
                $nama = isset($auto_item->nama_sebab_sakit) ? $auto_item->nama_sebab_sakit : (isset($auto_item->deskripsi) ? $auto_item->deskripsi : (isset($auto_item->deskripsi_diet_diagnosa_gizi) ? $auto_item->deskripsi_diet_diagnosa_gizi : ''));
                
                $text = trim($icd . ($nama ? ' - ' . $nama : ''));
                if (!empty($text)) {
                    $all_diag_output[] = $curr_num . '. ' . htmlspecialchars($text);
                    $curr_num++;
                }
            }
        ?>
        <tr>
            <td colspan="2" style="vertical-align: top; padding: 4px 6px;">
                <table style="width: 100%; border: none; border-collapse: collapse;">
                    <tr>
                        <td style="width: 110px; vertical-align: top; border: none; padding: 0; white-space: nowrap;">
                            Diagnosa medis :
                        </td>
                        <td style="vertical-align: top; border: none; padding: 0;">
                            <?php if (!empty($all_diag_output)): ?>
                                <?= implode('<br>', $all_diag_output) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ROW 3: Header ASSESMENT GIZI -->
        <tr>
            <td colspan="2" class="text-center font-bold" style="padding: 2px 0;">
                ASSESMENT GIZI
            </td>
        </tr>

        <!-- ROW 4: Antropometri & Status Gizi -->
        <tr>
            <!-- Left: Antropometri -->
            <td style="width: 50%; vertical-align: top; padding: 4px;">
                <div class="font-bold" style="margin-bottom: 2px;">Antropometri</div>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 55px; border: none; padding: 1px 0;">BB</td>
                        <td style="width: 15px; border: none; padding: 1px 0;">:</td>
                        <td style="width: 50px; border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->antropometri->bb) ? $params->data_gizi->antropometri->bb : '' ?>
                        </td>
                        <td style="border: none; padding: 1px 0; text-align: left;">Kg</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">TB</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->antropometri->tb) ? $params->data_gizi->antropometri->tb : '' ?>
                        </td>
                        <td style="border: none; padding: 1px 0; text-align: left;">Cm</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">LILA</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->antropometri->lila) ? $params->data_gizi->antropometri->lila : '' ?>
                        </td>
                        <td style="border: none; padding: 1px 0; text-align: left;">Cm</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">TL/RL</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->antropometri->tl_rl) ? $params->data_gizi->antropometri->tl_rl : '' ?>
                        </td>
                        <td style="border: none; padding: 1px 0; text-align: left;">Cm</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">BBI</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->antropometri->bbi) ? $params->data_gizi->antropometri->bbi : '' ?>
                        </td>
                        <td style="border: none; padding: 1px 0; text-align: left;">Kg</td>
                    </tr>
                </table>
            </td>

            <!-- Right: Status Gizi -->
            <td style="width: 50%; vertical-align: top; padding: 4px;">
                <div class="font-bold" style="margin-bottom: 2px;">Status Gizi</div>
                <table style="width: 100%; border: none;">
                    <tr>
                        <td style="width: 55px; border: none; padding: 1px 0;">BB/U</td>
                        <td style="width: 15px; border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->status_gizi->bb_u) ? $params->data_gizi->status_gizi->bb_u : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">TB/U</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->status_gizi->tb_u) ? $params->data_gizi->status_gizi->tb_u : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">BB/TB</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->status_gizi->bb_tb) ? $params->data_gizi->status_gizi->bb_tb : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">LLA/U</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->status_gizi->lla_u) ? $params->data_gizi->status_gizi->lla_u : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding: 1px 0;">Umur</td>
                        <td style="border: none; padding: 1px 0;">:</td>
                        <td style="border: none; padding: 1px 0;">
                            <?= isset($params->data_gizi->status_gizi->umur_thn) ? $params->data_gizi->status_gizi->umur_thn : '' ?> th
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= isset($params->data_gizi->status_gizi->umur_bln) ? $params->data_gizi->status_gizi->umur_bln : '' ?> bln
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <?= isset($params->data_gizi->status_gizi->umur_hr) ? $params->data_gizi->status_gizi->umur_hr : '' ?> hr
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ROW 5: Biokimia -->
        <tr>
            <td colspan="2" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse; font-size: 10pt;">
                    <tr>
                        <td colspan="4" style="border-bottom: 1px solid black; border-top: none; border-left: none; border-right: none; padding: 2px 5px; font-weight: bold;">
                            Biokimia
                        </td>
                    </tr>
                    <tr>
                        <!-- Column 1 -->
                        <td style="width: 29%; vertical-align: top; border-right: 1px solid black; border-top: none; border-bottom: none; border-left: none; padding: 3px 5px;">
                            1. HB : <?= (isset($params->data_gizi->biokimia->hb) && $params->data_gizi->biokimia->hb !== '') ? $params->data_gizi->biokimia->hb : '................' ?><br>
                            <span style="padding-left: 14px;">(Lk : 14 – 18 g/dl)</span><br>
                            <span style="padding-left: 14px;">(Pr : 12 – 16 g/dl)</span><br>
                            2. Kreatinin : <?= (isset($params->data_gizi->biokimia->kreatinin) && $params->data_gizi->biokimia->kreatinin !== '') ? $params->data_gizi->biokimia->kreatinin : '........' ?><br>
                            <span style="padding-left: 14px;">(L : 0,6 - 1,1 mg/dl)</span><br>
                            <span style="padding-left: 14px;">(P : 0,45 – 0,75 g/dl)</span><br>
                            3. Ureum : <?= (isset($params->data_gizi->biokimia->ureum) && $params->data_gizi->biokimia->ureum !== '') ? $params->data_gizi->biokimia->ureum : '............' ?><br>
                            <span style="padding-left: 14px;">(L : 15 – 45 mg/dl)</span><br>
                            <span style="padding-left: 14px;">(P : 15 – 45 mg/dl)</span><br>
                            4. Asam Urat : <?= (isset($params->data_gizi->biokimia->asam_urat) && $params->data_gizi->biokimia->asam_urat !== '') ? $params->data_gizi->biokimia->asam_urat : '..........' ?><br>
                            <span style="padding-left: 14px;">(L : 3,4 – 7,0 mg/dl)</span><br>
                            <span style="padding-left: 14px;">(P : 2,5 – 6,0 mg/dl)</span>
                        </td>

                        <!-- Column 2 -->
                        <td style="width: 26%; vertical-align: top; border-right: 1px solid black; border-top: none; border-bottom: none; border-left: none; padding: 3px 5px;">
                            5. KGDs : <?= (isset($params->data_gizi->biokimia->kgds) && $params->data_gizi->biokimia->kgds !== '') ? $params->data_gizi->biokimia->kgds : '.............' ?><br>
                            <span style="padding-left: 14px;">( 80 – 110 g/dl )</span><br>
                            6. Cholesterol : <?= (isset($params->data_gizi->biokimia->cholesterol) && $params->data_gizi->biokimia->cholesterol !== '') ? $params->data_gizi->biokimia->cholesterol : '.......' ?><br>
                            <span style="padding-left: 14px;">( &lt; 220 mg/dl )</span><br>
                            7. Trigliserida : <?= (isset($params->data_gizi->biokimia->trigliserida) && $params->data_gizi->biokimia->trigliserida !== '') ? $params->data_gizi->biokimia->trigliserida : '.........' ?><br>
                            <span style="padding-left: 14px;">(L : 60 – 165</span><br>
                            <span style="padding-left: 14px;">mg/dl)</span><br>
                            <span style="padding-left: 14px;">(P : 40 – 140 mg/dl)</span><br>
                            8. HDL : <?= (isset($params->data_gizi->biokimia->hdl) && $params->data_gizi->biokimia->hdl !== '') ? $params->data_gizi->biokimia->hdl : '..............' ?><br>
                            <span style="padding-left: 14px;">( &gt; 45 mg/dl)</span><br>
                            9. LDL : <?= (isset($params->data_gizi->biokimia->ldl) && $params->data_gizi->biokimia->ldl !== '') ? $params->data_gizi->biokimia->ldl : '..............' ?><br>
                            <span style="padding-left: 14px;">( 60 – 130 mg/dl )</span>
                        </td>

                        <!-- Column 3 -->
                        <td style="width: 23%; vertical-align: top; border-right: 1px solid black; border-top: none; border-bottom: none; border-left: none; padding: 3px 5px;">
                            10. HBsAg : <?= (isset($params->data_gizi->biokimia->hbsag) && $params->data_gizi->biokimia->hbsag !== '') ? $params->data_gizi->biokimia->hbsag : '............' ?><br><br>
                            11. SGPT : <?= (isset($params->data_gizi->biokimia->sgpt) && $params->data_gizi->biokimia->sgpt !== '') ? $params->data_gizi->biokimia->sgpt : '..............' ?><br><br>
                            12. SGOT : <?= (isset($params->data_gizi->biokimia->sgot) && $params->data_gizi->biokimia->sgot !== '') ? $params->data_gizi->biokimia->sgot : '.............' ?><br><br>
                            13. Albumin : <?= (isset($params->data_gizi->biokimia->albumin) && $params->data_gizi->biokimia->albumin !== '') ? $params->data_gizi->biokimia->albumin : '..........' ?><br>
                            <span style="padding-left: 14px;">(3,8 – 4,4 mg/dl)</span>
                        </td>

                        <!-- Column 4 -->
                        <td style="width: 22%; vertical-align: top; border: none; padding: 3px 5px;">
                            14. Lain-lain :<br>
                            <?php if (isset($params->data_gizi->biokimia->lain_lain) && !empty($params->data_gizi->biokimia->lain_lain)): ?>
                                <?= nl2br(htmlspecialchars($params->data_gizi->biokimia->lain_lain)) ?>
                            <?php else: ?>
                                &nbsp;&nbsp;&nbsp;&nbsp;...................<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;...................<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;...................<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;...................<br>
                                &nbsp;&nbsp;&nbsp;&nbsp;...................
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ROW 6: FISIK / KLINIS -->
        <?php
            $gangguan_list = isset($params->data_gizi->fisik_klinis->gangguan) ? (array)$params->data_gizi->fisik_klinis->gangguan : [];
            $lain_gangguan = isset($params->data_gizi->fisik_klinis->lain_lain_gangguan) ? $params->data_gizi->fisik_klinis->lain_lain_gangguan : '';
            $is_tidak_ada  = in_array('Tidak ada', $gangguan_list);
            $actual_gangguan = array_diff($gangguan_list, ['Tidak ada']);
            $has_gangguan  = !empty($actual_gangguan) || !empty($lain_gangguan);

            $pemberian_raw = isset($params->data_gizi->fisik_klinis->cara_pemberian) ? $params->data_gizi->fisik_klinis->cara_pemberian : '';
            $pemberian_list = is_array($pemberian_raw) ? $pemberian_raw : [$pemberian_raw];
            $lain_pemberian = isset($params->data_gizi->fisik_klinis->lain_lain_pemberian) ? $params->data_gizi->fisik_klinis->lain_lain_pemberian : '';
        ?>
        <tr>
            <td colspan="2" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="border-bottom: 1px solid black; border-top: none; border-left: none; border-right: none; padding: 2px 5px; font-weight: bold;">
                            Fisik / klinis
                        </td>
                    </tr>
                    <tr>
                        <!-- Col 1: Vital Sign -->
                        <td style="width: 27%; vertical-align: top; border-right: 1px solid black; border-top: none; border-bottom: none; border-left: none; padding: 3px 5px;">
                            <div class="italic" style="margin-bottom: 2px;">Vital Sign</div>
                            <table style="width: 100%; border: none;">
                                <tr>
                                    <td style="width: 30px; border: none; padding: 1px 0;">TD</td>
                                    <td style="width: 10px; border: none; padding: 1px 0;">:</td>
                                    <td style="border: none; padding: 1px 0;"><?= isset($params->data_gizi->fisik_klinis->td) ? $params->data_gizi->fisik_klinis->td : '' ?></td>
                                    <td style="width: 45px; border: none; padding: 1px 0;">mmHg</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 1px 0;">N</td>
                                    <td style="border: none; padding: 1px 0;">:</td>
                                    <td style="border: none; padding: 1px 0;"><?= isset($params->data_gizi->fisik_klinis->n) ? $params->data_gizi->fisik_klinis->n : '' ?></td>
                                    <td style="border: none; padding: 1px 0;">x/i</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 1px 0;">T</td>
                                    <td style="border: none; padding: 1px 0;">:</td>
                                    <td style="border: none; padding: 1px 0;"><?= isset($params->data_gizi->fisik_klinis->t) ? $params->data_gizi->fisik_klinis->t : '' ?></td>
                                    <td style="border: none; padding: 1px 0;">°C</td>
                                </tr>
                                <tr>
                                    <td style="border: none; padding: 1px 0;">RR</td>
                                    <td style="border: none; padding: 1px 0;">:</td>
                                    <td style="border: none; padding: 1px 0;"><?= isset($params->data_gizi->fisik_klinis->rr) ? $params->data_gizi->fisik_klinis->rr : '' ?></td>
                                    <td style="border: none; padding: 1px 0;">x/i</td>
                                </tr>
                            </table>
                        </td>

                        <!-- Col 2: Gangguan -->
                        <td style="width: 45%; vertical-align: top; border-right: 1px solid black; border-top: none; border-bottom: none; border-left: none; padding: 3px 5px;">
                            <div><?= render_box($is_tidak_ada) ?> &nbsp;Tidak ada</div>
                            <div style="margin-top: 1px;"><?= render_box($has_gangguan) ?> &nbsp;Ada :</div>
                            
                            <table style="width: 100%; border: none; margin-top: 1px;">
                                <tr>
                                    <td style="width: 48%; vertical-align: top; border: none; padding: 0 0 0 16px;">
                                        <?= render_box(in_array('Diare', $gangguan_list)) ?> Diare<br>
                                        <?= render_box(in_array('Muntah', $gangguan_list)) ?> Muntah<br>
                                        <?= render_box(in_array('Mual', $gangguan_list)) ?> Mual<br>
                                        <?= render_box(!empty($lain_gangguan)) ?> Lain-lain : <?= !empty($lain_gangguan) ? $lain_gangguan : '' ?>
                                    </td>
                                    <td style="width: 52%; vertical-align: top; border: none; padding: 0;">
                                        <?= render_box(in_array('Gangguan Menelan', $gangguan_list)) ?> Gangguan Menelan<br>
                                        <?= render_box(in_array('Konstipasi', $gangguan_list)) ?> Konstipasi<br>
                                        <?= render_box(in_array('Gangguan Mengunyah', $gangguan_list)) ?> Gangguan Mengunyah
                                    </td>
                                </tr>
                            </table>
                        </td>

                        <!-- Col 3: Cara Pemberian Makanan -->
                        <td style="width: 28%; vertical-align: top; border: none; padding: 3px 5px;">
                            <div style="margin-bottom: 2px;">Cara pemberian makanan :</div>
                            <div style="padding-left: 5px;">
                                <?= render_box(in_array('Oral', $pemberian_list)) ?> Oral<br>
                                <?= render_box(in_array('NGT', $pemberian_list)) ?> NGT<br>
                                <?= render_box(in_array('OGT', $pemberian_list)) ?> OGT<br>
                                <?= render_box(!empty($lain_pemberian) || in_array('Lain-lain', $pemberian_list)) ?> Lain – lain : <?= !empty($lain_pemberian) ? $lain_pemberian : '' ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ROW 7: DIETARY & ALERGI MAKANAN -->
        <?php
            $alergi = isset($params->data_gizi->dietary->alergi) ? $params->data_gizi->dietary->alergi : (object)[];
            
            $check_alergi = function($item_key, $status) use ($alergi) {
                if (!isset($alergi->$item_key)) return false;
                $val = strtolower($alergi->$item_key);
                if ($status === 'Ya') return ($val === 'ya' || $val === 'true' || $val === '1');
                if ($status === 'Tidak') return ($val === 'tidak' || $val === 'false' || $val === '0');
                return false;
            };
        ?>
        <tr>
            <td colspan="2" style="padding: 2px 5px;">
                <div class="font-bold" style="margin-bottom: 2px;">Dietary</div>
                <table style="width: 100%; border: none; border-collapse: collapse;">
                    <tr style="vertical-align: middle;">
                        <!-- Header Kiri -->
                        <td style="width: 38%; border: none; font-weight: bold; padding: 1px 0; vertical-align: middle;">Alergi Makanan :</td>
                        <td style="width: 30px; border: none; text-align: center; padding: 1px 0; vertical-align: middle;">Ya</td>
                        <td style="width: 35px; border: none; text-align: center; padding: 1px 0; vertical-align: middle;">Tidak</td>
                        <!-- Spacer -->
                        <td style="width: 4%; border: none; padding: 0;"></td>
                        <!-- Header Kanan -->
                        <td style="width: 38%; border: none; padding: 1px 0; vertical-align: middle;">&nbsp;</td>
                        <td style="width: 30px; border: none; text-align: center; padding: 1px 0; vertical-align: middle;">Ya</td>
                        <td style="width: 35px; border: none; text-align: center; padding: 1px 0; vertical-align: middle;">Tidak</td>
                    </tr>
                    <tr style="vertical-align: middle;">
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Telur</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('telur', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('telur', 'Tidak')) ?></td>
                        <td style="border: none; padding: 0;"></td>
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Gluten/gandum</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('gluten', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('gluten', 'Tidak')) ?></td>
                    </tr>
                    <tr style="vertical-align: middle;">
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Ikan</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('ikan', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('ikan', 'Tidak')) ?></td>
                        <td style="border: none; padding: 0;"></td>
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Kacang kedelai/ tanah</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('kacang', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('kacang', 'Tidak')) ?></td>
                    </tr>
                    <tr style="vertical-align: middle;">
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Udang</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('udang', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('udang', 'Tidak')) ?></td>
                        <td style="border: none; padding: 0;"></td>
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Susu sapi & produk olahannya</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('susu', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('susu', 'Tidak')) ?></td>
                    </tr>
                    <tr style="vertical-align: middle;">
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Ayam</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('ayam', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('ayam', 'Tidak')) ?></td>
                        <td style="border: none; padding: 0;"></td>
                        <td style="border: none; padding: 1px 0; vertical-align: middle;">&bull; &nbsp;Hazelnut/almond</td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('hazelnut', 'Ya')) ?></td>
                        <td style="border: none; text-align: center; padding: 1px 0; vertical-align: middle;"><?= render_box($check_alergi('hazelnut', 'Tidak')) ?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- ROW 8: POLA MAKAN -->
        <tr>
            <td colspan="2" style="padding: 3px 5px; vertical-align: top; height: 45px;">
                <div style="margin-bottom: 2px;">Pola Makan</div>
                <div>
                    <?= isset($params->data_gizi->dietary->pola_makan) && !empty($params->data_gizi->dietary->pola_makan) ? nl2br(htmlspecialchars($params->data_gizi->dietary->pola_makan)) : '' ?>
                </div>
            </td>
        </tr>

        <!-- ROW 9: RIWAYAT ASUPAN MAKANAN -->
        <tr>
            <td colspan="2" style="padding: 0;">
                <div style="border-bottom: 1px solid black; padding: 2px 5px;">Riwayat Asupan Makanan</div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="width: 25%; border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px 4px; font-weight: normal; text-align: center;">Zat Gizi</th>
                            <th style="width: 25%; border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px 4px; font-weight: normal; text-align: center;">Kecukupan</th>
                            <th style="width: 25%; border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px 4px; font-weight: normal; text-align: center;">Kebutuhan</th>
                            <th style="width: 25%; border-bottom: 1px solid black; padding: 2px 4px; font-weight: normal; text-align: center;">% Kecukupan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px 4px; text-align: center;">Energi</td>
                            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px 4px; text-align: center;"><?= isset($params->data_gizi->dietary->asupan->energi->kecukupan) ? $params->data_gizi->dietary->asupan->energi->kecukupan : '' ?></td>
                            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding: 2px 4px; text-align: center;"><?= isset($params->data_gizi->dietary->asupan->energi->kebutuhan) ? $params->data_gizi->dietary->asupan->energi->kebutuhan : '' ?></td>
                            <td style="border-bottom: 1px solid black; padding: 2px 4px; text-align: center;"><?= isset($params->data_gizi->dietary->asupan->energi->persen) ? $params->data_gizi->dietary->asupan->energi->persen : '' ?></td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px solid black; padding: 2px 4px; text-align: center;">Protein</td>
                            <td style="border-right: 1px solid black; padding: 2px 4px; text-align: center;"><?= isset($params->data_gizi->dietary->asupan->protein->kecukupan) ? $params->data_gizi->dietary->asupan->protein->kecukupan : '' ?></td>
                            <td style="border-right: 1px solid black; padding: 2px 4px; text-align: center;"><?= isset($params->data_gizi->dietary->asupan->protein->kebutuhan) ? $params->data_gizi->dietary->asupan->protein->kebutuhan : '' ?></td>
                            <td style="padding: 2px 4px; text-align: center;"><?= isset($params->data_gizi->dietary->asupan->protein->persen) ? $params->data_gizi->dietary->asupan->protein->persen : '' ?></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>


    <!-- ========================================== -->
    <!-- HALAMAN 2 (PAGE BREAK & REPEAT KOP SURAT)  -->
    <!-- ========================================== -->

    <div class="page-break"></div>

    <!-- KOP RUMAH SAKIT HALAMAN 2 -->
    <table border="0" width="100%" style="border-collapse: collapse; margin-bottom: 10px;">
        <tr>
            <td style="width: 55%; vertical-align: middle; text-align: left;">
                <table border="0" style="border-collapse: collapse;">
                    <tr>
                        <td style="width: 80px; text-align: center; vertical-align: middle;">
                            <img src="<?= $base_url . '/images/rs/LogoRs.png' ?>" style="width:70px; height:auto;" />
                        </td>
                        <td style="vertical-align: middle; padding-left: 10px;">
                            <span style="font-weight: bold; font-size: 18px; line-height: 1.2;">
                                <?= isset($static_label->hospital_name) ? $static_label->hospital_name : '' ?><br>
                            </span>
                            <span style="font-weight: bold; font-size: 18px; line-height: 1.2;">
                                <?= isset($static_label->hospital_city) ? $static_label->hospital_city : '' ?><br>
                            </span>
                            <span style="font-size: 14px;">
                                <?= isset($static_label->hospital_address) ? $static_label->hospital_address : '' ?><br>
                            </span>
                            <span style="font-weight: bold; font-size: 18px; line-height: 1.2;">
                                <?= isset($static_label->hospital_regency) ? $static_label->hospital_regency : '' ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>

            <td style="width: 45%; vertical-align: top;">
                <table style="border:1px solid black; border-collapse:collapse; width:100%; font-size:10pt;">
                    <tr>
                        <td style="padding:1px 4px; width:30%; vertical-align: top;">No. RM</td>
                        <td style="padding:1px 4px; width:2%; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; width:68%; vertical-align: top;">
                            <?= isset($params->pasien->no_rm) ? $params->pasien->no_rm : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px; vertical-align: top;">Nama</td>
                        <td style="padding:1px 4px; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; vertical-align: top;">
                            <?= isset($params->pasien->nama) ? $params->pasien->nama : '' ?>
                            <?php
                            if ($kelamin == 'L' || $kelamin == 'Laki-laki') {
                                echo ' (L)';
                            } elseif ($kelamin == 'P' || $kelamin == 'Perempuan') {
                                echo ' (P)';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px; vertical-align: top;">Tanggal Lahir</td>
                        <td style="padding:1px 4px; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; vertical-align: top;">
                            <?= isset($params->pasien->tanggal_lahir) ? (function_exists('tgl_indo') ? tgl_indo($params->pasien->tanggal_lahir) : $params->pasien->tanggal_lahir) : '' ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:1px 4px; vertical-align: top;">NIK</td>
                        <td style="padding:1px 4px; vertical-align: top;">:</td>
                        <td style="padding:1px 4px; vertical-align: top;">
                            <?= isset($params->pasien->no_identitas) && !empty($params->pasien->no_identitas) ? $params->pasien->no_identitas : (isset($params->pasien->nik) ? $params->pasien->nik : (isset($params->external_link->px_data->no_identitas) ? $params->external_link->px_data->no_identitas : (isset($params->external_link->px_data->nik) ? $params->external_link->px_data->nik : ''))) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- MAIN FORM TABLE HALAMAN 2 -->
    <table class="table-bordered" style="width: 100%;">
        <!-- ROW 1: Riwayat Personal & Riwayat Penyakit Dahulu -->
        <tr>
            <td style="width: 55%; vertical-align: top; height: 160px; padding: 4px 6px;">
                <div class="font-bold" style="margin-bottom: 4px;">Riwayat Personal</div>
                <div>
                    <?php
                        if (isset($params->data_gizi->riwayat_personal->personal) && !empty($params->data_gizi->riwayat_personal->personal)) {
                            echo nl2br(htmlspecialchars($params->data_gizi->riwayat_personal->personal));
                        } elseif (isset($params->riwayat_personal) && !empty($params->riwayat_personal)) {
                            echo nl2br(htmlspecialchars($params->riwayat_personal));
                        }
                    ?>
                </div>
            </td>
            <td style="width: 45%; vertical-align: top; height: 160px; padding: 4px 6px;">
                <div>Riwayat Penyakit Dahulu :</div>
                <div style="margin-top: 4px;">
                    <?php
                        if (isset($params->data_gizi->riwayat_personal->penyakit_dahulu) && !empty($params->data_gizi->riwayat_personal->penyakit_dahulu)) {
                            echo nl2br(htmlspecialchars($params->data_gizi->riwayat_personal->penyakit_dahulu));
                        } elseif (isset($params->riwayat_penyakit_dahulu) && !empty($params->riwayat_penyakit_dahulu)) {
                            echo nl2br(htmlspecialchars($params->riwayat_penyakit_dahulu));
                        }
                    ?>
                </div>
            </td>
        </tr>

        <!-- ROW 2: Header DIAGNOSA GIZI -->
        <tr>
            <td colspan="2" class="text-center font-bold" style="padding: 3px 0;">
                DIAGNOSA GIZI
            </td>
        </tr>

        <!-- ROW 3: Content DIAGNOSA GIZI -->
        <tr>
            <td colspan="2" style="vertical-align: top; height: 180px; padding: 4px 6px;">
                <div>
                    <?php
                        $gizi_freetext = isset($params->diagnosa_gizi_freetext) ? trim($params->diagnosa_gizi_freetext) : (isset($params->data_gizi->diagnosa_gizi) ? trim($params->data_gizi->diagnosa_gizi) : (isset($params->diagnosa_gizi) ? trim($params->diagnosa_gizi) : ''));
                        $gizi_auto = isset($params->diagnosa_gizi_list_autocomplete) ? (array)$params->diagnosa_gizi_list_autocomplete : [];
                        
                        $gizi_lines = [];
                        if (!empty($gizi_freetext)) {
                            $glines = preg_split('/\r\n|\r|\n/', $gizi_freetext);
                            foreach ($glines as $gl) {
                                $gl = trim($gl);
                                if (!empty($gl)) $gizi_lines[] = $gl;
                            }
                        }
                        
                        $has_gizi_num = false;
                        if (!empty($gizi_lines) && preg_match('/^\d+\.\s*/', $gizi_lines[0])) {
                            $has_gizi_num = true;
                        }

                        $all_gizi_output = [];
                        $g_num = 1;
                        foreach ($gizi_lines as $gl) {
                            $all_gizi_output[] = $has_gizi_num ? htmlspecialchars($gl) : ($g_num . '. ' . htmlspecialchars($gl));
                            $g_num++;
                        }
                        foreach ($gizi_auto as $ga) {
                            $ga = (object)$ga;
                            $kode = isset($ga->kode_nama) ? $ga->kode_nama : '';
                            $desk = isset($ga->deskripsi_diet_diagnosa_gizi) ? $ga->deskripsi_diet_diagnosa_gizi : (isset($ga->deskripsi) ? $ga->deskripsi : '');
                            $gtxt = trim($kode . ($desk ? ' - ' . $desk : ''));
                            if (!empty($gtxt)) {
                                $all_gizi_output[] = $g_num . '. ' . htmlspecialchars($gtxt);
                                $g_num++;
                            }
                        }

                        if (!empty($all_gizi_output)) {
                            echo implode('<br>', $all_gizi_output);
                        }
                    ?>
                </div>
            </td>
        </tr>

        <!-- ROW 4: Header INTERVENSI GIZI -->
        <tr>
            <td colspan="2" class="text-center font-bold" style="padding: 3px 0;">
                INTERVENSI GIZI
            </td>
        </tr>

        <!-- ROW 5: Content INTERVENSI GIZI -->
        <tr>
            <td colspan="2" style="vertical-align: top; height: 220px; padding: 4px 6px;">
                <div>
                    <?php
                        if (isset($params->data_gizi->intervensi_gizi) && !empty($params->data_gizi->intervensi_gizi)) {
                            echo nl2br(htmlspecialchars($params->data_gizi->intervensi_gizi));
                        } elseif (isset($params->intervensi_gizi) && !empty($params->intervensi_gizi)) {
                            echo nl2br(htmlspecialchars($params->intervensi_gizi));
                        }
                    ?>
                </div>
            </td>
        </tr>
    </table>

    <!-- TABLE MONITORING DAN EVALUASI -->
    <table class="table-bordered" style="width: 100%; margin-top: -1px;">
        <thead>
            <tr>
                <th colspan="6" class="text-center font-bold" style="padding: 3px 0;">
                    MONITORING DAN EVALUASI
                </th>
            </tr>
            <tr>
                <th style="width: 10%; text-align: center; padding: 3px 4px; font-weight: normal;">Tgl</th>
                <th style="width: 16%; text-align: center; padding: 3px 4px; font-weight: normal;">Antropometri</th>
                <th style="width: 15%; text-align: center; padding: 3px 4px; font-weight: normal;">biokimia</th>
                <th style="width: 18%; text-align: center; padding: 3px 4px; font-weight: normal;">Fisik/clinis</th>
                <th style="width: 16%; text-align: center; padding: 3px 4px; font-weight: normal;" class="italic">dietary</th>
                <th style="width: 25%; text-align: center; padding: 3px 4px; font-weight: normal;">evaluasi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $monitoring = isset($params->data_gizi->monitoring_evaluasi) ? $params->data_gizi->monitoring_evaluasi : (isset($params->data_gizi->monitoring) ? $params->data_gizi->monitoring : (isset($params->monitoring_evaluasi) ? $params->monitoring_evaluasi : []));
            if (!empty($monitoring) && (is_array($monitoring) || is_object($monitoring))):
                foreach ($monitoring as $item): 
                    $item = (object)$item;
                    $fisik_val = isset($item->fisik) ? $item->fisik : (isset($item->fisik_klinis) ? $item->fisik_klinis : '');
                    $tgl_val = '';
                    if (!empty($item->tgl)) {
                        $timestamp = strtotime($item->tgl);
                        $tgl_val = ($timestamp !== false) ? date('d/m/Y', $timestamp) : $item->tgl;
                    }
            ?>
                <tr>
                    <td style="text-align: center; vertical-align: top; padding: 4px; height: 35px;"><?= $tgl_val ?></td>
                    <td style="vertical-align: top; padding: 4px;"><?= isset($item->antropometri) ? nl2br(htmlspecialchars($item->antropometri)) : '' ?></td>
                    <td style="vertical-align: top; padding: 4px;"><?= isset($item->biokimia) ? nl2br(htmlspecialchars($item->biokimia)) : '' ?></td>
                    <td style="vertical-align: top; padding: 4px;"><?= !empty($fisik_val) ? nl2br(htmlspecialchars($fisik_val)) : '' ?></td>
                    <td style="vertical-align: top; padding: 4px;"><?= isset($item->dietary) ? nl2br(htmlspecialchars($item->dietary)) : '' ?></td>
                    <td style="vertical-align: top; padding: 4px;"><?= isset($item->evaluasi) ? nl2br(htmlspecialchars($item->evaluasi)) : '' ?></td>
                </tr>
            <?php 
                endforeach;
            else: 
                for ($i = 0; $i < 3; $i++):
            ?>
                <tr>
                    <td style="height: 50px; padding: 4px;">&nbsp;</td>
                    <td style="padding: 4px;">&nbsp;</td>
                    <td style="padding: 4px;">&nbsp;</td>
                    <td style="padding: 4px;">&nbsp;</td>
                    <td style="padding: 4px;">&nbsp;</td>
                    <td style="padding: 4px;">&nbsp;</td>
                </tr>
            <?php 
                endfor;
            endif; 
            ?>
        </tbody>
    </table>

    <!-- SECTION TANDA TANGAN (DIETISIEN / AHLI GIZI) -->
    <table border="0" style="width: 100%; margin-top: 15px; border-collapse: collapse;">
        <tr>
            <td style="width: 45%;"></td>
            <td style="width: 55%; text-align: center; vertical-align: top; font-size: 11pt;">
                <?= isset($static_label->hospital_city) ? $static_label->hospital_city : '' ?>, <?= isset($params->ttd_data->tanggal) ? (function_exists('tgl_indo') ? tgl_indo($params->ttd_data->tanggal) : $params->ttd_data->tanggal) : '.............................' ?> 
                pukul <?= isset($params->ttd_data->jam) ? $params->ttd_data->jam : '.........' ?> WIB<br>
                Dietisien/Ahli Gizi,<br>
                <div style="height: 60px; text-align: center;">
                    <?php 
                    $p_stroke = isset($params->ttd_data->perawat_stroke) ? $params->ttd_data->perawat_stroke : (isset($params->ttd_data->petugas_stroke) ? $params->ttd_data->petugas_stroke : '');
                    if (!empty($p_stroke)):
                        $img_src = (strpos($p_stroke, 'http') === 0 || strpos($p_stroke, 'data:') === 0) ? $p_stroke : ($base_url . '/' . ltrim($p_stroke, '/'));
                    ?>
                        <img src="<?= $img_src ?>" style="height: 55px; max-width: 140px; width: auto; margin-top: 3px;" />
                    <?php endif; ?>
                </div>
                (<?= (isset($params->ttd_data->perawat) && !empty($params->ttd_data->perawat)) ? $params->ttd_data->perawat : '....................................................' ?>)
            </td>
        </tr>
    </table>
</body>

</html>