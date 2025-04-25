<?php
/*
Plugin Name: PMPro Customizations by WPProAtoZ.com
Plugin URI: https://wpproatoz.com
Description: Customizations for Paid Memberships Pro Setup by WPProAtoZ.com
Version: .1
Author: Paid Memberships Pro and WPProAtoZ.com
Author URI: https://wpproatoz.com
*/
 
//Now start placing your customization code below this line

/**
 * Change the "Renew" link under My Memberships 
 * Hide "change" link from some levels (add level id to line 19)
 *
 * Please be aware this is not a thoroughly tested recipe and is therefore considered a "use-at-own-risk" option.
 * 
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */
function customize_change_link_for_pmpro_member_action_links( $pmpro_member_action_links ) {
	
	
	$pmpro_member_action_links['change'] = sprintf(
		/* change "change" URL. */
		'<a id="pmpro_actionlink-renew" href="/product/maappn-annual-membership-dues-full-or-out-of-state/">Become a Full Member</a>'	);

	// For which levels should we remove the "Change" link?
	$levels = array( 2, 3 ); // Level IDs go here

	// Get user's membership levels
	$user_levels = pmpro_getMembershipLevelsForUser();

	// Check level
	foreach ( $user_levels as $key => $level ) {
		if ( in_array( $level->id, $levels, false ) ) {
			unset( $pmpro_member_action_links['change'] );
		}
	}

	return $pmpro_member_action_links;

	

}
add_filter( 'pmpro_member_action_links', 'customize_change_link_for_pmpro_member_action_links' );



/**
 * Example of how to add links to the Member Links list on the Membership Account page.
 *
 * Learn More at: https://www.paidmembershipspro.com/add-links-membership-level-membership-account-page-links-section/
 * 
 * title: Add Links to Members links on Members Account Page 
 * layout: snippet
 * collection: frontend-pages
 * category: members-links
 *
 * You can add this recipe to your site by creating a custom plugin
 * or using the Code Snippets plugin available for free in the WordPress repository.
 * Read this companion article for step-by-step directions on either method.
 * https://www.paidmembershipspro.com/create-a-plugin-for-pmpro-customizations/
 */

// Add links to the top of the list
function my_pmpro_member_links_top() {
	//Add the level IDs here
	if ( pmpro_hasMembershipLevel( array(1,2,3 ) ) ) {
		//Add the links in <li> format here ?>
		<li><a href="/top/">My Member Link Top</a></li>
		<?php
	}
}
add_action( 'pmpro_member_links_top','my_pmpro_member_links_top' );

// Add links to the bottom of the list
function my_pmpro_member_links_bottom() {
	//Add the level IDs here
	if ( pmpro_hasMembershipLevel( array( 1,2,3 ) ) ) {
		//Add the links in <li> format here ?>
		<li><a href="/bottom/">My Member Link Bottom</a></li>
		<?php
	}
}
add_action( 'pmpro_member_links_bottom','my_pmpro_member_links_bottom' );


//added by john via Grok
function change_choose_membership_level_text($text) {
    if ($text == "Choose a membership level.") {
        return "Select Your Membership Plan"; // or any other text you prefer
    }
    return $text;
}
add_filter('pmpro_levels_table_button_text', 'change_choose_membership_level_text');
