<?php
use SoftnCMS\controllers\ViewController;
use SoftnCMS\models\managers\ProfilesManager;

$profile  = ViewController::getViewData('profile');
$title    = ViewController::getViewData('title');
$method   = ViewController::getViewData('method');
$isUpdate = $method == ProfilesManager::FORM_UPDATE;
?>
<div class="page-container" data-menu-collapse-id="user">
    <div>
        <h1><?php echo $title; ?></h1>
    </div>
    <div>
        <form method="post">
            <div id="content-left" class="col-sm-9">
                <div class="form-group">
                    <label class="control-label"><?php echo __('Nombre'); ?></label>
                    <input class="form-control" name="<?php echo ProfilesManager::PROFILE_NAME; ?>" value="<?php echo $profile->getLicenseName(); ?>">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo __('Descripción'); ?></label>
                    <textarea class="form-control" name="<?php echo ProfilesManager::PROFILE_DESCRIPTION; ?>" rows="5"><?php echo $profile->getLicenseDescription(); ?></textarea>
                </div>
            </div>
            <div id="content-right" class="col-sm-3">
                <div class="panel panel-default">
                    <div class="panel-heading"><?php echo __('Publicación'); ?></div>
                    <div class="panel-body">
                        <?php if ($isUpdate) { ?>
                            <button class="btn btn-primary btn-block" name="<?php echo ProfilesManager::FORM_UPDATE; ?>" value="<?php echo ProfilesManager::FORM_UPDATE; ?>"><?php echo __('Actualizar'); ?></button>
                        <?php } else { ?>
                            <button class="btn btn-primary btn-block" name="<?php echo ProfilesManager::FORM_CREATE; ?>" value="<?php echo ProfilesManager::FORM_CREATE; ?>"><?php echo __('Publicar'); ?></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <input type="hidden" name="<?php echo ProfilesManager::ID; ?>" value="<?php echo $profile->getId(); ?>"/>
            <?php \SoftnCMS\util\Token::formField(); ?>
        </form>
    </div>
</div>
