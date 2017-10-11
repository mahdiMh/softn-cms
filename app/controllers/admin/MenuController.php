<?php
/**
 * MenuController.php
 */

namespace SoftnCMS\controllers\admin;

use SoftnCMS\classes\constants\Constants;
use SoftnCMS\controllers\CUDControllerAbstract;
use SoftnCMS\controllers\ViewController;
use SoftnCMS\models\managers\MenusManager;
use SoftnCMS\models\managers\OptionsManager;
use SoftnCMS\models\tables\Menu;
use SoftnCMS\rute\Router;
use SoftnCMS\util\Arrays;
use SoftnCMS\util\form\builders\InputAlphanumericBuilder;
use SoftnCMS\util\form\builders\InputIntegerBuilder;
use SoftnCMS\util\form\builders\InputUrlBuilder;
use SoftnCMS\util\form\Form;
use SoftnCMS\util\Messages;
use SoftnCMS\util\Util;

/**
 * Class MenuController
 * @author Nicolás Marulanda P.
 */
class MenuController extends CUDControllerAbstract {
    
    public function create() {
        $menusManager = new MenusManager();
        $parentMenuId = Arrays::get($_GET, 'parentMenu');
        
        if (Form::submit(Constants::FORM_CREATE)) {
            $form = $this->form();
            
            if (!empty($form)) {
                $menu = Arrays::get($form, 'menu');
                
                if ($menusManager->create($menu)) {
                    $optionsManager = new OptionsManager();
                    Messages::addSuccess(__('Menu publicado correctamente.'), TRUE);
                    $siteUrlRedirect = $optionsManager->getSiteUrl() . 'admin/menu';
                    $parentMenuId    = $menu->getMenuSub();
                    
                    if ($parentMenuId != MenusManager::MENU_SUB_PARENT) {
                        $parentMenu = $menusManager->searchParent($parentMenuId);
                        
                        if (!empty($parentMenu)) {
                            $siteUrlRedirect .= '/edit/' . $parentMenu->getId();
                        }
                    }
                    
                    Util::redirect($siteUrlRedirect);
                }
            }
            
            Messages::addDanger(__('Error al publicar el menu.'));
        }
        
        if (empty($parentMenuId)) {
            ViewController::sendViewData('parentMenus', $menusManager->searchAllParent());
        } else {
            if (empty($menusManager->searchById($parentMenuId))) {
                $optionsManager = new OptionsManager();
                Messages::addDanger(__('El menu padre no existe.'), TRUE);
                Util::redirect($optionsManager->getSiteUrl() . 'admin/menu');
            }
            
            ViewController::sendViewData('parentMenuId', $parentMenuId);
        }
        
        ViewController::sendViewData('isUpdate', FALSE);
        ViewController::sendViewData('menu', new Menu());
        ViewController::sendViewData('title', __('Publicar nuevo menu'));
        ViewController::view('form');
    }
    
    protected function form() {
        $inputs = $this->filterInputs();
        
        if (empty($inputs)) {
            return FALSE;
        }
        
        $menu = new Menu();
        $menu->setId(Arrays::get($inputs, MenusManager::COLUMN_ID));
        $menu->setMenuTitle(Arrays::get($inputs, MenusManager::MENU_TITLE));
        $menu->setMenuUrl(Arrays::get($inputs, MenusManager::MENU_URL));
        $menu->setMenuSub(Arrays::get($inputs, MenusManager::MENU_SUB));
        $menu->setMenuPosition(NULL);
        $menu->setMenuTotalChildren(NULL);
        
        return ['menu' => $menu];
    }
    
    protected function filterInputs() {
        Form::setInput([
            InputIntegerBuilder::init(MenusManager::COLUMN_ID)
                               ->build(),
            InputAlphanumericBuilder::init(MenusManager::MENU_TITLE)
                                    ->build(),
            InputUrlBuilder::init(MenusManager::MENU_URL)
                           ->setRequire(FALSE)
                           ->build(),
            InputIntegerBuilder::init(MenusManager::MENU_SUB)
                               ->build(),
        ]);
        
        return Form::inputFilter();
    }
    
    public function update($id) {
        $menusManager = new MenusManager();
        $menu         = $menusManager->searchById($id);
        
        if (empty($menu)) {
            Messages::addDanger(__('El menu no existe.'), TRUE);
            Util::redirect(Router::getSiteURL(), 'admin/menu');
        } else {
            if (Form::submit(Constants::FORM_UPDATE)) {
                $form = $this->form();
                
                if (empty($form)) {
                    Messages::addDanger(__('Error en los campos del menu.'));
                } else {
                    $menu = Arrays::get($form, 'menu');
                    
                    if ($menusManager->updateByColumnId($menu)) {
                        Messages::addSuccess(__('Menu actualizado correctamente.'));
                    } else {
                        Messages::addDanger(__('Error al actualizar el menu.'));
                    }
                }
            }
        }
        
        $parentMenuId = $menu->getMenuSub();
        
        if ($parentMenuId == MenusManager::MENU_SUB_PARENT) {
            $parentMenus = $menusManager->searchAllParent();
            $parentMenus = array_filter($parentMenus, function(Menu $menu) use ($id) {
                return !($menu->getId() == $id);
            });
            ViewController::sendViewData('parentMenus', $parentMenus);
        } else {
            ViewController::sendViewData('parentMenuId', $parentMenuId);
            $parentMenu = $menusManager->searchParent($parentMenuId);
            
            if (!empty($parentMenu)) {
                $optionsManager        = new OptionsManager();
                $siteUrlEditParentMenu = $optionsManager->getSiteUrl() . 'admin/menu/edit/';
                $siteUrlEditParentMenu .= $parentMenu->getId();
                ViewController::sendViewData('siteUrlEditParentMenu', $siteUrlEditParentMenu);
            }
        }
        
        ViewController::sendViewData('isUpdate', TRUE);
        ViewController::sendViewData('menu', $menu);
        ViewController::sendViewData('title', __('Actualizar menu'));
        ViewController::view('form');
    }
    
    public function edit($id) {
        $menusManager = new MenusManager();
        $menu         = $menusManager->searchById($id);
        
        if (empty($menu)) {
            Messages::addDanger(__('El menu no existe.'), TRUE);
            Util::redirect(Router::getSiteURL(), 'admin/menu');
        }
        
        ViewController::sendViewData('menu', $menu);
        ViewController::sendViewData('subMenus', $menusManager->searchByMenuSub($id));
        ViewController::view('edit');
    }
    
    public function delete($id) {
        $menusManager = new MenusManager();
        
        if (empty($menusManager->deleteById($id))) {
            Messages::addDanger(__('Error al borrar el menu.'));
        } else {
            Messages::addSuccess(__('Menu borrado correctamente.'));
        }
        
        parent::delete($id);
    }
    
    public function reloadAJAX() {
        $input = InputIntegerBuilder::init('edit')
                                    ->setMethod($_GET)
                                    ->build();
        $id    = $input->filter();
        
        if (empty($id)) {
            parent::reloadAJAX();
        } else {
            $menusManager = new MenusManager();
            ViewController::sendViewData('subMenus', $menusManager->searchByMenuSub($id));
            ViewController::singleView('dataedit');
        }
        
    }
    
    protected function read() {
        $menusManager = new MenusManager();
        $count        = $menusManager->count();
        $limit        = parent::pagination($count);
        
        ViewController::sendViewData('menus', $menusManager->searchAllParent($limit));
    }
    
}
