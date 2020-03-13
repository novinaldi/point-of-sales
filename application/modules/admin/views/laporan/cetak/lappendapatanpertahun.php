<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judul; ?>|Kedai Antsar</title>
</head>

<body onload="window.print();">
    <?php
    $r = $x->row_array();
    $rr = $y->row_array();
    ?>
    <table style="width: 90%; border-collapse: collapse;" border="1" align="center">
        <tr>
            <td>
                <table align="center" style="width: 90%; font-family: 'Courier New', Courier, monospace;">
                    <tr>
                        <td style="text-align: center;">
                            <span
                                style="font-size:16pt; font-weight: bold;"><?= $this->config->item('namatoko'); ?></span>
                            <br>
                            <span style="font-size:12pt;">
                                <?= $this->config->item('alamat'); ?><br>HP.<?= $this->config->item('telp'); ?>
                            </span>
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <span style="font-size:10pt;">
                                Laporan Pendapatan Tahun : <?= $tahun; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="1" align="center"
                                style="width: 90%; font-family: 'Courier New', Courier, monospace; font-size:10pt;">
                                <tr>
                                    <th>Bulan</th>
                                    <th>Total Pembelian</th>
                                    <th>Total Penjualan</th>
                                </tr>
                                <tr>
                                    <td align="center">Januari</td>
                                    <td align="right"><?= number_format($r['jan'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['jan'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Februari</td>
                                    <td align="right"><?= number_format($r['feb'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['feb'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Maret</td>
                                    <td align="right"><?= number_format($r['mar'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['mar'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">April</td>
                                    <td align="right"><?= number_format($r['apr'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['apr'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Mei</td>
                                    <td align="right"><?= number_format($r['mei'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['mei'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Juni</td>
                                    <td align="right"><?= number_format($r['jun'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['jun'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Juli</td>
                                    <td align="right"><?= number_format($r['jul'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['jul'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Agustus</td>
                                    <td align="right"><?= number_format($r['agt'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['agt'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">September</td>
                                    <td align="right"><?= number_format($r['sep'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['sep'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Oktober</td>
                                    <td align="right"><?= number_format($r['okt'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['okt'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">November</td>
                                    <td align="right"><?= number_format($r['nov'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['nov'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center">Desember</td>
                                    <td align="right"><?= number_format($r['des'], 0, ",", "."); ?>&nbsp;</td>
                                    <td align="right"><?= number_format($rr['des'], 0, ",", "."); ?>&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table align="center"
                                style="width: 90%; font-family: 'Courier New', Courier, monospace; font-size:10pt;">
                                <tr>
                                    <td style="width: 70%;"></td>
                                    <td align="right">Padang, <?= date('d-m-Y'); ?><br><br><br><br><br>
                                        <?= '(' . $this->session->userdata('namauser') . ')'; ?>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
</body>