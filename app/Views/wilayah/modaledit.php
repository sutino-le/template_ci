<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">


            <form action="<?= base_url('wilayah/updatedata') ?>" class="formsimpan">

                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="staticBackdropLabel">Input Wilayah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">


                    <input type="hidden" name="id_wilayah" id="id_wilayah" value="<?= $id_wilayah ?>">

                    <div class="form-group">
                        <label for="">Kelurahan</label>
                        <input type="text" name="kelurahan" id="kelurahan" value="<?= $kelurahan ?>" class="form-control" placeholder="Masukan Kelurahan...">
                        <div class="invalid-feedback errorKelurahan"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Kecamatan</label>
                        <input type="text" name="kecamatan" id="kecamatan" value="<?= $kecamatan ?>" class="form-control" placeholder="Masukan Kecamatan...">
                        <div class="invalid-feedback errorKecamatan"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Kota / Kabupaten</label>
                        <input type="text" name="kota_kabupaten" id="kota_kabupaten" value="<?= $kota_kabupaten ?>" class="form-control" placeholder="Masukan Kota / Kabupaten...">
                        <div class="invalid-feedback errorKabupaten"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Propinsi</label>
                        <input type="text" name="propinsi" id="propinsi" value="<?= $propinsi ?>" class="form-control" placeholder="Masukan Propinsi...">
                        <div class="invalid-feedback errorPropinsi"></div>
                    </div>

                    <div class="form-group">
                        <label for="">Kodepos</label>
                        <input type="text" name="kodepos" id="kodepos" value="<?= $kodepos ?>" class="form-control" placeholder="MasukanKodepos...">
                        <div class="invalid-feedback errorKodepos"></div>
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
        $('#kelurahan').val('');
        $('#kecamatan').val('');
        $('#kota_kabupaten').val('');
        $('#propinsi').val('');
        $('#kodepos').val('');
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

                        if (err.errKelurahan) {
                            $('#kelurahan').addClass('is-invalid');
                            $('.errorKelurahan').html(err.errKelurahan);
                        }

                        if (err.errKecamatan) {
                            $('#kecamatan').addClass('is-invalid');
                            $('.errorKecamatan').html(err.errKecamatan);
                        }

                        if (err.errKotaKabupaten) {
                            $('#kota_kabupaten').addClass('is-invalid');
                            $('.errorKotaKabupaten').html(err.errKotaKabupaten);
                        }

                        if (err.errPropinsi) {
                            $('#propinsi').addClass('is-invalid');
                            $('.errorPropinsi').html(err.errPropinsi);
                        }

                        if (err.errKodepos) {
                            $('#kodepos').addClass('is-invalid');
                            $('.errorKodepos').html(err.errKodepos);
                        }

                    }

                    if (response.sukses) {
                        $('#modalEdit').modal('hide');
                        swal.fire(
                            'Berhasil',
                            response.sukses,
                            'success'
                        ).then((result) => {
                            window.location.reload();
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