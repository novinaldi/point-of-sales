<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Penjualan|Kedai Antsar</title>
</head>

<body>

    <table style="width: 60%; font-size:10pt; font-family:monospace;">
        <tr>
            <td colspan="3" align="left">
                <h4>Kedai Antsar<br>Jl.Simpang 3 Kalumbuak No.17<br>HP.0853-7536-3757 atau 0853-7648-8788</h4>
                <hr>
            </td>
        </tr>
        <tr>
            <td style="width: 5%;">Tgl</td>
            <td style="width: 1%;">:</td>
            <td><?= $tgl; ?></td>
        </tr>
    </table>
    <table style="width: 60%; font-size:10pt; font-family:monospace;" border="0">
        <thead>
            <tr>
                <th align="left" style="width: 3%;">No</th>
                <th align="left" style="width: 25%;">Item</th>
                <th align="left" style="width: 5%;">Qty</th>
                <th align="left" style="width: 7%;">Sub.Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $q = $this->db->query("SELECT detailpenjualan.*,produknm FROM detailpenjualan JOIN stok ON stok.`stokkode`=detkodeproduk
            JOIN produk ON produkid=stok.`stokprodukid` WHERE detjualnota='$nota'");
            $nomor = 0;
            $total = 0;
            foreach ($q->result_array() as $r) {
                $nomor++;
                $total
            ?>
            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $r['produknm']; ?></td>
                <td><?= $r['detqty']; ?></td>
                <td align="right"><?= number_format($r['detsubtotal'], 0, ",", "."); ?></td>
            </tr>
            <?php
            }
            ?>
            <tr>
                <th colspan="3">Total</th>
                <td align="right"><?= $jualtotal; ?></td>
            </tr>
            <tr>
                <th colspan="3">Bayar</th>
                <td align="right"><?= $jualbayar; ?></td>
            </tr>
            <tr>
                <th colspan="3">Sisa</th>
                <td align="right"><?= $jualsisa; ?></td>
            </tr>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="4">
                    ===== Terima kasih =====
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>