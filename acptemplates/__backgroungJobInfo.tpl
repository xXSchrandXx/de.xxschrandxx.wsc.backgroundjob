<ul>
	<li><span>{lang}wcf.acp.page.backgroundjobList.name{/lang}: <kbd>{$object->getClass()}</kbd></span></li>
	<li><span>{lang}wcf.acp.page.backgroundjobList.jobID{/lang}: <kbd>{#$object->jobID}</kbd></span></li>
	<li><span>{lang}wcf.acp.page.backgroundjobList.status{/lang}: <kbd>{$object->status}</kbd></span></li>
	<li><span>{lang}wcf.acp.page.backgroundjobList.time{/lang}: <kbd>{#$object->time}</kbd> (<span class="columnDate">{@$object->time|time}</span>)</span></li>
	<li>
		<hr />
		<ul>
			{foreach from=$object->getObjectVars() key=$key item=$value}
				<li><span>{$key}: <kbd>{$value|newlineToBreak}</kbd></span></li>
			{/foreach}
		</ul>
	</li>
</ul>
