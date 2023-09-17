import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, BlockControls, MediaReplaceFlow, InspectorControls } from '@wordpress/block-editor';
import { ToggleControl, Spinner, PanelBody, PanelRow } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import { isBlobURL } from '@wordpress/blob';

import './editor.scss';

export default function Edit( props ) {
	const classes = [];

	if ( props.attributes.onlyAuthor ) {
		classes.push( 'has-only-author' );
	}

	const blockProps = useBlockProps( {
		className: classes.join( ' ' ),
	} );

	const onChangeContent = ( newContent ) => {
		props.setAttributes( { content: newContent } );
	};

	const onChangeCitation = ( newCitation ) => {
		props.setAttributes( { citation: newCitation } );
	};

	const isTemporaryMedia = () => {
		return ! props.attributes.imageId && isBlobURL( props.attributes.imageUrl );
	};

	const setImageAttributes = ( media ) => {
		const fields = {
			imageUrl: null,
			imageId: null,
		};

		if ( media && media.url ) {
			fields.imageUrl = media.url;
			fields.imageId = media.id;
		}

		props.setAttributes( fields );
	};

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody title={ __( 'Настойки отображения', 'kedr-theme' ) }>
					<PanelRow>
						<ToggleControl
							label={ __( 'Показывать только автора', 'kedr-theme' ) }
							checked={ props.attributes.onlyAuthor }
							onChange={ ( value ) => props.setAttributes( { onlyAuthor: value } ) }
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<blockquote { ...blockProps }>
				<BlockControls group="other">
					<MediaReplaceFlow
						mediaId={ props.attributes.imageId }
						mediaUrl={ props.attributes.imageUrl }
						allowedTypes={ [ 'image', 'bold', 'link' ] }
						accept="image/*"
						onSelect={ setImageAttributes }
						name={ __( 'Фото автора', 'kedr-theme' ) }
					/>
				</BlockControls>

				<figure>
					{ isTemporaryMedia() &&
						<Spinner />
					}

					{ props.attributes.imageId &&
						<picture>
							<img src={ props.attributes.imageUrl } alt="" />
						</picture>
					}

					<RichText
						tagName="figcaption"
						onChange={ onChangeCitation }
						allowedFormats={ [ 'core/bold', 'core/italic', 'core/link', 'kedr/reference' ] }
						value={ props.attributes.citation }
						placeholder={ __( 'Автор цитаты', 'kedr-theme' ) }
					/>
				</figure>

				{ ! props.attributes.onlyAuthor &&
					<RichText
						tagName="p"
						onChange={ onChangeContent }
						allowedFormats={ [ 'core/bold', 'core/link', 'kedr/reference' ] }
						value={ props.attributes.content }
						placeholder={ __( 'Введите текст цитаты', 'kedr-theme' ) }
					/>
				}
			</blockquote>
		</Fragment>
	);
}
