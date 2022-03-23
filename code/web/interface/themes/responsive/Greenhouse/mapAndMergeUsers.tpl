{strip}
	<div class="row">
		<div class="col-xs-12">
			<h1 id="pageTitle">{$pageTitleShort}</h1>
		</div>
	</div>
    {if isset($mergeResults)}
		<div class="row">
			<div class="col-xs-12">
				<h2>{translate text="Merge Results" isAdminFacing=true}</h2>
			</div>
			<div class="col-xs-12">
				<dl>
					<dt>{translate text="Num Users in Aspen" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numUsersInAspen}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Users in Map" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numUsersInMap}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Unmapped Users in Aspen" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numUnmappedUsers}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Users Updated with New Username" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numUsersUpdated}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Users Updated and Merged" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numUsersMerged}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Lists Moved" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numListsMoved}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Reading History Entries Moved" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numReadingHistoryEntriesMoved}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Ratings & Reviews Moved" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numRatingsReviewsMoved}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Roles Moved" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numRolesMoved}</dd>
				</dl>
				<dl>
					<dt>{translate text="Num Don't Show Again Moved" isAdminFacing=true}</dt>
					<dd>{$mergeResults.numNotInterestedMoved}</dd>
				</dl>
			</div>
		</div>
    {else}
		<div class="row">
			<div class="col-xs-12">
				<div class="alert alert-info">{translate text="This tool can be used to convert User usernames (unique values in the ILS) to new values while merging anything that exists with both the old and new username into a single record and moving all the ." isAdminFacing=true}</div>
			</div>
		</div>
        {if !empty($setupErrors)}
			<div class="row">
				<div class="col-xs-12">
                    {foreach from=$setupErrors item=setupError}
						<div class="alert alert-danger">
                            {$setupError}
						</div>
                    {/foreach}
				</div>
			</div>
        {else}
			<form id='importForm' method="post" role="form" onsubmit="setFormSubmitting();" aria-label="{translate text="Remap User Usernames and Merge" isAdminFacing=true inAttribute=true}">
				<div class='editor'>
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<button type="submit" name="submit" value="remapUsernames" class="btn btn-primary">{translate text="Map and Merge Users" isAdminFacing=true}</button>
							</div>
						</div>
					</div>
				</div>
			</form>
        {/if}
    {/if}
{/strip}