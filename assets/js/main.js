jQuery(document).ready(function ($) {
    $('#modal-preview-certificate').hide()
    $('#popup-modal-create').hide();

    new DataTable('#tableSoldador', {
        responsive: true,
        language: {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "paginate": {
                "first": "Primera",
                "last": "Última",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "emptyTable": "No hay datos disponibles en la tabla",
            "zeroRecords": "No se encontraron registros coincidentes"
        },
        order: [
            [0, 'desc'],
        ]
    });

    $("#dateCourse").datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 1,
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onClose: function (selectedDate) {
            $("#to").datepicker("option", "minDate", selectedDate);
        }
    });

    $("#createSolderForm").validate({
        errorClass: "state-error",
        validClass: "state-success",
        errorElement: "em",
        rules: {
            firstName: {
                required: true
            },
            titleCourse: {
                required: true
            },
            identify: {
                required: true
            },
            nivelCourse: {
                required: true
            },
            hours: {
                required: true
            },
            dateCourse: {
                required: true
            }
        },
        messages: {
            firstName: {
                required: 'Ingresa el nombre completo.'
            },
            titleCourse: {
                required: 'Ingresa el titulo del curso.'
            },
            identify: {
                required: 'Ingresa el documento de identificación.'
            },
            nivelCourse: {
                required: 'Ingresa el nivel del curso'
            },
            hours: {
                required: 'Ingresa las horas'
            },
            dateCourse: {
                required: 'Ingresa la fecha inicio del curso.'
            }
        },

        highlight: function (element, errorClass, validClass) {
            $(element).closest('.field').addClass(errorClass).removeClass(validClass);
        }, // end highlight

        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.field').removeClass(errorClass).addClass(validClass);
        }, // end unhighlight

        errorPlacement: function (error, element) {
            if (element.is(":radio") || element.is(":checkbox")) {
                element.closest('.option-group').after(error);
            } else {
                error.insertAfter(element.parent());
            }
        },
        submitHandler: function (form) {
            let formData = $(form).serialize();
            const action = $('#submitButton').data('action') || 'create';
            if (action === "create") {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'insert_solder_form',
                        form_data: formData
                    },
                    success: function (response) {
                        if (response.success) {
                            var formData = new URLSearchParams(response.data);
                            var formDataObject = {};
                            for (let [key, value] of formData.entries()) {
                                formDataObject[key] = value;
                            }

                            let newRow = `
                        <tr>
                            <td class="text-left"></td>
                            <td class="text-left">${formDataObject?.firstName}</td>
                            <td class="text-left">${formDataObject?.identify}</td>
                            <td class="text-left">${formDataObject?.titleCourse}</td>
                            <td class="text-left">${formDataObject?.nivelCourse}</td>
                            <td class="text-left">${formDataObject?.hours}</td>
                            <td class="text-left">${formDataObject?.dateCourse}</td>
                            <td class="flex">
                                <button type="button" 
                                data-button='{"name_study": "${formDataObject?.firstName}", "document": "${formDataObject?.identify}", "course": "${formDataObject?.titleCourse}", "nivel": "${formDataObject?.nivelCourse}", "hours": "${formDataObject?.hours}", "fecha_registro": "${formDataObject?.dateCourse}"}'
                                class="previewCert cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                                    <svg class="w-7 h-7 relative top-0.5" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" data-name="Layer 1" viewBox="0 0 24 30" x="0px" y="0px">
                                        <path d="M15.93945,2.23242A2.48219,2.48219,0,0,0,14.17139,1.5H6A2.50263,2.50263,0,0,0,3.5,4V20A2.50263,2.50263,0,0,0,6,22.5H18A2.50263,2.50263,0,0,0,20.5,20V7.82812a2.48391,2.48391,0,0,0-.73242-1.76757ZM14.5,2.539a1.49048,1.49048,0,0,1,.73242.40045l3.82813,3.82813A1.50868,1.50868,0,0,1,19.4599,7.5H16A1.50164,1.50164,0,0,1,14.5,6ZM19.5,20A1.50164,1.50164,0,0,1,18,21.5H6A1.50164,1.50164,0,0,1,4.5,20V4A1.50164,1.50164,0,0,1,6,2.5h7.5V6A2.50263,2.50263,0,0,0,16,8.5h3.5ZM16,11.5a.5.5,0,0,1,0,1H8a.5.5,0,0,1,0-1Zm.5,3.5a.49971.49971,0,0,1-.5.5H8a.5.5,0,0,1,0-1h8A.49971.49971,0,0,1,16.5,15Zm0,3a.49971.49971,0,0,1-.5.5H8a.5.5,0,0,1,0-1h8A.49971.49971,0,0,1,16.5,18Z"/>
                                    </svg>
                                </button>
                               
                            </td>
                        </tr>
                   
                    `;
                            $('#tableSoldador tbody').prepend(newRow);
                            $('#popup-modal-create').hide();
                            form.reset();
                        }
                    },
                    error: function (error) {
                        console.error('Error al cargar el formulario:', error);
                    }
                });
            } else {
                const formId = $("#createSolderForm").data('id') || 'default_id';
                formData += `&id=${encodeURIComponent(formId)}`;
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'update_solder_form',
                        form_data: formData
                    },
                    success: function (response) {
                        $('#popup-modal-create').hide();
                        window.location.reload();
                    },
                    error: function (error) {
                        console.error('Error al cargar el formulario:', error);
                    }
                });
            }
            return false;
        }

    })

    $("#createCertificate").click(() => {
        $('#submitButton')
            .text('Crear Certificado')
            .addClass('btn-create')
            .removeClass('btn-modify')
            .data('action', 'create');

        $('#popup-modal-create').show();
    });

    $(document).on("click", "#uploadCertificates", function () {

        $("#modal-upload-excel").show();

        $('input[type=file]').change(function () {
            $smartFileVal = $(this);
            $smartFileVal.next('.gui-input').val($smartFileVal.val());
            let file = event.target.files[0];
            if (!file) {
                console.error("No se ha seleccionado un archivo.");
                return;
            }
            let reader = new FileReader();

            reader.onload = function (e) {
                let registros = [];

                let data = new Uint8Array(e.target.result); // Convierte a formato binario
                let workbook = XLSX.read(data, { type: 'array' });

                let sheetName = workbook.SheetNames[0];
                let sheet = workbook.Sheets[sheetName];

                let jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                for(let i = 0; i < jsonData.length;  i ++ ){
                    if(jsonData[i].length < 6 && i === 0) {
                            console.error("La cantidad de columnas no coinciden con la posicion de inserción");
                            return;
                    }
                    if(i >= 1){
                        registros.push({
                            name: jsonData[i][0],
                            document: jsonData[i][1],
                            course: jsonData[i][2],
                            level_course: jsonData[i][3],
                            hours: jsonData[i][4],
                            date: jsonData[i][5]
                        })
                    }
                }

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'insertar_data_excel_solder',
                        registers: JSON.stringify(registros)
                    },
                    success: function (response) {
                        console.log("Result: ", response);
                        $smartFileVal.next('.gui-input').val("");
                        $("#modal-upload-excel").hide();
                        window.location.reload();
                    },
                    error: function (error) {
                        console.error("Error al insertar:", error);
                    }
                });
            };

            reader.readAsArrayBuffer(file);
        });

    });

    $("#closeUploadExcelCert").click(() => {
        $("#modal-upload-excel").hide();

    })

    $("#closeCreateCertificate").click(() => {
        $('#popup-modal-create').hide();
    });

    $("#closePreviewCert").click(() => {
        $('#modal-preview-certificate').hide()
    });

    let tableSolder = $("#tableSoldador");

    tableSolder.on("click", ".editCert", function () {
        let data = $.parseJSON($(this).attr('data-button'));

        const fechaRegistro = data.fecha_registro || '';

        const fechaFormateada = fechaRegistro
            ? fechaRegistro.split('-').reverse().join('/')
            : '';

        $('#createSolderForm').data('id', data.id || '');
        $('#firstName').val(data.name_study || '');
        $('#identify').val(data.document || '');
        $('#titleCourse').val(data.course || '');
        $('#nivelCourse').val(data.nivel || '');
        $('#hours').val(data.hours || '');
        $('#dateCourse').val(fechaFormateada);

        $('#submitButton')
            .text('Modificar Certificado')
            .addClass('btn-modify')
            .removeClass('btn-create')
            .data('action', 'edit');

        $('#popup-modal-create').show();
    });

    tableSolder.on("click", ".previewCert", function () {
        let data = $.parseJSON($(this).attr('data-button'));
        $('#modal-preview-certificate').show()
        $("#certificate .recipient").html(data.name_study);
        $("#certificate .course").html(data.course);
        $("#certificate .level").html(data.nivel);
        $("#certificate .date").html(data.fecha_registro);
    });

    $('#print-btn').on('click', function () {
        const certificate = document.getElementById('certificate');
        html2canvas(certificate).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');
            printJS({printable: imgData, type: 'image'})
        });
    });

    $(window).on('load', function () {
        $('#loader').fadeOut(2000, function () {
            $(this).remove();
        });
    });

});