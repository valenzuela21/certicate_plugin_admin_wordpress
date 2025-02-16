<?php

namespace admin\includes;

use admin\theme\SolderCertificate;
use Xbox;

class ModalAdminContent
{
    public static function uploadModalExcel(): string {
        return '<div id="modal-upload-excel" 
     style="display: none;"
     tabindex="-1"
     class=" m-auto overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 ">
              <div class="flex items-center justify-center w-full">
                 <div class="relative w-[700px]  max-h-full p-4 mt-14">
        <div class="relative bg-white rounded-lg shadow-sm">
                        <button  type="button"
                            id = "closeUploadExcelCert"
                            class="cursor-pointer absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        </button>
                        <div class="smart-forms smart-container wrap-2">
                         <div class="p-4 md:p-5">
                           	<div class="section">
                                <label class="field prepend-icon file">
                                    <span class="button btn-primary"> Choose File </span>
                                    <input type="file" class="gui-file" name="upload2">
                                    <input type="text" class="gui-input" placeholder="no file selected" readonly>
                                    <span class="field-icon"><i class="fa fa-upload"></i></span>
                                 </label>                    
                            </div>
                        </div>
                        </div>
                    </div>
                 </div>
              </div>
        </div>';
    }

    public static function previewCertificate(): string
    {
        return '<div id="modal-preview-certificate" 
     style="display: none;"
     tabindex="-1"
     class=" m-auto overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 ">
        <div class="flex items-center justify-center w-full">
            <div class="relative w-[700px]  max-h-full p-4 mt-14">
        <div class="relative bg-white rounded-lg shadow-sm ">
            <button type="button"
                    id = "closePreviewCert"
                    class="cursor-pointer absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
            <div class="p-4 md:p-5">
        ' . SolderCertificate::content() . '
        <button id="print-btn" type="button" class="mt-4 cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 w-full">' . __('Imprimir Certificado', '') . '</button>
        </div></div></div>
        </div>
        </div>';
    }

    public static function content(): string
    {

        $xbox_general = Xbox::get('config_admin_select_soldador');
        $groups_cursos = $xbox_general->get_field_value('cursos_title');
        $groups_levels = $xbox_general->get_field_value('levels_title');

        $content_html = '<div id="popup-modal-create" tabindex="-1"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50  justify-center items-center w-full md:inset-0 ">
    <div class="flex items-center justify-center">
    <div class="relative w-xl  max-h-full p-4 mt-14">
        <div class="relative bg-white rounded-lg shadow-sm ">
            <button type="button"
                    id="closeCreateCertificate"
                    class="cursor-pointer absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="popup-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
            <div class="p-4 md:p-5">
                <div class="smart-forms">
                    <form id="createSolderForm" autocomplete="off" >
                        <div class="form-body">
                            <div class="spacer-b30">
                                <div class="tagline"><span>' . __('Información Personal', 'soldador-admin') . ' </span></div><!-- .tagline -->
                            </div>
                            <div class="section">
                                <label for="firstName"  class="field prepend-icon">
                                    <input type="text" name="firstName" id="firstName" class="gui-input"
                                           placeholder="'.__('Nombre del estudiante', 'soldador-admin').'">
                                    <span class="field-icon"><i class="fa fa-user"></i></span>
                                </label>
                            </div><!-- end section -->

                            <div class="section">
                                <label for="identify"  class="field prepend-icon">
                                    <input type="text" name="identify" id="identify" class="gui-input"
                                           placeholder="'.__('Documento de identidad', 'soldador-admin').'">
                                    <span class="field-icon"><i class="fa fa-file"></i></span>
                                </label>
                            </div><!-- end section -->

                            <div class="spacer-b30">
                                <div class="tagline"><span>'.__('Curso', 'soldador-admin').' </span></div><!-- .tagline -->
                            </div> <!-- end section -->

                            <div class="frm-row">

                                <div class="section colm colm6">
                                    <label for="titleCourse" class="field select">
                                        <select id="titleCourse" name="titleCourse">
                                            <option value="">'.__('Tipo', 'soldador-admin').'</option>
                                        ';

        foreach ($groups_cursos as $group) {
            $content_html .= '<option value="'.$group["cursos_title_name"].'">'.$group["cursos_title_name"].'</option>';
        }

        $content_html .= '</select>
                                    </label>
                                </div><!-- end section -->

                                <div class="section colm colm6">
                                    <label for="nivelCourse" class="field select">
                                        <select id="nivelCourse" name="nivelCourse">
                                            <option value="">'.__('Nivel', 'soldador-admin').'</option>';

        foreach ($groups_levels as $group) {
            $content_html .= '<option value="'.$group["levels_title_name"].'">'.$group["levels_title_name"].'</option>';
        }

                                        $content_html .= '</select>
                                    </label>
                                </div><!-- end section -->

                            </div><!-- end frm-row section -->
                            <div class="section">
                                <label for="hours"  class="field prepend-icon">
                                    <input type="text" name="hours" id="hours" class="gui-input"
                                           placeholder="'.__('Intencidad en horas', 'soldador-admin').'">
                                    <span class="field-icon"><i class="fa fa-hourglass"></i></span>
                                </label>
                            </div><!-- end section -->
                            <div class="section">
                                <label class="field-label">'.__('Fecha Inicio', 'soldador-admin').'</label>
                                <label  for="dateCourse"  class="field prepend-icon">
                                    <input type="text" id="dateCourse" name="dateCourse" class="gui-input">
                                    <span class="field-icon"><i class="fa fa-calendar"></i></span>
                                </label>
                            </div><!-- end section -->
                        </div><!-- end .form-body section -->
                        <button type="submit" id="submitButton" class="button w-full btn-primary">' . __('Ingresar Información', 'soldador-admin') . '</button>
                    </form>
                </div><!-- end .smart-forms section -->
            </div><!-- end .smart-wrap section -->

            <div>
            </div>
        </div>
        </div>
    </div>
</div>';
        return $content_html;
    }
}