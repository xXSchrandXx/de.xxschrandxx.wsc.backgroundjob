<ul>
	<li><span>{lang}wcf.acp.exceptionLog.search.exceptionID{/lang}: <kbd>{#$e->getCode()}</kbd></span></li>
	<li><span>{lang}wcf.acp.exceptionLog.exception.message{/lang}: <kbd>{$e->getMessage()}</kbd></span></li>
	<li><span>{lang}wcf.acp.exceptionLog.exception.file{/lang}: <kbd>{$e->getFile()} ({#$e->getLine()})</kbd></span></li>
	<li>
		<hr />
		<textarea readonly>{@$e->getTraceAsString()}</textarea>
	</li>
</ul>
