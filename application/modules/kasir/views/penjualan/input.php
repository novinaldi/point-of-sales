<script type="text/javascript" src="<?php echo base_url('assets/js/inputpenjualankasir.js') ?>"></script>
<div class="viewcarisatuan" style="display: none;"></div>
<div class="viewcariproduk" style="display: none;"></div>
<div class="viewpembayaran" style="display: none;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Kasir-Penjualan <button type="button" class="btn btn-primary btn-sm btnlihattransaksi"
                        data-toggle="tooltip" data-placement="top" title="Lihat Data Penjualan">
                        <i class="fa fa-fw fa-tasks"></i> Lihat Data Transaksi
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td style="width: 30%;">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="kode" id="kode" autofocus
                                    placeholder="Kode Barcode">
                                <input type="hidden" name="id" id="id">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="button" id="btncariproduk"><i
                                            class="fa fa-fw fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td style="width: 20%;">
                            <button type="button" class="btn btn-success btn-circle" data-toggle="tooltip"
                                data-placement="top" title="Simpan Transaksi (F3)" id="btnsimpantransaksi">
                                <i class="fa fa-fw fa-save"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-circle" data-toggle="tooltip"
                                data-placement="top" title="Batalkan Transaksi (F4)" id="btnbataltransaksi">
                                <i class="fa fa-fw fa-stop-circle"></i>
                            </button>

                        </td>
                        <td align="right">
                            <h5><?= "Faktur : " . $nota; ?></h5>
                            <input type="hidden" name="nota" id="nota" value="<?= $nota; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="left">
                            <table class="table table-sm">
                                <tr>
                                    <td style="text-align: left; width: 25%">Nama Produk</td>
                                    <td style="text-align: left; width: 15%">Satuan</td>
                                    <td style="text-align: left; width: 15%">Harga(Rp)</td>
                                    <td style="text-align: left; width: 10%">Qty</td>
                                    <td style="width: 5%;"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" name="namaproduk" id="namaproduk"
                                            class="form-control form-control-sm" readonly>
                                    </td>
                                    <td>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control form-control-sm" name="satnama"
                                                id="satnama" readonly>
                                            <input type="hidden" name="satid" id="satid">
                                            <input type="hidden" name="satqty" id="satqty">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success btn-sm" type="button"
                                                    id="btncarisatuan"><i class="fa fa-fw fa-search"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="hargax" id="hargax"
                                            class="form-control form-control-sm">
                                        <input type="hidden" name="harga" id="harga">
                                        <script>
                                        var rupiah = document.getElementById('hargax');
                                        rupiah.addEventListener('keyup', function(e) {
                                            // tambahkan 'Rp.' pada saat form di ketik
                                            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

                                            rupiah.value = formatRupiah(this.value, 'Rp. ');

                                            var ganti = rupiah.value.replace(/[^,\d]/g, '').toString();
                                            document.getElementById('harga').value = ganti;
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
                                    </td>
                                    <td>
                                        <input type="number" name="jml" id="jml" class="form-control form-control-sm"
                                            value="1">
                                        <input type="hidden" name="stokproduk" id="stokproduk">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip"
                                            data-placement="top" title="Simpan Produk" id="btnsimpanproduk">
                                            <i class="fa fa-fw fa-plus-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="viewdetaildata" style="display: none;"></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
const lihattransaksipenjualan = document.querySelector(".btnlihattransaksi");

lihattransaksipenjualan.addEventListener('click', function(e) {
    window.location.href = ('./data');
});
</script>