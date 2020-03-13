<script src="<?= base_url('assets/js/detailpembelian.js') ?>"></script>
<script>
$(document).on('click', '.btncariproduk', function(e) {
    $.ajax({
        url: './cariproduk',
        success: function(response) {
            $('.viewcariproduk').fadeIn();
            $('.viewcariproduk').html(response);
            $('#modalcariproduk').modal('show');
        }
    });
});
</script>
<div class="col col-md-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                Input Kode Barcode, Qty dan Harga Pembelian Produk
            </h6>
        </div>
        <div class="card-body">

            <?= form_open('admin/pembelian/simpandetailpembelian', ['class' => 'formdetailbeli']) ?>
            <input type="hidden" name="nota" id="nota" value="<?= $nota; ?>">
            <div class="form-group msg" style="display: none; font-size:8pt;">
            </div>
            <div class="form-group">
                <label>Kode Barcode</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg" name="kode" id="kode"
                        placeholder="Input Barcode">
                    <div class="input-group-append">
                        <button class="btn btn-info btncariproduk" type="button">
                            <i class="fa fa-fw fa-search"></i>
                        </button>
                        <div class="viewcariproduk" style="display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Qty</label>
                <input type="number" name="qty" id="qty" class="form-control form-control-sm" value="1"
                    style="text-align: center;">
            </div>
            <div class="form-group">
                <label>Harga Beli (Rp)</label>
                <input type="text" name="hargax" id="hargax" class="form-control form-control-sm text-primary"
                    style="font-weight: bold;text-align: right;" value="0">
                <input type="hidden" name="harga" id="harga" class="form-control form-control-sm">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-success btnsimpan">
                    Simpan Detail
                </button>
            </div>
        </div>

        <?= form_close() ?>
    </div>
</div>
</div>
<div class="col col-md-8">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success">
                Daftar Pembelian Produk Berdasarkan Faktur
            </h6>
        </div>
        <div class="card-body tampildetailpembelian">
            <div class="row">
                <div class="pesandetail table-responsive" style="display: none;"></div>
            </div>

        </div>
    </div>
</div>