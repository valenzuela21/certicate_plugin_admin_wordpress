<?php

namespace admin\includes;

use admin\theme\LoaderCertificate;

class SoldadorContentAdmin
{
    public static function extendsContent(): string
    {
        return LoaderCertificate::init() . ModalAdminContent::previewCertificate() . ModalAdminContent::content() . ModalAdminContent::uploadModalExcel();
    }

    public static function content(): string
    {
        global $wpdb;

        $table_name = $wpdb->prefix . 'certificate_solder';
        $results = $wpdb->get_results("SELECT * FROM $table_name Order by id DESC;");

        $content_html = self::extendsContent() . '
<div class="wrap">
<nav class="my-4 bg-white border-gray-200">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <div class="flex items-center space-x-3">
           <a href="./admin.php?page=config_admin_select_soldador" class="cursor-pointer py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100  ">
           <svg class="w-6 h-6 top-1 relative" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 125" style="enable-background:new 0 0 100 100;" xml:space="preserve"><g><path d="M91.7063675,60.0806274c-0.0029297-0.0014648-0.0048828-0.0029907-0.006897-0.0049438l-6.7276077-4.8499756   C85.2331543,53.4855957,85.3648071,51.7337036,85.3648071,50c0-1.7337646-0.1316528-3.4856567-0.3929443-5.225708   l6.7345047-4.8549194c2.9478149-2.1428223,3.7945557-6.1254921,1.9743652-9.255497l-5.0872192-8.831665   c-1.8289795-3.1437988-5.7060623-4.3927631-9.0192337-2.9080811l-7.5615845,3.4119873   c-2.7523804-2.1968994-5.7875977-3.9522095-9.0526733-5.2365742l-0.8388672-8.2584839   c-0.3771973-3.614747-3.3977051-6.3410659-7.0272217-6.3410659H44.9057579c-3.6295166,0-6.6500244,2.7263188-7.0272217,6.3469863   l-0.8388672,8.2525635c-3.2650757,1.2843647-6.300354,3.0396748-9.0526752,5.2365742l-7.5664673-3.4139404   c-3.3093262-1.4832172-7.1853647-0.2337646-9.019289,2.9178467l-5.0773931,8.815979   c-1.8250732,3.1383667-0.977356,7.1210365,1.9772954,9.2682533l6.7266855,4.8500366   C14.7665339,46.5143433,14.634881,48.2662354,14.634881,50c0,1.7337036,0.1316528,3.4855957,0.3929443,5.225708   l-6.7325449,4.8549194c-2.948792,2.142334-3.7965093,6.125-1.9763799,9.2554932l5.0872197,8.8316727   c1.8280649,3.1442871,5.7070332,4.3927612,9.019289,2.90802l7.5615845-3.4119263   c2.7523212,2.1968384,5.7875996,3.9522095,9.0526752,5.2365112l0.8388672,8.2584839   c0.3771973,3.6148071,3.3977051,6.3411255,7.0272217,6.3411255h10.1881752c3.6295166,0,6.6500244-2.7263184,7.0272217-6.3469849   l0.8388672-8.2526245c3.2650757-1.2843018,6.300293-3.0396729,9.0526733-5.2365112l7.5664673,3.4138794   c3.3112793,1.4852295,7.186348,0.234314,9.0192947-2.9178467l5.0773926-8.8159256   C95.5009232,66.2061157,94.6541824,62.2234497,91.7063675,60.0806274z M89.8046951,67.1033936l-5.0774002,8.8159866   c-0.6738281,1.1600342-2.0991211,1.6236572-3.314209,1.0789795l-8.8355713-3.9865799   c-0.7946777-0.3590088-1.7249146-0.2224731-2.3840332,0.3482666c-2.9723511,2.5750198-6.3543091,4.5307083-10.0516357,5.8140945   c-0.821167,0.2853394-1.4036865,1.0210571-1.4910889,1.8869629l-0.9793091,9.6341553   c-0.1385498,1.3290405-1.246521,2.3314209-2.5775146,2.3314209H44.9057579c-1.3309937,0-2.4390259-1.0023804-2.5775146-2.3255005   l-0.9793091-9.6400757c-0.0874634-0.8659058-0.6699219-1.6016235-1.4910889-1.8869629   c-3.6973267-1.2833862-7.0792847-3.2390747-10.0516968-5.8140945c-0.4144897-0.3590698-0.9370728-0.5461426-1.4645405-0.5461426   c-0.3114014,0-0.6247559,0.0648193-0.9194336,0.197876l-8.8306885,3.9846268   c-1.2180176,0.5456543-2.6442881,0.0825195-3.3142099-1.0692139L10.1900558,67.09552   c-0.6669312-1.1472778-0.3516235-2.6074219,0.7279053-3.3912926l7.8562641-5.665287   c0.7052612-0.5087891,1.0510254-1.3795776,0.8879395-2.2337036C19.2947941,53.8779907,19.1082096,51.9247437,19.1082096,50   c0-1.9248047,0.1865845-3.8780518,0.5539551-5.8052979c0.1630859-0.8540649-0.1826782-1.7248535-0.8879395-2.2337036   l-7.8504047-5.6603432c-1.0853882-0.7887573-1.4006958-2.2489624-0.7288208-3.4041138l5.0773935-8.815918   c0.6748047-1.1591187,2.1000986-1.62323,3.3142099-1.0790405l8.8355713,3.9865723   c0.7937012,0.3575439,1.7238789,0.2224731,2.3839741-0.3482056c2.9724121-2.5750732,6.3543701-4.5307617,10.0516968-5.8140869   c0.821167-0.2854004,1.4036255-1.0211182,1.4910889-1.8869629l0.9793091-9.6342182   c0.1384888-1.32898,1.246521-2.3314214,2.5775146-2.3314214h10.1881752c1.3309937,0,2.4389648,1.0024414,2.5775146,2.325562   L58.6507568,18.9389c0.0874023,0.8658447,0.6699219,1.6015625,1.4910889,1.8869629   c3.6973267,1.2833252,7.0792847,3.2390137,10.0516357,5.8140869c0.6591187,0.5706787,1.5893555,0.7057495,2.3840332,0.3482056   l8.8306274-3.9846191c1.2150879-0.5471191,2.6433105-0.0834961,3.314209,1.0692139l5.0872269,8.831665   c0.6669922,1.1472778,0.3516846,2.6074829-0.7268677,3.3912964l-7.8572464,5.665287   c-0.7052612,0.5088501-1.0510254,1.3796387-0.8880005,2.2337036C80.704834,46.1219482,80.8914795,48.0751953,80.8914795,50   c0,1.9247437-0.1866455,3.8779907-0.5540161,5.8052368c-0.1630249,0.854126,0.1827393,1.7249146,0.8880005,2.2337036   l7.8533401,5.6623573C90.1622391,64.4905396,90.4755936,65.9492188,89.8046951,67.1033936z"/><path d="M49.9998169,31.0592022c-10.4445229,0-18.941227,8.496706-18.941227,18.9407978   c0,10.4440308,8.4967041,18.9407349,18.941227,18.9407349c10.4445801,0,18.9412842-8.4967041,18.9412842-18.9407349   C68.9411011,39.5559082,60.444397,31.0592022,49.9998169,31.0592022z M49.9998169,64.4674683   c-7.9780312,0-14.4679604-6.4899292-14.4679604-14.4674683c0-7.9776001,6.4899292-14.4674721,14.4679604-14.4674721   c7.9780884,0,14.4680176,6.489872,14.4680176,14.4674721C64.4678345,57.9775391,57.9779053,64.4674683,49.9998169,64.4674683z"/></g></svg>
           </a>
           Shorcode: <code>[solder_consult]</code>
        </div>
        <div class="flex items-center space-x-6 rtl:space-x-reverse">
            <button type="button" id="uploadCertificates" class="bg-green-700 hover:bg-gray-400 text-gray-800 font-bold py-3 px-4 rounded inline-flex items-center cursor-pointer">
                <svg class="fill-current w-4 h-4 cursor-pointer text-white cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z"/></svg>
            </button>
            <button id="createCertificate" type="button" class="focus:outline-none text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 uppercase cursor-pointer">' . __('Crear Certificado', 'soldador-admin') . '</button>
        </div>
    </div>
</nav>';
        if ($results) {
            $content_html .= '<div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm ">
<table id="tableSoldador" class="min-w-full" style="width:100%">
        <thead>
            <tr>
                <th>' . __('ID', 'soldador-admin') . '</th>
                <th>' . __('Nombre del estudiante', 'soldador-admin') . '</th>
                <th>' . __('Documento de identidad', 'soldador-admin') . '</th>
                <th>' . __('Curso', 'soldador-admin') . '</th>
                <th>' . __('Nivel', 'soldador-admin') . '</th>
                <th>' . __('Horas', 'soldador-admin') . '</th>
                <th>' . __('Fecha Inico', 'soldador-admin') . '</th>
                <th>' . __('Opciones', 'soldador-admin') . '</th>
            </tr>
        </thead>
        <tbody>
        ';
            if ($results) {
                foreach ($results as $row) {
                    $content_html .= '<tr id=' . $row->id . '>
                <td class="text-left">' . $row->id . '</td>
                <td class="text-left">' . $row->name_study . '</td>
                <td class="text-left">' . $row->document . '</td>
                <td class="text-left">' . $row->course . '</td>
                <td class="text-left">' . $row->nivel . '</td>
                <td class="text-left">' . $row->hours . '</td>
                <td class="text-left">' . $row->fecha_registro . '</td>
                <td class="flex">
                <button type="button" 
                  data-button=\'{"id": "' . $row->id . '", "name_study" : "' . $row->name_study . '", "document" : "' . $row->document . '", "course" : "' . $row->course . '", "nivel": "' . $row->nivel . '", "hours": "' . $row->hours . '", "fecha_registro": "' . date('Y-m-d', strtotime($row->fecha_registro)) . '"}\'
                 class="previewCert cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 ">
<svg class="w-7 h-7  relative top-0.5" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" data-name="Layer 1" viewBox="0 0 24 30" x="0px" y="0px"><path d="M15.93945,2.23242A2.48219,2.48219,0,0,0,14.17139,1.5H6A2.50263,2.50263,0,0,0,3.5,4V20A2.50263,2.50263,0,0,0,6,22.5H18A2.50263,2.50263,0,0,0,20.5,20V7.82812a2.48391,2.48391,0,0,0-.73242-1.76757ZM14.5,2.539a1.49048,1.49048,0,0,1,.73242.40045l3.82813,3.82813A1.50868,1.50868,0,0,1,19.4599,7.5H16A1.50164,1.50164,0,0,1,14.5,6ZM19.5,20A1.50164,1.50164,0,0,1,18,21.5H6A1.50164,1.50164,0,0,1,4.5,20V4A1.50164,1.50164,0,0,1,6,2.5h7.5V6A2.50263,2.50263,0,0,0,16,8.5h3.5ZM16,11.5a.5.5,0,0,1,0,1H8a.5.5,0,0,1,0-1Zm.5,3.5a.49971.49971,0,0,1-.5.5H8a.5.5,0,0,1,0-1h8A.49971.49971,0,0,1,16.5,15Zm0,3a.49971.49971,0,0,1-.5.5H8a.5.5,0,0,1,0-1h8A.49971.49971,0,0,1,16.5,18Z"/></svg>
</button>
  <button type="button" 
   data-button=\'{"id": "' . $row->id . '", "name_study" : "' . $row->name_study . '", "document" : "' . $row->document . '", "course" : "' . $row->course . '", "nivel": "' . $row->nivel . '", "hours": "' . $row->hours . '", "fecha_registro": "' . date('Y-m-d', strtotime($row->fecha_registro)) . '"}\'
  class="editCert cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 ">
<svg class="w-7 h-7"  stroke="currentColor" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="-5.0 -10.0 110.0 135.0">
 <path fill="currentColor" d="m70.605 97.5h-59.008c-5.0156 0-9.0977-4.0781-9.0977-9.0977v-59.008c0-5.0156 4.082-9.0977 9.0977-9.0977h25.09c2.2344 0 4.043 1.8086 4.043 4.043s-1.8086 4.043-4.043 4.043h-25.09c-0.55859 0-1.0117 0.45313-1.0117 1.0117v59.012c0 0.55859 0.45312 1.0117 1.0117 1.0117h59.012c0.55859 0 1.0117-0.45312 1.0117-1.0117l-0.003906-25.09c0-2.2344 1.8086-4.043 4.043-4.043s4.043 1.8086 4.043 4.043v25.09c0 5.0156-4.082 9.0938-9.0977 9.0938z"/>
 <path fill="currentColor" d="m96.074 20.316-5.668 5.6758c-1.0664 1.0664-2.7969 1.0703-3.8633 0l-12.531-12.527c-1.0664-1.0664-1.0664-2.7969 0-3.8633l5.6719-5.6797c1.8984-1.8984 4.9844-1.8984 6.8828 0l9.5117 9.5117c1.8984 1.9023 1.8984 4.9844-0.003906 6.8828z"/>
 <path fill="currentColor" d="m82.258 34.145-33.918 33.906c-0.21094 0.21094-0.47656 0.35547-0.76562 0.42188l-18.352 4.1992c-1.1367 0.26172-2.1562-0.75781-1.8945-1.8945l4.1992-18.352c0.066406-0.28906 0.21484-0.55469 0.42188-0.76562l33.918-33.906c1.0664-1.0664 2.7969-1.0664 3.8633 0l12.527 12.527c1.0664 1.0664 1.0664 2.7969 0 3.8633z"/>
</svg>
</button>
</td>
            </tr>';
                }
            } else {
                $content_html .= '<tr colspan="7">
<td>
<p class="text-center p-4">' . __("No hay resultados", "soldador-admin") . '</p>
</td>
</tr>';
            }
        }
        $content_html .= '</tbody>
    </table>
    
</div>
</div>';
        return $content_html;
    }

}