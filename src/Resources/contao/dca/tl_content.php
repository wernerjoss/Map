<?php


use Contao\System;
use Contao\Backend;
use Contao\Model;
use App\Model\MapModel;
use App\Model\MapPointsModel;
use Contao\DataContainer;
use Contao\StringUtil;
use Contao\Image;


$GLOBALS['TL_DCA']['tl_content']['palettes']['map_viewer'] = '{type_legend},type;{map_legend},map;{protected_legend:hide};{expert_legend:hide},cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['fields']['map'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['map'],
	'inputType'               => 'select',
	'options_callback'        => array('tl_content_map', 'getMap'),
	'eval'                    => array('mandatory'=>true, 'chosen'=>true, 'submitOnChange'=>true),
	'wizard' 				  => array(array('tl_content_map', 'editMap')),
	'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

class tl_content_map extends Backend 
{

	public function getMap()
	{
		$objCats =  MapModel::findAll();
		$arrCats = array();
		foreach ($objCats as $objCat)
		{
			$arrCats[$objCat->id] = '[ID ' . $objCat->id . '] - '. $objCat->title;
		}
		return $arrCats;
	}

	public function editMap(DataContainer $dc)
	{


//		$this->loadLanguageFile('tl_map');
//
//		$title = "Edit"; //sprintf($GLOBALS['TL_LANG']['tl_map']['editheader'], $dc->value)"";
//
//		$href = System::getContainer()->get('router')->generate('contao_backend', array('do'=>'map', 'table'=>'tl_map', 'id'=>$dc->value, 'popup'=>'1', 'nb'=>'1'));
//
//		return ' <a href="' . StringUtil::specialcharsUrl($href) . '" title="' . StringUtil::specialchars($title) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", $title)) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $title) . '</a>';
		
		$requestToken = System::getContainer()->get('contao.csrf.token_manager')->getDefaultTokenValue();
		$this->loadLanguageFile('tl_map');
		return ($dc->value < 1) ? '' : ' <a href="contao/main.php?do=map&amp;act=edit&amp;id=' . $dc->value . '&amp;popup=1&amp;nb=1&amp;rt=' . $requestToken . '" title="' . sprintf(StringUtil::specialchars($GLOBALS['TL_LANG']['tl_map']['editheader'][1]), $dc->value) . '" onclick="Backend.openModalIframe({\'title\':\'' . StringUtil::specialchars(str_replace("'", "\\'", sprintf($GLOBALS['TL_LANG']['tl_map']['editheader'][1], $dc->value))) . '\',\'url\':this.href});return false">' . Image::getHtml('alias.svg', $GLOBALS['TL_LANG']['tl_map']['editheader'][0]) . '</a>';

	}

}