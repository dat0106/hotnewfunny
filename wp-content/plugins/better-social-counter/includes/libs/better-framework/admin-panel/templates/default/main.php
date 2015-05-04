<?php
	$template = $this->template;
?>
<div id="bf-panel">
    <div class="bf-header-wrapper">
        <div class="bf-header">
            <div class="logo-sec">
                <h1 class="logo"><?php echo $template['data']['panel-name']; ?></h1>
            </div>
            <div class="nav-sec">
                <div class="save-btn-sec">
                    <a class="button button-primary button-large fright bf-save-button bf-button"><span class="dashicons dashicons-edit"></span><?php _e( 'Save Settings', 'better-studio' ); ?></a>
                    <input type="hidden" id="bf-panel-id" value="<?php echo $template['id']; ?>" />
                </div>
            </div>
        </div>
    </div>

	<div id="bf-main" class="bf-clearfix">

		<div id="bf-nav">
			<?php echo $template['tabs']; ?>
		</div>

		<div id="bf-content">
			<form id="bf_options_form">
				<?php echo $template['fields']; ?>
			</form>
		</div>
	</div>

    <div id="footer" class="bf-footer bf-clearfix">
        <div class="reset-sec">
            <div class="btn-sec">
                <a class="button button-primary button-large fleft bf-save-button bf-button bf-reset-button"><span class="dashicons dashicons-update"></span><?php _e( 'Reset Setting', 'better-studio' ); ?></a>
            </div>
        </div>
        <div class="btn-sec">
            <a class="button button-primary button-large fright bf-save-button bf-button"><span class="dashicons dashicons-edit"></span><?php _e( 'Save Settings', 'better-studio' ); ?></a>
        </div>
	</div>

    <div class="bf-loading ">
        <div class="loader">
            <div class="in-loading-icon dashicons dashicons-update"></div>
            <div class="loaded-icon dashicons dashicons-yes"></div>
            <div class="not-loaded-icon dashicons dashicons-no-alt"></div>
            <div class="not-loaded-text"><?php _e( 'An Error Occurred!', 'better-studio' ); ?></div>
        </div>
    </div>
</div>