<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Environment Helper Function
|--------------------------------------------------------------------------
*/
if (!function_exists('env')) {
	function env($key, $default = null)
	{
		$value = getenv($key);
		if ($value === false) {
			return $default;
		}
		return $value;
	}
}

/*
|--------------------------------------------------------------------------
| Base Site URL (Auto-detect)
|--------------------------------------------------------------------------
*/
// Auto-detect base URL (works for both local and production)

$host = $_SERVER['HTTP_HOST'];
$path = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
if ($host == 'localhost') {
	$config['base_url'] = 'http://' . $host . $path;
} else {
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
		(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		? 'https' : 'http';
	$config['base_url'] = $protocol . '://' . $host . $path;
}

/*
|--------------------------------------------------------------------------
| Index File
|--------------------------------------------------------------------------
*/
$config['index_page'] = env('index_page', '');

/*
|--------------------------------------------------------------------------
| URI PROTOCOL
|--------------------------------------------------------------------------
*/
$config['uri_protocol'] = env('uri_protocol', 'REQUEST_URI');

/*
|--------------------------------------------------------------------------
| URL suffix
|--------------------------------------------------------------------------
*/
$config['url_suffix'] = env('url_suffix', '');

/*
|--------------------------------------------------------------------------
| Default Language
|--------------------------------------------------------------------------
*/
$config['language'] = env('language', 'english');

/*
|--------------------------------------------------------------------------
| Default Character Set
|--------------------------------------------------------------------------
*/
$config['charset'] = env('charset', 'UTF-8');

/*
|--------------------------------------------------------------------------
| Enable/Disable System Hooks
|--------------------------------------------------------------------------
*/
$config['enable_hooks'] = env('enable_hooks', TRUE);

/*
|--------------------------------------------------------------------------
| Class Extension Prefix
|--------------------------------------------------------------------------
*/
$config['subclass_prefix'] = env('subclass_prefix', 'MY_');

/*
|--------------------------------------------------------------------------
| Composer auto-loading
|--------------------------------------------------------------------------
*/
$config['composer_autoload'] = FCPATH . 'vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Allowed URL Characters
|--------------------------------------------------------------------------
*/
$config['permitted_uri_chars'] = env('permitted_uri_chars', 'a-z 0-9~%.:_\-');

/*
|--------------------------------------------------------------------------
| Enable Query Strings
|--------------------------------------------------------------------------
*/
$config['enable_query_strings'] = env('enable_query_strings', FALSE);
$config['controller_trigger'] = env('controller_trigger', 'c');
$config['function_trigger'] = env('function_trigger', 'm');
$config['directory_trigger'] = env('directory_trigger', 'd');

/*
|--------------------------------------------------------------------------
| Allow $_GET array
|--------------------------------------------------------------------------
*/
$config['allow_get_array'] = env('allow_get_array', TRUE);

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over 0. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = (ENVIRONMENT === 'production') ? 1 : env('log_threshold', 0);

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
*/
$config['log_path'] = env('log_path', APPPATH . 'logs/');

/*
|--------------------------------------------------------------------------
| Log File Extension
|--------------------------------------------------------------------------
*/
$config['log_file_extension'] = env('log_file_extension', '');

/*
|--------------------------------------------------------------------------
| Log File Permissions
|--------------------------------------------------------------------------
*/
$config['log_file_permissions'] = env('log_file_permissions', 0644);

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
*/
$config['log_date_format'] = env('log_date_format', 'Y-m-d H:i:s');

/*
|--------------------------------------------------------------------------
| Error Views Directory Path
|--------------------------------------------------------------------------
*/
$config['error_views_path'] = env('error_views_path', '');

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
*/
$config['cache_path'] = env('cache_path', '');

/*
|--------------------------------------------------------------------------
| Cache Include Query String
|--------------------------------------------------------------------------
*/
$config['cache_query_string'] = env('cache_query_string', FALSE);

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class, you must set an encryption key.
| See the user guide for more info.
|
| IMPORTANT: Do not use the same key across multiple applications!
| Generate a unique key for each application.
|
*/
$config['encryption_key'] = env('encryption_key', 'your-32-character-encryption-key-here');

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
*/
$config['sess_driver'] = env('sess_driver', 'files');
$config['sess_cookie_name'] = env('sess_cookie_name', 'ci_session');
$config['sess_samesite'] = env('sess_samesite', 'Lax');
$config['sess_expiration'] = env('sess_expiration', 7200);
$config['sess_save_path'] = APPPATH . 'sessions/';
$config['sess_match_ip'] = env('sess_match_ip', FALSE);
$config['sess_time_to_update'] = env('sess_time_to_update', 300);
$config['sess_regenerate_destroy'] = env('sess_regenerate_destroy', FALSE);

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
|
| 'cookie_secure' = TRUE/FALSE - Should only be sent over HTTPS
| 'cookie_httponly' = TRUE/FALSE - Prevents JavaScript access to cookies
| 'cookie_samesite' = 'None', 'Lax', or 'Strict' - CSRF protection
|
*/
$config['cookie_prefix'] = env('cookie_prefix', '');
$config['cookie_domain'] = env('cookie_domain', '');
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;
$config['cookie_httponly'] = FALSE;
$config['cookie_samesite'] = env('cookie_samesite', 'Lax');

/*
|--------------------------------------------------------------------------
| Standardize newlines
|--------------------------------------------------------------------------
*/
$config['standardize_newlines'] = env('standardize_newlines', FALSE);

/*
|--------------------------------------------------------------------------
| Global XSS Filtering
|--------------------------------------------------------------------------
|
| Determines whether the XSS filter is always active when GET, POST or
| COOKIE data is encountered
|
| WARNING: This feature is DEPRECATED and currently available only
|          for backwards compatibility purposes!
|
*/
$config['global_xss_filtering'] = (ENVIRONMENT === 'production') ? TRUE : env('global_xss_filtering', FALSE);

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
|
| Enables a CSRF cookie token to be set. When set to TRUE, token will be
| checked on a submitted form. If you are accepting user data, it is strongly
| recommended CSRF protection be enabled.
|
| 'csrf_token_name' = The token name
| 'csrf_cookie_name' = The cookie name
| 'csrf_expire' = The number in seconds the token should expire.
| 'csrf_regenerate' = Regenerate token on every submission
| 'csrf_exclude_uris' = Array of URIs which ignore CSRF checks
|
*/
$config['csrf_protection'] = env('csrf_protection', FALSE);
$config['csrf_token_name'] = env('csrf_token_name', 'csrf_token');
$config['csrf_cookie_name'] = env('csrf_cookie_name', 'csrf_cookie');
$config['csrf_expire'] = env('csrf_expire', 7200);
$config['csrf_regenerate'] = env('csrf_regenerate', TRUE);
$config['csrf_exclude_uris'] = array('admin/logs_ajax');

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
|
| Enables Gzip output compression for faster page loads.  When enabled,
| the output class will test whether your server supports Gzip.
| Even if it does, however, not all browsers support compression
| so enable only if you are reasonably sure your visitors can handle it.
|
| Only used if zlib.output_compression is turned off in your php.ini.
| Please do not use it together with httpd-level output compression.
|
| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
| means you are prematurely outputting something to your browser. It could
| even be a line of whitespace at the end of one of your scripts.  For
| compression to work, nothing can be sent before the output buffer is called
| by the output class.  Do not 'echo' any values with compression enabled.
|
*/
$config['compress_output'] = (ENVIRONMENT === 'production') ? TRUE : env('compress_output', FALSE);

/*
|--------------------------------------------------------------------------
| Master Time Reference
|--------------------------------------------------------------------------
*/
$config['time_reference'] = env('time_reference', 'local');

/*
|--------------------------------------------------------------------------
| Rewrite PHP Short Tags
|--------------------------------------------------------------------------
*/
$config['rewrite_short_tags'] = env('rewrite_short_tags', FALSE);

/*
|--------------------------------------------------------------------------
| Reverse Proxy IPs
|--------------------------------------------------------------------------
*/
$config['proxy_ips'] = env('proxy_ips', '');
