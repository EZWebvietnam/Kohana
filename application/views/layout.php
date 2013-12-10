<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" dir="ltr" >
<head>
	<title><?php echo isset($title) ? $title : '';?></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="copyright" content="Nguyễn Văn Nguyên" />
	<meta name="author" content="Nguyễn Văn Nguyên" />
</head>
<body>
<?php echo isset($content) ? $content : ''; ?>
</body>
</html>