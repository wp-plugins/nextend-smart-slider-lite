<?php
    global $table_prefix;

define('WP_TABLE_PREFIX', $table_prefix);

$tmp = wp_upload_dir();
define('WP_SS_TMP', $tmp['path']);

class JConfig {
	public $offline = '0';
	public $offline_message = '';
	public $display_offline_message = '1';
	public $offline_image = '';
	public $sitename = 'R25';
	public $editor = 'tinymce';
	public $captcha = 'recaptcha';
	public $list_limit = '20';
	public $access = '1';
	public $debug = '0';
	public $debug_lang = '0';
	public $dbtype = 'mysqlwp';
	public $host = DB_HOST;
	public $user = DB_USER;
	public $password = DB_PASSWORD;
	public $db = DB_NAME;
	public $dbprefix = WP_TABLE_PREFIX;
	public $live_site = '';
	public $secret = 'HqFJDP1mgVyCbBB5';
	public $gzip = '0';
	public $error_reporting = 'default';
	public $helpurl = 'http://help.joomla.org/proxy/index.php?option=com_help&amp;keyref=Help{major}{minor}:{keyref}';
	public $ftp_host = '127.0.0.1';
	public $ftp_port = '21';
	public $ftp_user = '';
	public $ftp_pass = '';
	public $ftp_root = '';
	public $ftp_enable = '0';
	public $offset = 'UTC';
	public $offset_user = 'UTC';
	public $mailer = 'mail';
	public $mailfrom = 'info@nextendweb.com';
	public $fromname = 'R25';
	public $sendmail = '/usr/sbin/sendmail';
	public $smtpauth = '0';
	public $smtpuser = '';
	public $smtppass = '';
	public $smtphost = 'localhost';
	public $smtpsecure = 'none';
	public $smtpport = '25';
	public $caching = '0';
	public $cache_handler = 'file';
	public $cachetime = '15';
	public $MetaDesc = '';
	public $MetaKeys = '';
	public $MetaTitle = '1';
	public $MetaAuthor = '1';
	public $sef = '1';
	public $sef_rewrite = '0';
	public $sef_suffix = '0';
	public $unicodeslugs = '0';
	public $feed_limit = '10';
	public $log_path = WP_SS_TMP;
	public $tmp_path = WP_SS_TMP;
	public $lifetime = '15';
	public $session_handler = 'none';
}