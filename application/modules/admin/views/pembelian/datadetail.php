<table class="table table-sm table-bordered">
    <?php
    $total = 0;
    foreach ($datadetail->result_array() as $r) {
        $total = $total + $r['detailbelisubtotal'];
    }
    ?>
    <thead>
        <tr class="bg-success text-white">
            <td align="right" colspan="8" style="font-size: 16pt; font-weight: bold;">
                <?php echo 'Rp. ' . number_format($total, 0, ",", ".") ?>
            </td>
        </tr>
        <tr class="bg-primary text-white">
            <th>No</th>
            <th>Kode Produk</th>
            <th>Nama Produk</th>
            <th>Satuan</th>
            <th>Hrg.Beli (Rp)</th>
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
            <td><?= $r['detailbelikode']; ?></td>
            <td><?= $r['produknm']; ?></td>
            <td><?= $r['satnama']; ?></td>
            <td><?= $r['detailbeliqty']; ?></td>
            <td align="right"><?= number_format($r['detailbeliharga'], 0); ?></td>
            <td align="right"><?= number_format($r['detailbelisubtotal'], 0); ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-circle btn-outline-danger"
                    onclick="hapusitem('<?= $r['detailid'] ?>')">
                    <i class="fa fa-fw fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>