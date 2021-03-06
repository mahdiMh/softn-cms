<?php
use SoftnCMS\controllers\ViewController;
//TODO: mejorar la barra lateral.
$siteUrl           = ViewController::getViewData('siteUrl');
$urlAdmin          = $siteUrl . 'admin/';
$urlPost           = $urlAdmin . 'post/';
$urlPostCreate     = $urlPost . 'create/';
$urlCategory       = $urlAdmin . 'category/';
$urlTerm           = $urlAdmin . 'term/';
$urlComment        = $urlAdmin . 'comment/';
$urlUser           = $urlAdmin . 'user/';
$urlUserCreate     = $urlUser . 'create/';
$urlOption         = $urlAdmin . 'option/';
$urlMenu           = $urlAdmin . 'menu/';
$urlSidebar        = $urlAdmin . 'sidebar/';
$urlPage           = $urlAdmin . 'page/';
$urlProfile        = $urlAdmin . 'profile/';
$urlLicense        = $urlAdmin . 'license/';
$urlOptionLicense  = $urlAdmin . 'optionlicense/';
$strTranslatePosts = __('Entradas');
$strTranslateUsers = __('Usuarios');
//TODO: ocultar opciones de la barra lateral si no tiene permisos para visualizar la pagina.
?>
<aside>
    <ul class="menu-content">
        <li>
            <a href="<?php echo $urlAdmin; ?>">
                <i class="fa fa-tachometer"></i> <?php echo __('Información'); ?>
            </a>
        </li>
        <li>
            <a data-toggle="collapse" href="#post">
                <span class="glyphicon glyphicon-bullhorn"></span> <?php echo $strTranslatePosts; ?>
                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul id="post" class="submenu-content collapse">
                <li>
                    <a href="<?php echo $urlPost; ?>">
                        <span class="glyphicon glyphicon-bullhorn"></span> <?php echo $strTranslatePosts; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlPostCreate; ?>">
                        <span class="glyphicon glyphicon-pencil"></span> <?php echo __('Nueva entrada'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlCategory; ?>">
                        <span class="glyphicon glyphicon-bookmark"></span> <?php echo __('Categorías'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlTerm; ?>">
                        <span class="glyphicon glyphicon-tags"></span> <?php echo __('Etiquetas'); ?>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="<?php echo $urlMenu; ?>">
                <span class="fa fa-bars"></span> <?php echo __('Menus'); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $urlPage; ?>">
                <span class="glyphicon glyphicon-file"></span> <?php echo __('Paginas'); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $urlSidebar; ?>">
                <span class="glyphicon glyphicon-object-align-right"></span> <?php echo __('Barras laterales'); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo $urlComment; ?>">
                <span class="glyphicon glyphicon-comment"></span> <?php echo __('Comentarios'); ?>
            </a>
        </li>
        <li>
            <a data-toggle="collapse" href="#user">
                <span class="glyphicon glyphicon-user"></span> <?php echo $strTranslateUsers; ?>
                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul id="user" class="submenu-content collapse">
                <li>
                    <a href="<?php echo $urlUser; ?>">
                        <span class="glyphicon glyphicon-user"></span> <?php echo $strTranslateUsers; ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlUserCreate; ?>">
                        <span class="glyphicon glyphicon-pencil"></span> <?php echo __('Nuevo usuario'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlProfile; ?>">
                        <span class="glyphicon glyphicon-sunglasses"></span> <?php echo __('Perfiles'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlLicense; ?>">
                        <span class="glyphicon glyphicon-user"></span> <?php echo __('Permisos'); ?>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a data-toggle="collapse" href="#option">
                <span class="glyphicon glyphicon-cog"></span> <?php echo __('Configuración'); ?>
                <span class="pull-right glyphicon glyphicon-chevron-down"></span>
            </a>
            <ul id="option" class="submenu-content collapse">
                <li>
                    <a href="<?php echo $urlOption; ?>">
                        <span class="glyphicon glyphicon-cog"></span> <?php echo __('General'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $urlOptionLicense; ?>">
                        <span class="glyphicon glyphicon-cog"></span> <?php echo __('Permisos'); ?>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
