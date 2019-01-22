<?php 
require_once BASE_DIR . '/lib/CUrlStream.php';
require_once BASE_DIR . '/3rdparty/phpQuery.php';
class PzkCrawlerHotelMytour extends PzkObjectLightWeight {
	/**
	* return PzkEntity
	*/
	public function crawl($link) {
		$records = array();
		$stream = new CUrlStream($link);
		$content = $stream->getContent();
		$phpQuery = phpQuery::newDocument($content);
		$list = $phpQuery->find('.detail_list');
		foreach($list as $detail) {
			$record = _db()->getEntity('travel.hotel');
			$hotel = pq($detail);
			$name = $hotel->find('.hotel_name a');
			$record->loadWhere(array('name' => $name->text()));
			$record->setName($name->text());
			$record->setLink($name->attr('href'));
			$star = $hotel->find('.hotel_name span');
			$star = $star->attr('class');
			$stars = explode('_', $star);
			$star = array_pop($stars);
			$record->setStar($star);
			$address = $hotel->find('.address');
			$address->find('a')->remove();
			$record->setAddress($address->text());
			$area = $hotel->find('.f_area');
			$record->setArea($area->text());
			$markrate = $hotel->find('.mark_rate');
			$record->setMarkrate($markrate->text());
			$allrate = $hotel->find('.all_rate');
			$allrate = $allrate->text();
			$allrate = explode(' ', $allrate);
			$allrate = $allrate[0];
			$allrate = trim($allrate, '(');
			$record->setAllrate($allrate);
			$tripadRating = $hotel->find('.tripad_rating_fil img');
			$tripadRating = $tripadRating->attr('src');
			$record->setTripadRating($tripadRating);
			$tripadReviews = trim($hotel->find('.tripad_rating_fil p')->text());
			$tripadReviews = explode(' ', $tripadReviews);
			$tripadReviews = $tripadReviews[0];
			$tripadReviews = trim($tripadReviews, '(');
			$record->setTripadReviews($tripadReviews);
			$oldprice = $hotel->find('.price_disable .price_show')->attr('data');
			$record->setOldprice($oldprice);
			$price = $hotel->find('.min_price .price_show')->attr('data');
			$record->setPrice($price);
			$facilities = $hotel->find('.attribute_hotel i');
			$facs = array();
			foreach($facilities as $facility) {
				$facility = pq($facility);
				$facility = $facility->attr('title');
				$facs[] = $facility;
			}
			$record->setFacilities(implode(', ', $facs));
			$records[] = $record;
			$record->save();
		}
		return $records;
	}
}

function pzk_mytour() {
	return pzk_element('mytour');
}