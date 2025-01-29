jQuery(document).ready(function($) {

    let resultGeneral = [];

    $("#container-result").hide();
    $('#result-table-certificado').on("click", ".btn-certificate", function() {
        let data = $.parseJSON($(this).attr('data-button'));
        console.log(data);
        $('#modal-preview-certificate').show();
        $("#certificate .recipient").html(data.name_study);
        $("#certificate .course").html(data.course);
        $("#certificate .level").html(data.nivel);
        $("#certificate .date").html(data.fecha_registro);
    });


    $(".consult-cert").click(function (){
        let firstName = $("[name='firstName']").val();
        let identify = $("[name='identify']").val();

        $.ajax({
            url: ajax_object.ajaxurl,
            type: 'POST',
            data: {
                action: 'consult_solder_form',
                form_data: {firstName, identify}
            },
            success: function(response){
                resultGeneral = [];
                let result = response.data;
                let enable_cert = result.enable_cert;
                let content_html;

                $("#container-result .title").html(result.data[0]?.name_study);
                $("#container-result .sub-title").html("Cc. " + result.data[0]?.document);

                if(result.data.length > 0){
                    resultGeneral.push(result.data);
                    result.data.map(item => {
                        console.log(item);
                        content_html += `
                     <tr>
        <td>${item?.course}</td>
        <td>${item?.nivel}</td>
        <td>${item?.hours}</td>
        <td>${item?.fecha_registro}</td>
        <td>
        ${(enable_cert === 'on')? 
          `<button
            data-button='{"name_study": "${item?.name_study}", "document": "${item.document}", "course": "${item.course}", "nivel": "${item.nivel}", "hours": "${item.hours}", "fecha_registro": "${item.course}"}' 
            class="btn-certificate">
            <svg class="icon-certificate" fill="currentColor" xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 512 640" enable-background="new 0 0 512 512" xml:space="preserve"><g><path d="M467.6,2H44.4C21,2,2,21,2,44.3v261.6c0,23.3,19,42.3,42.3,42.3h198.2v34c0,7.8,6.3,14.1,14.1,14.1h18.5v99.5   c-0.4,9.9,11.7,18.9,22.8,11.1l31.6-24.7l31.6,24.7c10,7.2,22.5,1.2,22.8-11.1v-99.5h18.5c7.8,0,14.1-6.3,14.1-14.1v-34h51.2   c23.3,0,42.3-19,42.3-42.3V44.3C510,21,491,2,467.6,2z M355.6,466.9l-17.5-13.7c-5.1-4-12.3-4-17.4,0l-17.5,13.7v-60.7l16.2,16.2   c6.7,6,14,5.2,20,0l16.2-16.2V466.9z M392.4,329.6c-2.6,2.6-4.1,6.2-4.1,10v28.6h-28.6c-3.7,0-7.3,1.5-10,4.1l-20.2,20.2   l-20.2-20.2c-2.6-2.6-6.2-4.1-10-4.1h-28.6v-28.6c0-3.7-1.5-7.3-4.1-10l-20.2-20.2l20.2-20.2c2.6-2.6,4.1-6.2,4.1-10v-28.6h28.6   c3.7,0,7.3-1.5,10-4.1l20.2-20.2l20.2,20.2c2.6,2.6,6.2,4.1,10,4.1h28.6v28.6c0,3.7,1.5,7.3,4.1,10l20.2,20.2L392.4,329.6z    M481.8,305.9c0,7.8-6.3,14.1-14.1,14.1h-25.8l0.7-0.7c5.5-5.5,5.5-14.4,0-20l-26.1-26.1v-36.9c0-7.8-6.3-14.1-14.1-14.1h-36.9   l-26-26c-5.5-5.5-14.4-5.5-20,0l-26,26h-36.9c-7.8,0-14.1,6.3-14.1,14.1v36.9l-26.1,26.1c-5.5,5.5-5.5,14.4,0,20l0.7,0.7H44.4   c-7.8,0-14.1-6.3-14.1-14.1V44.3c0-7.8,6.3-14.1,14.1-14.1h423.3c7.8,0,14.1,6.3,14.1,14.1V305.9z"/><path d="M432.6,58.4H79.4c-7.8,0-14.1,6.3-14.1,14.1s6.3,14.1,14.1,14.1h353.2c7.8,0,14.1-6.3,14.1-14.1S440.4,58.4,432.6,58.4z"/><path d="M432.6,128.4H79.4c-7.8,0-14.1,6.3-14.1,14.1c0,7.8,6.3,14.1,14.1,14.1h353.2c7.8,0,14.1-6.3,14.1-14.1   C446.7,134.7,440.4,128.4,432.6,128.4z"/><path d="M190.1,207.5H79.4c-7.8,0-14.1,6.3-14.1,14.1c0,7.8,6.3,14.1,14.1,14.1h110.7c7.8,0,14.1-6.3,14.1-14.1   C204.2,213.8,197.9,207.5,190.1,207.5z"/></g></svg>
          </button> `: '' }
        </td>
      </tr> `;
                    });
                }else{
                    content_html += `<tr> <td colspan="5" style="text-align: center"> No hay resultados </td></tr>`;
                }
                $("#container-result").fadeIn(1000);
                $("#resultCertSolder").html(content_html);
            },
            error: function (error) {
                console.error(error);
            }
        })
    });

    $('#downloader').click(function (){

        let workbook = XLSX.utils.book_new();
        let data = [];
        resultGeneral[0].map(item => {
            data.push([item.id, item.name_study, item.document, item.course, item.nivel, item.fecha_registro]);
        });

        let worksheet = XLSX.utils.aoa_to_sheet(data);
        XLSX.utils.book_append_sheet(workbook, worksheet, "certificados");

        workbook.Workbook = workbook.Workbook || {};
        workbook.Workbook.Views = workbook.Workbook.Views || [];
        workbook.Workbook.Views.push({ RTL: false, ReadOnlyRecommended: true });

        XLSX.writeFile(workbook, "certificado.xlsx");

    });


    $("#closePreviewCert").click(() => {
        $('#modal-preview-certificate').hide()
    });

    $('#print-btn').on('click', function () {
        const certificate = document.getElementById('certificate');
        html2canvas(certificate).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');
            printJS({printable: imgData, type: 'image'})
        });
    });

});