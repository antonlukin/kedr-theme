import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { PluginPostStatusInfo } from '@wordpress/edit-post';
import { CheckboxControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';

import styles from './styles.module.css';

const KedrThemeTopnews = () => {
	const termId = Number( window.kedr_theme_topnews?.term || 0 );
	const metaKey = window.kedr_theme_topnews?.meta;

	const options = useSelect( ( select ) => {
		const editor = select( 'core/editor' );
		const meta = editor.getEditedPostAttribute( 'meta' );

		if ( ! meta ) {
			return null;
		}

		const categories = editor.getEditedPostAttribute( 'categories' ) || [];

		return {
			field: meta[ metaKey ],
			hidden: ! categories.includes( termId ),
		};
	} );

	const field = options !== null ? options.field : null;

	const { editPost } = useDispatch( 'core/editor', [ field ] );

	return (
		<>
			{ field !== null && (
				<CheckboxControl
					className={ options.hidden ? styles.hidden : null }
					label={ __( 'Главная новость', 'kedr-theme' ) }
					checked={ field }
					onChange={ ( checked ) => {
						editPost( {
							meta: { [ metaKey ]: Number( checked ) },
						} );
					} }
					disabled={ options.hidden }
				/>
			) }
		</>
	);
};

registerPlugin( 'kedr-theme-topnews', {
	render: () => {
		return (
			<PluginPostStatusInfo>
				<KedrThemeTopnews />
			</PluginPostStatusInfo>
		);
	},
} );
