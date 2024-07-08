import { useSelect, useDispatch } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import { registerPlugin } from '@wordpress/plugins';

const KedrTitleLimit = () => {
	const [ loaded, setLoaded ] = useState( false );

	const postTitle = useSelect( ( select ) => {
		return select( 'core/editor' ).getEditedPostAttribute( 'title' );
	} );

	const { editPost } = useDispatch( 'core/editor' );

	useEffect( () => {
		if ( loaded ) {
			const maxTitleLength = 130;

			if ( postTitle.length > maxTitleLength ) {
				editPost( { title: postTitle.substring( 0, maxTitleLength ) } );
			}
		}

		setLoaded( true );
	}, [ postTitle ] ); // eslint-disable-line
};

registerPlugin( 'kedr-title-limit', {
	render: () => {
		return (
			<KedrTitleLimit />
		);
	},
} );
