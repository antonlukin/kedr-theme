import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { ToggleControl, PanelBody, PanelRow } from '@wordpress/components';
import { Fragment } from '@wordpress/element';

import './editor.scss';

export default function Edit( props ) {
	const classes = [];

	if ( props.backgroundColor?.class ) {
		classes.push( props.backgroundColor.class );
	}

	if ( props.attributes?.italic ) {
		classes.push( 'has-italic-font' );
	}

	const blockProps = useBlockProps( {
		className: classes.join( ' ' ),
	} );

	const onChangeContent = ( newContent ) => {
		props.setAttributes( { content: newContent } );
	};

	return (
		<Fragment>
			<InspectorControls>
				<PanelColorSettings
					title={ __( 'Настройки цветов', 'kedr-theme' ) }
					colorSettings={ [
						{
							value: props.backgroundColor.color,
							onChange: props.setBackgroundColor,
							label: __( 'Цвет фона блока', 'kedr-theme' ),
						},
					] }
				/>

				<PanelBody title={ __( 'Настойки отображения', 'kedr-theme' ) }>
					<PanelRow>
						<ToggleControl
							label={ __( 'Использовать курсив', 'kedr-theme' ) }
							checked={ props.attributes.italic }
							onChange={ ( value ) => props.setAttributes( { italic: value } ) }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<RichText
					tagName="p"
					onChange={ onChangeContent }
					allowedFormats={ [ 'core/bold', 'core/link', 'kedr/reference' ] }
					value={ props.attributes.content }
					placeholder={ __( 'Введите текст справки', 'kedr-theme' ) }
				/>
			</div>
		</Fragment>
	);
}
