<?php

/**
 * Activez les add-ons
 * A cet endroit vous pouvez saisir vos codes d‘activation pour déverrouiller les add-ons que vous souhaitez utiliser dans votre thème. 
 * Puisque tous les codes d'activation sont des licences multi-sites, vous êtes autorisé à inclure votre clé dans des thèmes pretium. 
 * Utilisez la partie de code commentée pour mettre à jour la base de données avec vos codes d'activation. 
 * Vous pouvez placer ce code dans une déclaration IF vraie uniquement lors de l'activation du thème.
 */ 
 
if(!get_option('acf_repeater_ac')) update_option('acf_repeater_ac', "QJF7-L4IX-UCNP-RF2W");
if(!get_option('acf_options_page_ac')) update_option('acf_options_page_ac', "OPN8-FA4J-Y2LW-81LS");
if(!get_option('acf_flexible_content_ac')) update_option('acf_flexible_content_ac', "FC9O-H6VN-E4CL-LT33");
// if(!get_option('acf_gallery_ac')) update_option('acf_gallery_ac', "xxxx-xxxx-xxxx-xxxx");



/**
 * Enregistrez des groupes de champs
 * La fonction register_field_group accepte 1 tableau qui contient les données nécessaire à l‘enregistrement d'un groupe de champs
 * Vous pouvez modifier ce tableau selon vos besoins. Cela peut toutefois provoquer des erreurs dans les cas où le tableau ne serait plus compatible avec ACF
 * Ce code doit être traité à chaque accès au fichier functions.php
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => '50c09c06b3759',
		'title' => 'Chapeau article',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50604eefd3b1d',
				'label' => 'Sous-titre',
				'name' => 'sous_titre',
				'type' => 'text',
				'order_no' => '0',
				'instructions' => 'Permet de mettre un sous-titre comprenant les informations de dates ou de lieu.',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'rules' => 
					array (
						0 => 
						array (
							'field' => '',
							'operator' => '==',
							'value' => '',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'formatting' => 'none',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '50c09c06b3f4e',
		'title' => 'options TALM',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_505b409bbf3c1',
				'label' => 'Adresse EPCC',
				'name' => 'adresse_epcc',
				'type' => 'wysiwyg',
				'order_no' => '0',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
				'the_content' => 'no',
			),
			1 => 
			array (
				'key' => 'field_505b3c09b1042',
				'label' => 'URL vimeo',
				'name' => 'url_vimeo',
				'type' => 'text',
				'order_no' => '1',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			2 => 
			array (
				'key' => 'field_505b409bcf8a0',
				'label' => 'URL facebook',
				'name' => 'url_facebook',
				'type' => 'text',
				'order_no' => '2',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			3 => 
			array (
				'key' => 'field_505b409bd1efb',
				'label' => 'URL twitter',
				'name' => 'url_twitter',
				'type' => 'text',
				'order_no' => '3',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			4 => 
			array (
				'key' => 'field_505b409bd4d06',
				'label' => 'URL plateforme étudiante',
				'name' => 'url_plateforme_etudiante',
				'type' => 'text',
				'order_no' => '4',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			5 => 
			array (
				'key' => 'field_505b41b34ccd1',
				'label' => 'URL Tours',
				'name' => 'url_tours',
				'type' => 'text',
				'order_no' => '5',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			6 => 
			array (
				'key' => 'field_505b41b350df8',
				'label' => 'URL Angers',
				'name' => 'url_angers',
				'type' => 'text',
				'order_no' => '6',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			7 => 
			array (
				'key' => 'field_505b41b3533ab',
				'label' => 'URL Le Mans',
				'name' => 'url_le_mans',
				'type' => 'text',
				'order_no' => '7',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'default_value' => '',
				'formatting' => 'none',
			),
			8 => 
			array (
				'key' => 'field_505b409bd7ae9',
				'label' => 'Informations concours d\'entrée',
				'name' => 'info_concours',
				'type' => 'page_link',
				'order_no' => '8',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'post_type' => 
				array (
					0 => 'page',
				),
				'allow_null' => '1',
				'multiple' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'Options',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 12,
	));
	register_field_group(array (
		'id' => '50c09c06b5a8e',
		'title' => 'Page modulable',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_4fa95bc65c8d6',
				'label' => 'Structure page',
				'name' => 'structure_page',
				'type' => 'flexible_content',
				'order_no' => '0',
				'instructions' => '',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'layouts' => 
				array (
					0 => 
					array (
						'label' => 'Module Texte',
						'name' => 'module_page_view',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Page liée',
								'name' => 'page_liee',
								'type' => 'post_object',
								'post_type' => 
								array (
									0 => 'page',
								),
								'taxonomy' => 
								array (
									0 => 'all',
								),
								'allow_null' => '0',
								'multiple' => '0',
								'key' => 'field_505b3a74c9ee4',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Texte résumé',
								'name' => 'texte_resume',
								'type' => 'true_false',
								'message' => 'Afficher un résumé du texte.',
								'key' => 'field_505b3a74c9f2f',
								'order_no' => '1',
							),
							2 => 
							array (
								'label' => 'Position de l\'image (si résumé)',
								'name' => 'image_position',
								'type' => 'radio',
								'choices' => 
								array (
									'droite' => 'droite',
									'gauche' => 'gauche',
								),
								'default_value' => 'droite',
								'layout' => 'vertical',
								'key' => 'field_505b3a74c9f77',
								'order_no' => '2',
							),
						),
					),
					1 => 
					array (
						'label' => 'Module onglets',
						'name' => 'module_pages_tab',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Titre du bloc',
								'name' => 'titre_du_bloc',
								'type' => 'text',
								'default_value' => 'Pages liées',
								'formatting' => 'none',
								'key' => 'field_505b3a74c9fce',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Pages liées',
								'name' => 'pages_liees',
								'type' => 'relationship',
								'post_type' => 
								array (
									0 => 'page',
								),
								'taxonomy' => 
								array (
									0 => 'all',
								),
								'max' => '-1',
								'key' => 'field_505b3a74ca016',
								'order_no' => '1',
							),
						),
					),
					2 => 
					array (
						'label' => 'Module image',
						'name' => 'module_image',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Image',
								'name' => 'image',
								'type' => 'image',
								'save_format' => 'id',
								'preview_size' => 'thumbnail',
								'key' => 'field_505b3a74ca061',
								'order_no' => '0',
							),
						),
					),
					3 => 
					array (
						'label' => 'Module player d\'actualités',
						'name' => 'module_posts_player',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Actualités',
								'name' => 'posts',
								'type' => 'relationship',
								'post_type' => 
								array (
									0 => 'post',
								),
								'taxonomy' => 
								array (
									0 => 'all',
								),
								'max' => '10',
								'key' => 'field_505b3a74ca0aa',
								'order_no' => '0',
							),
						),
					),
					4 => 
					array (
						'label' => 'Module listing d\'actualités',
						'name' => 'module_posts_listing',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Catégories d\'actualités',
								'name' => 'posts_categories',
								'type' => 'tax',
								'taxonomy' => 'category',
								'taxcol' => '3',
								'hidetax' => '0',
								'key' => 'field_505b3a74ca0f2',
								'order_no' => '0',
							),
						),
					),
				),
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_5050b184bd818',
					),
					1 => 
					array (
						'key' => 'field_5050b184bd52f',
					),
					2 => 
					array (
						'key' => 'field_5050b184bd2fe',
					),
				),
				'button_label' => '+ Ajouter un rang',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-modulable.php',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
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
		'id' => '50c09c06b63ac',
		'title' => 'Page simple',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50571d5155f9a',
				'label' => 'Pages en relation',
				'name' => 'pages_en_relation',
				'type' => 'relationship',
				'order_no' => '0',
				'instructions' => 'Liste des pages liées à ce document.',
				'required' => '0',
				'conditional_logic' => 
				array (
					'status' => '0',
					'allorany' => 'all',
					'rules' => false,
				),
				'post_type' => 
				array (
					0 => 'page',
				),
				'taxonomy' => 
				array (
					0 => 'all',
				),
				'max' => '',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => '0',
				),
				1 => 
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'post',
					'order_no' => '1',
				),
				2 => 
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'ai1ec_event',
					'order_no' => '2',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 12,
	));
}



///////////OLD

/**
 * Enregistrez des groupes de champs
 * La fonction register_field_group accepte 1 tableau qui contient les données nécessaire à l‘enregistrement d'un groupe de champs
 * Vous pouvez modifier ce tableau selon vos besoins. Cela peut toutefois provoquer des erreurs dans les cas où le tableau ne serait plus compatible avec ACF
 * Ce code doit être traité à chaque accès au fichier functions.php
 */

/*
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => '50605671335f0',
		'title' => 'Chapeau article',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50604eefd0cdf',
				'label' => 'Date de début',
				'name' => 'date_de_debut',
				'type' => 'date_picker',
				'instructions' => 'Date de début de l\'événement. Sinon mettre la date de publication.',
				'required' => '1',
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'order_no' => '0',
			),
			1 => 
			array (
				'key' => 'field_50604eefd3b1d',
				'label' => 'Sous-titre',
				'name' => 'sous_titre',
				'type' => 'text',
				'instructions' => 'Permet de mettre un sous-titre comprenant les informations de dates ou de lieu.',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'order_no' => '1',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => '50605671337c0',
		'title' => 'options TALM',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_505b409bbf3c1',
				'label' => 'Adresse EPCC',
				'name' => 'adresse_epcc',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'no',
				'the_content' => 'no',
				'order_no' => '0',
			),
			1 => 
			array (
				'key' => 'field_505b3c09b1042',
				'label' => 'URL vimeo',
				'name' => 'url_vimeo',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'order_no' => '1',
			),
			2 => 
			array (
				'key' => 'field_505b409bcf8a0',
				'label' => 'URL facebook',
				'name' => 'url_facebook',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'order_no' => '2',
			),
			3 => 
			array (
				'key' => 'field_505b409bd1efb',
				'label' => 'URL twitter',
				'name' => 'url_twitter',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'order_no' => '3',
			),
			4 => 
			array (
				'key' => 'field_505b409bd4d06',
				'label' => 'URL plateforme étudiante',
				'name' => 'url_plateforme_etudiante',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'order_no' => '4',
			),
			5 => 
			array (
				'label' => 'URL Tours',
				'name' => 'url_tours',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'key' => 'field_505b41b34ccd1',
				'order_no' => '5',
			),
			6 => 
			array (
				'label' => 'URL Angers',
				'name' => 'url_angers',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'key' => 'field_505b41b350df8',
				'order_no' => '6',
			),
			7 => 
			array (
				'label' => 'URL Le Mans',
				'name' => 'url_le_mans',
				'type' => 'text',
				'instructions' => '',
				'required' => '0',
				'default_value' => '',
				'formatting' => 'none',
				'key' => 'field_505b41b3533ab',
				'order_no' => '7',
			),
			8 => 
			array (
				'key' => 'field_505b409bd7ae9',
				'label' => 'Informations concours d\'entrée',
				'name' => 'info_concours',
				'type' => 'page_link',
				'instructions' => '',
				'required' => '0',
				'post_type' => 
				array (
					0 => 'page',
				),
				'allow_null' => '1',
				'multiple' => '0',
				'order_no' => '8',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'Options',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 12,
	));
	register_field_group(array (
		'id' => '5060567133c2b',
		'title' => 'Page modulable',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_4fa95bc65c8d6',
				'label' => 'Structure page',
				'name' => 'structure_page',
				'type' => 'flexible_content',
				'instructions' => '',
				'required' => '0',
				'layouts' => 
				array (
					0 => 
					array (
						'label' => 'Module Texte',
						'name' => 'module_page_view',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Page liée',
								'name' => 'page_liee',
								'type' => 'post_object',
								'post_type' => 
								array (
									0 => 'page',
								),
								'taxonomy' => 
								array (
									0 => 'all',
								),
								'allow_null' => '0',
								'multiple' => '0',
								'key' => 'field_505b3a74c9ee4',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Texte résumé',
								'name' => 'texte_resume',
								'type' => 'true_false',
								'message' => 'Afficher un résumé du texte.',
								'key' => 'field_505b3a74c9f2f',
								'order_no' => '1',
							),
							2 => 
							array (
								'label' => 'Position de l\'image (si résumé)',
								'name' => 'image_position',
								'type' => 'radio',
								'choices' => 
								array (
									'droite' => 'droite',
									'gauche' => 'gauche',
								),
								'default_value' => 'droite',
								'layout' => 'vertical',
								'key' => 'field_505b3a74c9f77',
								'order_no' => '2',
							),
						),
					),
					1 => 
					array (
						'label' => 'Module onglets',
						'name' => 'module_pages_tab',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Titre du bloc',
								'name' => 'titre_du_bloc',
								'type' => 'text',
								'default_value' => 'Pages liées',
								'formatting' => 'none',
								'key' => 'field_505b3a74c9fce',
								'order_no' => '0',
							),
							1 => 
							array (
								'label' => 'Pages liées',
								'name' => 'pages_liees',
								'type' => 'relationship',
								'post_type' => 
								array (
									0 => 'page',
								),
								'taxonomy' => 
								array (
									0 => 'all',
								),
								'max' => '-1',
								'key' => 'field_505b3a74ca016',
								'order_no' => '1',
							),
						),
					),
					2 => 
					array (
						'label' => 'Module image',
						'name' => 'module_image',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Image',
								'name' => 'image',
								'type' => 'image',
								'save_format' => 'id',
								'preview_size' => 'thumbnail',
								'key' => 'field_505b3a74ca061',
								'order_no' => '0',
							),
						),
					),
					3 => 
					array (
						'label' => 'Module player d\'actualités',
						'name' => 'module_posts_player',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Actualités',
								'name' => 'posts',
								'type' => 'relationship',
								'post_type' => 
								array (
									0 => 'post',
								),
								'taxonomy' => 
								array (
									0 => 'all',
								),
								'max' => '10',
								'key' => 'field_505b3a74ca0aa',
								'order_no' => '0',
							),
						),
					),
					4 => 
					array (
						'label' => 'Module listing d\'actualités',
						'name' => 'module_posts_listing',
						'display' => 'table',
						'sub_fields' => 
						array (
							0 => 
							array (
								'label' => 'Catégories d\'actualités',
								'name' => 'posts_categories',
								'type' => 'tax',
								'taxonomy' => 'category',
								'taxcol' => '3',
								'hidetax' => '0',
								'key' => 'field_505b3a74ca0f2',
								'order_no' => '0',
							),
						),
					),
				),
				'sub_fields' => 
				array (
					0 => 
					array (
						'key' => 'field_5050b184bd818',
					),
					1 => 
					array (
						'key' => 'field_5050b184bd52f',
					),
					2 => 
					array (
						'key' => 'field_5050b184bd2fe',
					),
				),
				'button_label' => '+ Ajouter un rang',
				'order_no' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-modulable.php',
					'order_no' => '0',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
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
		'id' => '5060567133f1d',
		'title' => 'Page simple',
		'fields' => 
		array (
			0 => 
			array (
				'key' => 'field_50571d5155f9a',
				'label' => 'Pages en relation',
				'name' => 'pages_en_relation',
				'type' => 'relationship',
				'instructions' => 'Liste des pages liées à ce document.',
				'required' => '0',
				'post_type' => 
				array (
					0 => 'page',
				),
				'taxonomy' => 
				array (
					0 => 'all',
				),
				'max' => '',
				'order_no' => '0',
			),
		),
		'location' => 
		array (
			'rules' => 
			array (
				0 => 
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'default',
					'order_no' => '0',
				),
				1 => 
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'post',
					'order_no' => '1',
				),
				2 => 
				array (
					'param' => 'post_type',
					'operator' => '!=',
					'value' => 'ai1ec_event',
					'order_no' => '2',
				),
			),
			'allorany' => 'all',
		),
		'options' => 
		array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 12,
	));
}
*/