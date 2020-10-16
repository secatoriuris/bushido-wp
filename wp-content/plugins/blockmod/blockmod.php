<?php
/*
Plugin Name: Group Block Mod
*/

function blockmod_enqueue() {
    wp_enqueue_script(
        'blockmod-script',
        plugins_url( 'blockmod.js', __FILE__ )
    );
}
add_action( 'enqueue_block_editor_assets', 'blockmod_enqueue' );