<?php

namespace admin\includes;

use admin\includes\ModalAdminContent;
class ShortCodeSolderPage {

    public function __construct()
    {
        add_shortcode('solder_consult', [$this, 'solder_shortcode_personalizado']);
    }

    public function solder_shortcode_personalizado() {
        $option_value = get_option('config_admin_cetificate_soldador');

        if (is_serialized($option_value)) {
            $option = unserialize($option_value);
        } else {
            $option = $option_value;
        }

        $output = ModalAdminContent::previewCertificate().'
        <div class="solder-form-search-section">
  <div class="container-search">
    <form autocomplete="off">
      <div class="container-solder">
        <div class="column col-solder-1">
          <label for="firstName">
            <input class="input-solder" name="firstName" id="firstName" placeholder="'.__('Ingresa el nombre', 'soldador-admin').'"/>
          </label>
        </div>
        <div class="column col-solder-2">
          <label for="identify">
            <input class="input-solder" name="identify" id="identify" placeholder="'.__('Ingresa la cédula', 'soldador-admin').'"/>
          </label>
        </div>
        <div class="column">
          <button  type="button" class="consult-cert button-search">
            <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" fill="currentColor" data-name="Layer 1"
                 viewBox="0 0 100 125" x="0px" y="0px">
              <path
                d="M45.5,20a25.5,25.5,0,1,0,15,46.13l12.7,12.7a4,4,0,0,0,5.66-5.66l-12.7-12.7A25.48,25.48,0,0,0,45.5,20Zm0,43A17.5,17.5,0,1,1,63,45.5,17.52,17.52,0,0,1,45.5,63Z"/>
            </svg>
          </button>
          <button type="button" class="consult-cert button-search-mobile">'.__('Buscar', 'soldador-admin').'</button>
        </div>
      </div>
    </form>
  </div>
  <div id="container-result" class="container-result">
    <h3 class="title"></h3>
    <p class="sub-title"></p>
    <div class="container-table">
    <table id="result-table-certificado" class="table">
      <tr>
        <th>'.__('Curso', 'soldador-admin').'</th>
        <th>'.__('Nivel', 'soldador-admin').'</th>
        <th>'.__('Horas','soldador-admin').'</th>
        <th>'.__('Inicio', 'soldador-admin').'</th>
         <th>';
         if ($option['enable-certificate'] == "on") { __('Certificado', 'soldador-admin'); }
        $output .='</th>
      </tr>
     <tbody id="resultCertSolder"></tbody>    
    </table>
    </div>
    <div class="footer">
        <div class="column column-4"></div>
        <div class="column">
          <button id="downloader" class="btn-downloader">'.__('Descargar Resultado', 'soldador-admin').'</button>
        </div>
    </div>
  </div>
</div>';

        return $output;
    }

}

new ShortCodeSolderPage();