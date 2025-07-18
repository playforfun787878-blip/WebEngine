<?php
/**
 * WebEngine CMS - Modern Template Sidebar
 * https://webenginecms.org/
 * 
 * @version 1.2.6
 * @author WebEngine CMS Team
 * @copyright (c) 2013-2025 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

if(!defined('access') or !access) die();

// Check if we're in usercp
$isUsercp = (isset($_REQUEST['page']) && $_REQUEST['page'] == 'usercp');
?>

<div class="modern-sidebar">
    <?php if($isUsercp): ?>
        <!-- User Control Panel Menu -->
        <div class="sidebar-widget">
            <h5 class="widget-title">
                <i class="fas fa-user-cog me-2"></i>
                <?php echo lang('module_titles_txt_3'); ?>
            </h5>
            <div class="widget-content p-0">
                <?php templateBuildUsercp(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Server Information -->
    <div class="sidebar-widget">
        <h5 class="widget-title">
            <i class="fas fa-server me-2"></i>
            Server Information
        </h5>
        <div class="widget-content">
            <div class="server-stats">
                <?php
                $serverInfoCache = LoadCacheData('server_info.cache');
                if(is_array($serverInfoCache)) {
                    $srvInfo = explode("|", $serverInfoCache[1][0]);
                ?>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Season</span>
                        <span class="stat-value"><?php echo config('server_info_season', true); ?></span>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Experience</span>
                        <span class="stat-value"><?php echo config('server_info_exp', true); ?></span>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Drop Rate</span>
                        <span class="stat-value"><?php echo config('server_info_drop', true); ?></span>
                    </div>
                </div>
                
                <?php if(isset($srvInfo[3])): ?>
                <div class="stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-label">Players Online</span>
                        <span class="stat-value"><?php echo templateFormatNumber($srvInfo[3]); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Social Links -->
    <?php
    $facebook = config('social_link_facebook', true);
    $instagram = config('social_link_instagram', true);
    $discord = config('social_link_discord', true);
    
    if(check_value($facebook) || check_value($instagram) || check_value($discord)):
    ?>
    <div class="sidebar-widget">
        <h5 class="widget-title">
            <i class="fas fa-share-alt me-2"></i>
            Follow Us
        </h5>
        <div class="widget-content">
            <div class="social-links">
                <?php if(check_value($facebook)): ?>
                <a href="<?php echo $facebook; ?>" target="_blank" class="social-link facebook" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                    <span>Facebook</span>
                </a>
                <?php endif; ?>
                
                <?php if(check_value($instagram)): ?>
                <a href="<?php echo $instagram; ?>" target="_blank" class="social-link instagram" title="Instagram">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>
                <?php endif; ?>
                
                <?php if(check_value($discord)): ?>
                <a href="<?php echo $discord; ?>" target="_blank" class="social-link discord" title="Discord">
                    <i class="fab fa-discord"></i>
                    <span>Discord</span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Latest News -->
    <?php
    $news = LoadCacheData('news.cache');
    if(is_array($news) && count($news) > 0):
    ?>
    <div class="sidebar-widget">
        <h5 class="widget-title">
            <i class="fas fa-newspaper me-2"></i>
            Latest News
        </h5>
        <div class="widget-content">
            <div class="news-list">
                <?php
                $count = 0;
                foreach($news as $newsItem) {
                    if($count >= 3) break;
                ?>
                <div class="news-item">
                    <div class="news-content">
                        <a href="<?php echo __BASE_URL__; ?>news/<?php echo newslink($newsItem[0],$newsItem[1]); ?>" class="news-title">
                            <?php echo htmlspecialchars(substr($newsItem[1], 0, 50)) . (strlen($newsItem[1]) > 50 ? '...' : ''); ?>
                        </a>
                        <div class="news-meta">
                            <span class="news-date">
                                <i class="fas fa-clock me-1"></i>
                                <?php echo templateTimeAgo($newsItem[2]); ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php
                    $count++;
                }
                ?>
            </div>
            <div class="widget-footer">
                <a href="<?php echo __BASE_URL__; ?>news/" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-arrow-right me-1"></i>
                    View All News
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Top Players -->
    <?php
    $rankingsCache = LoadCacheData('character_rankings.cache');
    if(is_array($rankingsCache) && count($rankingsCache) > 0):
    ?>
    <div class="sidebar-widget">
        <h5 class="widget-title">
            <i class="fas fa-trophy me-2"></i>
            Top Players
        </h5>
        <div class="widget-content">
            <div class="rankings-list">
                <?php
                $count = 0;
                foreach($rankingsCache as $player) {
                    if($count >= 5) break;
                    $rank = $count + 1;
                ?>
                <div class="ranking-item">
                    <div class="rank-number rank-<?php echo $rank; ?>">
                        <?php if($rank <= 3): ?>
                            <i class="fas fa-medal"></i>
                        <?php else: ?>
                            <?php echo $rank; ?>
                        <?php endif; ?>
                    </div>
                    <div class="player-info">
                        <a href="<?php echo playerProfile($player[1]); ?>" class="player-name">
                            <?php echo htmlspecialchars($player[1]); ?>
                        </a>
                        <div class="player-level">
                            Level <?php echo number_format($player[2]); ?>
                        </div>
                    </div>
                </div>
                <?php
                    $count++;
                }
                ?>
            </div>
            <div class="widget-footer">
                <a href="<?php echo __BASE_URL__; ?>rankings/" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-list me-1"></i>
                    View All Rankings
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="sidebar-widget">
        <h5 class="widget-title">
            <i class="fas fa-chart-bar me-2"></i>
            Quick Stats
        </h5>
        <div class="widget-content">
            <div class="quick-stats">
                <?php
                // Get total registered users
                $totalUsers = 0;
                if(function_exists('getTotalRegisteredUsers')) {
                    $totalUsers = getTotalRegisteredUsers();
                }
                
                // Get total guilds
                $totalGuilds = 0;
                if(function_exists('getTotalGuilds')) {
                    $totalGuilds = getTotalGuilds();
                }
                ?>
                
                <div class="quick-stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo templateFormatNumber($totalUsers); ?></div>
                        <div class="stat-label">Registered Users</div>
                    </div>
                </div>
                
                <div class="quick-stat-item">
                    <div class="stat-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?php echo templateFormatNumber($totalGuilds); ?></div>
                        <div class="stat-label">Active Guilds</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>