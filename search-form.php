<!-- search form -->
<div class="search-form">
	<form id="searchform" class="clearfix" role="search" action="<?php bb_uri( 'search.php', null, BB_URI_CONTEXT_FORM_ACTION ); ?>" method="get">
			<div id="searchfield">
				<input type="text" size="14" maxlength="100" name="q" id="searchbox"<?php bb_tabindex(); ?> class="text clearField" value="<?php _e( 'Search', 'bb-mystique' ); ?>" />
			</div>
			<input type="submit" value="" class="submit"<?php bb_tabindex(); ?> />
	</form>
</div>
<!-- /search form -->
