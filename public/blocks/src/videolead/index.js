import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { TextareaControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';

const KedrThemeVideolead = ( { metaKey } ) => {
	const format = useSelect( ( select ) =>
		select( 'core/editor' ).getEditedPostAttribute( 'format' ),
	);

	const meta = useSelect( ( select ) =>
		select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
	);

	const { editPost } = useDispatch( 'core/editor', [ meta ] );

	return (
		<>
			{ format === 'video' &&
			<PluginDocumentSettingPanel
				name="kedr-videolead-panel"
				title={ __( 'Описание видео', 'kedr-theme' ) }
			>
				<TextareaControl
					label={ __( 'Альтернативный лид', 'kedr-theme' ) }
					help={ __( 'Текст будет отображаться в виджете', 'kedr-theme' ) }
					value={ meta[ metaKey ] }
					onChange={ ( value ) => {
						editPost( {
							meta: { [ metaKey ]: value },
						} );
					} }>
				</TextareaControl>
			</PluginDocumentSettingPanel>
			}
		</>
	);
};

registerPlugin( 'kedr-theme-videolead', {
	render: () => {
		return (
			<KedrThemeVideolead metaKey={ window.kedr_theme_videolead?.meta } />
		);
	},
} );
