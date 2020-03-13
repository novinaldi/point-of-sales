<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judul; ?>|<?= $this->config->item('namatoko'); ?></title>
</head>

<body onload="window.print();">

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
                                Periode : <?= $awal . ' s.d ' . $akhir; ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="1"
                                style="width: 90%; font-family: 'Courier New', Courier, monospace; font-size:10pt;"
                                align="center">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No.</th>
                                        <th>Faktur</th>
                                        <th>Tgl.Faktur</th>
                                        <th>Supplier</th>
                                        <th>Total Pembelian (Rp)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
                                    foreach ($data as $r) {
                                        $no++;
                                        $this->db->select('detailbelisubtotal');
                                        $q = $this->db->get_where('detailpembelian', ['detailbelinota' => $r->belinota]);
                                        $total = 0;
                                        foreach ($q->result_array() as $x) {
                                            $total = $total + $x['detailbelisubtotal'];
                                        }
                                    ?>
                                    <tr>
                                        <td align="center"><?= $no; ?></td>
                                        <td>&nbsp;<?= $r->belinota; ?></td>
                                        <td>&nbsp;<?= date('d-m-Y', strtotime($r->belitgl)); ?></td>
                                        <td>&nbsp;<?= $r->supnm; ?></td>
                                        <td align="right">
                                            <?= number_format($total, 0, ",", "."); ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </td>
                        <br>
                        <br>
                    </tr>
                    <tr>
                        <td>
                            <table align="center"
                                style="width: 90%; font-family: 'Courier New', Courier, monospace; font-size:10pt;">
                                <tr>
                                    <td style="width: 60%;"></td>
                                    <td>Padang, <?= date('d-m-Y'); ?><br><br><br><br><br>
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