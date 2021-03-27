<?php

namespace Stylus\Components;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\Stylus\Components\Search')) {

    class Search
    {

        public function __construct()
        {}

        public function get_view($props)
        {
            $html = '<form class="search" onSubmit="return false;">';
            $html .= '<div class="searchWrapper">';
            $html .= '<input type="text" class="search__input" placeholder="' . $props['search_placeholder'] . '">';
            $html .= '<img class="search__icon" src="' . HELPIE_FAQ_URL . '/assets/img/search-icon.png">';
            $html .= '</div>';
            $html .= '<div class="searchEmptyWrapper">';
            $html .= '</div>';
            $html .= '</form>';

            return $html;
        }
    } // END CLASS
}