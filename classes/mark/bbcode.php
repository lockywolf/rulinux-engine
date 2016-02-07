<?php
function str_to_html($string)
{
	$code = array();
	$lang = array();
	$code_re = "#(\\[code)=?(abap|actionscript|actionscript3|ada|apache|applescript|apt_sources|asm|asp|autoit|avisynth|bash|basic4gl|bf|bibtex|blitzbasic|bnf|boo|c|c_mac|caddcl|cadlisp|cfdg|cfm|cil|cmake|cobol|cpp|cpp-qt|csharp|css|d|dcs|delphi|diff|div|dos|dot|eiffel|e-mail|erlang|fo|fortran|freebasic|genero|gettext|glsl|gml|gnuplot|groovy|haskell|hq9plus|html4strict|idl|ini|inno|intercal|io|java|java5|javascript|kixtart|klonec|latex|lisp|locobasic|lolcode|lotusformulas|lotusscript|lscript|lsl2|lua|m68k|make|matlab|mirc|modula3|mpasm|mxml|mysql|nsis|oberon2|objc|ocaml|ocaml-brief|oobas|oracle11|oracle8|pascal|per|perl|php|php-brief|pic16|pixelbender|plsql|povray|powershell|progress|prolog|providex||python|qbasic|rails|rebol|reg|robots|ruby|sas|scala|scheme|scilab|sdlbasic|smalltalk|smarty|sql|tcl|teraterm|text|thinbasic|tsql|typoscript|vb|vbnet|verilog|vhdl|vim|visualfoxpro|visualprolog|whitespace|whois|winbatch|xml|xorg_conf|xpp|z80)?(\\])(.*?[^\\[/code\\]]?)(\\[/code\\])#sim";
	$arr = preg_match_all($code_re, $string, $match);
	for($i=0;$i<$arr;$i++)
	{
		$lang[$i]=$match[3][$i];
		$with_breaks = mark::highlight(html_entity_decode($match[4][$i], ENT_QUOTES), $match[2][$i], "librarys/geshi/geshi");
		$code[$i] = $with_breaks;
		$string = str_replace($match[0][$i], '⓬'.$i.'⓬', $string);
	}
	$latex = array();
	$latex_re = '#(\\[latex\\])(.*?)(\\[/latex\\])#suim';
	$vh = preg_match_all($latex_re, $string, $match);
	for($i=0;$i<$vh;$i++)
	{
		$with_breaks = mark::make_latex($match[2][$i]);
		$latex[$i] = $with_breaks;
		$string = str_replace($match[0][$i], '☣'.$i.'☣', $string);
	}
	$math = array();
	$re = '#(\\[math\\])(.*?)(\\[/math\\])#suim';
	$vh = preg_match_all($re, $string, $match);
	for($i=0;$i<$vh;$i++)
	{
		$with_breaks = mark::make_formula($match[2][$i]);
		$math[$i] = $with_breaks;
		$string = str_replace($match[0][$i], 'ᴥ'.$i.'ᴥ', $string);
	}
	$string = htmlspecialchars($string);
	$string = str_replace('\\', '&#92;', $string);
	$string = preg_replace("#(\\[b\\])(.*?[^\\[/b\\]]?)(\\[/b\\])#sim","<b>\$2</b>", $string);
	$string = preg_replace("#(\\[spoiler\\])(.*?[^\\[/spoiler\\]]?)(\\[/spoiler\\])#sim","<span class=\"spoiler\">\$2</span>", $string);
	$string = preg_replace("#(\\[i\\])(.*?[^\\[/i\\]]?)(\\[/i\\])#sim","<i>\$2</i>", $string);
	$string = preg_replace("#(\\[u\\])(.*?[^\\[/u\\]]?)(\\[/u\\])#sim","<u>\$2</u>", $string);
	$string = preg_replace("#(\\[s\\])(.*?[^\\[/s\\]]?)(\\[/s\\])#sim","<s>\$2</s>", $string);
	$string = preg_replace("#(\\[sub\\])(.*?[^\\[/sub\\]]?)(\\[/sub\\])#sim","<sub>\$2</sub>", $string);
	$string = preg_replace("#(\\[sup\\])(.*?[^\\[/sup\\]]?)(\\[/sup\\])#sim","<sup>\$2</sup>", $string);
	$string = str_replace('imgh://', 'http://', $string);
	$string = str_replace('imghs://', 'https://', $string);
	$tags = array
	(
		'list' => '<ul>',
		'num' => '<ol>',
		'quote' => '<div class="quote"><pre>',
	);
	foreach ($tags as $tag => $val)
	{
		if ($tag == 'list')
		{
			$re = '#(\\[list\\])(.*?[^\\[/list\\]]?)(\\[/list\\])#sim';
			$vt = preg_match_all($re, $string, $match);
			for($i=0;$i<$vt;$i++)
			{
				$string = preg_replace($re, "$val\$2</ul>", $string, 1);
				$with_breaks = str_replace('[*]', '<li>&nbsp;', $match[2][$i]);
				$string = str_replace($match[2][$i], $with_breaks, $string);
			}
		}
		if ($tag == 'num')
		{
			$re = '#(\\[num\\])(.*?[^\\[/num\\]]?)(\\[/num\\])#sim';
			$vt = preg_match_all($re, $string, $match);
			for($i=0;$i<$vt;$i++)
			{
				$string = preg_replace($re, "$val\$2</ol>", $string, 1);
				$with_breaks = str_replace('[*]', '<li>&nbsp;', $match[2][$i]);
				$string = str_replace($match[2][$i], $with_breaks, $string);
			}
		}
		if ($tag == 'quote')
		{
			$re = '#(\\[quote\\])(.*?[^\\[/quote\\]]?)(\\[/quote\\])#sim';
			$vt = preg_match_all($re, $string, $match);
			for($i=0;$i<$vt;$i++)
			{
				$string = preg_replace($re, "$val\$2</pre></div>", $string, 1);
				$with_breaks = $match[2][$i];
				$string = str_replace($match[2][$i], $with_breaks, $string);
			}
		}
	}
	$string = preg_replace('#(\\[p align=)(left|right|center)(\\])(.*?[^\\[/p\\]]?)(\\[/p\\])#sim',"<p align=\"\$2\">\$4</p>", $string);
	
	$img_re = '#(\\[img) ?(align=)?(left|right|middle|top|bottom)?(\\])(.*?[^\\[/img\\]]?)(\\[/img\\])#sim';
	$vt = preg_match_all($img_re, $string, $match);
	for($i=0;$i<$vt;$i++)
	{
		if(!empty($match[3][$i]))
			$string = preg_replace($img_re, "<img src=\"\$5\" align=\"$3\" style=\"max-width: 1024px\" alt=\"[путь к изображению некорректен]\" />", $string, 1);
		else
			$string = preg_replace($img_re, "<img src=\"\$5\" style=\"max-width: 1024px\" alt=\"[путь к изображению некорректен]\" />", $string, 1);
	}
	$user_re = "#(\\[user\\])(.*?[^\\[/user\\]]?)(\\[/user\\])#sim";
	$arr = preg_match_all($user_re, $string, $match);
	for($i=0;$i<$arr;$i++)
	{
		$where_arr = array(array("key"=>'nick', "value"=>$match[2][$i], "oper"=>'='));
		$sel = base::select('users', '', '*', $where_arr, 'AND');
		if(!empty($sel))
			$string = preg_replace($user_re, "<b><a href=\"/profile.php?user=\$2\">\$2</a></b>", $string, 1);
		else
			$string = preg_replace($user_re, "\$2", $string, 1);
	}
	$url_re = '#(\\[url\\])(.*?[^\\[/url\\]]?)(\\[/url\\])#sim';
	$vt = preg_match_all($url_re, $string, $match);
	for($i=0;$i<$vt;$i++)
	{
		if(filter_var($match[2][$i], FILTER_VALIDATE_URL))
			$string = preg_replace($url_re, "<a href=\"\$2\">\$2</a>", $string);
	}
	$url_par_re = '#(\\[url=)(.*?[^\\]]?)(\\])(.*?[^\\[/url\\]]?)(\\[/url\\])#sim';
	$vt = preg_match_all($url_par_re, $string, $match);
	for($i=0;$i<$vt;$i++)
	{
		if(filter_var($match[2][$i], FILTER_VALIDATE_URL))
			$string = preg_replace($url_par_re, "<a href=\"\$2\">\$4</a>", $string);
	}
	$string = '<p>'.$string.'</p>';
	$string = str_replace("\r\n", '</p><p>', $string);
	$re = "#(⓬)([0-9]+)(⓬)#sim";
	$vt = preg_match_all($re, $string, $match);
	for($i=0;$i<$vt;$i++)
	{
		$string = str_replace('⓬'.$match[2][$i].'⓬','<fieldset><legend>'.$lang[$match[2][$i]].'</legend>'.$code[$match[2][$i]].'</fieldset>',$string);
	}
	$re = "#(ᴥ)([0-9]+)(ᴥ)#suim";
	$vt = preg_match_all($re, $string, $match);
	for($i=0;$i<$vt;$i++)
		$string = str_replace('ᴥ'.$match[2][$i].'ᴥ', $math[$match[2][$i]], $string);
	$re = "#(☣)([0-9]+)(☣)#suim";
	$vt = preg_match_all($re, $string, $match);
	for($i=0;$i<$vt;$i++)
		$string = str_replace('☣'.$match[2][$i].'☣', $latex[$match[2][$i]], $string);
	return $string;
}
?>