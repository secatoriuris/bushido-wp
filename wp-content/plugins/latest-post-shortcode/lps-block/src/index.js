/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */

import {
	registerBlockType,
	unstable__bootstrapServerSideBlockDefinitions as bootstrapServerSideBlockDefinitions,
} from '@wordpress/blocks';

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from '../block.json';
import Edit from './edit';
import save from './save';

const { name } = metadata;
bootstrapServerSideBlockDefinitions({ [name]: metadata });

const el = wp.element.createElement;
const iconEl = el(
	'span',
	{
		className: 'lps-icon-wrap',
	},
	el(
		'svg',
		{
			width: 22,
			height: 22,
			viewBox: '0 0 1260 1260',
			xmlns: 'http://www.w3.org/2000/svg',
		},
		el('path', {
			d:
				'M445 1260l370 0 0 -630 -370 0 0 630zm-445 0l371 0 0 -630 -371 0 0 630zm73 -234l225 0 0 156 -225 0 0 -156zm-73 -790l1260 0 0 -236 -1260 0 0 236zm612 -158l520 0 0 80 -520 0 0 -80zm-612 473l1260 0 0 -236 -1260 0 0 236zm612 -158l520 0 0 80 -520 0 0 -80zm277 867l371 0 0 -630 -371 0 0 630zm74 -234l224 0 0 156 -224 0 0 -156zm-445 0l224 0 0 156 -224 0 0 -156z',
		})
	)
);

/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/#registering-a-block
 */
registerBlockType('latest-post-shortcode/lps-block', {
	/**
	 * This is the display title for your block, which can be translated with `i18n` functions.
	 * The block inserter will show this name.
	 */
	title: __('LPS / Latest Post Shortcode', 'lps'),

	/**
	 * This is a short description for your block, can be translated with `i18n` functions.
	 * It will be shown in the Block Tab in the Settings Sidebar.
	 */
	description: __('Dynamic custom selection', 'lps'),

	/**
	 * Blocks are grouped into categories to help users browse and discover them.
	 * The categories provided by core are `common`, `embed`, `formatting`, `layout` and `widgets`.
	 */
	category: 'widgets',

	/**
	 * An icon property should be specified to make it easier to identify a block.
	 * These can be any of WordPress’ Dashicons, or a custom svg element.
	 */
	icon: iconEl,

	/**
	 * Optional block extended support features.
	 */
	supports: {
		// Removes support for an HTML mode.
		html: false,
		anchor: true,
		align: ['full', 'wide', 'center'],
	},

	/**
	 * @see ./edit.js
	 */
	edit: Edit,

	/**
	 * @see ./save.js
	 */
	save,
});
