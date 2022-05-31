<?php
add_action( 'wp_ajax_pd_gdpr_export_data', 'pd_gdpr_export_data' );
function pd_gdpr_export_data() {
    global $wpdb;
//    $table_name = $wpdb->prefix . 'options';
    $table_name = $wpdb->options;
    if ( isset( $_POST['export_type'] ) ) {
        $export_type = sanitize_text_field( $_POST['export_type'] );
        if ( $export_type == 'all' ) {
            //$sql_query = $wpdb->prepare("SELECT option_name,option_value FROM %s WHERE option_name LIKE 'puredevs_%_settings'", $table_name);
            $plugin_options = $wpdb->get_results( "SELECT option_name,option_value FROM $table_name WHERE option_name LIKE 'puredevs_%_settings'" );
            $delimiter = ",";
            //create a file pointer
            $f = fopen( 'php://memory', 'w' );
            //set column headers
            $option_name = wp_list_pluck( $plugin_options, 'option_name' );
            $option_value = wp_list_pluck( $plugin_options, 'option_value' );
            fputcsv($f, $option_name, $delimiter);
            fputcsv($f, $option_value, $delimiter);
            //move back to beginning of file
            fseek($f, 0);

            //output all remaining data on a file pointer
            fpassthru($f);
        } elseif ( $export_type == 'custom' ) {
            $select_opt = sanitize_text_field( $_POST['select_opt'] );
            $sql_query = $wpdb->prepare("SELECT option_name,option_value FROM $table_name WHERE option_name = %s", $select_opt);
            //$plugin_options = $wpdb->get_results( "SELECT option_name,option_value FROM $table_name WHERE option_name = '$select_opt'" );
            $plugin_options = $wpdb->get_results( $sql_query );
            $delimiter = ",";
            //create a file pointer
            $f = fopen('php://memory', 'w');
            //set column headers
            $option_name = wp_list_pluck( $plugin_options, 'option_name' );
            $option_value = wp_list_pluck( $plugin_options, 'option_value' );
            fputcsv($f, $option_name, $delimiter);
            fputcsv($f, $option_value, $delimiter);
            //move back to beginning of file
            fseek($f, 0);

            //output all remaining data on a file pointer
            fpassthru($f);
        }
    }
    exit();
}