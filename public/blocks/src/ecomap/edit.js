import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder } from '@wordpress/components';

export default function Edit() {
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps }>
			<Placeholder
				icon="admin-site"
				label={ __( 'Экокарта', 'kedr-theme' ) }
			>
				<div className="components-placeholder__learn-more">
					<p>
						{ __(
							'На страницу автоматически подгрузится две последние записи Экологической карты',
							'kedr-theme'
						) }
					</p>
				</div>
			</Placeholder>
		</div>
	);
}
