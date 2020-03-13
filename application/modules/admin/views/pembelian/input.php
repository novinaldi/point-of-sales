<script type="text/javascript" src="<?php echo base_url('assets/js/inputpembelian.js') ?>"></script>
<div class="viewcarisup" style="display: none;"></div>
<div class="viewcariproduk" style="display: none;"></div>
<div class="viewcarisatuan" style="display: none;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" id="btndatapembelian">
                        <i class="fa fa-fw fa-tasks"></i> Data Semua Pembelian
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td style="text-align: left; width: 25%">Inputkan No.Faktur</td>
                        <td style="text-align: left; width: 25%">Tgl.Faktur</td>
                        <td style="text-align: left; width: 25%">Cari Supplier</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" class="form-control form-control-sm" name="nota" id="nota" autofocus>
                        </td>
                        <td>
                            <input type="date" class="form-control form-control-sm" name="tgl" id="tgl">
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm" name="supnama" id="supnama"
                                    value="-" readonly>
                                <input type="hidden" name="supid" id="supid" value="1">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-sm" type="button" id="btncarisupplier">
                                        <i class="fa fa-fw fa-search"></i></button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-circle btn-sm" id="btnsimpanfaktur"
                                data-toggle="tooltip" data-placement="top" title="Simpan Faktur">
                                <i class="fa fa-fw fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-circle btn-sm" id="btnbatalkantransaksi"
                                data-toggle="tooltip" data-placement="top" title="Batalkan Transaksi">
                                <i class="fa fa-fw fa-ban"></i>
                            </button>
                            <button type="button" class="btn btn-info btn-circle btn-sm" id="btntransaksibaru"
                                data-toggle="tooltip" data-placement="bottom" title="Transaksi Baru ?"
                                onclick="window.location.reload();">
                                <i class="fa fa-fw fa-sync"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <table class="table table-sm">
                    <tr>
                        <td style="text-align: left; width: 20%">Inputkan Kode Produk</td>
                        <td style="text-align: left; width: 25%">Nama Produk</td>
                        <td style="text-align: left; width: 15%">Satuan</td>
                        <td style="text-align: left; width: 15%">Hrg.Jual(Rp)</td>
                        <td style="text-align: left; width: 15%">Hrg.Beli(Rp)</td>
                        <td style="text-align: left; width: 10%">Jml.Masuk</td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm" name="kode" id="kode" autofocus>
                                <input type="hidden" name="id" id="id">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-sm" type="button" id="btncariproduk"><i
                                            class="fa fa-fw fa-search"></i></button>
                                </div>
                            </div>

                        </td>
                        <td>
                            <input type="text" name="namaproduk" id="namaproduk" class="form-control form-control-sm"
                                readonly>
                        </td>
                        <td>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control form-control-sm" name="satnama" id="satnama"
                                    readonly>
                                <input type="hidden" name="satid" id="satid">
                                <input type="hidden" name="satqty" id="satqty">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success btn-sm" type="button" id="btncarisatuan"><i
                                            class="fa fa-fw fa-search"></i></button>
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="hargajualx" id="hargajualx" class="form-control form-control-sm"
                                readonly>
                            <input type="hidden" name="hargajual" id="hargajual">
                        </td>
                        <td>
                            <input type="text" name="hargabelix" id="hargabelix" class="form-control form-control-sm">
                            <input type="hidden" name="hargabeli" id="hargabeli">
                            <script>
                            var rupiah = document.getElementById('hargabelix');
                            rupiah.addEventListener('keyup', function(e) {
                                // tambahkan 'Rp.' pada saat form di ketik
                                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka

                                rupiah.value = formatRupiah(this.value, 'Rp. ');

                                var ganti = rupiah.value.replace(/[^,\d]/g, '').toString();
                                document.getElementById('hargabeli').value = ganti;
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
                            <input type="number" name="jml" id="jml" class="form-control form-control-sm" value="1">
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip"
                                data-placement="top" title="Simpan Data Produk" id="btnsimpanproduk">
                                <i class="fa fa-fw fa-plus-square"></i>
                            </button>
                        </td>
                    </tr>
                </table>

                <div class="viewdetaildata" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>