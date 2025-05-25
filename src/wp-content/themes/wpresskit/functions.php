<?php
flush_rewrite_rules();

// Version project
require_once get_template_directory() . '/includes/Version.php';

// Force postname permalinks
require_once get_template_directory() . '/includes/ForceStructurePostPermalinks.php';

// Force installation plugins
require_once get_template_directory() . '/includes/ForceInstallationPlugins.php';

// Utils
require_once get_template_directory() . '/includes/Utils.php';

// Validations
require_once get_template_directory() . '/includes/Validations.php'; 

// Allow API Cors
require_once get_template_directory() . '/includes/AllowHostCors.php'; 

// Theme Supports
require_once get_template_directory() . '/includes/ThemeSupports.php'; 

// Images Sizes
require_once get_template_directory() . '/includes/ImageSizes.php'; 

// Handle users wordpress
require_once get_template_directory() . '/includes/Users.php'; 

// Import javascript on admin
require_once get_template_directory() . '/includes/AdminJs.php'; 

//
// Services
require_once get_template_directory() . '/services/EmailService.php'; 

//
// Modules
require_once get_template_directory() . '/modules/FormNotification/init.php'; 
require_once get_template_directory() . '/modules/Form/init.php'; 
require_once get_template_directory() . '/modules/FormContact/init.php'; 
require_once get_template_directory() . '/modules/FormLead/init.php'; 
require_once get_template_directory() . '/modules/Blog/init.php'; 
require_once get_template_directory() . '/modules/Comment/init.php'; 

//
// Adaptsers
require_once get_template_directory() . '/adapters/RWMBMeta/init.php'; 