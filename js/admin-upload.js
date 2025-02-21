jQuery(document).ready(function(){

	//alert('file loaded');

	//disable upload buttons (regular upload form and the basic browser uploader)
	jQuery('#plupload-browse-button, #async-upload, #html-upload').prop('disabled',true);

	//get user to confirm in orer to re-enable the buttons
	if (confirm('Do you promise to only upload good things?')) {

		//re-enable buttons
		jQuery('#plupload-browse-button, #async-upload, #html-upload').prop('disabled',false);

	}

});
