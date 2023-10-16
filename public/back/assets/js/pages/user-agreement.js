$(document).ready(function () {
    let CKEDITOR = []
    var userAgreementPath = publicPath + "user-agreement/";
    $(document).on("click", ".addUserAgreement", function (e) {
        e.preventDefault();
        $.ajax({
            url: userAgreementPath + "create",
            method: "post",
            success: function (response) {
                $("#modalUserAgreement").find(".modalTitle").html("Add User Agreement");
                $("#modalUserAgreement").find(".modalBody").html(response.html);
                $("#modalUserAgreement").find(".modalBody").find(".formTemplate").select2();
                $("#modalUserAgreement").find(".modalBody").find(".userSeller").select2({
                    multiple: true,
                    placeholder: "Select User Contact",
                });
                $("#modalUserAgreement").modal("show");
            },
        });
    });
    $(document).on("click", ".saveUserAgreement", function (e) {
                e.preventDefault();
                var myData = $(this);
                myData.attr('disabled', true);
                $("form#user-agreement-create").find("textarea[name='content']").val(CKEDITOR["user-agreement-content"].getData());
                var data = $(this).parents("form").serialize();
                $.ajax({
                    url: userAgreementPath + "save",
                    method: "post",
                    data: data,
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            $("#modalUserAgreement").find("form")[0].reset();
                            $("#modalUserAgreement").modal("hide");
                            location.reload();
                        } else{
                            console.log(response);
                        }
                    },
                    error: function (xhr) {
                        // Handle the error here (e.g., show an error message to the user)
                        console.log("AJAX Request Error: " + xhr.statusText);
                        var errors = xhr.responseJSON.errors;

                        // Handle the errors as needed (e.g., display them to the user)
                        console.log(xhr.responseJSON);
                        var errorMessageContainer = $("#error-messages");
                        errorMessageContainer.empty(); // Clear any previous error messages
            
                        // Iterate through the error messages and add them to the div
                        for (var fieldName in errors) {
                            if (errors.hasOwnProperty(fieldName)) {
                                errorMessageContainer.append('<div>'  + fieldName + ': ' + errors[fieldName] + '</div>');
                            }
                        }

                        var errorMessageContainer = document.getElementById("error-messages");
                        errorMessageContainer.innerHTML = "";
                        var responseData = xhr.responseJSON;
                        for (var key in responseData) {
                            if (responseData.hasOwnProperty(key)) {
                                var errorList = responseData[key];
                                var errorHTML = "";
                        
                                for (var i = 0; i < errorList.length; i++) {
                                    errorHTML +=  errorList[i] +' is required!'+ "<br>";
                                }
                        
                                errorMessageContainer.innerHTML += errorHTML;
                            }
                        }
                       
                    }
                });
            
            
    });

    // $(document).on("click", ".saveUserAgreement", function (e) {
    //     if ($(".user-seller:checked").length === 0) {
    //         alert("Please select at least one User seller!");
    //         // e.preventDefault(); // Prevent form submission
    //     } else{
    //         var selectedCheckboxData = [];
    //         $(".user-seller:checked").each(function () {
    //             selectedCheckboxData.push($(this).val());
    //         });

    //         e.preventDefault();
    //         var myData = $(this);
    //         myData.attr('disabled', true);
    //         $("form#user-agreement-create").find("textarea[name='content']").val(CKEDITOR["user-agreement-content"].getData());
            
    //         var data = $(this).parents("form").serialize();
    //         // console.log(data);
    //         $.ajax({
    //             url: userAgreementPath + "save",
    //             method: "post",
    //             data: data,
    //             success: function (response) {
    //                 if (response.success) {
    //                     $("#modalUserAgreement").find("form")[0].reset();
    //                     $("#modalUserAgreement").modal("hide");
    //                     // location.reload();
    //                 }
    //             },
    //         });
    //     }

    // });

    $(document).on("click", ".editUserAgreement", function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        //var id = $(this).attr('data-id')
        $.ajax({
            url: userAgreementPath + id + "/edit",
            method: "post",
            success: function (response) {
                $("#modalUserAgreement").find(".modalTitle").html("Update User Agreement");
                $("#modalUserAgreement").find(".modalBody").html(response.html);
                $("#modalUserAgreement").find(".modalBody").find(".formTemplate").select2();
                $("#modalUserAgreement").find(".modalBody").find(".userSeller").select2({
                    multiple: true,
                    placeholder: "Select User Contact",
                }).val(response.userSeller).trigger('change');
                ClassicEditor.create(document.querySelector('#user-agreement-content'))
                    .then(editor => {
                        CKEDITOR["user-agreement-content"] = editor;
                    });
                $("#modalUserAgreement").modal("show");
            },
        });
    });
    $(document).on("click", ".updateUserAgreement", function (e) {
        e.preventDefault();
        var myData = $(this);
        myData.attr('disabled', true);
        $("form#user-agreement-edit").find("textarea[name='content']").val(CKEDITOR["user-agreement-content"].getData());
        var data = $(this).parents("form").serialize();
        var id = $(this).data('id');
        $.ajax({
            url: userAgreementPath + id + "/update",
            method: "post",
            data: data,
            success: function (response) {
                if (response.success) {
                    $("#modalUserAgreement").find("form")[0].reset();
                    $("#modalUserAgreement").modal("hide");
                    location.reload();
                }
            },
        });
    });
    $(document).on("click", ".deleteUserAgreement", function (e) {
        var id = $(this).attr('data-id'); //sachin
        $("#deleteUserAgreement").modal("show");//sachin
        var path = userAgreementPath + id + "/delete";//sachin
        $("#deleteUserAgreement").find('form').attr('action', path);//sachin
        $("#deleteUserAgreement").find("#deleteUserAgreementid").val(id);//sachin
        // var id = $(this).data("id");
        $.ajax({
            url: userAgreementPath + id + "/delete",
            method: "post",
            data: data,
            success: function (response) {
                location.reload();
            },
        });
    });
    $(document).on("change", ".formTemplate", function (e) {
        e.preventDefault();
        var templateId = $(this).val();
        if (templateId > 0) {
            // check if ckeditor is already created
            if (CKEDITOR["user-agreement-content"]) {
                CKEDITOR["user-agreement-content"].destroy();
            }
            $.ajax({
                url: userAgreementPath + templateId + "/getTemplateData",
                type: 'post',
                dataType: 'json',
                success: function (response) {
                    $("#user-agreement-content").html();
                    if (response.success) {
                        $("#user-agreement-content").html(response.content);
                        ClassicEditor.create(document.querySelector('#user-agreement-content'))
                            .then(editor => {
                                CKEDITOR["user-agreement-content"] = editor;
                            });
                    }
                },
            });
        }
    });
});