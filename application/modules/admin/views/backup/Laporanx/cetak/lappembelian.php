<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judul; ?>|Kedai Antsar</title>
</head>

<body>

    <table style="width: 60%; font-size:10pt; font-family:monospace;">
        <tr>
            <td colspan="3" align="left">
                <h4>Kedai Antsar<br>Jl.Simpang 3 Kalumbuak No.17<br>HP.0853-7536-3757/0853-7648-8788</h4>
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                Periode : <?= $awal . ' s.d ' . $akhir; ?>
            </td>
        </tr>
    </table>
    <table style="width: 60%; font-size:10pt; font-family:monospace;" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>No.Faktur</th>
                <th>Tgl.Faktur</th>
                <th>Supplier</th>
                <th>Jml.Item</th>
                <th>Total Uang (Rp)</th>
                <th>User Input</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 1;
            $totalitem = 0;
            $totalseluruhuang = 0;
            if ($data->num_rows() > 0) {
                foreach ($data->result_array() as $r) {

            ?>
            <tr>
                <th><?= $nomor ?></th>
                <td><?= $r['belinota'] ?></td>
                <td><?= date('d-m-Y', strtotime($r['belitgl'])); ?></td>
                <td><?= $r['supnm']; ?></td>
                <td align="center">
                    <?php
                            $qdetail = $this->db->get_where('detailpembelian', ['detailbelinota' => $r['belinota']])->result();
                            $jmlitem = 0;
                            foreach ($qdetail as $jml) {
                                $jmlitem = $jmlitem + $jml->detailbeliqty;
                            }
                            echo number_format($jmlitem, 0, ",", ".");
                            $totalitem = $totalitem + $jmlitem;
                            ?>
                </td>
                <td align="right">
                    <?php
                            $totaluang = 0;
                            foreach ($qdetail as $jml) {
                                $totaluang = $totaluang + $jml->detailbelisubtotal;
                            }
                            echo number_format($totaluang, 0, ",", ".");
                            $totalseluruhuang = $totalseluruhuang + $totaluang;
                            ?>
                </td>
                <td><?= $r['beliuserinput'] ?></td>
            </tr>
            <?php
                    $nomor++;
                }
            } else {
                echo '<tr>
                                        <td colspan="7">Data tidak ditemukan</td>
                                    </tr>';
            }

            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Keseluruhan</th>
                <td align="right" style="text-align: center;">
                    <?= number_format($totalitem, 0, ",", "."); ?>
                </td>
                <td align="right" style="text-align: right;">
                    <?= number_format($totalseluruhuang, 0, ",", "."); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</body>