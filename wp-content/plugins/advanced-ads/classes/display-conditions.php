<?php

/**
 * Display Conditions under which to (not) show an ad
 *
 * @since 1.7
 *
 */
class Advanced_Ads_Display_Conditions {

    /**
     *
     * @var Advanced_Ads_Display_Conditions
     */
    protected static $instance;

    /**
     * registered display conditions
     */
    public $conditions;

    /**
     * start of name in form elements
     */
    const FORM_NAME = 'advanced_ad[conditions]';

    protected static $query_var_keys = array(
	// 'is_single',
	'is_archive',
	'is_search',
	'is_home',
	'is_404',
	'is_attachment',
	'is_singular',
	'is_front_page',
	'is_feed'
    );
    
    // this is how the general conditions should look like by default
    protected static $default_general_keys = array(
	'is_front_page',
	'is_singular',
	'is_archive',
	'is_search',
	'is_404',
	'is_attachment',
	'is_main_query',
	'is_feed'
    );

    private function __construct() {

	// register filter
	add_filter('advanced-ads-ad-select-args', array($this, 'ad_select_args_callback'));
	add_filter('advanced-ads-can-display', array($this, 'can_display'), 10, 2);

	// register conditions with init hook
	add_action( 'init', array($this, 'register_conditions'), 10 );
    }
    
    /**
     * register display conditions
     * 
     * @since 1.7.1.4
     */
    public function register_conditions(){
	$conditions = array(
	    'posttypes' => array(// post types condition
		'label' => __('post type', 'advanced-ads'),
		'description' => __('Choose the public post types on which to display the ad.', 'advanced-ads'),
		'metabox' => array('Advanced_Ads_Display_Conditions', 'metabox_post_type'), // callback to generate the metabox
		'check' => array('Advanced_Ads_Display_Conditions', 'check_post_type'), // callback for frontend check
	    // 'helplink' => ADVADS_URL . 'manual/display-ads-either-on-mobile-or-desktop/#utm_source=advanced-ads&utm_medium=link&utm_campaign=edit-visitor-mobile' // link to help section
	    ),
	    'postids' => array(// post id condition
		'label' => __('specific pages', 'advanced-ads'),
		'description' => __('Choose on which individual posts, pages and public post type pages you want to display or hide ads.', 'advanced-ads'),
		'metabox' => array('Advanced_Ads_Display_Conditions', 'metabox_post_ids'), // callback to generate the metabox
		'check' => array('Advanced_Ads_Display_Conditions', 'check_post_ids'), // callback for frontend check
	    ),
	    'general' => array(// general conditions
		'label' => __('general conditions', 'advanced-ads'),
		// 'description' => __( 'Choose on which individual posts, pages and public post type pages you want to display or hide ads.', 'advanced-ads' ),
		'metabox' => array('Advanced_Ads_Display_Conditions', 'metabox_general'), // callback to generate the metabox
		'check' => array('Advanced_Ads_Display_Conditions', 'check_general'), // callback for frontend check
	    ),
	    'author' => array(// author conditions
		'label' => __('author', 'advanced-ads'),
		// 'description' => __( 'Choose on which individual posts, pages and public post type pages you want to display or hide ads.', 'advanced-ads' ),
		'metabox' => array('Advanced_Ads_Display_Conditions', 'metabox_author'), // callback to generate the metabox
		'check' => array('Advanced_Ads_Display_Conditions', 'check_author'), // callback for frontend check
	    ),
	);

	// register a condition for each taxonomy for posts
	$taxonomies = get_taxonomies(array('public' => true, 'publicly_queryable' => true), 'objects', 'or');	
	foreach ($taxonomies as $_tax) :
	    // check if there are any terms available
	    $terms = get_terms($_tax->name, array('hide_empty' => false, 'number' => 1));
	    if (is_wp_error($terms) || !count($terms) || $_tax->name === 'advanced_ads_groups') {
		continue;
	    }

	    $conditions['taxonomy_' . $_tax->name] = array(
		'label' => $_tax->label,
		// 'description' => sprintf(__( 'Choose terms from the %s taxonomy a post must belong to for showing or hiding ads.', 'advanced-ads' ), $_tax->label ),
		'metabox' => array('Advanced_Ads_Display_Conditions', 'metabox_taxonomy_terms'), // callback to generate the metabox
		'check' => array('Advanced_Ads_Display_Conditions', 'check_taxonomies'), // callback for frontend check
		'taxonomy' => $_tax->name, // unique for this type: the taxonomy name
	    );

	    $conditions['archive_' . $_tax->name] = array(
		'label' => sprintf(__('archive: %s', 'advanced-ads'), $_tax->labels->singular_name),
		// 'description' => sprintf(__( 'Choose on which %s archive page ads are hidden or displayeds.', 'advanced-ads' ), $_tax->label ),
		'metabox' => array('Advanced_Ads_Display_Conditions', 'metabox_taxonomy_terms'), // callback to generate the metabox
		'check' => array('Advanced_Ads_Display_Conditions', 'check_taxonomy_archive'), // callback for frontend check
		'taxonomy' => $_tax->name, // unique for this type: the taxonomy name
	    );
	endforeach;

	$this->conditions = apply_filters('advanced-ads-display-conditions', $conditions);

	ksort($this->conditions);
    }

    /**
     *
     * @return Advanced_Ads_Plugin
     */
    public static function get_instance() {
	// If the single instance hasn't been set, set it now.
	if (null === self::$instance) {
	    self::$instance = new self;
	}

	return self::$instance;
    }

    /**
     * controls frontend checks for conditions
     *
     * @param arr $options options of the condition
     * @param ob $ad Advanced_Ads_Ad
     * @return bool false, if ad can’t be delivered
     */
    static function frontend_check($options = array(), $ad = false) {
	$display_conditions = Advanced_Ads_Display_Conditions::get_instance()->conditions;

	if (is_array($options) && isset( $options['type'] ) && isset($display_conditions[$options['type']]['check'])) {
	    $check = $display_conditions[$options['type']]['check'];
	} else {
	    return true;
	}

	// call frontend check callback
	if (method_exists($check[0], $check[1])) {
	    return call_user_func(array($check[0], $check[1]), $options, $ad);
	}

	return true;
    }
    
    /**
     * render connector option
     * 
     * @since 1.7.0.4
     * @param int $index
     */
    static function render_connector_option( $index = 0, $value = 'or' ){
	
	$label = ( $value === 'or' ) ? __( 'or', 'advanced-ads' ) : __( 'and', 'advanced-ads' );
	
	return '<input type="checkbox" name="' . self::FORM_NAME . '[' . $index . '][connector]' . '" value="or" id="advads-conditions-' . 
		$index . '-connector"' .
		checked( 'or', $value, false ) 
		.'><label for="advads-conditions-' . $index . '-connector">' . $label . '</label>';
    }

    /**
     * callback to display the metabox for the post type condition
     *
     * @param arr $options options of the condition
     * @param int $index index of the condition
     */
    static function metabox_post_type($options, $index = 0) {

	if (!isset($options['type']) || '' === $options['type']) {
	    return;
	}

	$type_options = self::get_instance()->conditions;

	if (!isset($type_options[$options['type']])) {
	    return;
	}

	// form name basis
	$name = self::FORM_NAME . '[' . $index . ']';

	// options
	?><input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $options['type']; ?>"/><?php
	// set defaults
	$post_types = get_post_types(array('public' => true, 'publicly_queryable' => true), 'object', 'or');
	?><div class="advads-conditions-single advads-buttonset"><?php
	foreach ($post_types as $_type_id => $_type) {
	    if (isset($options['value']) && is_array($options['value']) && in_array($_type_id, $options['value'])) {
		$_val = 1;
	    } else {
		$_val = 0;
	    }
	    ?><label class="button" for="advads-conditions-<?php echo $index; ?>-<?php echo $_type_id;
	    ?>"><?php echo $_type->label; ?></label><input type="checkbox" id="advads-conditions-<?php echo $index; ?>-<?php echo $_type_id; ?>" name="<?php echo $name; ?>[value][]" <?php checked($_val, 1); ?> value="<?php echo $_type_id; ?>"><?php
	    }
	    ?><p class="advads-conditions-not-selected advads-error-message" display="none"><?php _ex( 'Please select some items.', 'Error message shown when no display condition term is selected', 'advanced-ads' ); ?></p></div><?php
	       }

	       /**
		* callback to display the metabox for the author condition
		*
		* @param arr $options options of the condition
		* @param int $index index of the condition
		*/
	       static function metabox_author($options, $index = 0) {

		   if (!isset($options['type']) || '' === $options['type']) {
		       return;
		   }

		   $type_options = self::get_instance()->conditions;

		   if (!isset($type_options[$options['type']])) {
		       return;
		   }

		   // get values and select operator based on previous settings
		   $operator = ( isset($options['operator']) && $options['operator'] === 'is_not' ) ? 'is_not' : 'is';
		   $values = ( isset($options['value']) && is_array($options['value']) ) ? $options['value'] : array();

		   // form name basis
		   $name = self::FORM_NAME . '[' . $index . ']';
		   ?><input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $options['type']; ?>"/>
	<select name="<?php echo $name; ?>[operator]">
	    <option value="is" <?php selected('is', $operator); ?>><?php _e('show'); ?></option>
	    <option value="is_not" <?php selected('is_not', $operator); ?>><?php _e('hide'); ?></option>
	</select><?php
	// set defaults
	$authors = get_users(array('who' => 'authors', 'orderby' => 'nicename', 'number' => 50));
		   ?><div class="advads-conditions-single advads-buttonset"><?php
	foreach ($authors as $_author) {
	    if (isset($options['value']) && is_array($options['value']) && in_array($_author->ID, $options['value'])) {
		$_val = 1;
	    } else {
		$_val = 0;
	    }
	    ?><label class="button ui-button" for="advads-conditions-<?php echo $index; ?>-<?php echo $_author->ID;
	    ?>"><?php echo $_author->display_name; ?></label><input type="checkbox" id="advads-conditions-<?php echo $index; ?>-<?php echo $_author->ID; ?>" name="<?php echo $name; ?>[value][]" <?php checked($_val, 1); ?> value="<?php echo $_author->ID; ?>"><?php
	}
	?><p class="advads-conditions-not-selected advads-error-message" display="none"><?php _ex( 'Please select some items.', 'Error message shown when no display condition term is selected', 'advanced-ads' ); ?></p></div><?php
	       }

	       /**
		* callback to display the metabox for the taxonomy archive pages
		*
		* @param arr $options options of the condition
		* @param int $index index of the condition
		*/
	       static function metabox_taxonomy_terms($options, $index = 0) {

		   if (!isset($options['type']) || '' === $options['type']) {
		       return;
		   }

		   $type_options = self::get_instance()->conditions;

		   // don’t use if this is not a taxonomy
		   if (!isset($type_options[$options['type']]) || !isset($type_options[$options['type']]['taxonomy'])) {
		       return;
		   }

		   $taxonomy = get_taxonomy($type_options[$options['type']]['taxonomy']);
		   if (false == $taxonomy) {
		       return;
		   }

		   // get values and select operator based on previous settings
		   $operator = ( isset($options['operator']) && $options['operator'] === 'is_not' ) ? 'is_not' : 'is';
		   $values = ( isset($options['value']) && is_array($options['value']) ) ? $options['value'] : array();

		   // limit the number of terms so many terms don’t break the admin page
		   $max_terms = absint(apply_filters('advanced-ads-admin-max-terms', 50));

		   // form name basis
		   $name = self::FORM_NAME . '[' . $index . ']';
		   ?><input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $options['type']; ?>"/>
	<select name="<?php echo $name; ?>[operator]">
	    <option value="is" <?php selected('is', $operator); ?>><?php _e('show'); ?></option>
	    <option value="is_not" <?php selected('is_not', $operator); ?>><?php _e('hide'); ?></option>
	</select><?php
		   ?><div class="advads-conditions-single advads-buttonset"><?php
	self::display_term_list($taxonomy, $values, $name . '[value][]', $max_terms, $index);
	?></div><?php
	}

	/**
	 * display terms of a taxonomy for choice
	 * 
	 * @param obj $taxonomy taxonomy object
	 * @param arr $checked ids of checked terms
	 * @param str $inputname name of the input field
	 * @param int $max_terms maximum number of terms to show
	 * @param int $index index of the conditions group
	 */
	public static function display_term_list($taxonomy, $checked = array(), $inputname = '', $max_terms = 50, $index = 0) {

	    $terms = get_terms($taxonomy->name, array('hide_empty' => false, 'number' => $max_terms));

	    if (!empty($terms) && !is_wp_error($terms)):
		// display search field if the term limit is reached
		if (count($terms) == $max_terms) :

		    // query active terms
		    if (is_array($checked) && count($checked)) {
			$args = array('hide_empty' => false);
			$args['include'] = $checked;
			$checked_terms = get_terms($taxonomy->name, $args);
			?><div class="advads-conditions-terms-buttons dynamic-search"><?php
		    foreach ($checked_terms as $_checked_term) :
			?><label class="button ui-state-active"><?php echo $_checked_term->name;
			?><input type="hidden" name="<?php echo $inputname; ?>" value="<?php echo $_checked_term->term_id; ?>"></label><?php
			endforeach;
			?></div><?php
			       } else {
				   ?><div class="advads-conditions-terms-buttons dynamic-search"></div><?php
			}
			?><span class="advads-conditions-terms-show-search button" title="<?php
		    _ex('add more terms', 'display the terms search field on ad edit page', 'advanced-ads');
		    ?>">+</span><span class="description"><?php _e('add more terms', 'advanced-ads');
		    ?></span><br/><input type="text" class="advads-conditions-terms-search" data-tag-name="<?php echo $taxonomy->name;
		    ?>" data-input-name="<?php echo $inputname; ?>" placeholder="<?php _e('term name or id', 'advanced-ads'); ?>"/><?php
		  else :
		      ?><div class="advads-conditions-terms-buttons advads-buttonset"><?php
				   foreach ($terms as $_term) :
				       $field_id = "advads-conditions-$index-$_term->term_id";
				       ?><input type="checkbox" id="<?php echo $field_id; ?>" name="<?php echo $inputname; ?>" value="<?php echo $_term->term_id; ?>" <?php checked(in_array($_term->term_id, $checked), true); ?>><label for="<?php echo $field_id; ?>"><?php echo $_term->name; ?></label><?php
		endforeach;
		?><p class="advads-conditions-not-selected advads-error-message" display="none"><?php _ex( 'Please select some items.', 'Error message shown when no display condition term is selected', 'advanced-ads' ); ?></p></div><?php
	    endif;
	endif;
    }

    /**
     * callback to display the metabox for the taxonomy archive pages
     *
     * @param arr $options options of the condition
     * @param int $index index of the condition
     */
    static function metabox_post_ids($options, $index = 0) {

	if (!isset($options['type']) || '' === $options['type']) {
	    return;
	}

	// get values and select operator based on previous settings
	$operator = ( isset($options['operator']) && $options['operator'] === 'is_not' ) ? 'is_not' : 'is';
	$values = ( isset($options['value']) && is_array($options['value']) ) ? $options['value'] : array();

	// form name basis
	$name = self::FORM_NAME . '[' . $index . ']';
	?><input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $options['type']; ?>"/>
	<select name="<?php echo $name; ?>[operator]">
	    <option value="is" <?php selected('is', $operator); ?>><?php _e('show'); ?></option>
	    <option value="is_not" <?php selected('is_not', $operator); ?>><?php _e('hide'); ?></option>
	</select><?php ?><div class="advads-conditions-single advads-buttonset advads-conditions-postid-buttons"><?php
	// query active post ids
	if ($values != array()) {
	    $args = array(
		'post_type' => 'any',
		// 'post_status' => 'publish',
		'post__in' => $values,
		'posts_per_page' => -1,
		    // 'ignore_sticky_posts' => 1,
	    );

	    $the_query = new WP_Query($args);
	    while ($the_query->have_posts()) {
		$the_query->next_post();
		?><label class="button ui-state-active"><?php echo get_the_title($the_query->post->ID) . ' (' . $the_query->post->post_type . ')';
		?><input type="hidden" name="<?php echo $name; ?>[value][]" value="<?php echo $the_query->post->ID; ?>"></label><?php
	    }
	}
	?><span class="advads-conditions-postids-show-search button" <?php
	if (!count($values)) {
	    echo 'style="display:none;"';
	}
	?>>+</span>
	    <p class="advads-conditions-postids-search-line">
		<input type="text" class="advads-display-conditions-individual-post" <?php if (count($values)) {
	    echo 'style="display:none;"';
	} ?>
		       placeholder="<?php _e('title or id', 'advanced-ads'); ?>"
		       data-field-name="<?php echo $name; ?>"/><?php
	wp_nonce_field('internal-linking', '_ajax_linking_nonce', false);
	?></p></div><?php
    }

    /**
     * callback to display the metabox for the general display conditions
     *
     * @param arr $options options of the condition
     * @param int $index index of the condition
     */
    static function metabox_general($options, $index = 0) {

	// general conditions array
	$conditions = self::get_instance()->general_conditions();
	if (!isset($options['type']) || '' === $options['type']) {
	    return;
	}

	$name = self::FORM_NAME . '[' . $index . ']';
	$values = isset($options['value']) ? $options['value'] : array();
	?><div class="advads-conditions-single advads-buttonset">
	    <input type="hidden" name="<?php echo $name; ?>[type]" value="<?php echo $options['type']; ?>"/><?php
		foreach ($conditions as $_key => $_condition) :

		    // activate by default
		    $value = ( $values === array() || in_array($_key, $values) ) ? 1 : 0;

		    $field_id = "advads-conditions-$index-$_key";
		    ?><input type="checkbox" id="<?php echo $field_id; ?>" name="<?php echo $name; ?>[value][]" value="<?php echo $_key; ?>" <?php checked(1, $value); ?>><label for="<?php echo $field_id; ?>"><?php echo $_condition['label']; ?></label><?php
	    endforeach;
	    ?></div><?php
	    return;
	}

	/**
	 * retrieve the array with general conditions
	 * 
	 * @return arr $conditions
	 * 
	 */
	static function general_conditions() {
	    return $conditions = array(
		'is_front_page' => array(
		    'label' => __('Home Page', 'advanced-ads'),
		    'description' => __('show on Home page', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_singular' => array(
		    'label' => __('Singular Pages', 'advanced-ads'),
		    'description' => __('show on singular pages/posts', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_archive' => array(
		    'label' => __('Archive Pages', 'advanced-ads'),
		    'description' => __('show on any type of archive page (category, tag, author and date)', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_search' => array(
		    'label' => __('Search Results', 'advanced-ads'),
		    'description' => __('show on search result pages', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_404' => array(
		    'label' => __('404 Page', 'advanced-ads'),
		    'description' => __('show on 404 error page', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_attachment' => array(
		    'label' => __('Attachment Pages', 'advanced-ads'),
		    'description' => __('show on attachment pages', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_main_query' => array(
		    'label' => __('Secondary Queries', 'advanced-ads'),
		    'description' => __('allow ads in secondary queries', 'advanced-ads'),
		    'type' => 'radio',
		),
		'is_feed' => array(
		    'label' => __('Feed', 'advanced-ads'),
		    'description' => __('allow ads in Feed', 'advanced-ads'),
		    'type' => 'radio',
		)
	    );
	}

	/**
	 * check post type display condition in frontend
	 *
	 * @param arr $options options of the condition
	 * @param obj $ad Advanced_Ads_Ad
	 * @return bool true if can be displayed
	 */
	static function check_post_type($options = array(), Advanced_Ads_Ad $ad) {

	    if (!isset($options['value']) || !is_array($options['value'])) {
		return false;
	    }

	    $ad_options = $ad->options();
	    $query = $ad_options['wp_the_query'];
	    $post = isset($ad_options['post']) ? $ad_options['post'] : null;
	    $post_type = isset($post['post_type']) ? $post['post_type'] : false;

	    if (self::in_array($post_type, $options['value']) === false) {
		return false;
	    }

	    return true;
	}

	/**
	 * check author display condition in frontend
	 *
	 * @param arr $options options of the condition
	 * @param obj $ad Advanced_Ads_Ad
	 * @return bool true if can be displayed
	 */
	static function check_author($options = array(), Advanced_Ads_Ad $ad) {

	    if (!isset($options['value']) || !is_array($options['value'])) {
		return false;
	    }

	    if (isset($options['operator']) && $options['operator'] === 'is_not') {
		$operator = 'is_not';
	    } else {
		$operator = 'is';
	    }

	    $ad_options = $ad->options();
	    $post = isset($ad_options['post']) ? $ad_options['post'] : null;
	    $post_author = isset($post['author']) ? $post['author'] : false;

	    if (!self::can_display_ids($post_author, $options['value'], $operator)) {
		return false;
	    }

	    return true;
	}

	/**
	 * check taxonomies display condition in frontend
	 *
	 * @param arr $options options of the condition
	 * @return bool true if can be displayed
	 */
	static function check_taxonomies($options = array(), Advanced_Ads_Ad $ad) {

	    if( !isset( $options['value']) ){
		return false;
	    }
	    
	    if (isset($options['operator']) && $options['operator'] === 'is_not') {
		$operator = 'is_not';
	    } else {
		$operator = 'is';
	    }

	    $ad_options = $ad->options();
	    $query = $ad_options['wp_the_query'];
	    $post_id = isset($ad_options['post']['id']) ? $ad_options['post']['id'] : null;

	    // get terms of the current taxonomy
	    $type_options = self::get_instance()->conditions;
	    if (!isset($options['type']) || !isset($type_options[$options['type']]['taxonomy'])) {
		return true;
	    }
	    $taxonomy = $type_options[$options['type']]['taxonomy'];

	    $terms = get_the_terms($post_id, $taxonomy);
	    
	    if ( is_array($terms) ) {
		foreach ($terms as $term) {
		    $term_ids[] = $term->term_id;
		}
	    } elseif( false === $terms && 'is' === $operator ) {
		// don’t show if should show only for a specific tag
		return false;
	    } else {
		return true;
	    }

	    if (isset($query['is_singular']) && $query['is_singular'] && !self::can_display_ids($options['value'], $term_ids, $operator) 
	    ) {
		return false;
	    }

	    return true;
	}

	/**
	 * check taxonomy archive display condition in frontend
	 *
	 * @param arr $options options of the condition
	 * @return bool true if can be displayed
	 */
	static function check_taxonomy_archive($options = array(), Advanced_Ads_Ad $ad) {

	    if( !isset( $options['value']) ){
		return false;
	    }
	    
	    if (isset($options['operator']) && $options['operator'] === 'is_not') {
		$operator = 'is_not';
	    } else {
		$operator = 'is';
	    }

	    $ad_options = $ad->options();
	    $query = $ad_options['wp_the_query'];
	    
	    if ( isset($query['term_id']) && isset($query['is_archive']) && $query['is_archive'] && !self::can_display_ids($query['term_id'], $options['value'], $operator)
	    ) {
		return false;
	    }

	    return true;
	}

	/**
	 * check post ids display condition in frontend
	 * 
	 * @param arr $options options of the condition
	 * @return bool true if can be displayed
	 */
	static function check_post_ids($options = array(), Advanced_Ads_Ad $ad) {

	    if (isset($options['operator']) && $options['operator'] === 'is_not') {
		$operator = 'is_not';
	    } else {
		$operator = 'is';
	    }

	    $ad_options = $ad->options();
	    $query = $ad_options['wp_the_query'];
	    $post_id = isset($ad_options['post']['id']) ? $ad_options['post']['id'] : null;

	    if (!isset($options['value']) || !is_array($options['value']) || !$post_id) {
		return true;
	    }

	    return self::can_display_ids($post_id, $options['value'], $operator);
	}

	/**
	 * check general display conditions in frontend
	 *
	 * @param arr $options options of the condition
	 * @param obj $ad Advanced_Ads_Ad
	 * @return bool true if can be displayed
	 */
	static function check_general($options = array(), Advanced_Ads_Ad $ad) {

	    // display by default
	    if (!isset($options['value']) || !is_array($options['value']) || !count($options['value'])) {
		return true;
	    }

	    // skip checks, if general conditions are unchanged
	    if( self::$default_general_keys === $options['value'] ){
		return true;
	    }
	    
	    // get plugin options
	    $plugin_options = Advanced_Ads_Plugin::get_instance()->options();

	    // error_log(print_r($options, true));
	    // error_log(print_r(debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS ), true));

	    $ad_options = $ad->options();
	    $query = $ad_options['wp_the_query'];

	    // check main query
	    if ( isset( $query['is_main_query'] ) && ! $query['is_main_query'] && ! in_array('is_main_query', $options['value'] ) ) {
		    return false;
	    }

	    // check home page
	    if ( ( ( isset($query['is_front_page']) && $query['is_front_page'] ) 
		    || ( isset($query['is_home']) && $query['is_home'] ) )
		    && in_array('is_front_page', $options['value'])
		    ) {
		return true;
	    } elseif (isset($query['is_front_page']) && $query['is_front_page'] && (
		    !in_array('is_front_page', $options['value'])
		    )) {
		return false;
	    }

	    // check common tests
	    foreach (self::$query_var_keys as $_type) {
		if ('is_main_query' !== $_type && isset($query[$_type]) && $query[$_type] &&
			in_array($_type, $options['value'])) {
		    return true;
		}
	    }

	    return false;
	}

	/**
	 * helper function to check for in array values
	 * 
	 * @param mixed $id  scalar (key) or array of keys as needle
	 * @param array $ids haystack
	 *
	 * @return boolean void if either argument is empty
	 */
	static function in_array($id, $ids) {
	    // empty?
	    if (!isset($id) || $id === array()) {
		return;
	    }

	    // invalid?
	    if (!is_array($ids)) {
		return;
	    }

	    return is_array($id) ? array_intersect($id, $ids) !== array() : in_array($id, $ids);
	}

	/**
	 * helper to compare ids
	 * 
	 * @param arr $needle ids that should be searched for in haystack
	 * @param arr $haystack reference ids
	 * @param str $operator whether it should be included or not
	 * @return boolean
	 */
	static function can_display_ids($needle, $haystack, $operator = 'is') {

	    if ('is' === $operator && self::in_array($needle, $haystack) === false) {
		return false;
	    }

	    if ('is_not' === $operator && self::in_array($needle, $haystack) === true) {
		return false;
	    }

	    return true;
	}

	/**
	 * check display conditions
	 *
	 * @since 1.1.0 moved here from can_display()
	 * @since 1.7.0 moved here from display-by-query module
	 * @return bool $can_display true if can be displayed in frontend
	 */
	public function can_display($can_display, $ad) {
	    if (!$can_display) {
		return false;
	    }

	    $options = $ad->options();
	    if (
	    // test if anything is to be limited at all
		    !isset($options['conditions']) || !is_array($options['conditions'])
		    // query arguments required
		    || !isset($options['wp_the_query'])
	    ) {
		return true;
	    }
	    $conditions = $options['conditions'];
	    $query = $options['wp_the_query'];
	    $post = isset($options['post']) ? $options['post'] : null;

	    $last_result = false;
	    $length = count( $conditions );
	    
	    for($i = 0; $i < $length; ++$i) {
		$_condition = current( $conditions );
		// ignore OR if last result was true
		if( $last_result && isset( $_condition['connector'] ) && 'or' === $_condition['connector'] ){
		    next( $conditions );
		    continue;
		}
		$last_result = $result = self::frontend_check($_condition, $ad);
		if( ! $result ) {
		    // return false only, if the next condition doesn’t have an OR operator
		    $next = next( $conditions );
		    if( ! isset( $next['connector'] ) || $next['connector'] !== 'or' ) {
			return false;
		    }
		} else {
		    next( $conditions );
		}
	    }

	    return true;
	}

	/**
	 * On demand provide current query arguments to ads.
	 *
	 * Existing arguments must not be overridden.
	 * Some arguments might be cachable.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function ad_select_args_callback($args) {
	    global $post, $wp_the_query, $wp_query;

	    if (isset($post)) {
		if (!isset($args['post'])) {
		    $args['post'] = array();
		}
		if (!isset($args['post']['id'])) {
		    // if currently on a single site, use the main query information just in case a custom query is broken
		    if( isset( $wp_the_query->post->ID ) && $wp_the_query->is_single() ){
			$args['post']['id'] = $wp_the_query->post->ID;
		    } else {
			$args['post']['id'] = $post->ID;
		    }
		}
		if (!isset($args['post']['author'])) {
		    // if currently on a single site, use the main query information just in case a custom query is broken
		    if( isset( $wp_the_query->post->post_author ) && $wp_the_query->is_single() ){
			$args['post']['author'] = $wp_the_query->post->post_author;
		    } else {
			$args['post']['author'] = $post->post_author;
		    }
		}
		if (!isset($args['post']['post_type'])) {
		    // if currently on a single site, use the main query information just in case a custom query is broken
		    if( isset( $wp_the_query->post->post_type ) && $wp_the_query->is_single() ){
			$args['post']['post_type'] = $wp_the_query->post->post_type;
		    } else {
			$args['post']['post_type'] = $post->post_type;
		    }
		}
	    }

	    // pass query arguments
	    if (isset($wp_the_query)) {
		if (!isset($args['wp_the_query'])) {
		    $args['wp_the_query'] = array();
		}
		$query = $wp_the_query->get_queried_object();
		// term_id exists only for taxonomy archive pages
		if (!isset($args['wp_the_query']['term_id']) && $query) {
		    $args['wp_the_query']['term_id'] = isset($query->term_id) ? $query->term_id : '';
		}

		// query type/ context
		if (!isset($args['wp_the_query']['is_main_query'])) {
		    $args['wp_the_query']['is_main_query'] = Advanced_Ads::get_instance()->is_main_query();
		}

		// query vars
		foreach (self::$query_var_keys as $key) {
		    if (!isset($args['wp_the_query'][$key])) {
			$args['wp_the_query'][$key] = $wp_the_query->$key();
		    }
		}
	    }

	    return $args;
	}

	/**
	 * modify post search query to search by post_title or ID
	 *
	 * @param array $query
	 * @return string
	 */
	public static function modify_post_search( $query ) {
		$query['suppress_filters'] = false;
		$query['orderby'] = 'post_title';
		return $query;
	}

	/**
	 * modify post search sql to search by post_title or ID
	 *
	 * @param string $sql
	 * @return string
	 */
	public static function modify_post_search_sql( $sql ) {
		global $wpdb;

		$sql = preg_replace_callback( "/{$wpdb->posts}.post_(content|excerpt)( NOT)? LIKE '%(.*?)%'/", array( 'Advanced_Ads_Display_Conditions', 'modify_post_search_sql_callback' ), $sql );

		return $sql;
	}

	/**
	 * preg_replace callback used in modify_post_search_sql()
	 *
	 * @param array $matches
	 * @return string
	 */
	public static function modify_post_search_sql_callback( $matches ) {
		global $wpdb;
		if ( $matches[1] === 'content' && preg_match( '@^([0-9]+)$@', $matches[3], $matches_id ) ) {
			$equals_op = $matches[2] === ' NOT' ? '!=' : '=';
			return "{$wpdb->posts}.ID$equals_op$matches_id[1]";
		} else if ( $matches[2] === ' NOT' ) {
			return '1=1';
		} else {
			return '1=0';
		}
	}

    }
    