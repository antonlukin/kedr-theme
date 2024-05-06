import { registerPlugin } from '@wordpress/plugins';
import { useDispatch } from '@wordpress/data';
import { store as editPostStore } from '@wordpress/post';

const KedrThemeComments = () => {
	const { removeEditorPanel } = useDispatch( editPostStore );

	removeEditorPanel( 'discussion-panel' );
};

registerPlugin( 'kedr-theme-comments', {
	render: () => {
		return (
			<KedrThemeComments />
		);
	},
} );
