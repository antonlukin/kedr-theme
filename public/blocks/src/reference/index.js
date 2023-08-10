import {
	registerFormatType,
	toggleFormat,
	applyFormat,
} from '@wordpress/rich-text';
import { BlockControls } from '@wordpress/block-editor';
import {
	Popover,
	TextareaControl,
	ToolbarGroup,
	ToolbarButton,
} from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import metadata from './block.json';

import './editor.scss';

const ReferenceButton = ( { isActive, value, onChange, activeAttributes } ) => {
	const label = isActive
		? __( 'Удалить аннотацию', 'kedr-theme' )
		: __( 'Добавить аннотацию', 'kedr-theme' );

	const onToggle = () => {
		onChange( toggleFormat( value, { type: metadata.name } ) );
	};

	const onTextAreaChange = ( text ) => {
		onChange(
			applyFormat( value, {
				type: metadata.name,
				attributes: {
					'data-reference': text,
				},
			} )
		);
	};

	return (
		<BlockControls>
			<ToolbarGroup>
				<ToolbarButton
					icon="admin-comments"
					label={ label }
					onClick={ onToggle }
					isPressed={ isActive }
				/>
			</ToolbarGroup>
			{ isActive && (
				<Popover
					position="bottom center"
					className="wp-block-kedr-popover"
					expandOnMobile={ true }
				>
					<TextareaControl
						value={ activeAttributes[ 'data-reference' ] ?? '' }
						onChange={ onTextAreaChange }
						placeholder={ __(
							'Введите текст аннотации',
							'kedr-theme'
						) }
					/>
				</Popover>
			) }
		</BlockControls>
	);
};

registerFormatType( metadata.name, {
	title: __( 'Add Tooltip', 'kedr-theme' ),
	tagName: 'span',
	className: 'wp-block-kedr-reference',
	attributes: {
		'data-reference': 'data-reference',
	},
	edit: ReferenceButton,
} );
