<table class="table table-sm table-bordered">
    <?php
    $total = 0;
    foreach ($datadetail->result_array() as $r) {
        $total = $total + $r['tempsubtotal'];
    }
    ?>
    <thead>
        <tr class="bg-primary text-white">
            <td align="right" colspan="8" style="font-size: 20pt; font-weight: bold;">
                <?php echo 'Total : Rp. ' . number_format($total, 0, ",", ".") ?>
                <input type="hidden" name="totaljual" id="totaljual" value="<?= $total; ?>">
            </td>
        </tr>
        <tr class="bg-success text-white">
            <th>No</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Satuan</th>
            <th>Harga (Rp.)</th>
            <th>Jml</th>
            <th>Sub.Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 0;
        foreach ($datadetail->result_array() as $r) {
            $nomor++;
        ?>
        <tr>
            <td><?= $nomor; ?></td>
            <td><?= $r['tempkode']; ?></td>
            <td><?= $r['produknm']; ?></td>
            <td><?= $r['satnama']; ?></td>
            <td align="right"><?= number_format($r['tempharga'], 0); ?></td>
            <td align="right"><?= $r['tempqty']; ?></td>
            <td align="right"><?= number_format($r['tempsubtotal'], 0); ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-circle btn-outline-danger"
                    onclick="hapusitem('<?= $r['id'] ?>')">
                    <i class="fa fa-fw fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>