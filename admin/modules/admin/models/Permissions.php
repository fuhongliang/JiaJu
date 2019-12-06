<?php
/**
 * link: http://www.zjhejiang.com/
 * copyright: Copyright (c) 2018 
 * author: wxf
 */

namespace app\modules\admin\models;

class Permissions
{

    /**
     * 获取微擎子管理员账号权限列表
     */
    public static function getCAdminPermission()
    {
        $cacheKey = \Yii::$app->admin->identity->access_token;
        $data = \Yii::$app->getCache()->get($cacheKey);
        if ($data) {
            return $data;
        }

        $menu = Menu::getMenu();
        $permissions = self::getPermissionList($menu);

        \Yii::$app->getCache()->set($cacheKey, $permissions, 1800);

        return $permissions;

    }

    public static function getPermissionList($list)
    {
        $arr = [];
        foreach ($list as $k => $item) {

            if (isset($item['is_admin']) && $item['is_admin'] == false) {
                $arr[] = $item['route'];
            }

            if (isset($item['children']) && is_array($item['children'])) {
                $arr = array_merge($arr, self::getPermissionList($item['children']));
            }

            if (isset($item['sub']) && is_array($item['sub'])) {
                $arr = array_merge($arr, self::getPermissionList($item['sub']));
            }
        }

        return $arr;
    }

}