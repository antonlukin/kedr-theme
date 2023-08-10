import { __ } from '@wordpress/i18n';
import { RichText, useBlockProps, BlockControls, MediaReplaceFlow } from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';
import { isBlobURL } from '@wordpress/blob';

import './editor.scss';

export default function Edit( props ) {
	const blockProps = useBlockProps();

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
		<blockquote { ...blockProps }>
			<BlockControls group="other">
				<MediaReplaceFlow
					mediaId={ props.attributes.imageId }
					mediaUrl={ props.attributes.imageUrl }
					allowedTypes={ [ 'image' ] }
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
					allowedFormats={ [] }
					value={ props.attributes.citation }
					placeholder={ __( 'Автор цитаты', 'kedr-theme' ) }
				/>
			</figure>

			<RichText
				tagName="p"
				onChange={ onChangeContent }
				allowedFormats={ [ 'core/link' ] }
				value={ props.attributes.content }
				placeholder={ __( 'Введите текст цитаты', 'kedr-theme' ) }
			/>
		</blockquote>
	);
}
