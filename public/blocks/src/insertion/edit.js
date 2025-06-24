import { __ } from '@wordpress/i18n';
import { useBlockProps, useInnerBlocksProps, InspectorControls, PanelColorSettings } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';

import './editor.scss';

const TEMPLATE = [
	[
		'core/paragraph',
		{
			placeholder: __(
				'Введите / чтобы добавить блок',
				'kedr-theme'
			),
		},
	],
];

export default function Edit( props ) {
	const classes = [];

	if ( props.backgroundColor?.class ) {
		classes.push( props.backgroundColor.class );
	}

	const blockProps = useBlockProps( {
		className: classes.join( ' ' ),
	} );

	const innerBlocksProps = useInnerBlocksProps( blockProps, {
		template: TEMPLATE,
		__experimentalCaptureToolbars: true,
	} );

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
			</InspectorControls>

			<div { ...blockProps }>
				{ innerBlocksProps.children }
			</div>
		</Fragment>
	);
}
