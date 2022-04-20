<!-- Modal -->
<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('levels/simpan') ?>" class="formsimpan">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Levels</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">Level ID</label>
                        <input type="text" name="levelid" id="levelid" class="form-control" placeholder="Masukan Level ID...">
                        <div class="invalid-feedback errorLevelID"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Level Nama</label>
                        <input type="text" name="levelnama" id="levelnama" class="form-control" placeholder="Masukan Level Nama...">
                        <div class="invalid-feedback errorLevelNama"></div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="tombolsimpan" autocomplete="off">Simpan</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Batal</button>
                </div>


            </form>

        </div>
    </div>
</div>

<script>
    function kosong() {
        $('#leveid').val('');
        $('#levelnama').val('');
    }

    $(document).ready(function() {
        $('.formsimpan').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    if (response.error) {
                        let err = response.error;

                        if (err.errLevelID) {
                            $('#levelid').addClass('is-invalid');
                            $('.errorLevelID').html(err.errLevelID);
                        }

                        if (err.errLevelNama) {
                            $('#levelnama').addClass('is-invalid');
                            $('.errorLevelNama').html(err.errLevelNama);
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses +
                                ", Apakah ingin menambah Levels ?",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#modalTambah').modal('show');
                                kosong();
                            } else {
                                window.location.reload();
                            }
                        })
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + thrownError);
                }
            });

            return false;
        });

        $('#batal').click(function(e) {
            e.preventDefault();
            window.location.reload();
        });

    });
</script>