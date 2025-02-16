<?php

/*
Plugin Name:  Soldador Admin
Plugin URI:   https://creatives.com.co/
Description:  Sistema administrador de  los cursos de certificados de los soldadores
Version:      1.0
Author:       David Fernando Valenzuela Pardo
Author URI:   https://creatives.com.co/
License:      GPL2
License URI:  GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
Text Domain:  soldador-admin
*/

use admin\includes\SoldadorContentAdmin;
use helper\CreateTable;


if ( ! defined( 'ABSPATH' ) ) exit;

if( ! defined( 'XBOX_HIDE_DEMO' ) ){
    define( 'XBOX_HIDE_DEMO', false );
}

class SoldadorAdmin {

    public string $hooKey = "toplevel_page_consult_admin_soldador";

    public function __construct()
    {
        $this->_require_file();
        add_action('admin_menu', array($this, 'page_admin_soldador_config'));
        add_action('wp_enqueue_scripts', array($this,'frontend_css_js_solder'), 10, 1);
        add_action('admin_enqueue_scripts', array($this,'admin_css_js_soldador'), 10, 1);
        add_action('wp_ajax_insert_solder_form', array($this, 'insert_solder_form'));
        add_action('wp_ajax_nopriv_insert_solder_form',  array($this, 'insert_solder_form'));
        add_action('wp_ajax_update_solder_form', array($this, 'update_solder_form'));
        add_action('wp_ajax_nopriv_update_solder_form', array($this, 'update_solder_form'));
        add_action('wp_ajax_consult_solder_form', array($this, 'consult_solder_form'));
        add_action('wp_ajax_nopriv_consult_solder_form', array($this, 'consult_solder_form'));
        add_action('wp_ajax_insertar_data_excel_solder', array($this,'insertar_data_excel_solder'));
        add_action('wp_ajax_nopriv_insertar_data_excel_solder', array($this, 'insertar_data_excel_solder'));
        register_uninstall_hook(__FILE__, array($this, 'soldador_plugin_uninstall'));
        register_deactivation_hook(__FILE__, array($this, 'soldador_plugin_uninstall'));
        register_activation_hook(__FILE__, array($this, 'create_table_soldador_plugin'));
    }

    function soldador_plugin_uninstall() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'certificate_solder';

        // Elimina la tabla de la base de datos
        $wpdb->query("DROP TABLE IF EXISTS $table_name");
    }

    public function insertar_data_excel_solder(){

        global $wpdb;
        $table_name = $wpdb->prefix . 'certificate_solder';


        if (!isset($_POST['registers'])) {
            wp_send_json_error("No hay datos recibidos.");
        }

        $wpdb->query("TRUNCATE TABLE $table_name");

        $registers = json_decode(stripslashes($_POST['registers']), true);
        if (!empty($registers) && is_array($registers)) {
            foreach ($registers as $form_data) {

                if (
                    !isset($form_data['name'], $form_data['document'], $form_data['course'],
                        $form_data['level_course'], $form_data['hours'], $form_data['date']) ||
                    in_array('N/A', $form_data, true)
                )  {
                    continue;
                }

                $result = $wpdb->insert(
                    $table_name,
                    array(
                        'name_study' => sanitize_text_field($form_data['name']),
                        'document' => sanitize_text_field($form_data['document']),
                        'course' => sanitize_text_field($form_data['course']),
                        'nivel' => sanitize_text_field($form_data['level_course']),
                        'hours' => sanitize_text_field($form_data['hours']),
                        'fecha_registro' => sanitize_text_field($form_data['date']),
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );
            }

            if($result){
                wp_send_json_success("Datos insertados correctamente.");
            }else{
                wp_send_json_error("Los datos no se insertaron correctamente.");
            }
        }
    }

    public function consult_solder_form(){
        global $wpdb;

        $option_value = get_option('config_admin_cetificate_soldador');

        if (is_serialized($option_value)) {
            $option = unserialize($option_value);
        } else {
            $option = $option_value;
        }

        $data = $_POST['form_data'];

        try{
            $table_name = $wpdb->prefix . 'certificate_solder';
            $query = $wpdb->prepare(
                "SELECT * FROM $table_name WHERE name_study = %s OR document = %s",
                $data['firstName'],
                $data['identify']
            );

            $results = $wpdb->get_results($query);

            wp_send_json_success([ 'data' => $results , 'enable_cert' => $option['enable-certificate']]);

        }catch (Exception $e){
            wp_send_json_error($e->getMessage());
        }
    }

    public function process_form_data($form_data): array
    {
        if (!is_array($form_data)) {
            wp_die('Error: Los datos del formulario no son válidos.');
        }

        $processed_data = array(
            'firstName' => sanitize_text_field($form_data['firstName']),
            'titleCourse' => sanitize_text_field($form_data['titleCourse']),
            'identify' => sanitize_text_field($form_data['identify']),
            'nivelCourse' => sanitize_text_field($form_data['nivelCourse']),
            'hours' => sanitize_text_field($form_data['hours']),
            'dateCourse' => sanitize_text_field($form_data['dateCourse'])
        );

        $date = DateTime::createFromFormat('d/m/Y', $processed_data['dateCourse']);

        if ($date) {
            $processed_data['dateCourse'] = $date->format('Y-m-d H:i:s');
        } else {
            wp_send_json_error('Formato de fecha no válido');
            wp_die();
        }

        return $processed_data;
    }

    public function  update_solder_form()
    {
        global $wpdb;

        if (isset($_POST['form_data'])) {

            parse_str(stripslashes($_POST['form_data']), $dataInput);

            $form_data = $this->process_form_data($dataInput);

            $id = intval($dataInput['id']);

            $table_name = $wpdb->prefix . 'certificate_solder';

            $data = array(
                'name_study' => $form_data['firstName'],
                'document' => $form_data['identify'],
                'course' => $form_data['titleCourse'],
                'nivel' => $form_data['nivelCourse'],
                'hours' => $form_data['hours'],
                'fecha_registro' => $form_data['dateCourse']
            );

            $format = array(
                '%s',
                '%s',
                '%s',
                '%s',
                '%s',
                '%s'
            );

            $where = array(
                'id' => $id
            );

            $where_format = array(
                '%d'
            );

            $result = $wpdb->update($table_name, $data, $where, $format, $where_format);

            if ($result !== false) {
                wp_send_json_success('Registro actualizado correctamente');
            } else {
                wp_send_json_error('Error al actualizar el registro: ' . $wpdb->last_error);
            }
        } else {
            wp_send_json_error('No se recibieron datos del formulario');
        }

        wp_die();
    }

    public function insert_solder_form() {

        global $wpdb;

        if (isset($_POST['form_data'])) {
            try {
                parse_str(stripslashes($_POST['form_data']), $dataInput);
                $form_data = $this->process_form_data($dataInput);
                $table_name = $wpdb->prefix . 'certificate_solder';

                $result = $wpdb->insert(
                    $table_name,
                    array(
                        'name_study' => $form_data['firstName'],
                        'document' => $form_data['identify'],
                        'course' => $form_data['titleCourse'],
                        'nivel' => $form_data['nivelCourse'],
                        'hours' => $form_data['hours'],
                        'fecha_registro' => $form_data['dateCourse']
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );

                if ($result) {
                    wp_send_json_success($form_data);
                } else {
                    wp_send_json_error('No se pudo enviar los datos correctamente: ' . $wpdb->last_error);
                }
            }catch (exception $e) {
                wp_send_json_error('Error: ' . $e);
            }

        } else {
            wp_send_json_error( 'Error al enviar loas datos');
        }

        wp_die();
    }

    public function create_table_soldador_plugin(){
            return CreateTable::create();
    }

    public function frontend_css_js_solder(){
        wp_enqueue_script(
            'admin_jquery_solder',
            plugins_url('./assets/js/jquery-1.9.1.min.js', __FILE__),
            array('jquery'),
            '1.9.1',
            true
        );

        wp_enqueue_script(
            'admin_tailwind_min_solder',
            plugins_url('./assets/js/tailwind.min.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_script(
            'admin_datatables_jquery_jspdf',
            plugins_url('./assets/js/jspdf.umd.min.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_script(
            'admin_datatables_jquery_html2canvas',
            plugins_url('./assets/js/html2canvas.min.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_style(
            'frontend_tailwind_css_solder',
            plugins_url('./assets/css/style.css', __FILE__),
            array(),
            '1.0.1'
        );

        wp_enqueue_script(
            'frontend_xlsx_full_min',
            plugins_url('./assets/js/xlsx.full.min.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );

        wp_enqueue_script(
            'front_main_soldador',
            plugins_url('./assets/js/main.front.js', __FILE__),
            array('jquery'),
            '1.0.1',
            true
        );
        wp_localize_script('front_main_soldador', 'ajax_object', [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ]);
    }

    public function admin_css_js_soldador($hook){
            if($hook == $this->hooKey){
                wp_enqueue_script(
                    'admin_jquery_solder',
                    plugins_url('./assets/js/jquery-1.9.1.min.js', __FILE__),
                    array('jquery'),
                    '1.9.1',
                    true
                );

                wp_enqueue_script(
                    'admin_tailwind_min_solder',
                    plugins_url('./assets/js/tailwind.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_js_table_solder',
                    plugins_url('./assets/js/dataTables.js', __FILE__),
                    array('jquery'),
                    '3.7.1',
                    true
                );

                wp_enqueue_script(
                    'admin_datatables_jquery_jspdf',
                    plugins_url('./assets/js/jspdf.umd.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_datatables_jquery_html2canvas',
                    plugins_url('./assets/js/html2canvas.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_main_soldador',
                    plugins_url('./assets/js/main.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );


                wp_enqueue_script(
                    'admin_datatables_min_solder',
                    plugins_url('./assets/js/dataTables.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_datatables_jquery_placeholder',
                    plugins_url('./assets/js/jquery.placeholder.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_datatables_jquery_validate',
                    plugins_url('./assets/js/jquery.validate.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_datatables_jquery_ui_custom',
                    plugins_url('./assets/js/jquery-ui-custom.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_tailwind_min_solder',
                    plugins_url('./assets/js/tailwind.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );

                wp_enqueue_script(
                    'admin_xlsx_full_min',
                    plugins_url('./assets/js/xlsx.full.min.js', __FILE__),
                    array('jquery'),
                    '1.0',
                    true
                );


                wp_enqueue_style(
                    'admin_css_data_table_solder',
                    plugins_url('./assets/css/dataTable.min.css', __FILE__),
                    array(),
                    '1.0.1'
                );

                wp_enqueue_style(
                    'admin_css_font_awesome',
                    plugins_url('./assets/css/font-awesome.min.css', __FILE__),
                    array(),
                    '1.0.1'
                );

                wp_enqueue_style(
                    'admin_smart_addons_forms',
                    plugins_url('./assets/css/smart-addons.css', __FILE__),
                    array(),
                    '1.0.1'
                );

                wp_enqueue_style(
                    'admin_css_form_solder_ie8',
                    plugins_url('./assets/css/smart-forms-ie8.css', __FILE__),
                    array(),
                    '1.0.1'
                );

                wp_enqueue_style(
                    'admin_css_style_solder',
                    plugins_url('./assets/css/style.css', __FILE__),
                    array(),
                    '1.0.1'
                );

                wp_enqueue_style(
                    'admin_css_form_solder',
                    plugins_url('./assets/css/smart-forms.css', __FILE__),
                    array(),
                    '1.0.1'
                );

            }
    }

    public function page_admin_soldador_config()
    {
        add_menu_page(
            __('Admin Soldador', 'soldador-admin'),
            __('Admin Soldador', 'soldador-admin'),
            'read',
            'consult_admin_soldador',
            array($this, 'soldador_custom_page_consult'),
            'dashicons-store',
            6
        );
    }


    public function soldador_custom_page_consult()
    {
        echo SoldadorContentAdmin::content();
    }

    private function _require_file()
    {
        require_once plugin_dir_path(__FILE__) . './xbox/xbox.php';
        require_once plugin_dir_path(__FILE__) . './admin/includes/ShortCodeSolderPage.php';
        require_once plugin_dir_path(__FILE__) . './admin/includes/ConfigSoldador.php';
        require_once plugin_dir_path(__FILE__) . './admin/includes/SoldadorContentAdmin.php';
        require_once plugin_dir_path(__FILE__) . './admin/includes/ModalAdminContent.php';
        require_once plugin_dir_path(__FILE__) . './admin/theme/LoaderCertificate.php';
        require_once plugin_dir_path(__FILE__) . './admin/theme/SolderCertificate.php';
        require_once plugin_dir_path(__FILE__) . './helper/CreateTable.php';
    }
}

new SoldadorAdmin();