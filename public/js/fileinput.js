$(document).ready(function() {
    $(document).on('change', '.file-upload input[type="file"]', function() {
        var filename = $(this).val();
        if (/^\s*$/.test(filename)) {
            $(this).parents(".file-upload").find(".file-select-name").text("No file chosen...");
        } else {
            $(this).parents(".file-upload").find(".file-select-name").text(filename.substring(filename.lastIndexOf("\\") + 1, filename.length));
        }

        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function() { // set image data as background of div
                // alert(uploadFile.closest(".file-upload").find('.imagePreview').length);
                uploadFile.closest(".file-upload").find('.imagePreview').css("background-image", "url(" + this.result + ")");
            }
        }
    });
    $(document).on('click', '.file-remove', function(e) {
        e.preventDefault();
        $(this).closest('.file-upload').remove();
        return false;
    });
    $(document).on('click', '.file-add', function(e) {
        e.preventDefault();
        var attch = $('#attachParam').val();
        if (attch == 'ON') {
            var rqd = 'required';
        } else {
            var rqd = '';
        }
        $(".upload-card").append('<div class="file-upload">' +
            '<div class="file-select">' +
            '<div class="imagePreview mb-1 img-thumbnail"></div>' +

            '<div class="file-select-name text-dark">Dokumen PO</div>' +
            '<input type="file" id="imagePo" name="imagePo[]" class="profileimg imagePo"  accept="image/*;capture=camera">' +
            '</div>' +
            '<button class="btn btn-danger btn-sm file-remove"><i class="fas fa-trash"></i></button>' +
            '</div>');
        return false;

    });

    $(document).on('click', '.file-add-noOrder', function(e) {
        e.preventDefault();
        var attch = $('#attachParamNoOrder').val();
        if (attch == 'ON') {
            var rqd = 'required';
        } else {
            var rqd = '';
        }
        $(".upload-card-no-order").append('<div class="file-upload-no-order file-upload">' +
            '<div class="file-select">' +
            '<div class="imagePreview mb-1 img-thumbnail"></div>' +

            '<div class="file-select-name text-dark">Foto Keterangan<br> No-Order</div>' +
            '<input type="file" id="imageNoOdr" name="imageNoOdr[]" class="imageNoOdr profileimg"  accept="image/*;capture=camera">' +
            '</div>' +
            '<button class="btn btn-danger btn-sm file-remove"><i class="fas fa-trash"></i></button>' +
            '</div>');
        return false;

    });
});