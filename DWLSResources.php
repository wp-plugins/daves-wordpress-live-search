<?php

/**
 * Copyright (c) 2009 Dave Ross <dave@csixty4.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 * persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * */

define('DWLS_JS_PARAM', 'dwls_js');
define('DWLS_CSS_PARAM', 'dwls_css');

/**
 * Description of DWLSResources
 */
class DWLSResources {

    public static function parse_request($wp) {


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

// Javascript resources don't require database access, so they can
// be processed before WordPress is done spinning up
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
