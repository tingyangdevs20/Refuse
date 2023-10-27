$(document).ready(function () {
    let CKEDITOR = []
    var userAgreementPath = publicPath + "user-agreement/";
    $(document).on("click", ".addUserAgreement", function (e) {
        // e.preventDefault();
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
                // e.preventDefault();
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
                        var errorMessageContainer = $("#error-messages");
                        errorMessageContainer.empty(); // Clear any previous error messages
                    
                        if (errors) {
                            // Scenario 1: Named errors
                            for (var fieldName in errors) {
                                if (errors.hasOwnProperty(fieldName)) { 
                                    var errorValues = errors[fieldName];
                                    if (Array.isArray(errorValues)) {
                                        console.log(errors[fieldName]);
                                        if(errors[fieldName].length > 1){
                                            errors[fieldName].forEach(element => {
                                                errorMessageContainer.append('<div> <i class="fa fa-info"></i> '+ fieldName + ' : ' + element + ' Value is not found in the contact record!</div><br>');
                                            }); 
                                        } else{
                                            if(errorValues[0] === 'This field is required!' || errorValues[0] === 'The seller name field is required.'){
                                                errorMessageContainer.append('<div> <i class="fa fa-info"></i> '+ fieldName + ' : ' + errorValues + '</div><br>');
                                                
                                            } else {
                                                
                                                errorMessageContainer.append('<div> <i class="fa fa-info"></i> '+ fieldName + ' : ' + errorValues + ' Value is not found in the contact record!</div><br>');
                                            }
                                        }
                                        // If there are multiple error values, join them into a single line
                                        // var errorMessage = fieldName + ': ' + errorValues.join(', ');
                                    } else {
                                        errorMessageContainer.append('<div> <i class="fa fa-info"></i> ' + fieldName + ' : ' + errorValues + '</div>');
                                    }
                                }
                            }
                        } else {
                            // Scenario 2: Missing field error
                            var errorList = xhr.responseJSON;
                            var errorHTML = "";
                            for (var i = 0; i < errorList.length; i++) {
                                errorHTML += errorList[i] + ' is required!' + "<br>";
                            }
                            errorMessageContainer.append('<div>' + errorHTML + '</div>');
                        }
                        errorMessageContainer.show();
                    }
                    
                });
        });

        $(document).on("click", ".savePdf", function (e) {
                // e.preventDefault();
                var myData = $(this);
                // console.log(myData);
                myData.attr('disabled', true);
                $("form#user-agreement-create").find("textarea[name='content']").val(CKEDITOR["user-agreement-content"].getData());
                var data = $(this).parents("form").serialize();
                $.ajax({
                    url: userAgreementPath + "pdf",
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
                        var errorMessageContainer = $("#error-messages");
                        errorMessageContainer.empty(); // Clear any previous error messages
                    
                        if (errors) {
                            // Scenario 1: Named errors
                            for (var fieldName in errors) {
                                if (errors.hasOwnProperty(fieldName)) { 
                                    var errorValues = errors[fieldName];
                                    if (Array.isArray(errorValues)) {
                                        console.log(errors[fieldName]);
                                        if(errors[fieldName].length > 1){
                                            errors[fieldName].forEach(element => {
                                                errorMessageContainer.append('<div> <i class="fa fa-info"></i> '+ fieldName + ' : ' + element + ' Value is not found in the contact record!</div><br>');
                                            }); 
                                        } else{
                                            if(errorValues[0] === 'This field is required!' || errorValues[0] === 'The seller name field is required.'){
                                                errorMessageContainer.append('<div> <i class="fa fa-info"></i> '+ fieldName + ' : ' + errorValues + '</div><br>');
                                                
                                            } else {
                                                
                                                errorMessageContainer.append('<div> <i class="fa fa-info"></i> '+ fieldName + ' : ' + errorValues + ' Value is not found in the contact record!</div><br>');
                                            }
                                        }
                                        // If there are multiple error values, join them into a single line
                                        // var errorMessage = fieldName + ': ' + errorValues.join(', ');
                                    } else {
                                        errorMessageContainer.append('<div> <i class="fa fa-info"></i> ' + fieldName + ' : ' + errorValues + '</div>');
                                    }
                                }
                            }
                        } else {
                            // Scenario 2: Missing field error
                            var errorList = xhr.responseJSON;
                            var errorHTML = "";
                            for (var i = 0; i < errorList.length; i++) {
                                errorHTML += errorList[i] + ' is required!' + "<br>";
                            }
                            errorMessageContainer.append('<div>' + errorHTML + '</div>');
                        }
                        errorMessageContainer.show();
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
        // e.preventDefault();
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

    $(document).on("click", ".modalSellersList", function (e) {
        var data = $(this).attr('data-id'); //sachin
        $.ajax({
            url: userAgreementPath + "signers",
            method: "GET",
            data: {data },
            success: function (response) {
                // location.reload();
                var modalBody = $("#modalBody");
                modalBody.empty();
                // Clear the modal body before adding new content
                // modalBody.empty();
                var index = 1;
                // Loop through the response data and create three columns
                for (var i = 0; i < response.length; i++) {
                    var fullName = response[i].name + ' ' + response[i].last_name;
                    
                    // Create a new div for each concatenated name
                    var nameDiv = $('<div class="col-4">'+ index+'. ' + fullName + '</div>');
                    index++;
                    modalBody.append(nameDiv);
                }
                $("#modalSellersList").modal("show");//sachin
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

    var ckEditorInstance;

$(document).on("click", ".formTemplateCheckbox", function() {
    var selectedCheckboxes = $('.formTemplateCheckbox:checked');
    
    if (selectedCheckboxes.length > 0) { // Check if any checkbox is selected
        var promises = []; // Store promises for each AJAX request
        var contentArray = []; // Store content from each template
        
        selectedCheckboxes.each(function() {
            var templateId = $(this).val();
            
            var ajaxPromise = $.ajax({
                url: userAgreementPath + templateId + "/getTemplateData",
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        contentArray.push(response.content);
                    }
                },
            });
            
            promises.push(ajaxPromise);
        });
        
        $.when.apply($, promises).done(function() {
            // All AJAX requests have completed
            var combinedContent = contentArray.join('<br>'); // Concatenate the content
            
            if (!ckEditorInstance) {
                // Initialize CKEditor if it doesn't exist
                ClassicEditor
                    .create(document.querySelector('#user-agreement-content'))
                    .then(editor => {
                        ckEditorInstance = editor;
                        ckEditorInstance.setData(combinedContent); // Set the content
                    });
            } else {
                // Update the existing CKEditor instance's content
                ckEditorInstance.setData(combinedContent);
            }
        });
    } else {
        // No checkboxes are selected, clear the content
        if (ckEditorInstance) {
            ckEditorInstance.setData('');
        }
    }
});

});