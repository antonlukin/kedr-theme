import { useBlockProps, getColorClassName, InnerBlocks } from '@wordpress/block-editor';

export default function save( props ) {
	const classes = [];
	const colorClass = getColorClassName( 'background-color', props.attributes.backgroundColor );

	if ( colorClass ) {
		classes.push( colorClass );
	}

	const blockProps = useBlockProps.save( {
		className: classes.join( ' ' ),
	} );

	return (
		<div { ...blockProps }>
			<InnerBlocks.Content />
		</div>
	);
}
