<?php
  /**
   * Database update logic
   *
   * @link       #
   * @since      2.0.0
   * @author     Woodpecker Team
   * @package    Woodpecker_For_Wordpress_Connector
   * @subpackage Woodpecker_For_Wordpress_Connector/includes
   */

  class WFW_Update_Database {

    private $pluginVersion = '';
    private $databaseVersion = '';

    public function __construct($databaseVersion = array()) {
        $this->pluginVersion = WOODPECKER_PLUGIN_NAME_VERSION;
        $this->databaseVersion = $databaseVersion;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        if ($databaseVersion == 'reinstall') {
          $this->removeWfwTables();
        }

        if ($databaseVersion != '2.0.0'
        && $databaseVersion != '2.0.1'
        && $databaseVersion != '2.0.2'
        && $databaseVersion != '2.0.3'
        && $databaseVersion != '2.0.4'
        && $databaseVersion != '3.0.0') {
         $databaseVersion == '1.5.0' ? $this->update_2_0_version() : $this->update_1_5_version();
        }

        if ($databaseVersion == '2.0.0') {
          return $this->update_2_0_1_version();
        } 

        if ($databaseVersion == '2.0.4') {
          return $this->update_3_0_0_version();
        } 
        
        return true;
    }

    private function removeWfwTables() {
      global $wpdb;

      $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "wfw_forms_fields");
      $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "wfw_forms");
      $wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "wfw_forms_prospects");
      update_option('wfw_db_version', '0.0.0');
    }

    private function update_1_5_version() {
      global $wpdb;

      $formsData = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "wfw_forms WHERE id = 1");

      $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wfw_forms_fields (
            id INT NOT NULL auto_increment,
            field_label varchar(255) NOT NULL,
            field_state BOOLEAN DEFAULT true NOT NULL,
            fields_map varchar(255) NOT NULL,
            form_id INT NOT NULL,
            timestamp DATETIME,
            PRIMARY KEY (id)
          ) ". $charset_collate .";";

      dbDelta($sql);

      if ($this->databaseVersion != $pluginVersion) {
        if (!empty($formsData)) {

          $isFirstNameShow = false;
          $isLastNameShow = false;
          $isCompanyShow = false;

          if ($formsData->first_name_hide == '1') {
            $isFirstNameShow = true;
          }

          if ($formsData->last_name_hide == '1') {
            $isLastNameShow = true;
          }

          if ($formsData->company_hide == '1') {
            $isCompanyShow = true;
          }

          $emailData = array(
              'id' => '',
              'field_label' => sanitize_text_field($formsData->email_label),
              'field_state' => true,
              'fields_map' => 'EMAIL',
              'form_id' => 1,
              'timestamp' => date('Y-m-d H:m:s'),
          );
          $wpdb->insert($wpdb->prefix . 'wfw_forms_fields', $emailData);

          $firstNameData = array(
              'id' => '',
              'field_label' => sanitize_text_field($formsData->first_name_label),
              'field_state' => sanitize_key($isFirstNameShow),
              'fields_map' => 'FIRST_NAME',
              'form_id' => 1,
              'timestamp' => date('Y-m-d H:m:s'),
          );
          $wpdb->insert($wpdb->prefix . 'wfw_forms_fields', $firstNameData);

          $lastNameData = array(
              'id' => '',
              'field_label' => sanitize_text_field($formsData->last_name_label),
              'field_state' => sanitize_key($isLastNameShow),
              'fields_map' => 'LAST_NAME',
              'form_id' => 1,
              'timestamp' => date('Y-m-d H:m:s'),
          );
          $wpdb->insert($wpdb->prefix . 'wfw_forms_fields', $lastNameData);

          $companyData = array(
              'id' => '',
              'field_label' => sanitize_text_field($formsData->company_label),
              'field_state' => sanitize_key($isCompanyShow),
              'fields_map' => 'COMPANY',
              'form_id' => 1,
              'timestamp' => date('Y-m-d H:m:s'),
          );
          $wpdb->insert($wpdb->prefix . 'wfw_forms_fields', $companyData);

          $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms
            DROP COLUMN email_label,
            DROP COLUMN email_hide,
            DROP COLUMN first_name_label,
            DROP COLUMN first_name_hide,
            DROP COLUMN last_name_label,
            DROP COLUMN last_name_hide,
            DROP COLUMN company_label,
            DROP COLUMN company_hide;
          ");
        }
      }

      $formsFieldsData = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "wfw_forms_fields");

      if (empty($formsFieldsData)) {
        $defaultField = array(
            'id' => '',
            'field_label' => 'Email',
            'field_state' => true,
            'fields_map' => 'EMAIL',
            'form_id' => 1,
            'timestamp' => date('Y-m-d H:m:s'),
        );
        $wpdb->insert($wpdb->prefix . 'wfw_forms_fields', $defaultField);
      }

      $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wfw_forms (
            id INT NOT NULL auto_increment,
            create_date DATE,
            last_mod_date DATE,
            button_label varchar(255) NOT NULL,
            default_style int(1) DEFAULT '1' NOT NULL,
            font_color varchar(255) DEFAULT '#000000' NOT NULL,
            button_color varchar(255) DEFAULT '#000000' NOT NULL,
            button_hover varchar(255) DEFAULT '#000000' NOT NULL,
            success_message text,
            error_message text,
            already_exist_message text,
            privacy_policy_message text,
            api_key text,

            PRIMARY KEY  (id)
          ) ". $charset_collate .";";

      dbDelta($sql);

      if (empty($formsData)) {
        $data = array(
              'id' => '',
              'create_date' => date("Y-m-d"),
              'last_mod_date' => "",
              'button_label' => 'Submit',
              'default_style' => 1,
              'font_color' => '#FFF',
              'button_color' => '#5d32e9',
              'button_hover' => '#5d32e9',
              'success_message' => '<p>Subscription complete</p>',
              'error_message' => '<p>You need to fill all labels to submit your form.</p>',
              'already_exist_message' => '<p>You have already subscribed. Your data has been updated.</p>',
              'privacy_policy_message' => '<p>Accept Privacy Policy</p>',
              'api_key' => '',
            );
        $wpdb->insert($wpdb->prefix . 'wfw_forms', $data);
      }

      return $this->update_2_0_version();
    }

    private function update_2_0_version() {
      global $wpdb;

      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms ADD field_required_message TEXT NOT NULL");
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields ADD regex TEXT NOT NULL");
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields ADD required BOOLEAN DEFAULT '1' NOT NULL");
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields ADD validate_text TEXT NOT NULL");
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields ADD relation TEXT NOT NULL");
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields DROP IF EXISTS field_state");

      $sql = "CREATE TABLE IF NOT EXISTS " . $wpdb->prefix . "wfw_forms_prospects (
            id INT NOT NULL auto_increment,
            email varchar(62) NOT NULL,
            first_name varchar(50),
            last_name varchar(50),
            company varchar(50),
            www varchar(255),
            title varchar(50),
            phone varchar(20),
            address varchar(95),
            tag varchar(30),
            city varchar(35),
            state varchar(35),
            country varchar(35),
            industry varchar(50),
            snippet_1 varchar(255),
            snippet_2 varchar(255),
            snippet_3 varchar(255),
            snippet_4 varchar(255),
            snippet_5 varchar(255),
            snippet_6 varchar(255),
            snippet_7 varchar(255),
            snippet_8 varchar(255),
            snippet_9 varchar(255),
            snippet_10 varchar(255),
            snippet_11 varchar(255),
            snippet_12 varchar(255),
            snippet_13 varchar(255),
            snippet_14 varchar(255),
            snippet_15 varchar(255),
            form_id INT NOT NULL,
            timestamp DATETIME,
            PRIMARY KEY  (id)
          ) ". $charset_collate .";";

      dbDelta($sql);
     
      $this->update_2_0_1_version();
    }

    private function update_2_0_1_version() {
      global $wpdb;

      $isOk = $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_prospects ADD linkedin_url varchar(255) NOT NULL");

      if ($isOk) {
        update_option('wfw_db_version', '2.0.4');
      }

      return $this->update_3_0_0_version();
    }

    private function update_3_0_0_version() {
      global $wpdb;
      $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields DROP IF EXISTS field_state");

      $isOk = $wpdb->query("ALTER TABLE " . $wpdb->prefix . "wfw_forms_fields CHANGE relation slug TEXT");
      $updateEmail = $wpdb->update($wpdb->prefix . "wfw_forms_fields", array('slug' => 'EMAIL'), array('fields_map' => 'EMAIL'));

      if ($isOk && $updateEmail) {
        update_option('wfw_db_version', '3.0.0');
      }

      return $isOk && $updateEmail;
    }

  }
?>