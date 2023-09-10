<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Element where PSPDFKit will be mounted. -->
    <div id="pspdfkit" style="height: 100vh"></div>

    <script src="{{ asset('back/assets/libs/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('assets/pspdfkit.js') }}"></script>

    <script>
        PSPDFKit.load({
            autoSaveMode: PSPDFKit.AutoSaveMode.INTELLIGENT,
            container: "#pspdfkit",
            document: "document.pdf",
        })
        .then(function(instance) {
            instance.setViewState(viewState => viewState.set("showToolbar", false));
            const widget1 = new PSPDFKit.Annotations.WidgetAnnotation({
                pageIndex: 0,
                boundingBox: new PSPDFKit.Geometry.Rect({
                    left: 30,
                    top: 675,
                    width: 100,
                    height: 100
                }),
                formFieldName: "My signature form field",
                id: PSPDFKit.generateInstantId(),
            });
            const formField1 = new PSPDFKit.FormFields.SignatureFormField({
                name: "My signature form field",
                annotationIds: PSPDFKit.Immutable.List([widget1.id])
            });

            const widget2 = new PSPDFKit.Annotations.WidgetAnnotation({
                pageIndex: 0,
                boundingBox: new PSPDFKit.Geometry.Rect({
                    left: 230,
                    top: 675,
                    width: 100,
                    height: 100
                }),
                formFieldName: "My signature form field",
                id: PSPDFKit.generateInstantId()
            });
            const formField2 = new PSPDFKit.FormFields.SignatureFormField({
                name: "My signature form field",
                annotationIds: PSPDFKit.Immutable.List([widget2.id])
            });

            const widget3 = new PSPDFKit.Annotations.WidgetAnnotation({
                pageIndex: 0,
                boundingBox: new PSPDFKit.Geometry.Rect({
                    left: 430,
                    top: 675,
                    width: 100,
                    height: 100
                }),
                formFieldName: "My signature form field",
                id: PSPDFKit.generateInstantId()
            });
            const formField3 = new PSPDFKit.FormFields.SignatureFormField({
                name: "My signature form field",
                annotationIds: PSPDFKit.Immutable.List([widget3.id])
            });
            instance.create([widget1, formField1, widget2, formField2,widget3, formField3]);

            // save signature to pdf file
            instance.addEventListener("annotations.change", function() {
                const arrayBuffer = instance.exportPDF({
                            incremental: true
                        });
                const blob = new Blob([arrayBuffer], { type: 'application/pdf' });
                const formData = new FormData();
                formData.append("file", blob);

                $.ajax({
                    data: formData,
                    url: "/upload",
                    type: "POST",
                    dataType: "JSON",
                    enctype: 'multipart/form-data',
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (result) {
                        
                    },
                });
            });

            // attachmentBlob contains a PNG image file
            const imageAttachmentId = instance.createAttachment(attachmentBlob);
            const imageAnnotation = new PSPDFKit.Annotations.ImageAnnotation({
                imageAttachmentId,
                contentType: 'image/png',
                pageIndex: 0,
                boundingBox: new PSPDFKit.Geometry.Rect({
                    width: 100,
                    height: 100,
                    top: 100,
                    left: 100
                })
            });
            const [createdAnnotation] = instance.create(imageAnnotation);
        })
        .catch(function(error) {
            console.error(error.message);
        });
    </script>
</body>

</html>