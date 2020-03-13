<link href="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('.datadetailpembelian').DataTable();
});

function hapusitemdetail(id) {
    Swal.fire({
        title: 'Hapus Item Produk',
        text: "Yakin di hapus ?",
        icon: 'warning',
        position: 'top',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "<?= site_url('admin/pembelian/hapusitemproduk') ?>",
                data: "&id=" + id,
                dataType: "json",
                success: function(response) {
                    var nota = $('#nota').val();
                    if (response.sukses) {
                        $.ajax({
                            type: "post",
                            url: "<?= site_url('admin/pembelian/tampildetailpembelian') ?>",
                            data: "&nota=" + nota,
                            success: function(response) {
                                $('.tampildetailpembelian').html(response);
                            }
                        });
                    }
                }
            });
        }
    })
}
</script>
<input type="hidden" name="nota" id="nota" value="<?= $nota ?>">
<table class="table table-bordered table-striped table-sm datadetailpembelian">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Produk</th>
            <th>Produk</th>
            <th>Qty</th>
            <th>Harga (Rp)</th>
            <th>Sub.Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 0;
        $total = 0;
        foreach ($tampildatadetail->result_array() as $d) {
            $no++;
            $total = $total + $d['subtotal'];
        ?>
        <tr>
            <td><?= $no; ?></td>
            <td><?= $d['kode']; ?></td>
            <td><?= $d['produk']; ?></td>
            <td><?= $d['qty']; ?></td>
            <td align="right"><?= number_format($d['harga'], 0, ",", "."); ?>
            <td align="right"><?= number_format($d['subtotal'], 0, ",", "."); ?></td>
            <td>
                <button type="button" class="btn btn-outline-danger" onclick="hapusitemdetail('<?= $d['id'] ?>')">
                    <i class="fa fa-fw fa-trash-alt"></i>
                </button>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total Keseluruhan</td>
            <td align="right" style="font-weight: bold; font-size:14pt;"><?= number_format($total, 0, ",", "."); ?></td>
        </tr>
    </tfoot>
</table>