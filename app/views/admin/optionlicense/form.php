<?php

use SoftnCMS\classes\constants\Constants;
use SoftnCMS\controllers\ViewController;
use SoftnCMS\models\managers\OptionsLicensesManager;
use SoftnCMS\models\tables\License;
use SoftnCMS\util\Arrays;

ViewController::registerScript('option-license-form');
$title           = ViewController::getViewData('title');
$optionsLicenses = ViewController::getViewData('optionsLicenses');
$dataList        = ViewController::getViewData('dataList');
$licenseSelected = ViewController::getViewData('license');
$licenses        = ViewController::getViewData('licenses');
$method          = ViewController::getViewData('method');
$isUpdate        = ViewController::getViewData('isUpdate');
$countBr         = 0;
?>
<div class="page-container" data-menu-collapse-id="option">
    <div>
        <h1><?php echo $title; ?></h1>
    </div>
    <div id="option-license">
        <form method="post" class="form-horizontal">
            <div class="form-group">
                <label class="control-label col-sm-2"><?php echo __('Permiso'); ?></label>
                <div class="col-sm-10">
                    <select class="form-control" name="<?php echo OptionsLicensesManager::LICENSE_ID ?>">
                        <?php
                        if (!empty($licenseSelected) && !empty($licenseSelected->getId())) {
                            echo "<option value='" . $licenseSelected->getId() . "' selected>" . $licenseSelected->getLicenseName() . '</option>';
                        }

                        $output = '';
                        array_walk($licenses, function(License $license) use (&$output) {
                            $output .= '<option value="' . $license->getId() . '">' . $license->getLicenseName() . '</option>';
                        });
                        echo $output;
                        ?>
                    </select>
                </div>
            </div>
            <button id="btn-check-all" class="btn btn-primary" type="button">
                <?php echo __('Marcar todo'); ?>
                <span class="glyphicon glyphicon-ok"></span>
            </button>
            <button id="btn-uncheck-all" class="btn btn-danger" type="button">
                <?php echo __('Desmarcar todo'); ?>
                <span class="glyphicon glyphicon-remove"></span>
            </button>
            <?php if ($isUpdate) { ?>
                <button class="btn btn-primary" name="<?php echo Constants::FORM_UPDATE; ?>" value="<?php echo Constants::FORM_UPDATE; ?>"><?php echo __('Actualizar'); ?></button>
            <?php } else { ?>
                <button class="btn btn-primary" name="<?php echo Constants::FORM_CREATE; ?>" value="<?php echo Constants::FORM_CREATE; ?>"><?php echo __('Publicar'); ?></button>
            <?php } ?>
            <br/>
            <br/>
            <div class="row">
                <?php array_walk($dataList, function($data) use ($optionsLicenses, &$countBr) {
                    $className      = Arrays::get($data, 'className');
                    $optionLicenses = Arrays::get($optionsLicenses, $className);
                    ViewController::sendViewData('optionLicenses', $optionLicenses);
                    ViewController::sendViewData('className', $className);
                    ViewController::sendViewData('controllerMethods', Arrays::get($data, 'controllerMethods'));
                    ViewController::sendViewData('managerConstants', Arrays::get($data, 'managerConstants'));
                    ?>
                    <div class="col-sm-6">
                    <?php ViewController::singleView('datapages'); ?>
                </div>
                    <?php
                    if (++$countBr == 2) {
                        $countBr = 0;
                        echo '<br style="clear: both"/>';
                    }
                }); ?>
            </div>
            <?php if ($isUpdate) { ?>
                <button class="btn btn-primary" name="<?php echo Constants::FORM_UPDATE; ?>" value="<?php echo Constants::FORM_UPDATE; ?>"><?php echo __('Actualizar'); ?></button>
            <?php } else { ?>
                <button class="btn btn-primary" name="<?php echo Constants::FORM_CREATE; ?>" value="<?php echo Constants::FORM_CREATE; ?>"><?php echo __('Publicar'); ?></button>
            <?php } ?>
            <?php \SoftnCMS\util\Token::formField(); ?>
        </form>
    </div>
</div>
