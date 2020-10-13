/**
 * Dependencies
 */
import { __ } from '@wordpress/i18n';
import { Button, PanelBody } from '@wordpress/components';
import { RichText, InspectorControls } from '@wordpress/block-editor';
import { compose, withInstanceId } from '@wordpress/compose';
import ServerSideRender from '@wordpress/server-side-render';

/**
 * Module Constants
 */

function GetBlockIndexOnPage(blocksList, clientId) {
	let occurrences = blocksList.map(function (item) {
		const name = wp.data.select('core/block-editor').getBlockName(item);
		if (name === 'latest-post-shortcode/lps-block') {
			return item;
		}
		return '';
	});
	occurrences = occurrences.filter(
		(value) => Object.keys(value).length !== 0
	);
	return occurrences.indexOf(clientId);
}

function Edit({ attributes, setAttributes, className, clientId }) {
	const { lpsContent = '' } = attributes;

	const postId = wp.data.select('core/editor').getCurrentPostId();
	const blocksList = wp.data
		.select('core/block-editor')
		.getClientIdsWithDescendants();
	const nthOfType = GetBlockIndexOnPage(blocksList, clientId);
	setAttributes({ nthOfType });

	const handleClick = () => {
		const lpsCustomBlockId = wp.data
			.select('core/block-editor')
			.getSelectedBlock();
		LPS_generator.openBlockPopup(lpsCustomBlockId, lpsContent); // eslint-disable-line
	};

	const handleOnChange = (newLpsContent) => {
		setAttributes({ lpsContent: newLpsContent });
	};
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Latest Post Shortcode Settings', 'lps')}>
					<p>
						{__(
							'Click the button below to use the shortcode UI, or change the attributes manually.',
							'lps'
						)}
					</p>

					<Button
						className="lps-block-settings-button"
						label={__('Latest Post Shortcode', 'lps')}
						onClick={handleClick}
					>
						{__('Shortcode Options', 'lps')}
					</Button>

					<RichText
						tagName="p"
						className={className + ' lps-block-settings-controls'}
						value={attributes.lpsContent}
						onChange={handleOnChange}
					/>
				</PanelBody>
			</InspectorControls>

			<ServerSideRender
				block="latest-post-shortcode/lps-block"
				setAttributes={setAttributes}
				className={className}
				attributes={{
					lpsContent,
					lpsBlockName: 'latest-post-shortcode/lps-block',
					postId,
					nthOfType,
					clientId,
				}}
			/>
		</>
	);
}

export default compose([withInstanceId])(Edit);
