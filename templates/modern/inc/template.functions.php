<?php
/**
 * WebEngine CMS - Modern Template Functions
 * https://webenginecms.org/
 * 
 * @version 1.2.6
 * @author WebEngine CMS Team
 * @copyright (c) 2013-2025 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

function templateBuildNavbar() {
	$cfg = loadConfig('navbar');
	if(!is_array($cfg)) return;
	
	foreach($cfg as $element) {
		if(!is_array($element)) continue;
		
		# active
		if(!$element['active']) continue;
		
		# type
		$link = ($element['type'] == 'internal' ? __BASE_URL__ . $element['link'] : $element['link']);
		
		# title
		$title = (check_value(lang($element['phrase'], true)) ? lang($element['phrase'], true) : 'Unk_phrase');
		
		# visibility
		if($element['visibility'] == 'guest') if(isLoggedIn()) continue;
		if($element['visibility'] == 'user') if(!isLoggedIn()) continue;
		
		# current page detection
		$current_page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
		$is_active = ($element['link'] == $current_page . '/') ? 'active' : '';
		
		# print
		if($element['newtab']) {
			echo '<li class="nav-item"><a class="nav-link '.$is_active.'" href="'.$link.'" target="_blank">'.$title.' <i class="fas fa-external-link-alt ms-1"></i></a></li>';
		} else {
			echo '<li class="nav-item"><a class="nav-link '.$is_active.'" href="'.$link.'">'.$title.'</a></li>';
		}
	}
}

function templateBuildUsercp() {
	$cfg = loadConfig('usercp');
	if(!is_array($cfg)) return;
	
	echo '<div class="list-group modern-sidebar-menu">';
	foreach($cfg as $element) {
		if(!is_array($element)) continue;
		
		# active
		if(!$element['active']) continue;
		
		# visibility
		if($element['visibility'] == 'guest') if(isLoggedIn()) continue;
		if($element['visibility'] == 'user') if(!isLoggedIn()) continue;
		
		# admin level
		if(check_value($element['admin_level'])) {
			if(!check_admin_auth($element['admin_level'])) continue;
		}
		
		# title
		$title = (check_value(lang($element['phrase'], true)) ? lang($element['phrase'], true) : 'Unk_phrase');
		
		# current page detection
		$current_subpage = isset($_REQUEST['subpage']) ? $_REQUEST['subpage'] : '';
		$is_active = ($element['link'] == $current_subpage) ? 'active' : '';
		
		# icon
		$icon = isset($element['icon']) && !empty($element['icon']) ? $element['icon'] : 'fas fa-cog';
		
		# print
		echo '<a href="'.__BASE_URL__.'usercp/'.$element['link'].'/" class="list-group-item list-group-item-action '.$is_active.'">';
		echo '<i class="'.$icon.' me-2"></i> '.$title;
		echo '</a>';
	}
	echo '</div>';
}

function templateLanguageSelector() {
	$languagesConfig = __PATH_LANGUAGES__ . 'languages.json';
	if(!file_exists($languagesConfig)) return;
	
	$languages = json_decode(file_get_contents($languagesConfig), true);
	if(!is_array($languages)) return;
	
	foreach($languages as $key => $language) {
		if(!is_array($language)) continue;
		if(!$language['active']) continue;
		
		$current = ($_SESSION['language'] == $key) ? 'active' : '';
		echo '<li><a class="dropdown-item '.$current.'" href="'.__BASE_URL__.'?changelang='.$key.'">';
		echo '<img src="'.__PATH_TEMPLATE_IMG__.'flags/'.$key.'.png" alt="'.$language['name'].'" class="flag-icon me-2"> ';
		echo $language['name'];
		echo '</a></li>';
	}
}

function templateBuildSidebar() {
	echo '<div class="modern-sidebar">';
	
	// Server Information
	echo '<div class="sidebar-widget">';
	echo '<h5 class="widget-title"><i class="fas fa-server me-2"></i>Server Information</h5>';
	echo '<div class="widget-content">';
	echo '<div class="server-stats">';
	
	$serverInfoCache = LoadCacheData('server_info.cache');
	if(is_array($serverInfoCache)) {
		$srvInfo = explode("|", $serverInfoCache[1][0]);
		
		echo '<div class="stat-item">';
		echo '<span class="stat-label">Season:</span>';
		echo '<span class="stat-value">'.config('server_info_season', true).'</span>';
		echo '</div>';
		
		echo '<div class="stat-item">';
		echo '<span class="stat-label">Experience:</span>';
		echo '<span class="stat-value">'.config('server_info_exp', true).'</span>';
		echo '</div>';
		
		echo '<div class="stat-item">';
		echo '<span class="stat-label">Drop Rate:</span>';
		echo '<span class="stat-value">'.config('server_info_drop', true).'</span>';
		echo '</div>';
	}
	
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	// Social Links
	$facebook = config('social_link_facebook', true);
	$instagram = config('social_link_instagram', true);
	$discord = config('social_link_discord', true);
	
	if(check_value($facebook) || check_value($instagram) || check_value($discord)) {
		echo '<div class="sidebar-widget">';
		echo '<h5 class="widget-title"><i class="fas fa-share-alt me-2"></i>Follow Us</h5>';
		echo '<div class="widget-content">';
		echo '<div class="social-links">';
		
		if(check_value($facebook)) {
			echo '<a href="'.$facebook.'" target="_blank" class="social-link facebook">';
			echo '<i class="fab fa-facebook-f"></i>';
			echo '</a>';
		}
		
		if(check_value($instagram)) {
			echo '<a href="'.$instagram.'" target="_blank" class="social-link instagram">';
			echo '<i class="fab fa-instagram"></i>';
			echo '</a>';
		}
		
		if(check_value($discord)) {
			echo '<a href="'.$discord.'" target="_blank" class="social-link discord">';
			echo '<i class="fab fa-discord"></i>';
			echo '</a>';
		}
		
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
	
	// Latest News (if available)
	$news = LoadCacheData('news.cache');
	if(is_array($news) && count($news) > 0) {
		echo '<div class="sidebar-widget">';
		echo '<h5 class="widget-title"><i class="fas fa-newspaper me-2"></i>Latest News</h5>';
		echo '<div class="widget-content">';
		echo '<div class="news-list">';
		
		$count = 0;
		foreach($news as $newsItem) {
			if($count >= 3) break;
			
			echo '<div class="news-item">';
			echo '<a href="'.__BASE_URL__.'news/'.newslink($newsItem[0],$newsItem[1]).'" class="news-title">';
			echo htmlspecialchars(substr($newsItem[1], 0, 40)) . (strlen($newsItem[1]) > 40 ? '...' : '');
			echo '</a>';
			echo '<div class="news-date">'.date('M j, Y', $newsItem[2]).'</div>';
			echo '</div>';
			
			$count++;
		}
		
		echo '</div>';
		echo '</div>';
		echo '</div>';
	}
	
	echo '</div>';
}

function templateFormatNumber($number) {
	if($number >= 1000000) {
		return round($number / 1000000, 1) . 'M';
	} elseif($number >= 1000) {
		return round($number / 1000, 1) . 'K';
	}
	return number_format($number);
}

function templateTimeAgo($timestamp) {
	$time = time() - $timestamp;
	
	if($time < 60) return 'Just now';
	if($time < 3600) return floor($time/60) . ' minutes ago';
	if($time < 86400) return floor($time/3600) . ' hours ago';
	if($time < 2592000) return floor($time/86400) . ' days ago';
	if($time < 31536000) return floor($time/2592000) . ' months ago';
	
	return floor($time/31536000) . ' years ago';
}
?>