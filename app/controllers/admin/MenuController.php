<?php
/**
 * MenuController.php
 */

namespace SoftnCMS\controllers\admin;

use SoftnCMS\controllers\CUDControllerAbstract;
use SoftnCMS\controllers\ViewController;
use SoftnCMS\models\CRUDManagerAbstract;
use SoftnCMS\models\managers\MenusManager;
use SoftnCMS\models\managers\OptionsManager;
use SoftnCMS\models\tables\Menu;
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
        
        if (Form::submit(CRUDManagerAbstract::FORM_CREATE)) {
            $messages    = 'Error al publicar el menu.';
            $typeMessage = Messages::TYPE_DANGER;
            $form        = $this->form();
            
            if (!empty($form)) {
                $menu = Arrays::get($form, 'menu');
                
                if ($menusManager->create($menu)) {
                    $messages       = 'Menu publicado correctamente.';
                    $typeMessage    = Messages::TYPE_SUCCESS;
                    $optionsManager = new OptionsManager();
                    Messages::addSessionMessage($messages, $typeMessage);
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
            
            Messages::addMessage($messages, $typeMessage);
        }
        
        if (empty($parentMenuId)) {
            ViewController::sendViewData('parentMenus', $menusManager->searchAllParent());
        } else {
            if (empty($menusManager->searchById($parentMenuId))) {
                $message        = 'El menu padre no existe.';
                $typeMessage    = Messages::TYPE_DANGER;
                $optionsManager = new OptionsManager();
                Messages::addSessionMessage($message, $typeMessage);
                Util::redirect($optionsManager->getSiteUrl() . 'admin/menu');
            }
            
            ViewController::sendViewData('parentMenuId', $parentMenuId);
        }
        
        ViewController::sendViewData('menu', new Menu());
        ViewController::sendViewData('title', "Publicar nuevo menu");
        ViewController::view('form');
    }
    
    protected function form() {
        $inputs = $this->filterInputs();
        
        if (empty($inputs)) {
            return FALSE;
        }
        
        $menu = new Menu();
        $menu->setId(Arrays::get($inputs, MenusManager::ID));
        $menu->setMenuTitle(Arrays::get($inputs, MenusManager::MENU_TITLE));
        $menu->setMenuUrl(Arrays::get($inputs, MenusManager::MENU_URL));
        $menu->setMenuSub(Arrays::get($inputs, MenusManager::MENU_SUB));
        $menu->setMenuPosition(NULL);
        $menu->setMenuTotalChildren(NULL);
        
        return ['menu' => $menu];
    }
    
    protected function filterInputs() {
        Form::setINPUT([
            InputIntegerBuilder::init(MenusManager::ID)
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
        $message      = 'El menu no existe.';
        $typeMessage  = Messages::TYPE_DANGER;
        $menusManager = new MenusManager();
        $menu         = $menusManager->searchById($id);
        
        if (empty($menu)) {
            $optionsManager = new OptionsManager();
            Messages::addSessionMessage($message, $typeMessage);
            Util::redirect($optionsManager->getSiteUrl() . 'admin/menu');
        }
        
        if (Form::submit(MenusManager::FORM_UPDATE)) {
            $message = 'Error al actualizar el menu.';
            $form    = $this->form();
            
            if (!empty($form)) {
                $menu = Arrays::get($form, 'menu');
                
                if ($menusManager->update($menu)) {
                    $message     = 'Menu actualizado correctamente.';
                    $typeMessage = Messages::TYPE_SUCCESS;
                }
            }
            
            Messages::addMessage($message, $typeMessage);
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
        
        ViewController::sendViewData('menu', $menu);
        ViewController::sendViewData('title', "Actualizar menu");
        ViewController::view('form');
    }
    
    public function edit($id) {
        $message        = 'El menu no existe.';
        $typeMessage    = Messages::TYPE_DANGER;
        $optionsManager = new OptionsManager();
        $menusManager   = new MenusManager();
        $menu           = $menusManager->searchById($id);
        
        if (empty($menu)) {
            $optionsManager = new OptionsManager();
            Messages::addSessionMessage($message, $typeMessage);
            Util::redirect($optionsManager->getSiteUrl() . 'admin/menu');
        }
        
        ViewController::sendViewData('siteUrl', $optionsManager->getSiteUrl());
        ViewController::sendViewData('menu', $menu);
        ViewController::sendViewData('subMenus', $menusManager->searchByMenuSub($id));
        ViewController::view('edit');
    }
    
    public function delete($id) {
        $messages     = 'Error al borrar el menu.';
        $typeMessage  = Messages::TYPE_DANGER;
        $menusManager = new MenusManager();
        
        if (!empty($menusManager->delete($id))) {
            $messages    = 'Menu borrado correctamente.';
            $typeMessage = Messages::TYPE_SUCCESS;
        }
        
        Messages::addMessage($messages, $typeMessage);
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
            $menusManager   = new MenusManager();
            $optionsManager = new OptionsManager();
            ViewController::sendViewData('siteUrl', $optionsManager->getSiteUrl());
            ViewController::sendViewData('subMenus', $menusManager->searchByMenuSub($id));
            ViewController::singleView('dataedit');
        }
        
    }
    
    protected function read() {
        $filters        = [];
        $menusManager   = new MenusManager();
        $optionsManager = new OptionsManager();
        $count          = $menusManager->count();
        $pagination     = parent::pagination($count);
        
        if ($pagination !== FALSE) {
            $filters['limit'] = $pagination;
        }
        
        ViewController::sendViewData('siteUrl', $optionsManager->getSiteUrl());
        ViewController::sendViewData('menus', $menusManager->searchAllParent($filters));
    }
    
}
