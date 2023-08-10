import { registerBlockType } from '@wordpress/blocks';
import { withColors } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import Edit from './edit';
import save from './save';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: withColors( 'backgroundColor' )( Edit ),
	save,
} );
