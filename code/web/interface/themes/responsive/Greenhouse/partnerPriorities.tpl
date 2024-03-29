{strip}
	<div id="main-content" class="col-sm-12">
		<h1>{translate text="Partner Priorities" isAdminFacing=true}</h1>

		<table id="adminTable" class="table table-striped table-bordered">
			<thead>
			<tr>
				<th>{translate text="Site Name" isAdminFacing=true}</th>
				<th>{translate text="Priority 1" isAdminFacing=true}</th>
				<th>{translate text="Priority 2" isAdminFacing=true}</th>
				<th>{translate text="Priority 3" isAdminFacing=true}</th>
				<th>{translate text="Last Priority Ticket Closed" isAdminFacing=true}</th>
				<th>{translate text="Last Priority 1 Closed" isAdminFacing=true}</th>
				<th>{translate text="Last Priority 2 Closed" isAdminFacing=true}</th>
				<th>{translate text="Last Priority 3 Closed" isAdminFacing=true}</th>
				<th>{translate text="Num Priority Tickets Closed" isAdminFacing=true}</th>
{*				<th>{translate text="Num Previously Ranked Tickets Closed" isAdminFacing=true}</th>*}
				<th>{translate text="Num Closed Bugs" isAdminFacing=true}</th>
				<th>{translate text="Num Closed Developmennts" isAdminFacing=true}</th>
			</tr>
			</thead>
			<tbody>
				{foreach from=$partnerPriorities item=partnerTicketInfo}
					<tr>
						<td><a href="/Greenhouse/PartnerTicketDashboard?site={$partnerTicketInfo.siteId}">{$partnerTicketInfo.siteName}</a></td>
						<td>
							{if !empty($partnerTicketInfo.priority1Ticket)}
								<a href="/Greenhouse/Tickets?objectAction=edit&id={$partnerTicketInfo.priority1Ticket->id}">{$partnerTicketInfo.priority1Ticket->ticketId} {$partnerTicketInfo.priority1Ticket->title} ({$partnerTicketInfo.priority1Ticket->queue})</a>
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{if !empty($partnerTicketInfo.priority2Ticket)}
								<a href="/Greenhouse/Tickets?objectAction=edit&id={$partnerTicketInfo.priority2Ticket->id}">{$partnerTicketInfo.priority2Ticket->ticketId} {$partnerTicketInfo.priority2Ticket->title} ({$partnerTicketInfo.priority2Ticket->queue})</a>
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{if !empty($partnerTicketInfo.priority3Ticket)}
								<a href="/Greenhouse/Tickets?objectAction=edit&id={$partnerTicketInfo.priority3Ticket->id}">{$partnerTicketInfo.priority3Ticket->ticketId} {$partnerTicketInfo.priority3Ticket->title} ({$partnerTicketInfo.priority3Ticket->queue})</a>
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{if !empty($partnerTicketInfo.lastPriorityClosed)}
								{$partnerTicketInfo.lastPriorityClosed->dateClosed|date_format:"%D"}
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{if !empty($partnerTicketInfo.lastPriority1Closed)}
								{$partnerTicketInfo.lastPriority1Closed->dateClosed|date_format:"%D"}
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{if !empty($partnerTicketInfo.lastPriority2Closed)}
								{$partnerTicketInfo.lastPriority2Closed->dateClosed|date_format:"%D"}
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{if !empty($partnerTicketInfo.lastPriority3Closed)}
								{$partnerTicketInfo.lastPriority3Closed->dateClosed|date_format:"%D"}
							{else}
								{translate text='N/A' isAdminFacing=true}
							{/if}
						</td>
						<td>
							{$partnerTicketInfo.closedPriorityTickets}
						</td>
{*						<td>*}
{*							{$partnerTicketInfo.previouslyRankedClosed}*}
{*						</td>*}
						<td>
							{$partnerTicketInfo.closedBugs}
						</td>
						<td>
							{$partnerTicketInfo.closedDevelopments}
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{/strip}
<script type="text/javascript">
	{literal}
	$("#adminTable").tablesorter({cssAsc: 'sortAscHeader', cssDesc: 'sortDescHeader', cssHeader: 'unsortedHeader', widgets:['zebra', 'filter'] });
	{/literal}
</script>