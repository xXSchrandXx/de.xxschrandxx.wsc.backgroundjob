{include file='header' pageTitle='wcf.acp.menu.link.devtools.backgroundjob'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}wcf.acp.page.backgroundjobList.contentTitle{/lang}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li>
				<a href="{link controller='AddTestBackgroundJob'}{/link}" class="button">
					{icon size=16 name='plus' type='solid'} {lang}wcf.acp.page.backgroundjobList.addTest{/lang}
				</a>
			</li>
			<li>
				<a href="{link controller='AddTestBackgroundJob'}fail=1{/link}" class="button">
					{icon size=16 name='plus' type='solid'} {lang}wcf.acp.page.backgroundjobList.addFailingTest{/lang}
				</a>
			</li>
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{hascontent}
	<div class="paginationTop">
		{content}
			{pages print=true assign=pagesLinks controller="BackgroundList" link="pageNo=%d"}
		{/content}
	</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox">
		<table class="table jsObjectActionContainer" data-object-action-class-name="wcf\data\backgroundjob\BackgroundjobAction">
			<thead>
				<tr>
					<th></th>
					<th>{lang}wcf.acp.page.backgroundjobList.jobID{/lang}</th>
					<th>{lang}wcf.acp.page.backgroundjobList.status{/lang}</th>
					<th>{lang}wcf.acp.page.backgroundjobList.time{/lang}</th>
				</tr>
			</thead>
			<tbody class="jsReloadPageWhenEmpty">
				{foreach from=$objects item=object}
					<tr class="jsObjectActionObject" data-object-id="{@$object->jobID}">
						<td class="columnIcon">
							<a href="#" title="{lang}wcf.acp.page.backgroundjobList.button.info{/lang}" class="jsInfo jsTooltip">
								{icon name='info'}
							</a>
							<a href="#" title="{lang}wcf.acp.page.backgroundjobList.button.execute{/lang}" class="jsExecute jsTooltip">
								{icon name='play'}
							</a>
							{objectAction action="delete" objectTitle=$object->jobID}

							{event name='rowButtons'}
						</td>
						<td class="columnID">{#$object->jobID}</td>
						<td class="columnText">{$object->status}</td>
						<td class="columnDate">{@$object->time|time}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/if}

{hascontent}
	<div class="paginationBottom">
		{content}
			{@$pagesLinks}
		{/content}
	</div>
{/hascontent}

{include file='footer'}

<script data-relocate="true">
	require(["xXSchrandXx/Backgroundjob/BackgroundjobUi", "WoltLabSuite/Core/Language"], function(BackgroundjobUi, Language) {
		Language.registerPhrase('wcf.acp.page.backgroundjobList.button.info.result', '{jslang}wcf.acp.page.backgroundjobList.button.info.result{/jslang}');
		new BackgroundjobUi.default();
	});
</script>
