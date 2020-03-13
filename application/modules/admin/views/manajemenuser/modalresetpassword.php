<div class="modal fade bd-example-modal-lg" id="modalresetpass" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLabel">Reset Password User Berhasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-striped">
                    <tr>
                        <td style="width:25%;">ID User</td>
                        <td>:</td>
                        <td><?= $iduser ?></td>
                    </tr>
                    <tr>
                        <td>Password Baru Anda</td>
                        <td>:</td>
                        <td>
                            <h2><?= $pass; ?></h2>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>