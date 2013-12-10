<?php defined('SYSPATH') or die('No direct script access.');

class HTML extends Kohana_HTML {

	private static $_options = array(
		'mode' => 'exact',
		'theme' => 'advanced',
		'theme_advanced_toolbar_location' => 'top',
		'theme_advanced_toolbar_align' => 'left',
		'theme_advanced_path_location' => 'bottom',
		'theme_advanced_resizing' => 'true',
		'extended_valid_elements' => 'a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]',
		'theme_advanced_buttons1' => 'formatselect,fontselect,fontsizeselect,separator,bold,italic,underline,strikethrough,sub,sup,separator,pastetext,pasteword,',
		'theme_advanced_buttons2' => 'justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,separator,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,charmap,separator,removeformat,code,help',
		'theme_advanced_buttons3' => 'tablecontrols,|,insertimage',
		'width' => '470px',
		'height' => '250px',
		//'force_br_newlines' => true,
		//'force_p_newlines' => false,
	);
 
	private static $_langs = array(
		'ar' => 'ar',
		'ca' => 'ca',
		'cs' => 'cs',
		'cy' => 'cy',
		'da' => 'da',
		'de' => 'de',
		'el' => 'el',
		'en' => 'en',
		'en_US' => 'en',
		'es' => 'es',
		'fa' => 'fa',
		'fi' => 'fi',
		'fr' => 'fr',
		'fr_CA' => 'fr_ca',
		'he' => 'he',
		'hu' => 'hu',
		'is' => 'is',
		'it' => 'it',
		'ja' => 'ja_utf-8',
		'ko' => 'ko',
		'nb' => 'nb',
		'nl' => 'nl',
		'nn' => 'nn',
		'pl' => 'pl',
		'pt' => 'pt',
		'pt_BR' => 'pt_br',
		'ro' => 'ro',
		'ru' => 'ru',
		'si' => 'si',
		'sk' => 'sk',
		'sq' => 'sq',
		'sr' => 'sr',
		'sv' => 'sv_utf8',
		'th' => 'th',
		'tr' => 'tr',
		'vi' => 'vi',
		'vi_VN' => 'vi',
		'zh' => 'zh_cn_utf8',
		'zh_CN' => 'zh_cn_utf8',
		'zh_TW' => 'zh_tw_utf8'
	);

	private static $_plugins = array(
		'safari',
		'pagebreak',
		'style',
		'layer',
		'table',
		'save',
		'advhr',
		'advimage',
		'advlink',
		'iespell',
		'inlinepopups',
		'preview',
		'media',
		'searchreplace',
		'print',
		'contextmenu',
		'paste',
		'directionality',
		'fullscreen',
		'noneditable',
		'visualchars',
		'nonbreaking',
		'xhtmlxtras',
		'template',
		'imagemanager',
	);

	private static $_themes = array(
		'simple',
		'advanced'
	);

	private static function _init_file_manager()
	{
		$base_url = URL::base();
		$stored_language = Session::instance()->get('language', 'en-us');
		$language = !empty($stored_language) ? $stored_language : 'en';
		$script = <<<EOT
			function fileManager(field_name, url, type, win)
			{
				switch (type)
				{
					case "image":
						break;
					default:
						return false;
				}
				tinyMCE.activeEditor.windowManager.open({
					url: '$base_url' + 'scripts/filemanager/ajaxfilemanager.php?language=$language',
					width: 782,
					height: 440,
					inline : "yes",
					close_previous : "no"
				},{
					window : win,
					input : field_name
				});
			}
EOT;
		return $script;
	}
	
	public static function tinymce($elements, array $options = array(), $has_file_manager = false)
	{
		if(is_array($elements))
		{
			self::$_options['elements'] = implode(',',$elements);
		}
		else
		{
			self::$_options['elements'] = (string) $elements;
		}
		if(isset($options['plugins']))
		{
			$plugins = is_array($options['plugins']) ? $options['plugins'] : array((string) $options['plugins']);
			self::$_options['plugins'] = (count($plugins) > 0) ? implode(',', $plugins) : implode(',', self::$_plugins);
		}
		else
		{
			self::$_options['plugins'] = implode(',', self::$_plugins);
		}

		$stored_language = Session::instance()->get('language', 'en-us');
		self::$_options['language'] = (isset(self::$_langs[$stored_language])) ? self::$_langs[$stored_language] : 'vi';
		
		self::$_options = array_merge(self::$_options, $options);
		$script = '';
		if($has_file_manager)
		{
			self::$_options['file_browser_callback'] = 'fileManager';
			$script .= "\n" . self::_init_file_manager();
		}
		$render_text = HTML::script('scripts/tiny_mce/tiny_mce.js');
		$script .= "if(typeof(tinyMCE)!='undefined'){tinyMCE.init(".self::encode_js(self::$_options,true,true).");}";
		$render_text .= self::script_block($script);
		return $render_text;
	}

	public static function script_blocks(array $scripts = array())
	{
		if(count($scripts))
			return "<script type=\"text/javascript\">\n/*<![CDATA[*/\n" . implode("\n", $scripts) . "\n/*]]>*/\n</script>\n";
		else
			return '';
	}

	public static function script_block($script)
	{
		return "<script type=\"text/javascript\">\n/*<![CDATA[*/\n{$script}\n/*]]>*/\n</script>\n";
	}

	public static function style_blocks(array $styles = array())
	{
		if(count($styles))
			return "<style type=\"text/css\">\n" . implode("\n", $styles) . "\n</style>\n";
		else
			return '';
	}
	
	public static function quote_string($js, $for_url=false)
	{
		if($for_url)
			return strtr($js,array('%'=>'%25',"\t"=>'\t',"\n"=>'\n',"\r"=>'\r','"'=>'\"','\''=>'\\\'','\\'=>'\\\\'));
		else
			return strtr($js,array("\t"=>'\t',"\n"=>'\n',"\r"=>'\r','"'=>'\"','\''=>'\\\'','\\'=>'\\\\'));
	}

	public static function quote_function($js)
	{
		if(self::is_js_function($js))
			return $js;
		else
			return 'javascript:'.$js;
	}

	public static function is_js_function($js)
	{
		return preg_match('/^\s*javascript:/i', $js);
	}

	public static function encode_js($value, $to_map=true, $encode_empty_strings=false)
	{
		if(is_string($value))
		{
			if(($n=strlen($value))>2)
			{
				$first=$value[0];
				$last=$value[$n-1];
				if(($first==='[' && $last===']') || ($first==='{' && $last==='}'))
					return $value;
			}

			if(self::is_js_function($value))
			{
				return preg_replace('/^\s*javascript:/', '', $value);
			}
			else
			{
				return "'".self::quote_string($value)."'";
			}
		}
		elseif(is_bool($value))
		{
			return $value?'true':'false';
		}
		elseif(is_array($value))
		{
			$results='';
			if(($n=count($value))>0 && array_keys($value)!==range(0,$n-1))
			{
				foreach($value as $k=>$v)
				{
					if($v!=='' || $encode_empty_strings)
					{
						if($results!=='') $results.=',';
						$results.="'$k':".self::encode_js($v,$to_map,$encode_empty_strings);
					}
				}
				return '{'.$results.'}';
			}
			else
			{
				foreach($value as $v)
				{
					if($v!=='' || $encode_empty_strings)
					{
						if($results!=='') $results.=',';
						$results.=self::encode_js($v,$to_map, $encode_empty_strings);
					}
				}
				return '['.$results.']';
			}
		}
		elseif(is_integer($value))
		{
			return "$value";
		}
		elseif(is_float($value))
		{
			if($value===-INF)
				return 'Number.NEGATIVE_INFINITY';
			elseif($value===INF)
				return 'Number.POSITIVE_INFINITY';
			else
				return "$value";
		}
		elseif(is_object($value))
			return self::encode_js(get_object_vars($value),$to_map);
		elseif($value===null)
			return 'null';
		else
			return '';
	}

	public static function json_encode($value)
	{
		if(self::$_json === null)
		{
			self::$_json = new JSON;
		}
		return self::$_json->encode($value);
	}

	public static function json_decode($value)
	{
		if(self::$_json === null)
		{
			self::$_json = new JSON;
		}
		return self::$_json->decode($value);
	}
} // End HTML
