<?php
/**
 * Template: Searchform.php
 *
 * @package WPFramework
 * @subpackage Template
 */
?>
<!--BEGIN #searchform-->
<form class="searchform" method="get" action="<?php bloginfo( 'url' ); ?>">
	<input class="search" name="s" type="text" value="Какво..." tabindex="1" onblur="if(this.value=='' || this.value==' ') this.value='Какво...';" onfocus="if(this.value=='Какво...') this.value='';" />
    <button class="search-btn" type="submit" tabindex="2">Давай</button>
<!--END #searchform-->
</form>