<?php
/**
 * @link http://www.zjhejiang.com/
 * @copyright Copyright (c) 2018 
 * @author Lu Wei
 *
 * Created by IntelliJ IDEA.
 * User: luwei
 * Date: 2018/6/19
 * Time: 10:26
 */


namespace app\models;


use app\hejiang\CloudPlugin;
use yii\base\BaseObject;
use yii\helpers\VarDumper;

class StorePermission extends BaseObject
{
    /** @var  Store $store */
    public static $store;

    /**
     * 获取当前小程序商城的权限（固定权限、已安装插件）
     * @return array ['coupon','miaosha',...]
     */
    public static function getOpenPermissionList($store = null)
    {
        if ($store)
            self::$store = $store;
        if (!self::$store)
            return null;

        if (self::$store->user_id) {
            //微擎版账户
            $user = User::findOne(self::$store->user_id);
            if (!$user || !$user->we7_uid) {
                return null;
            }
            $we7_user_auth = We7UserAuth::findOne(['we7_user_id' => $user->we7_uid]);
            if (!$we7_user_auth) {
                //微擎账户未设置过权限，是否默认有所有权限，总管理员默认有所有权限
                $we7_default_all_permission = Option::get('we7_default_all_permission');
                if ($we7_default_all_permission || $user->we7_uid == 1) {
                    $permission_list = self::getAllPermissionList();
                } else {
                    $permission_list = [];
                }
            } else {
                //微擎账户设置过权限，根据已设置的权限
                if ($we7_user_auth->auth) {
                    $permission_list = \Yii::$app->serializer->decode($we7_user_auth->auth);
                    if (!$permission_list)
                        $permission_list = [];
                } else {
                    $permission_list = [];
                }
            }
            if ($user->we7_uid == 1) {
                $permission_list = self::getAllPermissionList();
            }
        } elseif (self::$store->admin_id) {
            //独立版账户
            $admin = Admin::findOne(self::$store->admin_id);
            if (!$admin) {
                return null;
            }
            if ($admin->permission) {
                $permission_list = \Yii::$app->serializer->decode($admin->permission);
                if (!$permission_list)
                    $permission_list = [];
            } else
                $permission_list = [];
        } else {
            return null;
        }
        return (array)$permission_list;
    }

    /**
     * 获取当前系统所有权限（固定权限、已安装插件）
     * @return array ['coupon','miaosha',...]
     */
    private static function getAllPermissionList()
    {
        $plugin_list = CloudPlugin::getInstalledPluginList();
        $plugin_permission_list = [];
        if (is_array($plugin_list)) {
            foreach ($plugin_list as $p) {
                $plugin_permission_list[] = $p['name'];
            }
        }
        $admin_permission_list = AdminPermission::getList();
        $system_permission_list = [];
        if (is_array($admin_permission_list)) {
            foreach ($admin_permission_list as $ap) {
                $system_permission_list[] = $ap->name;
            }
        }
        return array_keys(array_flip($plugin_permission_list) + array_flip($system_permission_list));
    }
}