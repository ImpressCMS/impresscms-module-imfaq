<?php
/**
* @copyright	INBOX International
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Rodrigo Pereira Lima <rodrigo@inboxinternational.com>
* @package		imfaq
* @version		$Id$
*/

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function imfaq_search($queryarray, $andor, $limit, $offset, $userid) {
	$imfaq_cat_handler = icms_getModuleHandler('category', 'imfaq');
	$catsArray = $imfaq_cat_handler->getCategoriesForSearch($queryarray, $andor, $limit, $offset, $userid);

	$ret = array();

	foreach ($catsArray as $catArray) {
		$item['image'] = "images/faq.png";
		$item['link'] = str_replace(IMFAQ_URL, '', $catArray->getItemLink());
		$item['title'] = $catArray->getVar('cat_title','n');
		$item['time'] = 0;
		$item['uid'] = 0;
		$ret[] = $item;
		unset($item);
	}
	
	$imfaq_faq_handler = icms_getModuleHandler('faq', 'imfaq');
	$faqsArray = $imfaq_faq_handler->getFaqsForSearch($queryarray, $andor, $limit, $offset, $userid);
	
	foreach ($faqsArray as $faqArray) {
		$item['image'] = "images/faq.png";
		$item['link'] = str_replace(IMFAQ_URL, '', $faqArray->getItemLink());
		$item['title'] = $faqArray->getVar('faq_question','nh');
		$item['time'] = strtotime($faqArray->getVar('faq_published_date'));
		$item['uid'] = $faqArray->getVar('faq_uid','e');
		$ret[] = $item;
		unset($item);
	}
	return $ret;
}

?>