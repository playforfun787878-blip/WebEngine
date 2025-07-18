<?php
/**
 * WebEngine CMS - Modern Template
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
include('inc/template.functions.php');

$serverInfoCache = LoadCacheData('server_info.cache');
if(is_array($serverInfoCache)) {
	$srvInfo = explode("|", $serverInfoCache[1][0]);
}

$maxOnline = config('maximum_online', true);
$onlinePlayers = isset($srvInfo[3]) ? $srvInfo[3] : 0;
$onlinePlayersPercent = check_value($maxOnline) ? $onlinePlayers*100/$maxOnline : 0;

if(!isset($_REQUEST['page'])) {
	$_REQUEST['page'] = '';
}

if(!isset($_REQUEST['subpage'])) {
	$_REQUEST['subpage'] = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php $handler->websiteTitle(); ?></title>
    <meta name="generator" content="WebEngine <?php echo __WEBENGINE_VERSION__; ?>">
    <meta name="author" content="Lautaro Angelico">
    <meta name="description" content="<?php config('website_meta_description'); ?>">
    <meta name="keywords" content="<?php config('website_meta_keywords'); ?>">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php $handler->websiteTitle(); ?>">
    <meta property="og:description" content="<?php config('website_meta_description'); ?>">
    <meta property="og:image" content="<?php echo __PATH_IMG__; ?>webengine.jpg">
    <meta property="og:url" content="<?php echo __BASE_URL__; ?>">
    <meta property="og:site_name" content="<?php $handler->websiteTitle(); ?>">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="<?php $handler->websiteTitle(); ?>">
    <meta property="twitter:description" content="<?php config('website_meta_description'); ?>">
    <meta property="twitter:image" content="<?php echo __PATH_IMG__; ?>webengine.jpg">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo __PATH_TEMPLATE__; ?>favicon.ico">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>style.css" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>animations.css" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>components.css" rel="stylesheet">
    <link href="<?php echo __PATH_TEMPLATE_CSS__; ?>responsive.css" rel="stylesheet">
    
    <script>
        var baseUrl = '<?php echo __BASE_URL__; ?>';
    </script>
</head>
<body class="modern-theme">
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader">
            <div class="spinner"></div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <!-- Background Effects -->
    <div class="background-effects">
        <div class="particles" id="particles"></div>
        <div class="grid-overlay"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo __BASE_URL__; ?>">
                <img src="<?php echo __PATH_TEMPLATE_IMG__; ?>logo.png" alt="<?php config('server_name'); ?>" class="logo">
                <span class="brand-text"><?php config('server_name'); ?></span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php templateBuildNavbar(); ?>
                </ul>
                
                <div class="navbar-nav ms-auto">
                    <?php if(config('language_switch_active',true)): ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-globe"></i> Language
                            </a>
                            <ul class="dropdown-menu">
                                <?php templateLanguageSelector(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <?php if(isLoggedIn()): ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo $_SESSION['username']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo __BASE_URL__; ?>usercp/"><i class="fas fa-cog"></i> <?php echo lang('module_titles_txt_3'); ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item logout" href="<?php echo __BASE_URL__; ?>logout/"><i class="fas fa-sign-out-alt"></i> <?php echo lang('menu_txt_6'); ?></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a class="nav-link btn btn-outline-primary me-2" href="<?php echo __BASE_URL__; ?>login/">
                            <i class="fas fa-sign-in-alt"></i> <?php echo lang('menu_txt_4'); ?>
                        </a>
                        <a class="nav-link btn btn-primary" href="<?php echo __BASE_URL__; ?>register/">
                            <i class="fas fa-user-plus"></i> <?php echo lang('menu_txt_3'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Server Status Bar -->
    <div class="server-status-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="server-info">
                        <div class="status-indicator online"></div>
                        <span class="status-text">Server Online</span>
                        <?php if(check_value(config('maximum_online', true))): ?>
                            <span class="online-count">
                                <i class="fas fa-users"></i> 
                                <span class="count"><?php echo number_format($onlinePlayers); ?></span>
                                <span class="max">/ <?php echo number_format($maxOnline); ?></span>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <div class="server-time">
                        <i class="fas fa-clock"></i>
                        <span id="serverTime">&nbsp;</span>
                    </div>
                </div>
            </div>
            
            <?php if(check_value(config('maximum_online', true))): ?>
                <div class="online-progress">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $onlinePlayersPercent; ?>%" aria-valuenow="<?php echo $onlinePlayersPercent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <?php if($_REQUEST['page'] == 'usercp' && $_REQUEST['subpage'] != ''): ?>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="content-wrapper">
                            <?php $handler->loadModule($_REQUEST['page'],$_REQUEST['subpage']); ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <?php include(__PATH_TEMPLATE_ROOT__ . 'inc/modules/sidebar.php'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12">
                        <div class="content-wrapper">
                            <?php $handler->loadModule($_REQUEST['page'],$_REQUEST['subpage']); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <?php include(__PATH_TEMPLATE_ROOT__ . 'inc/modules/footer.php'); ?>
    </footer>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo __PATH_TEMPLATE_JS__; ?>particles.min.js"></script>
    <script src="<?php echo __PATH_TEMPLATE_JS__; ?>animations.js"></script>
    <script src="<?php echo __PATH_TEMPLATE_JS__; ?>main.js"></script>
    <script src="<?php echo __PATH_TEMPLATE_JS__; ?>events.js"></script>
</body>
</html>