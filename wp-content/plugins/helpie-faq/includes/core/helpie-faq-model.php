<?php

namespace HelpieFaq\Includes\Core;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\HelpieFaq\Includes\Core\Helpie_Faq_Model')) {
    class Helpie_Faq_Model
    {
        public function __construct()
        {
            $this->option = get_option('helpie-faq');
            // error_log(' [option] ' . print_r($this->option, true));
        }

        public function get_cpt_slug()
        {

            $faq_option = $this->option;
            $cpt_slug = 'helpie_faq';
            if (isset($faq_option['helpie_faq_slug']) && !empty($faq_option['helpie_faq_slug'])) {
                $cpt_slug = $faq_option['helpie_faq_slug'];
            }

            return $cpt_slug;
        }

        public function get_global_search_option()
        {
            $faq_option = $this->option;
            $exclude_from_search = false;
            if (isset($faq_option['exclude_from_search'])) {
                $exclude_from_search = ($faq_option['exclude_from_search'] == 1) ? true : false;
            }
            return $exclude_from_search;
        }
    }
}