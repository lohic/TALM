<?php

/**
 *  Install Add-ons
 *  
 *  The following code will include all 4 premium Add-Ons in your theme.
 *  Please do not attempt to include a file which does not exist. This will produce an error.
 *  
 *  The following code assumes you have a folder 'add-ons' inside your theme.
 *
 *  IMPORTANT
 *  Add-ons may be included in a premium theme/plugin as outlined in the terms and conditions.
 *  For more information, please read:
 *  - http://www.advancedcustomfields.com/terms-conditions/
 *  - http://www.advancedcustomfields.com/resources/getting-started/including-lite-mode-in-a-plugin-theme/
 */ 

// Add-ons 
// include_once('add-ons/acf-repeater/acf-repeater.php');
// include_once('add-ons/acf-gallery/acf-gallery.php');
// include_once('add-ons/acf-flexible-content/acf-flexible-content.php');
// include_once( 'add-ons/acf-options-page/acf-options-page.php' );


/**
 * Enregistrez des groupes de champs
 * La fonction register_field_group accepte 1 tableau qui contient les données nécessaire à l‘enregistrement d'un groupe de champs
 * Vous pouvez modifier ce tableau selon vos besoins. Cela peut toutefois provoquer des erreurs dans les cas où le tableau ne serait plus compatible avec ACF
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_article',
		'title' => 'Article',
		'fields' => array (
			array (
				'key' => 'field_50604eefd3b1d',
				'label' => 'Sous-titre',
				'name' => 'sous_titre',
				'type' => 'text',
				'instructions' => 'Permet de mettre un sous-titre comprenant les informations de dates ou de lieu.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_52668dbeb7ada',
				'label' => 'Tri',
				'name' => 'tri',
				'type' => 'text',
				'instructions' => 'Le texte à utiliser pour trier de manière personnalisée (par ordre alphabétique par exemple).',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
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
		'id' => 'acf_attachements',
		'title' => 'Attachements',
		'fields' => array (
			array (
				'key' => 'field_51c574e0a6165',
				'label' => 'Masquer dans la liste/galerie',
				'name' => 'masquer_liste_galerie',
				'type' => 'true_false',
				'instructions' => 'Masquer dans la galerie d\'image ou dans la liste de liens',
				'message' => 'Galerie/liste O/N',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'ef_media',
					'operator' => '==',
					'value' => 'all',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
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
			),
			array (
				'key' => 'field_505b3c09b1042',
				'label' => 'URL vimeo',
				'name' => 'url_vimeo',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b409bcf8a0',
				'label' => 'URL facebook',
				'name' => 'url_facebook',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b409bd1efb',
				'label' => 'URL twitter',
				'name' => 'url_twitter',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b409bd4d06',
				'label' => 'URL plateforme étudiante',
				'name' => 'url_plateforme_etudiante',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b41b34ccd1',
				'label' => 'URL Tours',
				'name' => 'url_tours',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b41b350df8',
				'label' => 'URL Angers',
				'name' => 'url_angers',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b41b3533ab',
				'label' => 'URL Le Mans',
				'name' => 'url_le_mans',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_505b409bd7ae9',
				'label' => 'Lien en haut à droite du menu',
				'name' => 'info_concours',
				'type' => 'post_object',
				'post_type' => array (
					0 => 'page',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'allow_null' => 1,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
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
								'column_width' => '',
								'choices' => array (
									'droite' => 'droite',
									'gauche' => 'gauche',
								),
								'other_choice' => 0,
								'save_other_choice' => 0,
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
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'none',
								'maxlength' => '',
							),
							array (
								'key' => 'field_505b3a74ca016',
								'label' => 'Pages liées',
								'name' => 'pages_liees',
								'type' => 'relationship',
								'column_width' => '',
								'return_format' => 'object',
								'post_type' => array (
									0 => 'page',
								),
								'taxonomy' => array (
									0 => 'all',
								),
								'filters' => array (
									0 => 'search',
								),
								'result_elements' => array (
									0 => 'post_type',
									1 => 'post_title',
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
								'library' => 'all',
							),
							array (
								'key' => 'field_526774363b5ea',
								'label' => 'Lien',
								'name' => 'url',
								'type' => 'text',
								'instructions' => 'URL du lien lorsque l\'on clique sur l\'image (optionnel)',
								'column_width' => '',
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'formatting' => 'none',
								'maxlength' => '',
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
								'return_format' => 'object',
								'post_type' => array (
									0 => 'post',
								),
								'taxonomy' => array (
									0 => 'all',
								),
								'filters' => array (
									0 => 'search',
								),
								'result_elements' => array (
									0 => 'post_type',
									1 => 'post_title',
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
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'min' => '',
								'max' => '',
								'step' => '',
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
								'multiple' => 0,
							),
							array (
								'key' => 'field_52668e3835599',
								'label' => 'Trier par',
								'name' => 'order_by',
								'type' => 'select',
								'column_width' => '',
								'choices' => array (
									'date' => 'Date',
									'tri' => 'Valeur de tri',
								),
								'default_value' => 'date',
								'allow_null' => 0,
								'multiple' => 0,
							),
							array (
								'key' => 'field_52668e7d3559a',
								'label' => 'Ordre du tri',
								'name' => 'order_direction',
								'type' => 'select',
								'instructions' => 'Ordre de tri croissant ou décroissant',
								'column_width' => '',
								'choices' => array (
									'DESC' => 'Décroissant',
									'ASC' => 'Croissant',
								),
								'default_value' => 'DESC',
								'allow_null' => 0,
								'multiple' => 0,
							),
						),
					),
				),
				'button_label' => '+ Ajouter un rang',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-modulable.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
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
				'filters' => array (
					0 => 'search',
				),
				'result_elements' => array (
					0 => 'post_title',
					1 => 'post_type',
				),
				'return_format' => 'object',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => '0',
					'group_no' => 0,
				),
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'post',
					'order_no' => '1',
					'group_no' => 0,
				),
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'ai1ec_event',
					'order_no' => '2',
					'group_no' => 0,
				),
			),
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
