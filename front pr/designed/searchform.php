<form class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
<input type="text" name="s" class="s ghost p-border rad" size="30" value="<?php esc_attr_e('Search...','designed'); ?>" onfocus="if (this.value = '') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php esc_attr_e('Search...','designed'); ?>';}" />
<button class='searchSubmit ribbon rad' ><i class="fa fa-search"></i></button>
</form>