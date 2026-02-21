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
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
	(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
	? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$path = '/simpintar/';
$config['base_url'] = $protocol . '://' . $host . $path;

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
$config['composer_autoload'] = env('composer_autoload', FALSE);

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
*/
$config['log_threshold'] = env('log_threshold', 0);

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
*/
$config['encryption_key'] = env('encryption_key', '');

/*
|--------------------------------------------------------------------------
| Session Variables
|--------------------------------------------------------------------------
*/
$config['sess_driver'] = env('sess_driver', 'files');
$config['sess_cookie_name'] = env('sess_cookie_name', 'ci_session');
$config['sess_samesite'] = env('sess_samesite', 'Lax');
$config['sess_expiration'] = env('sess_expiration', 7200);
$config['sess_save_path'] = env('sess_save_path', NULL);
$config['sess_match_ip'] = env('sess_match_ip', FALSE);
$config['sess_time_to_update'] = env('sess_time_to_update', 300);
$config['sess_regenerate_destroy'] = env('sess_regenerate_destroy', FALSE);

/*
|--------------------------------------------------------------------------
| Cookie Related Variables
|--------------------------------------------------------------------------
*/
$config['cookie_prefix'] = env('cookie_prefix', '');
$config['cookie_domain'] = env('cookie_domain', '');
$config['cookie_path'] = env('cookie_path', '/');
$config['cookie_secure'] = env('cookie_secure', FALSE);
$config['cookie_httponly'] = env('cookie_httponly', FALSE);
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
*/
$config['global_xss_filtering'] = env('global_xss_filtering', FALSE);

/*
|--------------------------------------------------------------------------
| Cross Site Request Forgery
|--------------------------------------------------------------------------
*/
$config['csrf_protection'] = env('csrf_protection', FALSE);
$config['csrf_token_name'] = env('csrf_token_name', 'csrf_token');
$config['csrf_cookie_name'] = env('csrf_cookie_name', 'csrf_cookie');
$config['csrf_expire'] = env('csrf_expire', 7200);
$config['csrf_regenerate'] = env('csrf_regenerate', TRUE);
$config['csrf_exclude_uris'] = array();

/*
|--------------------------------------------------------------------------
| Output Compression
|--------------------------------------------------------------------------
*/
$config['compress_output'] = env('compress_output', FALSE);

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
