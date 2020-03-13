<link href="<?= base_url('assets/') ?>vendor/select2/select2.min.css" rel="stylesheet" />
<script src="<?= base_url('assets/') ?>vendor/select2/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#kat').select2();
    $('#sat').select2();
});
</script>
<div class="modal fade bd-example-modal-lg" id="modaleditdata" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('admin/produk/updatedata', array('class' => 'formedit')) ?>

            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama produk</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="namaproduk" id="namaproduk" value="<?= $nama ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pilih Kategori</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="kat" id="kat" style="width: 100%;">
                            <?php
                            foreach ($kategori->result_array() as $k) {
                                if ($k['katid'] == $idkat) {

                                    echo '<option value="' . $k['katid'] . '" selected>' . $k['katnama'] . '</option>';
                                } else {
                                    echo '<option value="' . $k['katid'] . '">' . $k['katnama'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pilih Satuan</label>
                    <div class="col-sm-4">
                        <select class="form-control" name="sat" id="sat" style="width: 100%;">
                            <?php
                            foreach ($satuan->result_array() as $s) {

                                if ($s['satid'] == $idsat) {
                                    echo '<option selected value="' . $s['satid'] . '">' . $s['satnama'] . '</option>';
                                } else {
                                    echo '<option value="' . $s['satid'] . '">' . $s['satnama'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pilih Harga</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="harga" value="<?= $harga ?>" id="harga"
                            style="text-align: right;">
                        <input type="hidden" name="hargax" id="hargax" value="<?= $harga ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success btnsimpan">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<script>
var rupiah = document.getElementById('harga');
rupiah.addEventListener('keyup', function(e) {
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

    rupiah.value = formatRupiah(this.value, 'Rp. ');

    var ganti = rupiah.value.replace(/[^,\d]/g, '').toString();
    document.getElementById('hargax').value = ganti;
});

function formatRupiah(angka, prefix) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}
</script>