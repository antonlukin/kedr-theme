import { __ } from '@wordpress/i18n';
import { registerBlockStyle } from '@wordpress/blocks';

import './editor.scss';

registerBlockStyle( 'core/heading', {
	name: 'separator',
	label: __( 'Разделитель', 'kedr-theme' ),
} );
