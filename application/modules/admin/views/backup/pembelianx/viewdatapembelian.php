<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <?= anchor('admin/pembelian/index', '<i class="fa fa-plus"></i> Tambah Data', array('class' => 'btn btn-primary')) ?>

                </h6>
            </div>
            <div class="card-body">

                <p>
                    <?= $this->session->flashdata('pesan'); ?>
                    <p>
                        <?= form_open('admin/pembelian/data') ?>
                        <div class="row form-group">
                            <div class="col col-md-8">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Cari Data No.Faktur (Nota) atau Tgl.Pembelian (Format:yyyy-mm-dd)"
                                        name="cari" autofocus="autofocus" autocomplete="off"
                                        value="<?= $this->session->userdata('caripembelian') ?>">
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
                                <th>Supplier</th>
                                <th>Jml.Item</th>
                                <th>Total Uang (Rp)</th>
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
                                <td><?= $r['belinota'] ?></td>
                                <td><?= date('d-m-Y', strtotime($r['belitgl'])); ?></td>
                                <td><?= $r['supnm']; ?></td>
                                <td>
                                    <?php
                                            $qdetail = $this->db->get_where('detailpembelian', ['detailbelinota' => $r['belinota']])->result();
                                            $jmlitem = 0;
                                            foreach ($qdetail as $jml) {
                                                $jmlitem = $jmlitem + $jml->detailbeliqty;
                                            }
                                            echo number_format($jmlitem, 0, ",", ".");
                                            ?>
                                </td>
                                <td align="right">
                                    <?php
                                            $totaluang = 0;
                                            foreach ($qdetail as $jml) {
                                                $totaluang = $totaluang + $jml->detailbelisubtotal;
                                            }
                                            echo number_format($totaluang, 0, ",", ".");
                                            ?>
                                </td>
                                <td><?= $r['beliuserinput'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-danger"
                                        onclick="return hapus('<?= $r['belinota'] ?>')">
                                        <i class="fa fa-fw fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-info"
                                        onclick="return edit('<?= sha1($r['belinota']) ?>')">
                                        <i class="fa fa-fw fa-tag"></i>
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
function edit(nota) {
    window.location.href = ("<?= site_url('admin/pembelian/edit/') ?>" + nota);
}

function hapus(nota) {
    Swal.fire({
        title: 'Hapus Transaksi Pembelian?',
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
                url: "./hapuspembelian",
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