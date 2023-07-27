import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder, Button } from '@wordpress/components';
import { useState } from '@wordpress/element';

export default function Edit( { attributes, setAttributes, onFocus } ) {
	const [ link, setLink ] = useState( attributes.link );
	const blockProps = useBlockProps();

	const onSubmit = ( event ) => {
		if ( event ) {
			event.preventDefault();
		}

		setAttributes( { link } );
	};

	return (
		<div { ...blockProps }>
			<Placeholder
				icon="archive"
				label={ __( 'Читайте также', 'kedr-gutenberg' ) }
				onFocus={ onFocus }
				instructions={ __(
					'Вставьте ссылку на запись с этого сайта',
					'kedr-gutenberg'
				) }
			>
				<form onSubmit={ onSubmit }>
					<input
						type="url"
						value={ link || '' }
						className="components-placeholder__input"
						placeholder={ __(
							'Ссылка на запись…',
							'kedr-gutenberg'
						) }
						onChange={ ( event ) => setLink( event.target.value ) }
					/>
					<Button variant="primary" type="submit">
						{ __( 'Добавить', 'kedr-gutenberg' ) }
					</Button>
				</form>
				<div className="components-placeholder__learn-more">
					<p>
						{ __(
							'На страницу автоматически подгрузится заголовок, изображение и отрывок записи',
							'kedr-gutenberg'
						) }
					</p>
				</div>
			</Placeholder>
		</div>
	);
}
