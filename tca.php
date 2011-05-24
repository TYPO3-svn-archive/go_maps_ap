<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_gomapsap_adress'] = array (
	'ctrl' => $TCA['tx_gomapsap_adress']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'title,adress,image,imagesize,imageheight,imagewidth,shadow,shadowsize,shadowheight,shadowwidth,text'
	),
	'feInterface' => $TCA['tx_gomapsap_adress']['feInterface'],
	'columns' => array (
		'title' => array (		
			'exclude' => 1,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.title',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'adress' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.adress',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',
			)
		),
		'image' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.image',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => 'gif,png,jpeg,jpg',	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_gomapsap',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'imagesize' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.imagesize',		
			'config' => array (
				'type' => 'check',
			)
		),
		'imagewidth' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.imagewidth',		
			'config' => array (
				'type' => 'input',	
				'size' => '5',	
				'max' => '4',	
				'eval' => 'int',
			)
		),
		'imageheight' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.imageheight',		
			'config' => array (
				'type' => 'input',	
				'size' => '5',	
				'max' => '4',	
				'eval' => 'int',
			)
		),
		'shadow' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.shadow',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_gomapsap',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'shadowsize' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.shadowsize',		
			'config' => array (
				'type' => 'check',
			)
		),
		'shadowwidth' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.shadowwidth',		
			'config' => array (
				'type' => 'input',	
				'size' => '5',	
				'max' => '4',	
				'eval' => 'int',
			)
		),
		'shadowheight' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.shadowheight',		
			'config' => array (
				'type' => 'input',	
				'size' => '5',	
				'max' => '4',	
				'eval' => 'int',
			)
		),
		'text' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:go_maps_ap/locallang_db.xml:tx_gomapsap_adress.text',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'title;;;;2-2-2, adress;;;;3-3-3, image, imagesize, imageheight, imagewidth, shadow, shadowsize, shadowheight, shadowwidth, text;;;richtext[]:rte_transform[mode=ts_css|imgpath=uploads/tx_gomapsap/rte/]')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>