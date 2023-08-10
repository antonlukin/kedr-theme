import { useBlockProps, RichText, getColorClassName } from '@wordpress/block-editor';

export default function save( props ) {
	const classes = [];
	const colorClass = getColorClassName( 'background-color', props.attributes.backgroundColor );

	if ( colorClass ) {
		classes.push( colorClass );
	}

	if ( props.attributes.italic ) {
		classes.push( 'has-italic-font' );
	}

	const blockProps = useBlockProps.save( {
		className: classes.join( ' ' ),
	} );

	return (
		<div { ...blockProps }>
			<RichText.Content
				tagName="p"
				value={ props.attributes.content }
			/>
		</div>
	);
}
