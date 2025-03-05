<?php

/**
 * Summary: php file which implements customizations related to permissions
 */


function gmuw_fs_roles_and_caps_setup() {

    // set up mason_user role. this role is intended for regular Mason users of this system

    // first, remove the role if it exists
    remove_role('mason_user');

    // then re-add the role
    add_role('mason_user','Mason User',array());

    // add the read and upload_files capability to the role
	get_role('mason_user')->add_cap('read');
	get_role('mason_user')->add_cap('upload_files');

}

function gmuw_fs_roles_and_caps_cleanup() {

    // portal_user
    remove_role('mason_user');

}

/**
 * gmuw_fs_allow_edit_posts_for_mason_users_for_attachments()
 *
 * Filter on the current_user_can() function.
 * This function is used to explicitly allow mason_users to have the capablity to edit their own attachment posts, without giving them the edit_posts capablity generally (which would give them more permissions than we want). This enables them to make use of the enable media replace plugin on the attachment edit page for their own uploaded files.
 *
 * @param array $allcaps All the capabilities of the user
 * @param array $cap     [0] Required capability
 * @param array $args    [0] Requested capability
 *                       [1] User ID
 *                       [2] Associated object ID
 */
add_filter( 'user_has_cap', 'gmuw_fs_allow_edit_posts_for_mason_users_for_attachments', 10, 3 );
function gmuw_fs_allow_edit_posts_for_mason_users_for_attachments( $allcaps, $cap, $args ) {

	//bail out if we're not asking about editing a post
	if ('edit_post' != $args[0])
		return $allcaps;

	//bail out if user isn't a mason_user (have mason_user capability)
	if (!isset($allcaps['mason_user']))
		return $allcaps;

	//bail out if mason_user capability is false
	if ($allcaps['mason_user']!=1)
		return $allcaps;

	//load the post data
	$mypost = get_post($args[2]);

	//bail if no post
	if (empty($mypost))
		return $allcaps;

	//bail out if the post is not an attachment
	if ($mypost->post_type!='attachment')
		return $allcaps;

	//if we're still here, this user is a mason_user, and the system is asking whether they have the capability to edit a particular attachment post
	//add the edit_posts capability
	$allcaps['edit_posts']=1;

	//also, check to see if this post is for a website that this user has manage permissions for
	//what site does this file belong to?
	$related_website=$mypost->attachment_related_website;
	//what sites can this user manage files for?
	$user_website_ids = get_field('user_websites_admin','user_'.$args[1]);
	//if we have any admin websites, is the related website in the list of websites that this user can manage files for?
	if (is_array($user_website_ids) && in_array($related_website,$user_website_ids)) {
		//allow user to edit this post
		$allcaps['edit_others_posts']=1;
	}

	//return capabilities
	return $allcaps;

}
