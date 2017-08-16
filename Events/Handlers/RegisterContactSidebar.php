<?php namespace Modules\Contact\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Sidebar\AbstractAdminSidebar;

class RegisterContactSidebar extends AbstractAdminSidebar
{
    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('contact::contacts.title.contacts'), function (Item $item) {
                $item->authorize(
                    $this->auth->hasAccess('contact.contacts.index')
                );
                $item->icon('fa fa-envelope-o');
                $item->weight(10);
                $item->route('admin.contact.contact.index');
                $item->authorize(
                    $this->auth->hasAccess('contact.contacts.index')
                );
            });
        });
        return $menu;
    }
}
