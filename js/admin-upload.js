jQuery(document).ready(function(){

	//alert('file loaded');

	//hide upload form
	jQuery('.media-upload-form').hide();

	//add checkbox to show the upload form
	jQuery('.media-upload-form').before(
		'<div class="gmuw_fileshare_upload_attestation">\
		<h2>Verify Accessibility and Web Standards Compliance</h2>\
		<p>By uploading this document, you confirm that this document:</p>\
		<ul>\
		<li><input type="checkbox" class="upload_attestation" id="upload_attestation_1" /> Cannot be easily converted into standard web content.</li>\
		<li><input type="checkbox" class="upload_attestation" id="upload_attestation_2" /> Is essential to official university communication and must retain original formatting (e.g., a printable form, policy, or report).</li>\
		<li><input type="checkbox" class="upload_attestation" id="upload_attestation_3" /> Does not collect or transmit sensitive or privileged information.</li>\
		<li><input type="checkbox" class="upload_attestation" id="upload_attestation_4" /> Meets WCAG 2.1 AA accessibility standards.</li>\
		</ul>\
		<p>If the document does not meet <strong>all</strong> of these conditions, do not upload it to Web Docs.</p>\
		</div>',
	);

    //handle upload checkbox confirmation
    jQuery('.upload_attestation').on('change',function(){

		//if all checkboxes are checked
        if (
			jQuery('#upload_attestation_1').is(':checked') &&
			jQuery('#upload_attestation_2').is(':checked') &&
			jQuery('#upload_attestation_3').is(':checked') &&
			jQuery('#upload_attestation_4').is(':checked')
        ) {

			//show upload form
			jQuery('.media-upload-form').show();

        } else {

			//hide upload form
			jQuery('.media-upload-form').hide();

        }

    });

});
