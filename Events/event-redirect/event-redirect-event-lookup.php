<?php

	/*
		REDIRECT RECURRING EVENT SEARCH RESULT TO LATEST OCCURRENCE

		Conditions:
		1. Event detail pages are created like so: /event/date-event-slug/
		2. Search results page is: /search-results/?keywords...

		Use:
		Include at the top of the event detail page (most likely ekk_eventpage.php),
		just after the require of monkcms.php.

		Note:
		May not return the correct event if the "next" event is an exception to
		the recurrence rule.

	*/

	function updatedEventRedirect($event_slug){

		if (strpos($_SERVER['HTTP_REFERER'],'/search-results') !== false) {

			// original event string
			$event_slug_old = $event_slug;

			// get old event's title
			$event_preg_match = array();
			preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $event_slug, $event_preg_match);
			$event_slug = str_replace($event_preg_match[0], '', $event_slug);
			$event_preg_match = array();
			preg_match('/[0-9]+--/', $event_slug, $event_preg_match);
			$event_slug = str_replace($event_preg_match[0], '', $event_slug);
			$event_slug = ltrim($event_slug,'-');

			// get new event by title
			$event_url_new = getContent('event','display:detail','find:' . $event_slug,'show:__url__','noecho');
			$event_slug_new = str_replace('event/','',trim($event_url_new,'/'));

			// if new event string is different, redirect to new URL
			if(($event_slug_old != '') && ($event_slug_new != '') && ($event_slug_old != $event_slug_new)){
				$event_url_new = 'http://' . $_SERVER['HTTP_HOST'] . $event_url_new;
				header('Location:' . $event_url_new);
			}

		}

	}

	updatedEventRedirect($_GET['slug']);

?>