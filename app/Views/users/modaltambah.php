<!-- Modal -->
<div class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('users/simpan') ?>" class="formsimpan">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Users</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="">User ID</label>
                        <input type="text" name="userid" id="userid" class="form-control" placeholder="Masukan User ID...">
                        <div class="invalid-feedback errorUserID"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Nama</label>
                        <input type="text" name="usernama" id="usernama" class="form-control" placeholder="Masukan User Nama...">
                        <div class="invalid-feedback errorUserNama"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Email</label>
                        <input type="email" name="useremail" id="useremail" class="form-control" placeholder="Masukan User Email...">
                        <div class="invalid-feedback errorUserEmail"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Password</label>
                        <input type="password" name="userpassword" id="userpassword" class="form-control" placeholder="Masukan User Password...">
                        <div class="invalid-feedback errorUserPassword"></div>
                    </div>

                    <div class="form-group">
                        <label for="">User Level</label>
                        <select name="userlevelid" id="userlevelid" class="form-control">
                            <option value="">Pilih Level</option>
                            <option value=""></option>
                            <?php foreach($datalevel as $rowlevel) : ?>
                            <option value="<?= $rowlevel['levelid'] ?>"><?= $rowlevel['levelnama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback errorUserLevelId"></div>
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
        $('#userid').val('');
        $('#usernama').val('');
        $('#useremail').val('');
        $('#userpassword').val('');
        $('#userlevelid').val('');
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

                        if (err.errUserID) {
                            $('#userid').addClass('is-invalid');
                            $('.errorUserID').html(err.errUserID);
                        }

                        if (err.errUserNama) {
                            $('#usernama').addClass('is-invalid');
                            $('.errorUserNama').html(err.errUserNama);
                        }

                        if (err.errUserEmail) {
                            $('#useremail').addClass('is-invalid');
                            $('.errorUserEmail').html(err.errUserEmail);
                        }

                        if (err.errUserPassword) {
                            $('#userpassword').addClass('is-invalid');
                            $('.errorUserPassword').html(err.errUserPassword);
                        }

                        if (err.errUserLevelId) {
                            $('#userlevelid').addClass('is-invalid');
                            $('.errorUserLevelId').html(err.errUserLevelId);
                        }
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.sukses +
                                ", Apakah ingin menambah Users ?",
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