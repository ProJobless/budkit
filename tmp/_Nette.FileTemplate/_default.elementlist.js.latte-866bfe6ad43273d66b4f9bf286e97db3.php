<?php //netteCache[01]000401a:2:{s:4:"time";s:21:"0.12123200 1361349947";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:81:"/Users/livingstonefultang/Documents/apigen/templates/default/elementlist.js.latte";i:2;i:1347143210;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:28:"$WCREV$ released on $WCDATE$";}}}?><?php

// source file: /Users/livingstonefultang/Documents/apigen/templates/default/elementlist.js.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, 'srbxg9h3m7')
;
// prolog Nette\Latte\Macros\UIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
// ?>

var ApiGen = ApiGen || {};
ApiGen.elements = <?php echo Nette\Templating\Helpers::escapeJs($elements) ?>;