jQuery(document).ready(function(){

	//alert('file loaded');

	//hide upload form
	jQuery('.media-upload-form').hide();

	//add checkbox to show the upload form
	jQuery('.media-upload-form').before(
		'<h2>Confirm</h2>',
		'<p><strong>Before uploading files, please confirm using the checkbox below.</strong></p>',
		'<p>I promise to only upload files which meet the file hosting guidelines: <input type="checkbox" id="upload_certification" /></p>'
	);

    //handle upload checkbox confirmation
    jQuery('#upload_certification').on('change',function(){

		//if checkbox is checked
        if (jQuery(this).is(':checked')) {

			//show upload form
			jQuery('.media-upload-form').show();

        } else {

			//hide upload form
			jQuery('.media-upload-form').hide();

        }

    });

});
