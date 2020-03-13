<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <?= anchor('admin/penjualan/index', '<i class="fa fa-plus"></i> Tambah Data', array('class' => 'btn btn-primary')) ?>
                </h6>
            </div>
            <div class="card-body">

                <p>
                    <?= $this->session->flashdata('pesan'); ?>
                    <p>
                        <?= form_open('admin/penjualan/data') ?>
                        <div class="row form-group">
                            <div class="col col-md-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Cari Data No.Faktur (Nota) atau Tgl.penjualan (Format:yyyy-mm-dd)"
                                        name="cari" autofocus="autofocus" autocomplete="off"
                                        value="<?= $this->session->userdata('caripenjualan') ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit" name="btncari"><i
                                                class="fa fa-fw fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?= form_close() ?>
                    </p>
                    <p>
                        <h6>Total Data : <?= $totaldata; ?></h6>
                    </p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No.Faktur</th>
                                <th>Tgl.Faktur</th>
                                <th>Jml.Item</th>
                                <th>Total Penjualan (Rp)</th>
                                <th>User Input</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor = 1 + $this->uri->segment(4);
                            if ($tampildata->num_rows() > 0) {
                                foreach ($tampildata->result_array() as $r) {

                            ?>
                            <tr>
                                <th><?= $nomor ?></th>
                                <td><?= $r['jualnota'] ?></td>
                                <td><?= date('d-m-Y', strtotime($r['jualtgl'])); ?></td>
                                <td>
                                    <?php
                                            $qdetail = $this->db->get_where('detailpenjualan', ['detjualnota' => $r['jualnota']])->result();
                                            $jmlitem = 0;
                                            foreach ($qdetail as $jml) {
                                                $jmlitem = $jmlitem + $jml->detqty;
                                            }
                                            echo number_format($jmlitem, 0, ",", ".");
                                            ?>
                                </td>
                                <td align="right">
                                    <?php
                                            echo number_format($r['jualtotal'], 0, ",", ".");
                                            ?>
                                </td>
                                <td><?= $r['jualuserinput'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger"
                                        onclick="return hapus('<?= $r['jualnota'] ?>')">
                                        <i class="fa fa-fw fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php
                                    $nomor++;
                                }
                            } else {
                                echo '<tr>
                                        <td colspan="7">Data tidak ditemukan</td>
                                    </tr>';
                            }

                            ?>
                        </tbody>
                    </table>
                </p>
                <p>

                    <?= $this->pagination->create_links(); ?>

                </p>

            </div>
        </div>
    </div>
</div>
<script>
function hapus(nota) {
    Swal.fire({
        title: 'Hapus Transaksi penjualan?',
        text: "Semua detail juga akan terhapus",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapuspenjualan",
                data: "&nota=" + nota,
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: response.sukses,
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.value) {
                                window.location.reload();
                            }
                        })
                    }
                }
            });
        }
    })
}
</script>