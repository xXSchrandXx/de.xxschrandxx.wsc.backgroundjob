{include file='header' pageTitle='wcf.acp.menu.link.devtools.backgroundjob'}

<header class="contentHeader">
    <div class="contentHeaderTitle">
        <h1 class="contentTitle">{lang}wcf.acp.menu.link.configuration.backgroundjobList{/lang}</h1>
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
        <table class="table jsObjectActionContainer" data-object-action-class-name="wcf\data\backgroundjob\BackgroundjobAction">
            <thead>
                <tr>
                    <th></th>
                    <th>{lang}wcf.page.backgroundjobList.jobID{/lang}</th>
                    <th>{lang}wcf.page.backgroundjobList.status{/lang}</th>
					<th>{lang}wcf.page.backgroundjobList.time{/lang}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$objects item=object}
                    <tr class="jsObjectActionObject" data-object-id="{@$object->jobID}">
                        <td class="columnIcon">
							{objectAction action="delete" objectTitle=$object->jobID}
							<a href="#" title="{lang}wcf.page.backgroundjobList.button.execute{/lang}" class="backgroundjobExecuteButton jsTooltip">
								<span class="icon icon16 fa-wifi"></span>
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
			'wcf.page.backgroundjobList.button.execute.result': '{lang}wcf.page.backgroundjobList.button.execute.result{/lang}'
		});
		new BackgroundjobExecute.default();
	});
</script>
