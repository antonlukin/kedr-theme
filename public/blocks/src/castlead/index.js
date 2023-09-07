import { __ } from '@wordpress/i18n';
import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { TextareaControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';

const KedrThemecastlead = () => {
	const termId = Number( window.kedr_theme_castlead?.term || 0 );
	const metaKey = window.kedr_theme_castlead?.meta;

	const meta = useSelect( ( select ) =>
		select( 'core/editor' ).getEditedPostAttribute( 'meta' ),
	);

	const hidden = useSelect( ( select ) => {
		const categories = select( 'core/editor' ).getEditedPostAttribute( 'categories' ) || [];

		return ! categories.includes( termId );
	} );

	const { editPost } = useDispatch( 'core/editor', [ meta ] );

	return (
		<>
			{ ! hidden && (
				<PluginDocumentSettingPanel
					name="kedr-castlead-panel"
					title={ __( 'Номер эпизода', 'kedr-theme' ) }
				>
					<TextareaControl
						label={ __( 'Сезон и выпуск подкаста', 'kedr-theme' ) }
						help={ __( 'Текст будет отображаться в виджете', 'kedr-theme' ) }
						value={ meta[ metaKey ] }
						onChange={ ( value ) => {
							editPost( {
								meta: { [ metaKey ]: value },
							} );
						} }>
					</TextareaControl>
				</PluginDocumentSettingPanel>
			) }
		</>
	);
};

registerPlugin( 'kedr-theme-castlead', {
	render: () => {
		return (
			<KedrThemecastlead />
		);
	},
} );
