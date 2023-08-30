import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder } from '@wordpress/components';
import { useState } from '@wordpress/element';

export default function Edit( { attributes, setAttributes, onFocus } ) {
	const [ link, setLink ] = useState( attributes.link );
	const blockProps = useBlockProps();

	const onChange = ( event ) => {
		setLink( event.target.value );
		setAttributes( { link: event.target.value } );
	};

	return (
		<div { ...blockProps }>
			<Placeholder
				icon="archive"
				label={ __( 'Читайте также', 'kedr-theme' ) }
				onFocus={ onFocus }
				instructions={ __(
					'Вставьте ссылку на запись с этого сайта',
					'kedr-theme'
				) }
			>
				<form>
					<input
						type="url"
						value={ link || '' }
						className="components-placeholder__input"
						placeholder={ __(
							'Ссылка на запись…',
							'kedr-theme'
						) }
						onChange={ onChange }
					/>
				</form>
				<div className="components-placeholder__learn-more">
					<p>
						{ __(
							'На страницу автоматически подгрузится заголовок, изображение и отрывок записи',
							'kedr-theme'
						) }
					</p>
				</div>
			</Placeholder>
		</div>
	);
}
