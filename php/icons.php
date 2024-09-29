<?php

/**
 * Summary: php file which implements customizations related to custom icons
 */


//function to return SVG icons (icons from https://icon-sets.iconify.design/)
function gmuw_fs_icon($icon=''){

	//initialize return value
	$return_value='';

	switch($icon){
		case 'pdf':
			$return_value.='<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="none" stroke="#ff0000"><path d="m11.79 10.673l-.058.265a9.8 9.8 0 0 1-1.368 3.286m1.425-3.551l.467-2.136c.162-.738-.556-1.316-1.11-.894c-.297.226-.407.665-.26 1.037l.246.617q.286.719.657 1.376Zm0 0a10.4 10.4 0 0 0 2.064 2.596m0 0l2.255-.286c.632-.08 1.09.671.806 1.32c-.207.474-.721.649-1.121.382l-.851-.568a9.4 9.4 0 0 1-1.089-.848Zm0 0l-.095.013a12.3 12.3 0 0 0-3.394.942m0 0q-.626.274-1.228.618l-1.706.975c-.475.271-.577.994-.202 1.423c.332.379.88.338 1.165-.087l1.91-2.837z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.792 21.25h8.416a3.5 3.5 0 0 0 3.5-3.5v-5.53a3.5 3.5 0 0 0-1.024-2.475l-5.969-5.97A3.5 3.5 0 0 0 10.24 2.75H7.792a3.5 3.5 0 0 0-3.5 3.5v11.5a3.5 3.5 0 0 0 3.5 3.5"/></g></svg>';
			break;
		case 'doc':
			$return_value.='<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="#0080c0" d="M12 2v6.5a1.5 1.5 0 0 0 1.5 1.5H20v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm2.064 10.649l-.564 1.503l-.47-1.253c-.357-.952-1.703-.952-2.06 0l-.47 1.253l-.564-1.503a1 1 0 0 0-1.872.702l1.406 3.75c.357.952 1.703.952 2.06 0l.47-1.253l.47 1.253c.357.952 1.703.952 2.06 0l1.406-3.75a1 1 0 0 0-1.872-.702M14 2.043a2 2 0 0 1 1 .543L19.414 7a2 2 0 0 1 .543 1H14z"/></g></svg>';
			break;
		case 'image':
			$return_value.='<svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="#008040" d="m14 2l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm4 18V9h-5V4H6v16zm-1-7v6H7l5-5l2 2m-4-5.5A1.5 1.5 0 0 1 8.5 12A1.5 1.5 0 0 1 7 10.5A1.5 1.5 0 0 1 8.5 9a1.5 1.5 0 0 1 1.5 1.5"/></svg>';
			break;
	}

	//return value
	return $return_value;

}

//function to map mime types to icon slugs
function gmuw_fs_mime_type_icon($mime_type=''){

	//initialize return value
	$return_value='';

	switch($mime_type){
		case 'image/png':
			$return_value='image';
			break;
		case 'application/pdf':
			$return_value='pdf';
			break;
		case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
			$return_value='doc';
			break;
	}

	//return value
	return $return_value;

}
