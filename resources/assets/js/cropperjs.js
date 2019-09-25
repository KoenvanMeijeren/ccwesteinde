var host = "http://"+window.location.host;

function makeRandomString(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}

window.addEventListener('DOMContentLoaded', function () {
    var thumbnailOutput = document.getElementById('thumbnailOutput');
    var thumbnailInputOutput = document.getElementById('thumbnailInputOutput');
    var thumbnailImage = document.getElementById('thumbnailImage');
    var thumbnailInput = document.getElementById('inputThumbnail');
    var $progress = $('.thumbnailProgress');
    var $progressBar = $('.thumbnail-progress-bar');
    var $alert = $('.thumbnailAlert');
    var $modal = $('.thumbnailModal');
    var cropper;

    $('[data-toggle="tooltip"]').tooltip();

    thumbnailInput.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            thumbnailInput.value = '';
            thumbnailImage.src = url;
            $alert.hide();
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(thumbnailImage, {
            aspectRatio: 37 / 30,
            viewMode: 1,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    document.getElementById('cropThumbnail').addEventListener('click', function () {
        var canvas;

        $modal.modal('hide');

        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 370,
                height: 300,
            });
            thumbnailOutput.src = canvas.toDataURL();
            $progress.show();
            $alert.removeClass('alert-success alert-warning');
            var fileName = makeRandomString(30);
            canvas.toBlob(function (fileName) {
                var formData = new FormData();

                formData.append('thumbnailOutput', fileName);
                $.ajax(host + '/admin/upload', {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    xhr: function () {
                        var xhr = new XMLHttpRequest();

                        xhr.upload.onprogress = function (e) {
                            var percent = '0';
                            var percentage = '0%';

                            if (e.lengthComputable) {
                                percent = Math.round((e.loaded / e.total) * 100);
                                percentage = percent + '%';
                                $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                            }
                        };

                        return xhr;
                    },

                    success: function (data) {
                        thumbnailInputOutput.value = data;
                        $alert.show().addClass('alert-success').text('Succesvol geüpload');
                    },

                    error: function () {
                        $alert.show().addClass('alert-warning').text('Uploaden is mislukt');
                    },

                    complete: function () {
                        $progress.hide();
                    },
                });
            });
        }
    });
});

window.addEventListener('DOMContentLoaded', function () {
    var headerOutput = document.getElementById('headerOutput');
    var headerInputOutput = document.getElementById('headerInputOutput');
    var headerImage = document.getElementById('headerImage');
    var headerInput = document.getElementById('headerInput');
    var $progress = $('.headerProgress');
    var $progressBar = $('.header-progress-bar');
    var $alert = $('.headerAlert');
    var $modal = $('.headerModal');
    var cropper;

    $('[data-toggle="tooltip"]').tooltip();

    headerInput.addEventListener('change', function (e) {
        var files = e.target.files;
        var done = function (url) {
            headerInput.value = '';
            headerImage.src = url;
            $alert.hide();
            $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function (e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(headerImage, {
            aspectRatio: 15 / 4,
            viewMode: 1,
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    document.getElementById('cropHeader').addEventListener('click', function () {
        var initialAvatarURL;
        var canvas;

        $modal.modal('hide');

        if (cropper) {
            canvas = cropper.getCroppedCanvas({
                width: 1500,
                height: 400,
            });
            initialAvatarURL = headerOutput.src;
            headerOutput.src = canvas.toDataURL();
            $progress.show();
            $alert.removeClass('alert-success alert-warning');
            var fileName = makeRandomString(30);
            canvas.toBlob(function (fileName) {
                var formData = new FormData();

                formData.append('headerOutput', fileName);
                $.ajax(host + '/admin/upload', {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    xhr: function () {
                        var xhr = new XMLHttpRequest();

                        xhr.upload.onprogress = function (e) {
                            var percent = '0';
                            var percentage = '0%';

                            if (e.lengthComputable) {
                                percent = Math.round((e.loaded / e.total) * 100);
                                percentage = percent + '%';
                                $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                            }
                        };

                        return xhr;
                    },

                    success: function (data) {
                        headerInputOutput.value = data;
                        $alert.show().addClass('alert-success').text('Succesvol geüpload');
                    },

                    error: function () {
                        headerOutput.src = initialAvatarURL;
                        $alert.show().addClass('alert-warning').text('Uploaden mislukt');
                    },

                    complete: function () {
                        $progress.hide();
                    },
                });
            });
        }
    });
});