<?php
/**
 * WebEngine CMS - Modern Template Footer
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
?>

<div class="footer-content">
    <div class="container">
        <div class="row">
            <!-- Server Information -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">
                        <i class="fas fa-server me-2"></i>
                        <?php config('server_name'); ?>
                    </h5>
                    <p class="footer-description">
                        Join the ultimate MU Online experience! Explore vast worlds, engage in epic battles, and build your legend in our community.
                    </p>
                    
                    <div class="server-info-grid">
                        <div class="info-item">
                            <span class="info-label">Season:</span>
                            <span class="info-value"><?php echo config('server_info_season', true); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Experience:</span>
                            <span class="info-value"><?php echo config('server_info_exp', true); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Drop Rate:</span>
                            <span class="info-value"><?php echo config('server_info_drop', true); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Max Level:</span>
                            <span class="info-value">400</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">
                        <i class="fas fa-link me-2"></i>
                        Quick Links
                    </h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo __BASE_URL__; ?>"><i class="fas fa-home me-1"></i> Home</a></li>
                        <li><a href="<?php echo __BASE_URL__; ?>register/"><i class="fas fa-user-plus me-1"></i> Register</a></li>
                        <li><a href="<?php echo __BASE_URL__; ?>downloads/"><i class="fas fa-download me-1"></i> Downloads</a></li>
                        <li><a href="<?php echo __BASE_URL__; ?>rankings/"><i class="fas fa-trophy me-1"></i> Rankings</a></li>
                        <?php if(isLoggedIn()): ?>
                        <li><a href="<?php echo __BASE_URL__; ?>usercp/"><i class="fas fa-cog me-1"></i> User Panel</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            
            <!-- Community -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">
                        <i class="fas fa-users me-2"></i>
                        Community
                    </h5>
                    <ul class="footer-links">
                        <li><a href="<?php echo __BASE_URL__; ?>news/"><i class="fas fa-newspaper me-1"></i> Latest News</a></li>
                        <?php if(check_value(config('website_forum_link', true))): ?>
                        <li><a href="<?php echo config('website_forum_link', true); ?>" target="_blank"><i class="fas fa-comments me-1"></i> Forum</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo __BASE_URL__; ?>contact/"><i class="fas fa-envelope me-1"></i> Contact Us</a></li>
                        <li><a href="<?php echo __BASE_URL__; ?>tos/"><i class="fas fa-file-alt me-1"></i> Terms of Service</a></li>
                        <li><a href="<?php echo __BASE_URL__; ?>privacy/"><i class="fas fa-shield-alt me-1"></i> Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <!-- Social & Newsletter -->
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="footer-section">
                    <h5 class="footer-title">
                        <i class="fas fa-share-alt me-2"></i>
                        Stay Connected
                    </h5>
                    
                    <!-- Social Links -->
                    <div class="social-media">
                        <?php
                        $facebook = config('social_link_facebook', true);
                        $instagram = config('social_link_instagram', true);
                        $discord = config('social_link_discord', true);
                        
                        if(check_value($facebook) || check_value($instagram) || check_value($discord)):
                        ?>
                        <p>Follow us on social media for the latest updates:</p>
                        <div class="social-buttons">
                            <?php if(check_value($facebook)): ?>
                            <a href="<?php echo $facebook; ?>" target="_blank" class="social-btn facebook" title="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(check_value($instagram)): ?>
                            <a href="<?php echo $instagram; ?>" target="_blank" class="social-btn instagram" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if(check_value($discord)): ?>
                            <a href="<?php echo $discord; ?>" target="_blank" class="social-btn discord" title="Discord">
                                <i class="fab fa-discord"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Server Status -->
                    <div class="server-status mt-3">
                        <div class="status-card">
                            <div class="status-header">
                                <span class="status-indicator online"></span>
                                <span class="status-text">Server Online</span>
                            </div>
                            <?php
                            $serverInfoCache = LoadCacheData('server_info.cache');
                            if(is_array($serverInfoCache)) {
                                $srvInfo = explode("|", $serverInfoCache[1][0]);
                                if(isset($srvInfo[3])):
                            ?>
                            <div class="status-details">
                                <span class="online-players">
                                    <i class="fas fa-users me-1"></i>
                                    <?php echo number_format($srvInfo[3]); ?> players online
                                </span>
                            </div>
                            <?php 
                                endif;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php config('server_name'); ?>. All rights reserved.</p>
                        <p class="powered-by">
                            Powered by <a href="https://webenginecms.org/" target="_blank" class="webengine-link">WebEngine CMS</a> 
                            <span class="version">v<?php echo __WEBENGINE_VERSION__; ?></span>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-meta text-md-end">
                        <div class="server-time">
                            <i class="fas fa-clock me-1"></i>
                            Server Time: <span id="footerServerTime">&nbsp;</span>
                        </div>
                        <div class="page-load-time">
                            <i class="fas fa-tachometer-alt me-1"></i>
                            <span>Page loaded in <span id="pageLoadTime">0.000</span>s</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Back to Top Button -->
<div class="back-to-top">
    <button id="backToTopBtn" class="btn btn-primary btn-floating">
        <i class="fas fa-chevron-up"></i>
    </button>
</div>

<script>
// Footer JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Update server time in footer
    function updateFooterTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour12: false,
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        
        const footerTimeElement = document.getElementById('footerServerTime');
        if (footerTimeElement) {
            footerTimeElement.textContent = timeString;
        }
    }
    
    // Update time immediately and then every second
    updateFooterTime();
    setInterval(updateFooterTime, 1000);
    
    // Calculate and display page load time
    window.addEventListener('load', function() {
        const loadTime = (performance.timing.loadEventEnd - performance.timing.navigationStart) / 1000;
        const loadTimeElement = document.getElementById('pageLoadTime');
        if (loadTimeElement) {
            loadTimeElement.textContent = loadTime.toFixed(3);
        }
    });
    
    // Back to top functionality
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.style.display = 'block';
            } else {
                backToTopBtn.style.display = 'none';
            }
        });
        
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
</script>