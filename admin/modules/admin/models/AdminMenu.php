<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 
 * author: wxf
 */

namespace app\modules\admin\models;

use Yii;

class AdminMenu
{
    public $route = [
        'admin/user/me',
        'admin/app/index',
        'admin/app/recycle'
    ];

    public function getMenu()
    {
        $menu = Menu::getMenu();
        $menuList = $this->resetList($menu, $this->route);
        $menuList = $this->delete($menuList);

        return $menuList;

    }

    public function resetList($list, $route)
    {
        foreach ($list as $k => $item) {
            if (Yii::$app->admin->id == 1) {
                $list[$k]['show'] = true;
            }else {
                if (in_array($item['route'], $route)) {
                    $list[$k]['show'] = true;
                } else {
                    $list[$k]['show'] = false;
                }
            }


            if (isset($item['children']) && is_array($item['children'])) {
                $list[$k]['children'] = $this->resetList($item['children'], $route);
                foreach ($list[$k]['children'] as $i) {
                    if ($i['show']) {
                        $list[$k]['route'] = $i['route'];
                        $list[$k]['show'] = true;
                        break;
                    }
                }
            }
        }

        return $list;
    }


    public function delete($menuList)
    {
        foreach ($menuList as $k1 => $item) {

            if (isset($item['children'])) {
                $menuList[$k1]['children'] = $this->delete($item['children']);

            }

            if ($item['show'] == false) {
                unset($menuList[$k1]);
            }
        }

        return $menuList;
    }

}