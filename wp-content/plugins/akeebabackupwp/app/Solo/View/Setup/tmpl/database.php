<?php
/**
 * @package     Solo
 * @copyright   2014-2016 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license     GNU GPL version 3 or later
 *
 * @var \Solo\View\Setup\Html $this
 */

use Awf\Text\Text;
use Awf\Uri\Uri;

/** @var \Solo\View\Setup\Html $this */

// If we're going to use SQLite let's hide all the options
$js = <<<JS
(function($) {
$( document ).ready(function() {
    $('#driver').change(function(){
        if($(this).val().toLowerCase() == 'sqlite')
        {
            $('#host-wrapper').hide();
            $('#user-wrapper').hide();
            $('#pass-wrapper').hide();
            $('#name-wrapper').hide();
            $('#prefix-wrapper').hide();
        
            $('#host').val('');
            $('#user').val('');
            $('#pass').val('');
            $('#name').val('');
            $('#prefix').val('solo_');
        }
        else
        {
            $('#host-wrapper').show();
            $('#user-wrapper').show();
            $('#pass-wrapper').show();
            $('#name-wrapper').show();
            $('#prefix-wrapper').show();
        }
    })
        .change();  
});
})(akeeba.jQuery);
JS;

$this->container->application->getDocument()->addScriptDeclaration($js);

?>

<h1><?php echo Text::_('SOLO_SETUP_SUBTITLE_DATABASE') ?></h1>

<p><?php echo Text::_('SOLO_SETUP_LBL_DATABASE_INFO') ?></p>

<form action="<?php echo Uri::rebase('?view=setup&task=installdb', $this->container) ?>" method="POST" class="form-horizontal" role="form" name="dbForm">
	<div class="form-group">
		<label for="driver" class="col-sm-2 control-label">
			<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_DRIVER'); ?>
		</label>
		<div class="col-sm-10">
			<?php echo \Solo\Helper\Setup::databaseTypesSelect($this->connectionParameters['driver']); ?>
			<div class="help-block">
				<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_DRIVER_HELP') ?>
			</div>
		</div>
	</div>

	<div class="form-group" id="host-wrapper">
		<label for="host" class="col-sm-2 control-label">
			<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_HOST'); ?>
		</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="host" name="host" placeholder="<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_HOST'); ?>" value="<?php echo $this->connectionParameters['host']?>">
			<div class="help-block">
				<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_HOST_HELP') ?>
			</div>
		</div>
	</div>

	<div class="form-group" id="user-wrapper">
		<label for="user" class="col-sm-2 control-label">
			<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_USER'); ?>
		</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="user" name="user" placeholder="<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_USER'); ?>" value="<?php echo $this->connectionParameters['user']?>">
			<div class="help-block">
				<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_USER_HELP') ?>
			</div>
		</div>
	</div>

	<div class="form-group" id="pass-wrapper">
		<label for="pass" class="col-sm-2 control-label">
			<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_PASS'); ?>
		</label>
		<div class="col-sm-10">
			<input type="password" class="form-control" id="pass" name="pass" placeholder="<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_PASS'); ?>" value="<?php echo $this->connectionParameters['pass']?>">
			<div class="help-block">
				<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_PASS_HELP') ?>
			</div>
		</div>
	</div>

	<div class="form-group" id="name-wrapper">
		<label for="name" class="col-sm-2 control-label">
			<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_NAME'); ?>
		</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="name" name="name" placeholder="<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_NAME'); ?>" value="<?php echo $this->connectionParameters['name']?>">
			<div class="help-block">
				<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_NAME_HELP') ?>
			</div>
		</div>
	</div>

	<div class="form-group" id="prefix-wrapper">
		<label for="prefix" class="col-sm-2 control-label">
			<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_PREFIX'); ?>
		</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="prefix" name="prefix" placeholder="<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_PREFIX'); ?>" value="<?php echo $this->connectionParameters['prefix']?>">
			<div class="help-block">
				<?php echo Text::_('SOLO_SETUP_LBL_DATABASE_PREFIX_HELP') ?>
			</div>
		</div>
	</div>

	<div class="col-sm-10 col-sm-push-2">
		<button type="submit" id="dbFormSubmit" class="btn btn-primary">
			<?php echo Text::_('SOLO_BTN_SUBMIT') ?>
		</button>
	</div>
</form>