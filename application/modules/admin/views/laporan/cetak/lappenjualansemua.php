<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judul; ?>|Kedai Antsar</title>
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
                            <?php
                            foreach ($datakategori->result_array() as $k) {
                                $katid = $k['katid'];
                                $sqldetail = "SELECT detjualtgl,detjualprodukkode,produknm,detjualqty,detjualharga,detjualsubtotal FROM detailpenjualan JOIN produk
                                ON produkkode=detjualprodukkode JOIN kategori ON katid=produk.`produkkatid` WHERE katid= ? AND DATE_FORMAT(detjualtgl,'%Y-%m-%d') BETWEEN ? AND ?";

                                $qdetail = $this->db->query($sqldetail, [$katid, $awal, $akhir])->result();
                            ?>

                            <table align="center"
                                style="width: 90%; font-family: 'Courier New', Courier, monospace; font-size:10pt;">
                                <tr>
                                    <td>
                                        <?php echo 'Kategori : ' . $k['katnama'] ?>
                                    </td>
                                </tr>
                            </table>
                            <table align="center" border="1"
                                style="width: 90%; font-family: 'Courier New', Courier, monospace; font-size:10pt;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Kode Produk</th>
                                        <th>Nama Produk</th>
                                        <th>Qty</th>
                                        <th>Harga(Rp.)</th>
                                        <th>Sub.Total(Rp.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $nomor = 0;
                                        $total = 0;
                                        foreach ($qdetail as $row) {
                                            $nomor++;
                                            $total = $total + $row->detjualsubtotal;
                                        ?>
                                    <tr>
                                        <td align="center"><?= $nomor; ?></td>
                                        <td>&nbsp;<?= date('d-m-Y', strtotime($row->detjualtgl)); ?></td>
                                        <td>&nbsp;<?= $row->detjualprodukkode; ?></td>
                                        <td>&nbsp;<?= $row->produknm; ?></td>
                                        <td align="center">&nbsp;<?= $row->detjualqty; ?></td>
                                        <td align="right">&nbsp;<?= number_format($row->detjualharga, 0, ",", "."); ?>
                                        </td>
                                        <td align="right">
                                            &nbsp;<?= number_format($row->detjualsubtotal, 0, ",", "."); ?></td>
                                    </tr>
                                    <?php
                                        }
                                        ?>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <th colspan="6">Total Uang</th>
                                        <td align="right">
                                            &nbsp;<?= number_format($total, 0, ",", "."); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <?php
                            }
                            ?>
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