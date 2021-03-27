<?php

namespace HelpieFaq\Features\Faq_Group;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\HelpieFaq\Features\Faq_Group\Controller')) {
    class Controller
    {
        public function init()
        {
            $this->load_hooks();
        }

        public function load_hooks()
        {
            $actions = new \HelpieFaq\Features\Faq_Group\Actions();
            $filters = new \HelpieFaq\Features\Faq_Group\Filters();
        }

        /**
         * FAQ Groups default arguments
         */
        public function get_default_args($args)
        {

            $fields = $this->get_default_fields();
            $faq_group_term = get_term($args['group_id']);

            $faq_group_args = array(
                'group_id' => $args['group_id'],
                'title' => isset($faq_group_term->name) ? $faq_group_term->name : '',
            );

            $args = array_merge($fields, $faq_group_args);
            return $args;
        }

        private function get_default_fields()
        {
            $fields = [
                'group_id' => 0,
                'display_mode' => 'simple_accordion',
                'product_only' => false,
                'categories' => '',
                'sortby' => 'post__in',
                'title' => '',
            ];

            return $fields;
        }
    }
}