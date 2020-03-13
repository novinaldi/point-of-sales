<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Penjualan</title>
    <style>
    @page print {
        margin: 0;
        padding: 0;
    }

    body {
        margin: 0;
        font-family: 'Courier New', Courier, monospace;
    }
    </style>
    <script>
    function tutup() {
        if (event.keyCode == 27) {
            event.preventDefault();
            window.close();
        }
    }
    </script>
</head>

<body onload="window.print();" onkeydown="tutup();">
    <table align="center" style="font-size: 7pt; width: 100%;">
        <tr>
            <td>
                <table align="center" style="font-size: 7pt; width: 100%;">
                    <tr>
                        <td colspan="3" align="center" style="font-weight: bold;">
                            Kedai Antsar<br>Jl.Simpang 3 Kalumbuak No.17<br>HP.0853-7536-3757 / 0853-7648-8788</Kedai>
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center">
                            <?= $tgl; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table align="left" style="font-size: 7pt; width: 100%;">
                    <tr>
                        <td align="left">Item</td>
                        <td align="center">Qty</td>
                        <td align="right">Harga</td>
                        <td align="right">Sub.Total</td>
                    </tr>
                    <?php
                    $totaljual = 0;
                    foreach ($datadetail as $r) {
                        $totaljual += $r->subtotal;
                    ?>
                    <tr>
                        <td align="left"><?= $r->produknm ?></td>
                        <td align="center"><?= $r->qty . '&nbsp;' . $r->satnama ?></td>
                        <td align="right"><?= number_format($r->harga, 0); ?></td>
                        <td align="right"><?= number_format($r->subtotal, 0); ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <td align="right" colspan="3">Total</td>
                        <td align="right"><?= number_format($totaljual, 0, ",", "."); ?></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3">Diskon</td>
                        <td align="right"><?= $jualdiskon; ?></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3">Bayar</td>
                        <td align="right"><?= $jualbayar; ?></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3">Sisa</td>
                        <td align="right"><?= $jualsisa; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <hr>
                <br>
                <span style="font-style: italic;">Terima Kasih</span>
            </td>
        </tr>
    </table>



</html>