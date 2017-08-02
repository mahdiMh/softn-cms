<?php
use SoftnCMS\controllers\ViewController;
use SoftnCMS\models\managers\PostsManager;
use SoftnCMS\util\Arrays;
use SoftnCMS\models\managers\PostsCategoriesManager;
use SoftnCMS\models\managers\PostsTermsManager;

ViewController::registerScript('form');
$title                = ViewController::getViewData('title');
$post                 = ViewController::getViewData('post');
$categories           = ViewController::getViewData('categories');
$terms                = ViewController::getViewData('terms');
$selectedCategoriesId = ViewController::getViewData('selectedCategoriesId');
$selectedTermsId      = ViewController::getViewData('selectedTermsId');
$method               = ViewController::getViewData('method');
$isUpdate             = $method == PostsManager::FORM_UPDATE;
$linkPost             = ViewController::getViewData('linkPost');
?>
<div class="page-container" data-menu-collapse-id="post">
    <div>
        <h1><?php echo $title; ?></h1>
    </div>
    <div>
        <div class="row clearfix">
            <form role="form" method="post">
                <div class="col-sm-9">
                    <div class="form-group">
                        <input type="text" class="form-control input-lg" name="<?php echo PostsManager::POST_TITLE; ?>" placeholder="Escribe el título" value="<?php echo $post->getPostTitle(); ?>">
                    </div>
                    <?php if ($isUpdate) { ?>
                        <div class="form-group">
                            <label>Enlace: <a href="<?php echo $linkPost; ?>" target="_blank"><?php echo $linkPost; ?></a></label>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="control-label">Contenido de la entrada</label>
                        <textarea id="textContent" class="form-control" name="<?php echo PostsManager::POST_CONTENTS; ?>" rows="5"><?php echo $post->getPostContents(); ?></textarea>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="checkbox">
                                <label>
                                    <input name="<?php echo PostsManager::POST_COMMENT_STATUS; ?>" type="checkbox" <?php echo $post->getPostCommentStatus() ? 'checked' : ''; ?>> Habilitar comentarios
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content-right" class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-heading">Publicación</div>
                        <div class="panel-body">
                            <div class="form-group checkbox">
                                <label>
                                    <input name="<?php echo PostsManager::POST_STATUS; ?>" type="checkbox" <?php echo $post->getPostStatus() ? 'checked' : ''; ?>> Visible
                                </label>
                            </div>
                            <?php if ($isUpdate) { ?>
                                <p>Ultima actualización: <span class="label label-warning">
                                        <span class="glyphicon glyphicon-time"></span>
                                        <?php echo $post->getPostUpdate(); ?></span>
                                </p>
                                <button class="btn btn-primary btn-block" type="submit" name="<?php echo PostsManager::FORM_UPDATE; ?>" value="<?php echo PostsManager::FORM_UPDATE; ?>">Actualizar</button>
                            <?php } else { ?>
                                <button class="btn btn-primary btn-block" type="submit" name="<?php echo PostsManager::FORM_CREATE; ?>" value="<?php echo PostsManager::FORM_CREATE; ?>">Publicar</button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Categorías</div>
                        <div class="panel-body">
                            <select name="<?php echo PostsCategoriesManager::CATEGORY_ID; ?>[]" multiple class="form-control">
                                <?php
                                foreach ($categories as $category) {
                                    $categoryID = $category->getID();
                                    $selected   = '';
    
                                    if (Arrays::valueExists($selectedCategoriesId, $categoryID)) {
                                        $selected = 'selected';
                                    }
    
                                    echo "<option value='$categoryID' $selected>" . $category->getCategoryName() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">Etiquetas</div>
                        <div class="panel-body">
                            <select name="<?php echo PostsTermsManager::TERM_ID; ?>[]" multiple class="form-control">
                                <?php
                                foreach ($terms as $term) {
                                    $termID   = $term->getID();
                                    $selected = '';
    
                                    if (Arrays::valueExists($selectedTermsId, $termID)) {
                                        $selected = 'selected';
                                    }
    
                                    echo "<option value='$termID' $selected>" . $term->getTermName() . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="<?php echo PostsManager::ID; ?>" value="<?php echo $post->getId(); ?>"/>
                <!-- token -->
            </form>
        </div>
    </div>
</div>