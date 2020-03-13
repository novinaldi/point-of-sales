<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $judul; ?>|Kedai Antsar</title>
</head>

<body>
    <?php $r = $data->row_array(); ?>
    <table style="width: 60%; font-size:10pt; font-family:monospace;">
        <tr>
            <td colspan="3" align="left">
                <h4>Kedai Antsar<br>Jl.Simpang 3 Kalumbuak No.17<br>HP.0853-7536-3757 atau 0853-7648-8788</h4>
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                Periode : <?= $awal . ' s.d ' . $akhir; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center" style="font-weight: bold;">
                Kategori : <?= $r['katnama']; ?>
            </td>
        </tr>
    </table>
    <table style="width: 60%; font-size:10pt; font-family:monospace;" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Qty</th>
                <th>Harga(Rp)</th>
                <th>Sub Total(Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 0;
            $total = 0;
            $totqty = 0;
            foreach ($data->result_array() as $x) {
                $nomor++;
                $total = $total + $x['detsubtotal'];
                $totqty = $totqty + $x['detqty'];
            ?>
            <tr>
                <td><?= $nomor; ?></td>
                <td><?= date('d-m-Y H:i:s', strtotime($x['jualtgl'])); ?></td>
                <td><?= $x['produknm']; ?></td>
                <td><?= $x['katnama']; ?></td>
                <td align="center"><?= $x['detqty']; ?></td>
                <td align="right"><?= number_format($x['detharga'], 0, ",", ".");; ?></td>
                <td align="right"><?= number_format($x['detsubtotal'], 0, ",", ".");; ?></td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">Total Keseluruhan</th>
                <td align="center"><?= $totqty; ?></td>
                <td></td>
                <td align="right"><?= number_format($total, 0, ",", ".");; ?></td>
            </tr>
        </tfoot>
    </table>
</body>