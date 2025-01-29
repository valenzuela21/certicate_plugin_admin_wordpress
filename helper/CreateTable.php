<?php

namespace helper;
class CreateTable {

    public static  function create()
    {
        global $wpdb;

        $name_table = $wpdb->prefix . 'certificate_solder';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $name_table (
            id int NOT NULL AUTO_INCREMENT,
            name_study varchar(120) NOT NULL,
            document varchar(120) NOT NULL,
            course varchar(100) NOT NULL,
            nivel varchar(100) NOT NULL,
            hours varchar(100) NOT NULL,
            fecha_registro datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            inserted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";


        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta($sql);
    }

}