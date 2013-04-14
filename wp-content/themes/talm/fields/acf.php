<?php

/**
 *  Install Add-ons
 *  
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *  
 *  All fields must be included during the 'acf/register_fields' action.
 *  Other types of Add-ons (like the options page) can be included outside of this action.
 *  
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme as outlined in the terms and conditions.
 *  However, they are NOT to be included in a premium / free plugin.
 *  For more information, please read http://www.advancedcustomfields.com/terms-conditions/
 */ 

// Champs 
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('add-ons/acf-repeater/repeater.php');
	include_once('add-ons/acf-gallery/gallery.php');
	include_once('add-ons/acf-flexible-content/flexible-content.php');
}

// Page d‘options 
//include_once( 'add-ons/acf-options-page/acf-options-page.php' );


/**
 *  Register Field Groups
 *
 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_chapeau-article',
		'title' => 'Chapeau article',
		'fields' => array (
			array (
				'key' => 'field_50604eefd3b1d',
				'label' => 'Sous-titre',
				'name' => 'sous_titre',
				'type' => 'text',
				'instructions' => 'Permet de mettre un sous-titre comprenant les informations de dates ou de lieu.',
				'default_value' => '',
				'formatting' => 'none',
			),
		),
		'location' => array (
			'rules' => array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_options-talm',
		'title' => 'options TALM',
		'fields' => array (
			array (
				'key' => 'field_505b409bbf3c1',
				'label' => 'Adresse EPCC',
				'name' => 'adresse_epcc',
				'type' => 'wysiwyg',
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
				'the_content' => 'no',
			),
			array (
				'key' => 'field_505b3c09b1042',
				'label' => 'URL vimeo',
				'name' => 'url_vimeo',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b409bcf8a0',
				'label' => 'URL facebook',
				'name' => 'url_facebook',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b409bd1efb',
				'label' => 'URL twitter',
				'name' => 'url_twitter',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b409bd4d06',
				'label' => 'URL plateforme étudiante',
				'name' => 'url_plateforme_etudiante',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b41b34ccd1',
				'label' => 'URL Tours',
				'name' => 'url_tours',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b41b350df8',
				'label' => 'URL Angers',
				'name' => 'url_angers',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b41b3533ab',
				'label' => 'URL Le Mans',
				'name' => 'url_le_mans',
				'type' => 'text',
				'default_value' => '',
				'formatting' => 'none',
			),
			array (
				'key' => 'field_505b409bd7ae9',
				'label' => 'Informations concours d\'entrée',
				'name' => 'info_concours',
				'type' => 'page_link',
				'post_type' => array (
					0 => 'page',
				),
				'allow_null' => 1,
				'multiple' => 0,
			),
		),
		'location' => array (
			'rules' => array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'Options',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 12,
	));
	register_field_group(array (
		'id' => 'acf_page-modulable',
		'title' => 'Page modulable',
		'fields' => array (
			array (
				'key' => 'field_4fa95bc65c8d6',
				'label' => 'Structure page',
				'name' => 'structure_page',
				'type' => 'flexible_content',
				'layouts' => array (
					array (
						'label' => 'Module Texte',
						'name' => 'module_page_view',
						'display' => 'table',
						'sub_fields' => array (
							array (
								'key' => 'field_505b3a74c9ee4',
								'label' => 'Page liée',
								'name' => 'page_liee',
								'type' => 'post_object',
								'column_width' => '',
								'post_type' => array (
									0 => 'page',
								),
								'taxonomy' => array (
									0 => 'all',
								),
								'allow_null' => 0,
								'multiple' => 0,
							),
							array (
								'key' => 'field_505b3a74c9f2f',
								'label' => 'Texte résumé',
								'name' => 'texte_resume',
								'type' => 'true_false',
								'column_width' => '',
								'message' => 'Afficher un résumé du texte.',
								'default_value' => 0,
							),
							array (
								'key' => 'field_505b3a74c9f77',
								'label' => 'Position de l\'image (si résumé)',
								'name' => 'image_position',
								'type' => 'radio',
								'choices' => array (
									'droite' => 'droite',
									'gauche' => 'gauche',
								),
								'column_width' => '',
								'default_value' => 'droite',
								'layout' => 'vertical',
							),
						),
					),
					array (
						'label' => 'Module onglets',
						'name' => 'module_pages_tab',
						'display' => 'table',
						'sub_fields' => array (
							array (
								'key' => 'field_505b3a74c9fce',
								'label' => 'Titre du bloc',
								'name' => 'titre_du_bloc',
								'type' => 'text',
								'column_width' => '',
								'default_value' => 'Pages liées',
								'formatting' => 'none',
							),
							array (
								'key' => 'field_505b3a74ca016',
								'label' => 'Pages liées',
								'name' => 'pages_liees',
								'type' => 'relationship',
								'column_width' => '',
								'post_type' => array (
									0 => 'page',
								),
								'taxonomy' => array (
									0 => 'all',
								),
								'max' => -1,
							),
						),
					),
					array (
						'label' => 'Module image',
						'name' => 'module_image',
						'display' => 'table',
						'sub_fields' => array (
							array (
								'key' => 'field_505b3a74ca061',
								'label' => 'Image',
								'name' => 'image',
								'type' => 'image',
								'column_width' => '',
								'save_format' => 'id',
								'preview_size' => 'thumbnail',
							),
						),
					),
					array (
						'label' => 'Module player d\'actualités',
						'name' => 'module_posts_player',
						'display' => 'table',
						'sub_fields' => array (
							array (
								'key' => 'field_505b3a74ca0aa',
								'label' => 'Actualités',
								'name' => 'posts',
								'type' => 'relationship',
								'column_width' => '',
								'post_type' => array (
									0 => 'post',
								),
								'taxonomy' => array (
									0 => 'all',
								),
								'max' => 10,
							),
						),
					),
					array (
						'label' => 'Module listing d\'actualités',
						'name' => 'module_posts_listing',
						'display' => 'table',
						'sub_fields' => array (
							array (
								'key' => 'field_5163f33657601',
								'label' => 'Nombre d\'articles',
								'name' => 'nbr_articles',
								'type' => 'number',
								'instructions' => 'La quantité d\'articles à afficher.',
								'column_width' => 33,
								'default_value' => 8,
							),
							array (
								'key' => 'field_505b3a74ca0f2',
								'label' => 'Catégories d\'actualités',
								'name' => 'posts_categories',
								'type' => 'taxonomy',
								'column_width' => '',
								'taxonomy' => 'category',
								'field_type' => 'checkbox',
								'allow_null' => 0,
								'load_save_terms' => 0,
								'return_format' => 'object',
							),
						),
					),
				),
				'button_label' => '+ Ajouter un rang',
			),
		),
		'location' => array (
			'rules' => array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-modulable.php',
					'order_no' => 0,
				),
			),
			'allorany' => 'all',
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'discussion',
				3 => 'comments',
				4 => 'slug',
			),
		),
		'menu_order' => 12,
	));
	register_field_group(array (
		'id' => 'acf_page-simple',
		'title' => 'Page simple',
		'fields' => array (
			array (
				'key' => 'field_50571d5155f9a',
				'label' => 'Pages en relation',
				'name' => 'pages_en_relation',
				'type' => 'relationship',
				'instructions' => 'Liste des pages liées à ce document.',
				'post_type' => array (
					0 => 'page',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'max' => '',
			),
		),
		'location' => array (
			'rules' => array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => '0',
				),
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'post',
					'order_no' => '1',
				),
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'ai1ec_event',
					'order_no' => '2',
				),
			),
			'allorany' => 'all',
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 12,
	));
}
