{ezscript_require( array( 'ezjsc::jqueryUI' ) )}
{ezcss_require( 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css' )}

{if $error}
<div class="message-error">
    <h2>{$error}</h2>
</div>
{/if}

{if $message}
<div class="message-feedback">
    <h2>{$message}</h2>
</div>	
{/if}

{if $output}
<pre>{$output}</pre>
{/if}

<div class="context-block">
	<div class="box-header">
		<h1 class="context-title">{'Branches'|i18n( 'extension/git_manager' )}</h1>
		<div class="header-mainline"></div>
	</div>

	<div class="box-content">
		<div class="context-attributes">

			<table class="list" cellspacing="0">
				<tbody>
					<tr>
						<th><label>{'HEAD'|i18n( 'extension/git_manager' )}</label></th>
					</tr>
					<tr>
						<td>
							<div class="block">
								{$git_manager.current_branch}, <a href="{concat( 'git_manager/commit_details/', $git_manager.current_commit )|ezurl( 'no' )}">{$git_manager.current_commit}</a>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="block">
				<form action="{'git_manager/dashboard'|ezurl( 'no' )}" method="post">
					<label class="inline">{'Local'|i18n( 'extension/git_manager' )}:
						<select name="branch">
							<option value="">{'- Select -'|i18n( 'extension/git_manager' )}</option>
							{foreach $git_manager.local_branches as $branch}
							<option value="{$branch}">{$branch}</option>
							{/foreach}
						</select>
					</label>
					<input class="button" type="submit" name="CheckoutLocalBranch" value="{'Checkout'|i18n( 'extension/git_manager' )}">
				</form>
			</div>

			<div class="block">
				<form action="{'git_manager/dashboard'|ezurl( 'no' )}" method="post">
					<label class="inline">{'Remote'|i18n( 'extension/git_manager' )}:
						<select name="branch">
							<option value="">{'- Select -'|i18n( 'extension/git_manager' )}</option>
							{foreach $git_manager.remote_branches as $branch}
							<option value="{$branch}">{$branch}</option>
							{/foreach}
						</select>
					</label>
					<input class="button" type="submit" name="CheckoutRemoteBranch" value="{'Checkout'|i18n( 'extension/git_manager' )}">
				</form>
			</div>

		</div>
	</div>

</div>

<div class="context-block">
	<div class="box-header">
		<h1 class="context-title">{'Commits log'|i18n( 'extension/git_manager' )}</h1>
		<div class="header-mainline"></div>
	</div>

	<form name="{''|ezurl( 'no' )}" method="post" action="/git_manager/dashboard">
		<div class="block">
			<fieldset>					
				<label>{'Author'|i18n( 'extension/git_manager' )}</label>
				<input type="text" name="author" value="" />

				<label>{'Start date'|i18n( 'extension/git_manager' )}</label>
				<input type="text" name="start_date" value="" class="date-picker" />

				<label>{'End date'|i18n( 'extension/git_manager' )}</label>
				<input type="text" name="end_date" value="" class="date-picker" />

				<input class="button" type="submit" name="SetFilter" value="{'Filter'|i18n( 'extension/git_manager' )}">
			</fieldset>
		</div>        
	</form>
</div>
			
<div class="context-block">
	<div class="box-ml"><div class="box-mr"><div class="box-content">
				<table class="list" cellspacing="0">
					<tbody>
						<tr>
							<th class="tight">Hash</th>
							<th>Title</th>
							<th>Author</th>
							<th>Date</th>
						</tr>
						{foreach $transactions as $transaction sequence array( 'bgdark', 'bglight' ) as $style }
						{/foreach}
				<tr class="bglight">
					<td><a href="/git_manager/commit_details/HASH">HASH</a></td>
					<td>TITLE</td>
					<td>AUTHOR ADAASDASD</td>
					<td>DATE</td>
				</tr>
			</tbody>
		</table>
	</div></div></div>
</div>

{literal}
<script>
jQuery( function() {
    $( '.date-picker' ).datepicker();
} );
</script>
{/literal}