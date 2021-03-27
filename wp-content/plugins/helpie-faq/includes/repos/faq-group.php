<?php

namespace HelpieFaq\Includes\Repos;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

if (!class_exists('\HelpieFaq\Includes\Repos\Faq_Group')) {
    class Faq_Group
    {

        public function update_faq_group($request, $term_id)
        {
            $faq_groups = isset($request['faq_groups']) ? $request['faq_groups'] : [];

            $collections = $this->insert_or_update_the_posts($term_id, $faq_groups);

            $faq_group_items = isset($collections['faq_group_items']) ? $collections['faq_group_items'] : [];
            $post_ids = isset($collections['post_ids']) ? $collections['post_ids'] : [];

            $this->update_faq_group_term_meta($term_id, $faq_group_items);

            $this->remove_posts_not_in_faq_group($term_id, $post_ids);
        }

        public function insert_or_update_the_posts(int $term_id, array $faq_group_items)
        {
            $post_ids = [];

            // 1. Return values,if empty $faq_group_items
            if (empty($faq_group_items)) {
                return array(
                    'post_ids' => $post_ids,
                    'faq_group_items' => $faq_group_items,
                );
            }

            // 2. Loop through $faq_group_items
            for ($ii = 0; $ii < count($faq_group_items); $ii++) {

                $faq = isset($faq_group_items[$ii]['faq_item']) ? $faq_group_items[$ii]['faq_item'] : '';

                if (isset($faq) && !empty($faq)) {

                    $post_id = (isset($faq['post_id']) && !empty($faq['post_id'])) ? $faq['post_id'] : '';

                    $post_data = array(
                        'ID' => $post_id,
                        'post_title' => isset($faq['title']) ? $faq['title'] : '',
                        'post_content' => isset($faq['content']) ? $faq['content'] : '',
                    );

                    /** 2.1. Update the post  */
                    if (!empty($post_id)) {
                        wp_update_post($post_data);
                    }

                    /** 2.2. create new faq post  */
                    if (empty($post_id)) {
                        $post_data['term_id'] = $term_id;
                        $post_id = $this->store_faq_post_by_tax_id($post_data);
                        /** set post_id */
                        $faq_group_items[$ii]['faq_item']['post_id'] = $post_id;
                    }

                    // 2.3 collect current group all post-ids
                    if ($post_id) {
                        $post_ids[] = $post_id;
                    }
                }
            }

            // 3. Return faq_posts with updated post data and also post_ids
            return array(
                'post_ids' => $post_ids,
                'faq_group_items' => $faq_group_items,
            );
        }

        public function remove_posts_not_in_faq_group(int $term_id, array $post_ids)
        {
            //1. Get All Posts by term id
            $posts = $this->get_posts_by_term_id($term_id);

            //2. return, if the posts is empty
            if (empty($posts) && count($posts) == 0) {
                return;
            }

            foreach ($posts as $post) {
                if (!isset($post)) {
                    continue;
                }
                $postId = $post->ID;
                //3. remove the post, if not exists in $post_ids data
                if (!in_array($postId, $post_ids)) {
                    wp_delete_post($postId, true);
                }
            }
        }

        public function store_faq_post_by_tax_id(array $args)
        {
            $utils_helper = new \HelpieFaq\Includes\Utils\Helpers();
            $post_id = $utils_helper->insert_post_with_term(HELPIE_FAQ_POST_TYPE, $args['term_id'], 'helpie_faq_group', $args['post_title'], $args['post_content']);
            return $post_id;
        }

        public function update_faq_group_term_meta(int $term_id, array $term_meta_data)
        {
            update_term_meta($term_id, 'helpie_faq_group_items', ['faq_groups' => $term_meta_data]);
        }

        public function modify_faq_group_items(string $action, int $postId, array $faq_group_items)
        {
            $post = get_post($postId);
            $allowed_actions = ['remove', 'update'];

            // 1. return empty array value, if $faq_group_items is empty
            if (empty($faq_group_items)) {
                return [];
            }

            // 2. validate the $action name
            if (!in_array($action, $allowed_actions)) {
                return $faq_group_items;
            }
            $faq_repo = new \HelpieFaq\Includes\Repos\Faq();

            for ($ii = 0; $ii < count($faq_group_items); $ii++) {
                $faq_item = isset($faq_group_items[$ii]['faq_item']) ? $faq_group_items[$ii]['faq_item'] : '';

                // continue the loop, if not found faq or not match post ID
                if (!isset($faq_item) || $post->ID != $faq_item['post_id']) {
                    continue;
                }

                if ($action == 'remove') {
                    unset($faq_group_items[$ii]);
                    // reindexing FAQ Group Items
                    $faq_group_items = array_values($faq_group_items);
                } else if ($action === 'update') {
                    $faq_group_items[$ii]['faq_item'] = $faq_repo->get_post_content($post);
                }

            }

            return $faq_group_items;
        }

        public function get_faq_group_items(int $term_id)
        {
            $term_meta = get_term_meta($term_id, 'helpie_faq_group_items');
            $faq_group_items = isset($term_meta[0]['faq_groups']) ? $term_meta[0]['faq_groups'] : [];
            return $faq_group_items;
        }

        public function get_posts_by_term_id(int $term_id)
        {
            $post_args = array(
                'post_type' => 'helpie_faq',
                'numberposts' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'helpie_faq_group',
                        'field' => 'term_id',
                        'terms' => $term_id,
                        'include_children' => false,
                    ),
                ),
            );

            $posts = get_posts($post_args);
            return $posts;
        }

        public function get_post_ids_from_faq_group($args)
        {
            $post_ids = array();
            $term_id = isset($args['group_id']) ? $args['group_id'] : '';
            if (empty($term_id)) {
                return $post_ids;
            }

            $faq_group_items = $this->get_faq_group_items($term_id);

            if (isset($faq_group_items) && empty($faq_group_items) && count($faq_group_items) == 0) {
                return $post_ids;
            }

            for ($ii = 0; $ii < count($faq_group_items); $ii++) {
                $faq = isset($faq_group_items[$ii]['faq_item']) ? $faq_group_items[$ii]['faq_item'] : '';
                if (isset($faq) && !empty($faq)) {
                    $post_ids[] = (isset($faq['post_id']) && !empty($faq['post_id'])) ? $faq['post_id'] : '';
                }
            }

            return $post_ids;
        }

    }
}
