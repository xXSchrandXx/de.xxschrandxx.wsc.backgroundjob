{include file='header' pageTitle='wcf.acp.menu.link.devtools.backgroundjob'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.page.backgroundjobList.contentTitle{/lang}</h1>
    </div>
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
		{foreach from=$objects item=$object}
			<ul id="backgroundJobDetailDialog-{#$object->jobID}" style="display: none;">
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
			<script data-relocate="true">
				$(function() {
					$('#backgroundJobDetail-{#$object->jobID}').click(function() {
						$('#backgroundJobDetailDialog-{#$object->jobID}').wcfDialog({
							title: '{lang}wcf.acp.page.backgroundjobList.button.info.result{/lang}'
						});
					});
				});
			</script>
		{/foreach}
        <table class="table jsObjectActionContainer" data-object-action-class-name="wcf\data\backgroundjob\BackgroundjobAction">
            <thead>
                <tr>
                    <th></th>
                    <th>{lang}wcf.acp.page.backgroundjobList.jobID{/lang}</th>
                    <th>{lang}wcf.acp.page.backgroundjobList.status{/lang}</th>
					<th>{lang}wcf.acp.page.backgroundjobList.time{/lang}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$objects item=object}
                    <tr class="jsObjectActionObject" data-object-id="{@$object->jobID}">
                        <td class="columnIcon">
							<a id="backgroundJobDetail-{#$object->jobID}" title="{lang}wcf.acp.page.backgroundjobList.button.info{/lang}" class="jsTooltip">
								<span class="icon icon16 fa-info"></span>
							</a>
							{objectAction action="delete" objectTitle=$object->jobID}
							<a href="#" title="{lang}wcf.acp.page.backgroundjobList.button.execute{/lang}" class="backgroundjobExecuteButton jsTooltip">
								<span class="icon icon16 fa-play"></span>
							</a>
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

{include file='footer'}

<script data-relocate="true">
	require(["xXSchrandXx/Backgroundjob/BackgroundjobExecute", "Language"], function(BackgroundjobExecute, Language) {
		Language.addObject({
			'wcf.apc.page.backgroundjobList.button.info.result': '{lang}wcf.apc.page.backgroundjobList.button.info.result{/lang}'
		});
		new BackgroundjobExecute.default();
	});
</script>
