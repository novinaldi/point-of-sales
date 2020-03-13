<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $('.datadetail').DataTable();
});

function hapusitem(id) {
    Swal.fire({
        title: 'Hapus Item',
        text: "Yakin ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Batalkan !'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "<?= site_url('admin/penjualan/hapusitem') ?>",
                data: "&id=" + id,
                success: function(response) {
                    if (response == 'sukses') {
                        tampildetaildata();
                    }
                }
            });
        }
    })
}

function tampildetaildata() {
    let nota = $('#nota').val();
    $.ajax({
        type: "post",
        url: "<?= site_url('admin/penjualan/tampildetaildata') ?>",
        data: "&nota=" + nota,
        success: function(response) {
            $('.viewdetaildata').fadeIn();
            $('.viewdetaildata').html(response);
        }
    });
}
</script>
<input type="hidden" name="nota" id="nota" value="<?= $nota; ?>">
<div class="table-responsive">
    <table class="table table-sm table-bordered datadetail">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga (Rp)</th>
                <th>Sub Total (Rp)</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 0;
            $total = 0;
            foreach ($datadetail as $r) {
                $nomor++;
                $total = $total + $r->tempsubtotal;
            ?>
            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $r->tempkode; ?></td>
                <td><?= $r->produknm; ?></td>
                <td><?= $r->tempqty; ?></td>
                <td align="right"><?= number_format($r->tempharga, 0, ",", "."); ?></td>
                <td align="right"><?= number_format($r->tempsubtotal, 0, ",", "."); ?></td>
                <td>
                    <button type="button" class="btn btn-outline-danger" onclick="hapusitem('<?= $r->id ?>')">
                        <i class="fa fa-fw fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <th colspan="5">Total</th>
            <td style="font-size: 16pt; font-weight: bold; text-align: right">
                <?= number_format($total, 0, ",", "."); ?>
                <input type="hidden" name="total" id="total" value="<?= $total ?>">
            </td>
        </tfoot>
    </table>
</div>