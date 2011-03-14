<?php

define('DWLS_JS_PARAM', 'dwls_js');
define('DWLS_CSS_PARAM', 'dwls_css');

/**
 * Description of DWLSResources
 */
class DWLSResources {

    public static function parse_request($wp) {

        // Javascript resources
        if (array_key_exists(DWLS_JS_PARAM, $_GET) && !empty($_GET[DWLS_JS_PARAM])) {
            switch($_GET[DWLS_JS_PARAM]) {
                case 'livesearch':
                    $file_path = dirname(__FILE__) . "/daves-wordpress-live-search.js";
                    break;
                case 'dimensions':
                    $file_path = dirname(__FILE__) . "/jquery.dimensions.pack.js";
                    break;
                default;
                    // unknown
                    exit;

            }
            header('Content-Type: text/javascript');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        }

        // CSS resource
        if (array_key_exists(DWLS_CSS_PARAM, $_GET) && !empty($_GET[DWLS_CSS_PARAM])) {
            $cssOption = get_option('daves-wordpress-live-search_css_option');

            switch ($cssOption) {
                case 'default_red':
                    $file_path = dirname(__FILE__) . "/daves-wordpress-live-search_default_red.css";
                    break;
                case 'default_blue':
                    $file_path = dirname(__FILE__) . "/daves-wordpress-live-search_default_blue.css";
                    break;
                case 'default_gray':
                default:
                    $file_path = dirname(__FILE__) . "/daves-wordpress-live-search_default_gray.css";
            }

            header('Content-Type: text/css');
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
            exit;
        }
    }

}

add_action('parse_request', array('DWLSResources', 'parse_request'));
