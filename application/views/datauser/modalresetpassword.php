<div class="modal fade bd-example-modal-lg" id="modalresetpassword" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password Berhasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <tr>
                        <td style="width: 40%;">ID User</td>
                        <td>:</td>
                        <td>
                            <?= $iduser; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>:</td>
                        <td>
                            <?= $namauser; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Password Baru Anda</td>
                        <td>:</td>
                        <td>
                            <h3><?= $passbaru; ?></h3>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>