<?php

namespace HelpieFaq\Includes\Repos;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\HelpieFaq\Includes\Repos\Faq')) {
    class Faq
    {
        public function update_post(int $postId)
        {
            // 1. get current post by postId
            $post = get_post($postId);

            // 2. get current post terms
            $terms = get_the_terms($post->ID, 'helpie_faq_group');

            // 3. return, if the terms is empty
            if (isset($terms) && empty($terms)) {
                return;
            }

            $faq_group_repo = new \HelpieFaq\Includes\Repos\Faq_Group();
            foreach ($terms as $faq_group_term) {
                // 4.1 get current term faq group items
                $faq_group_items = $faq_group_repo->get_faq_group_items($faq_group_term->term_id);

                // 4.2 update the current post content
                $faq_group_items = $faq_group_repo->modify_faq_group_items('update', $post->ID, $faq_group_items);

                // 4.3 if $faq_group_items empty then, append the current post
                if (empty($faq_group_items)) {
                    $faq_group_items[]['faq_item'] = $this->get_post_content($post);
                }

                // 4.4 update the faq group items
                $faq_group_repo->update_faq_group_term_meta($faq_group_term->term_id, $faq_group_items);
            }
        }

        public function remove_post(int $postId)
        {
            // 1. get the current post
            $post = get_post($postId);

            // 2. get all current post terms
            $terms = get_the_terms($post->ID, 'helpie_faq_group');

            if (isset($terms) && empty($terms) || count($terms) == 0) {
                return;
            }

            $faq_group_repo = new \HelpieFaq\Includes\Repos\Faq_Group();
            foreach ($terms as $faq_group_term) {
                // 3.1 get current term faq group items
                $faq_group_items = $faq_group_repo->get_faq_group_items($faq_group_term->term_id);

                // 3.2 remove the current post in a faq group items
                $faq_group_items = $faq_group_repo->modify_faq_group_items('remove', $post->ID, $faq_group_items);

                // 3.3 update the faq group items
                $faq_group_repo->update_faq_group_term_meta($faq_group_term->term_id, $faq_group_items);
            }

        }

        public function get_post_content($post)
        {
            return array(
                'post_id' => $post->ID,
                'title' => $post->post_title,
                'content' => $post->post_content,
            );
        }

    }
}