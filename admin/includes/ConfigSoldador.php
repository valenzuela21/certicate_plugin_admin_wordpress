<?php
namespace admin\includes;
class ConfigSoldador {
    public function __construct()
    {
        add_action('admin_menu', array($this, 'soldador_page_config'));
        add_action('admin_menu', array($this, 'soldador_page_certificate_config'));
    }

    public function soldador_page_certificate_config(){
        $options = array(
            'id' => 'config_admin_cetificate_soldador',
            'title' => __( 'Config Certificado', 'soldador-admin' ),
            'menu_title' => __( 'Config Certificado', 'soldador-admin' ),
            'icon' => ' dashicons-sticky',
            'parent' => 'consult_admin_soldador',
            'position' => 6
        );

        $xbox = xbox_new_admin_page( $options );

        $xbox->add_field( array(
            'id' => 'logo-business',
            'name' => 'Logo Empresa',
            'type' => 'file',
            'options' => array(
                'mime_types' => array( 'jpg', 'jpeg', 'png'),
                'preview_size' => array( 'width' => '60px','height' => '60px' ),
                'multiple' => false,
            ),
            'desc' => 'Solo se acepta: "jpg", "jpeg", "png"',
        ));

        $xbox->add_field(array(
            'id' => 'title-certificate',
            'name' => __( 'Titulo', 'soldador-admin' ),
            'type' => 'text',
        ));

        $xbox->add_field(array(
            'id' => 'description-certicate',
            'name' => __( 'Descripción', 'soldador-admin' ),
            'type' => 'text',
        ));

        $xbox->add_field(array(
            'id' => 'sub-description-certicate',
            'name' => __( 'Sub Descripción', 'soldador-admin' ),
            'type' => 'text',
        ));

        $xbox->add_field( array(
            'id' => 'signal-one',
            'name' => 'Firma Autorisado',
            'type' => 'file',
            'options' => array(
                'mime_types' => array( 'jpg', 'jpeg', 'png'),
                'preview_size' => array( 'width' => '60px','height' => '60px' ),
                'multiple' => false,
            ),
            'desc' => 'Solo se acepta: "jpg", "jpeg", "png"',
        ));

        $xbox->add_field( array(
            'id' => 'signal-two',
            'name' => 'Firma Educativa',
            'type' => 'file',
            'options' => array(
                'mime_types' => array( 'jpg', 'jpeg', 'png'),
                'preview_size' => array( 'width' => '60px','height' => '60px' ),
                'multiple' => false,
            ),
            'desc' => 'Solo se acepta: "jpg", "jpeg", "png"',
        ));

        $xbox->add_field(array(
            'name' => 'Activar Certificado',
            'id' => 'enable-certificate',
            'type' => 'switcher',
            'default' => 'on',
            'desc' => 'Si deseas activar el servicio de certificados',
            'options' => array(
                'desc_tooltip' => true
            )
        ));

    }

    public function soldador_page_config() {
        $options = array(
            'id' => 'config_admin_select_soldador',//It will be used as "option_name" key to save the data in the wp_options table
            'title' => __( 'Config Servicios', 'soldador-admin' ),
            'menu_title' => __( 'Config Servicios', 'soldador-admin' ),
            'icon' => ' dashicons-sticky',
            'parent' => 'consult_admin_soldador',
            'position' => 6
        );

        $xbox = xbox_new_admin_page( $options );

        $xbox->add_group( array(
            'name' => __('Cursos','soldador-admin'),
            'id' => 'cursos_title',
            'type' => 'group',
            'controls' => array(
                'name' => '',
                'readonly_name' => false
            )
        ));

        $xbox->add_group( array(
            'name' => __('Niveles','soldador-admin'),
            'id' => 'levels_title',
            'type' => 'group',
            'controls' => array(
                'name' => '',
                'readonly_name' => false
            )
        ));
    }

}

new ConfigSoldador();