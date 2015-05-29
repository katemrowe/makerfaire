<?php
/* 
 * this script will hold all the cronjobs for makerfaire
 */

/*
//for testing
define( 'BLOCK_LOAD', true );
require_once( '../../../../wp-config.php' );
require_once( '../../../../wp-includes/wp-db.php' );
$wpdb = new wpdb( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST);
dailyCronFunction(); //for testing*/

add_action('dailyCronHook', 'dailyCronFunction');

function dailyCronFunction(){    
   build_wp_mf_maker();
   build_wp_mf_api_entity();
    
}
function build_wp_mf_api_entity(){
    global $wpdb;
    $sql = "REPLACE INTO `wp_mf_api_entity`
            (`ID`,
            `project_title`,
            `project_description`,
            `project_url`,
            `category_id`,
            `child_id_ref`,
            `thumb_image_url`,
            `large_image_url`)
            SELECT 
        `wp_rg_lead_detail`.`lead_id` AS `lead_id`,
        trim(GROUP_CONCAT(DISTINCT IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) = 151),
                `wp_rg_lead_detail`.`value`,
                NULL)
            SEPARATOR ',')) AS `Title`,COALESCE(
        trim(GROUP_CONCAT(DISTINCT IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) = 16),
                `l`.`value`,
                NULL)
            SEPARATOR ',')),trim(GROUP_CONCAT(DISTINCT IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) = 16),
                `wp_rg_lead_detail`.`value`,
                NULL)
            SEPARATOR ','))) AS `Description`,
       trim( GROUP_CONCAT(DISTINCT IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) = 27),
                `wp_rg_lead_detail`.`value`,
                NULL)
            SEPARATOR ',')) AS `URL`,
         trim(GROUP_CONCAT(DISTINCT IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) BETWEEN 146.9999 AND 147.9999),
                    SUBSTRING_INDEX(SUBSTRING_INDEX(`wp_rg_lead_detail`.`value`, ':', 2), ':', -1),
               NULL)
            SEPARATOR ',')) AS `Categories`,
		trim(GROUP_CONCAT(distinct maker_id
            SEPARATOR ',')) AS `maker_ids`,
		trim(GROUP_CONCAT(distinct IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) = 22),
                `wp_rg_lead_detail`.`value`,
                NULL)
            SEPARATOR ',')) AS `Photo`,
        trim(GROUP_CONCAT(DISTINCT IF((FORMAT(`wp_rg_lead_detail`.`field_number`,
                    2) = 22),
                `wp_rg_lead_detail`.`value`,
                NULL)
            SEPARATOR ',')) AS `ThumbPhoto`
    FROM
        (`wp_rg_lead_detail`
        left outer JOIN `wp_rg_lead_detail_long` `l` ON ((`wp_rg_lead_detail`.`id` = `l`.`lead_detail_id`)))
        JOIN `wp_rg_lead` `b` ON ((`wp_rg_lead_detail`.`lead_id` = `b`.`id`))
        JOIN `wp_mf_maker` `c` ON (`b`.`id` = `c`.lead_id) and not isnull(`c`.`First Name`)
    GROUP BY `wp_rg_lead_detail`.`lead_id`;";
     $wpdb->get_results($sql);
}
function build_wp_mf_maker(){
    global $wpdb;
    //first empty existing table
    $sql = "Truncate Table wp_mf_maker;";
    $wpdb->get_results($sql);
    //now populate with new data
    $sql = "INSERT INTO `wp_mf_maker`
    (`lead_id`,
    `First Name`,
    `Last Name`,
    `Bio`,
    `Email`,
    `OnsitePhone`,
    `TWITTER`,
    `SpecialRequest`,
    `PresentationTitle`,
    `PresentationType`,
    `Name`,
    `Location`,
    `Status`,
    `Photo`,
    `form_id`,
    `maker_id`
    )
    SELECT `wp_gravityforms_maker_view`.`lead_id`,
        `wp_gravityforms_maker_view`.`First Name`,
        `wp_gravityforms_maker_view`.`Last Name`,
        `wp_gravityforms_maker_view`.`Bio`,
        `wp_gravityforms_maker_view`.`Email`,
        `wp_gravityforms_maker_view`.`OnsitePhone`,
        `wp_gravityforms_maker_view`.`TWITTER`,
        `wp_gravityforms_maker_view`.`SpecialRequest`,
        `wp_gravityforms_maker_view`.`PresentationTitle`,
        `wp_gravityforms_maker_view`.`PresentationType`,
        `wp_gravityforms_maker_view`.`Name`,
        `wp_gravityforms_maker_view`.`Location`,
        `wp_gravityforms_maker_view`.`Status`,
        `wp_gravityforms_maker_view`.`Photo`,
        `wp_gravityforms_maker_view`.`form_id`,
        `wp_gravityforms_maker_view`.`maker_id`
    FROM `wp_gravityforms_maker_view`;";
     $wpdb->get_results($sql);
    
}


