import { RichText, useBlockProps } from '@wordpress/block-editor';

import './editor.scss';

export default function save( props ) {
	const blockProps = useBlockProps.save();

	return (
		<blockquote { ...blockProps }>
			<figure>
				{ props.attributes.imageId &&
					<picture>
						<img src={ props.attributes.imageUrl } alt="" />
					</picture>
				}

				<RichText.Content
					tagName="figcaption"
					value={ props.attributes.citation }
				/>
			</figure>

			<RichText.Content
				tagName="p"
				value={ props.attributes.content }
			/>
		</blockquote>
	);
}
