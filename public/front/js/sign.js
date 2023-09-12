$(document).ready(function () {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    var canvas = document.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas);
    signaturePad.penColor = "rgb(0, 0, 0)";
    var saveSignature = document.getElementById('saveSign');
    var clearSignature = document.getElementById("clearSignature");
    clearSignature.addEventListener('click', function (e) {
        signaturePad.clear();
    });
    saveSignature.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (!signaturePad.isEmpty()) {
            var myData = $(this);
            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to sing this user agreement!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Sign it!',
                cancelButtonText: 'No, Cancel it!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    myData.attr('disabled', true);
                    var img = signaturePad.toDataURL('image/png');
                    var key = myData.data("key");
                    $.ajax({
                        url: publicPath + "sign",
                        method: "post",
                        data: {
                            "image": img,
                            "key": key,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                $("#modal-sign-contract").modal('hide');
                                swalWithBootstrapButtons.fire(
                                    'Signed!',
                                    'Your agreement has been sign successfully.',
                                    'success'
                                );
                                setTimeout(function () {
                                    window.location.reload();
                                    // window.opener = null;
                                    // window.open('', '_self');
                                    // window.close();
                                    // window.history.go(-1);
                                    // $(document.body).hide()
                                }, 2000);
                            }
                        },
                    });
                } else {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your agreement is not signed :)',
                        'error'
                    );
                    signaturePad.clear();
                    $("#modal-sign-contract").modal('hide');
                }
            });
            return false;
        }
    });
    $(document).on("click", ".clearSignature", function () {
        signaturePad.clear();
    });

    $(document).on("click", ".clearSignature", function () {
        signaturePad.clear();
    });

    // manage jquery click 
    $(document).on("click", ".changeColor", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var color = $(this).data("color");
        signaturePad.penColor = color;
    });
});