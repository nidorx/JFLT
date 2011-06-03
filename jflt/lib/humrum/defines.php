<?php

// no direct access
defined('JFLT_EXEC') or die('Restricted access');

/**
 * jflt! Application define
 */
//Global definitions
$parts = explode(DS, JPATH_BASE);

//Defines
define('JPATH_ROOT', implode(DS, $parts));

define('JPATH_SITE', JPATH_ROOT);
define('JPATH_CONFIGURATION', JPATH_ROOT);
define('JPATH_ADMINISTRATOR', JPATH_ROOT . DS . 'administrator');
define('JPATH_XMLRPC', JPATH_ROOT . DS . 'xmlrpc');
define('JPATH_LIBRARIES', JPATH_ROOT . DS . 'libraries');
define('JPATH_PLUGINS', JPATH_ROOT . DS . 'plugins');
define('JPATH_INSTALLATION', JPATH_ROOT . DS . 'installation');
define('JPATH_THEMES', JPATH_BASE . DS . 'templates');
define('JPATH_CACHE', JPATH_BASE . DS . 'cache');



//Browser definitions
define('BROWSER_UNKNOWN', 'unknown');
define('VERSION_UNKNOWN ', 'unknown');
define('BROWSER_OPERA ', 'Opera');                               // http://www.opera.com/
define('BROWSER_OPERA_MINI ', 'Opera Mini');                          // http://www.opera.com/mini/
define('BROWSER_WEBTV ', 'WebTV');                               // http://www.webtv.net/pc/
define('BROWSER_IE ', 'Internet Explorer');                   // http://www.microsoft.com/ie/
define('BROWSER_POCKET_IE ', 'Pocket Internet Explorer');            // http://en.wikipedia.org/wiki/Internet_Explorer_Mobile
define('BROWSER_KONQUEROR ', 'Konqueror');                           // http://www.konqueror.org/
define('BROWSER_ICAB ', 'iCab');                                // http://www.icab.de/
define('BROWSER_OMNIWEB ', 'OmniWeb');                             // http://www.omnigroup.com/applications/omniweb/
define('BROWSER_FIREBIRD ', 'Firebird');                            // http://www.ibphoenix.com/
define('BROWSER_FIREFOX ', 'Firefox');                             // http://www.mozilla.com/en-US/firefox/firefox.html
define('BROWSER_ICEWEASEL ', 'Iceweasel');                           // http://www.geticeweasel.org/
define('BROWSER_SHIRETOKO ', 'Shiretoko');                           // http://wiki.mozilla.org/Projects/shiretoko
define('BROWSER_MOZILLA ', 'Mozilla');                             // http://www.mozilla.com/en-US/
define('BROWSER_AMAYA ', 'Amaya');                               // http://www.w3.org/Amaya/
define('BROWSER_LYNX ', 'Lynx');                                // http://en.wikipedia.org/wiki/Lynx
define('BROWSER_SAFARI ', 'Safari');                              // http://apple.com
define('BROWSER_IPHONE ', 'iPhone');                              // http://apple.com
define('BROWSER_IPOD ', 'iPod');                                // http://apple.com
define('BROWSER_IPAD ', 'iPad');                                // http://apple.com
define('BROWSER_CHROME ', 'Chrome');                              // http://www.google.com/chrome
define('BROWSER_ANDROID ', 'Android');                             // http://www.android.com/
define('BROWSER_GOOGLEBOT ', 'GoogleBot');                           // http://en.wikipedia.org/wiki/Googlebot
define('BROWSER_SLURP ', 'Yahoo! Slurp');                        // http://en.wikipedia.org/wiki/Yahoo!_Slurp
define('BROWSER_W3CVALIDATOR ', 'W3C Validator');                       // http://validator.w3.org/
define('BROWSER_BLACKBERRY ', 'BlackBerry');                          // http://www.blackberry.com/
define('BROWSER_ICECAT ', 'IceCat');                              // http://en.wikipedia.org/wiki/GNU_IceCat
define('BROWSER_NOKIA_S60 ', 'Nokia S60 OSS Browser');               // http://en.wikipedia.org/wiki/Web_Browser_for_S60
define('BROWSER_NOKIA ', 'Nokia Browser');                       // * all other WAP-based browsers on the Nokia Platform
define('BROWSER_MSN ', 'MSN Browser');                         // http://explorer.msn.com/
define('BROWSER_MSNBOT ', 'MSN Bot');                             // http://search.msn.com/msnbot.htm
// http://en.wikipedia.org/wiki/Msnbot  (used for Bing as well)
define('BROWSER_NETSCAPE_NAVIGATOR ', 'Netscape Navigator');                  // http://browser.netscape.com/ (DEPRECATED)
define('BROWSER_GALEON ', 'Galeon');                              // http://galeon.sourceforge.net/ (DEPRECATED)
define('BROWSER_NETPOSITIVE ', 'NetPositive');                         // http://en.wikipedia.org/wiki/NetPositive (DEPRECATED)
define('BROWSER_PHOENIX ', 'Phoenix');                             // http://en.wikipedia.org/wiki/History_of_Mozilla_Firefox (DEPRECATED)
//Platform definitions
define('PLATFORM_UNKNOWN ', 'unknown');
define('OPERATING_SYSTEM_UNKNOWN ', 'unknown');

define('PLATFORM_WINDOWS ', 'Windows');
define('PLATFORM_WINDOWS_CE ', 'Windows CE');
define('PLATFORM_APPLE ', 'Apple');
define('PLATFORM_LINUX ', 'Linux');
define('PLATFORM_OS2 ', 'OS/2');
define('PLATFORM_BEOS ', 'BeOS');
define('PLATFORM_IPHONE ', 'iPhone');
define('PLATFORM_IPOD ', 'iPod');
define('PLATFORM_IPAD ', 'iPad');
define('PLATFORM_BLACKBERRY ', 'BlackBerry');
define('PLATFORM_NOKIA ', 'Nokia');
define('PLATFORM_FREEBSD ', 'FreeBSD');
define('PLATFORM_OPENBSD ', 'OpenBSD');
define('PLATFORM_NETBSD ', 'NetBSD');
define('PLATFORM_SUNOS ', 'SunOS');
define('PLATFORM_OPENSOLARIS ', 'OpenSolaris');
define('PLATFORM_ANDROID ', 'Android');
?>
