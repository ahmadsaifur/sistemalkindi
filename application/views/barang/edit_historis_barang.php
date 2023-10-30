<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.min.css
" rel="stylesheet">

<h4>Update Historis Barang.</h4>

<form id="formupdate">

    <div class='form-group'>
        <label for="basic-url" class="form-label">Nama Barang</label>
        <div class="input-group">
            <input type="text" required readonly class="form-control" name="nama_barang" value="<?= $obat->nama_barang ?>">
        </div>
    </div>
    <div class='form-group'>
        <label for="basic-url" class="form-label">Jumlah Stok</label>
        <div class="input-group">
            <input type="number" class="form-control" name="jumlah_stok" value="<?= $obat->total_stok ?>">
        </div>
    </div>
    <div class='form-group'>
        <label for="basic-url" class="form-label">Tanggal Masuk</label>
        <div class="input-group">
            <input type="date" class="form-control" id="datepicker" name="tanggal_masuk" value="<?= $obat->tanggal_masuk ?>">
        </div>
    </div>
    <div class='form-group'>
        <button type="submit" value="submit" name="submit">Update</button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.8.0/dist/sweetalert2.all.min.js
"></script>
<script type="text/javascript">
    $('#formupdate').submit(function(e) {
        e.preventDefault()
        var dataForm = $(this).serialize();
        // alert(dataForm);
        var id = <?= $obat->id ?>;
        $.ajax({
            url: "<?= base_url('barang/update_historis_barang') ?>" + '/' + id,
            data: $('#formupdate').serialize(),
            type: 'json',
            method: 'post',
            success: function(data) {
                var result = jQuery.parseJSON(data);
                console.log(result);
                if (result == 'success') {

                    Swal.fire(
                        'Good job!',
                        'Success Update Data!',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Failed!',
                        'Gagal Update Data!',
                        'error'
                    )

                }
            }
        })
        $('#ModalGue').modal('hide');
        $('#my-grid').DataTable().ajax.reload();

        $("#datepicker").datetimepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'YYYY-mm-dd H:i:s',
        });
    })
</script>