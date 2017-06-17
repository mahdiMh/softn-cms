<?php
use SoftnCMS\controllers\ViewController;
use SoftnCMS\models\managers\OptionsManager;

ViewController::registerScript('api-github');
$countPosts      = ViewController::getViewData('countPosts');
$countPages      = ViewController::getViewData('countPages');
$countComments   = ViewController::getViewData('countComments');
$countCategories = ViewController::getViewData('countCategories');
$countTerms      = ViewController::getViewData('countTerms');
$countUsers      = ViewController::getViewData('countUsers');
$posts           = ViewController::getViewData('posts');
$comments        = ViewController::getViewData('comments');
$optionsManager  = new OptionsManager();
$siteUrl         = $optionsManager->getSiteUrl() . "admin/index/";
?>
<div class="page-container" data-url="<?php echo $siteUrl; ?>">
    <div>
        <h1>Información general</h1>
    </div>
    <div class="row clearfix">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Estadísticas Generales</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge"><?php echo $countPosts; ?></span>
                            <span>Publicaciones</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $countPages; ?></span>
                            <span>Paginas</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $countComments; ?></span>
                            <span>Comentarios</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $countCategories; ?></span>
                            <span>Categorías</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $countTerms; ?></span>
                            <span>Etiquetas</span>
                        </li>
                        <li class="list-group-item">
                            <span class="badge"><?php echo $countUsers; ?></span>
                            <span>Usuarios</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="data-github"></div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Publicaciones</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php foreach ($posts as $post) { ?>
                            <li class="list-group-item clearfix">
                            <span class="pull-left"><?php echo $post->getPostDate(); ?></span>
                            <span><?php echo $post->getPostTitle(); ?></span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Comentarios</div>
                <div class="panel-body">
                    <ul class="list-group">
                        <?php foreach ($comments as $comment) { ?>
                            <li class="list-group-item clearfix">
                            <span class="pull-left"><?php echo $comment->getCommentDate(); ?></span>
                            <span><?php echo $comment->getCommentContents(); ?></span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
