<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                </h6>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('msg'); ?>
                <div class="row">
                    <div class="col col-md-6">
                        <button type="button" class="btn btn-primary btnkosongkandata">
                            Kosongkan Semua Data Yang Ada ?
                        </button>
                        <br>
                        <p>
                            <div class="alert alert-info">
                                Dengan Mengklik tombol diatas, semua data transaksi penjualan dan pembelian akan
                                dikosongkan
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
const kosongData = document.querySelector('.btnkosongkandata');
kosongData.addEventListener('click', function() {
    pesan = confirm('Yakin mengkosongkan data transaksi ?');

    if (pesan) {
        window.location.href = ("<?= site_url('superadmin/utility/kosongkandata') ?>");
    }
});
</script>