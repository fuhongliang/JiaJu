<?php
namespace app\modules\mch\controllers\permission;

class Menu
{

    public static function getMenu()
    {
        return [
            [
                'name' => '总览',
                'is_menu' => true,
                'route' => 'mch/store/index',
                'icon' => 'iconfont icon-houtaizonglan',
                'children' => [
                    [
                        'name' => '数据总览',
                        'is_menu' => true,
                        'route' => 'mch/store/index',
                    ],
                ],
            ],
            [
                'name' => '商品',
                'is_menu' => true,
                'route' => 'mch/goods/goods',
                'icon' => 'iconfont icon-shangpinguanli',
                'children' => [
                    [
                        'name' => '商品管理',
                        'is_menu' => true,
                        'route' => 'mch/goods/goods',
                        'sub' => [
                            [
                                'name' => '商品编辑',
                                'is_menu' => false,
                                'route' => 'mch/goods/goods-edit',
                            ]
                        ],
                    ],
                    [
                        'name' => '分类列表',
                        'is_menu' => true,
                        'route' => 'mch/store/cat',
                        'sub' => [
                            [
                                'name' => '分类编辑',
                                'is_menu' => false,
                                'route' => 'mch/store/cat-edit',
                            ]
                        ],
                    ],
                ],
            ],
            [
                'name' => '订单',
                'is_menu' => true,
                'route' => 'mch/order/index',
                'icon' => 'iconfont icon-dingdanguanli-',
                'children' => [
                    [
                        'name' => '订单列表',
                        'is_menu' => true,
                        'route' => 'mch/order/index',
                        'sub' => [
                            [
                                'name' => '订单详情',
                                'is_menu' => false,
                                'route' => 'mch/order/detail'
                            ],
                        ],
                    ],
                    [
                        'name' => '自提订单',
                        'is_menu' => true,
                        'route' => 'mch/order/offline',
                    ],
                    [
                        'name' => '售后订单',
                        'is_menu' => true,
                        'route' => 'mch/order/refund',
                    ],
                    [
                        'name' => '评价管理',
                        'is_menu' => true,
                        'route' => 'mch/comment/index',
                        'sub' => [
                            [
                                'name' => '评价回复',
                                'is_menu' => false,
                                'route' => 'mch/comment/reply',
                            ],
                            [
                                'name' => '评价编辑',
                                'is_menu' => true,
                                'route' => 'mch/comment/edit',
                            ]
                        ]
                    ],
                    [
                        'name' => '批量发货',
                        'is_menu' => true,
                        'route' => 'mch/order/batch-ship',
                    ],
                ],
            ],
            [
                'name' => '商户',
                'is_menu' => true,
                'route' => 'mch/mch/index/index',
                'icon' => 'iconfont icon-shangjia',
                'children' => [

                    [
                        'name' => '商户列表',
                        'is_menu' => true,
                        'route' => 'mch/mch/index/index',
                        'sub' => [
                            [
                                'name' => '商户列表编辑',
                                'is_menu' => false,
                                'route' => 'mch/mch/index/edit',
                            ],
                            [
                                'name' => '商户列表添加',
                                'is_menu' => false,
                                'route' => 'mch/mch/index/add',
                            ],
                        ],
                    ],
                    [
                        'name' => '入驻审核',
                        'is_menu' => true,
                        'route' => 'mch/mch/index/apply',
                    ],

//                    [
//                        'name' => '所售类目',
//                        'is_menu' => true,
//                        'route' => 'mch/mch/index/common-cat',
//                        'sub' => [
//                            [
//                                'name' => '类目编辑',
//                                'is_menu' => false,
//                                'route' => 'mch/mch/index/common-cat-edit',
//                            ]
//                        ],
//                    ],

//                    [
//                        'name' => '提现管理',   已移到财务
//                        'is_menu' => true,
//                        'route' => 'mch/mch/index/cash',
//                    ],
                    [
                        'name' => '模板消息',
                        'is_menu' => true,
                        'route' => 'mch/mch/index/tpl-msg',
                    ],
                    [
                        'name' => '商品列表',
                        'is_menu' => true,
                        'route' => 'mch/mch/goods/goods',
                        'sub' => [
                            [
                                'name' => '商品详情',
                                'is_menu' => false,
                                'route' => 'mch/mch/goods/detail'
                            ]
                        ]
                    ],
                    [
                        'name' => '订单列表',
                        'is_menu' => true,
                        'route' => 'mch/mch/order/index',
                        'sub' => [
                            [
                                'name' => '订单详情',
                                'is_menu' => false,
                                'route' => 'mch/mch/order/detail'
                            ],
                        ]
                    ],
                    [
                        'name' => '多商户设置',
                        'is_menu' => true,
                        'route' => 'mch/mch/index/setting',
                    ],

                ]
            ],
            [
                'name' => '用户',
                'is_menu' => true,
                'route' => 'mch/user/index',
                'icon' => 'iconfont icon-yonghuguanli1',
                'children' => [
                    [
                        'name' => '用户列表',
                        'is_menu' => true,
                        'route' => 'mch/user/index',
                        'sub' => [
                            [
                                'name' => '用户列表Card',
                                'is_menu' => false,
                                'route' => 'mch/user/card',
                            ],
                            [
                                'name' => '用户编辑',
                                'is_menu' => false,
                                'route' => 'mch/user/edit',
                            ],
                            [
                                'name' => '用户余额',
                                'is_menu' => false,
                                'route' => 'mch/user/recharge-money-log'
                            ],
                            [
                                'name' => '积分充值记录',
                                'is_menu' => false,
                                'route' => 'mch/user/rechange-log',
                            ],
                        ],
                    ],
                    [
                        'name' => '核销员',
                        'is_menu' => true,
                        'route' => 'mch/user/clerk',
                    ],
                    [
                        'name' => '会员等级',
                        'is_menu' => true,
                        'route' => 'mch/user/level',
                        'sub' => [
                            [
                                'name' => '会员等级编辑',
                                'is_menu' => false,
                                'route' => 'mch/user/level-edit',
                            ],
                        ]
                    ],
                    [
                        'name' => '余额充值记录',
                        'is_menu' => true,
                        'route' => 'mch/user/recharge',
                    ],
                    [
                        'name' => '会员购买记录',
                        'is_menu' => true,
                        'route' => 'mch/user/buy',
                    ],
                    [
                        'name' => '积分充值记录',
                        'is_menu' => true,
                        'route' => 'mch/user/integral-rechange-list',
                    ],
                ],
            ],
            [
                'key' => 'share',
                'name' => '分销',
                'is_menu' => true,
                'route' => 'mch/share/index',
                'icon' => 'iconfont icon-zuzhiqunzu',
                'children' => [
                    [
                        'name' => '分销商',
                        'is_menu' => true,
                        'route' => 'mch/share/index',
                    ],
                    [
                        'name' => '分销订单',
                        'is_menu' => true,
                        'route' => 'mch/share/order',
                    ],
                    [
                        'name' => '分销提现',
                        'is_menu' => true,
                        'route' => 'mch/share/cash',
                    ],
                    [
                        'name' => '分销设置',
                        'is_menu' => true,
                        'route' => 'mch/share/basic',
                        'children' => [
                            [
                                'name' => '基础设置',
                                'is_menu' => true,
                                'route' => 'mch/share/basic',
                                'sub' => [
                                    [
                                        'name' => '分享二维码',
                                        'is_menu' => false,
                                        'route' => 'mch/share/qrcode'
                                    ],
                                ]
                            ],
                            [
                                'name' => '佣金设置',
                                'is_menu' => true,
                                'route' => 'mch/share/setting'
                            ],
                            [
                                'name' => '自定义设置',
                                'is_menu' => true,
                                'route' => 'mch/share/custom'
                            ],
                        ]
                    ],
                ],
            ],
            [
                'name' => '优惠券',
                'is_menu' => true,
                'route' => 'mch/coupon/index',
                'icon' => 'iconfont icon-youhuiquan1',
                'children' => [
                    [
                        'name' => '优惠券管理',
                        'is_menu' => true,
                        'route' => 'mch/coupon/index',
                        'sub' => [
                            [
                                'name' => '优惠券发放',
                                'is_menu' => false,
                                'route' => 'mch/coupon/send',
                            ],
                            [
                                'name' => '优惠券编辑',
                                'is_menu' => false,
                                'route' => 'mch/coupon/edit',
                            ],
                        ],
                    ],
                    [
                        'name' => '领取记录',
                        'is_menu' => true,
                        'route' => 'mch/user/coupon',
                        'sub' => [
                            [
                                'name' => '优惠券列表',
                                'is_menu' => false,
                                'route' => 'mch/user/coupon',
                            ],
                        ],
                    ],
                    [
                        'name' => '自动发放设置',
                        'is_menu' => true,
                        'route' => 'mch/coupon/auto-send',
                        'sub' =>[
                            [
                                'name' => '自动发放编辑',
                                'is_menu' => false,
                                'route' => 'mch/coupon/auto-send-edit'
                            ]
                        ]
                    ]
                ],
            ],
            [
                'name' => '营销',
                'is_menu' => true,
                'route' => 'mch/card/index',
                'icon' => 'iconfont icon-yingxiaoguanli',
                'children' => [
                    /*[
                        'key' => 'miaosha',
                        'name' => '整点秒杀',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/index',
                        'children' => [
                            [
                                'name' => '开放时间',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/index',
                            ],
                            [
                                'name' => '秒杀设置',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/setting',

                            ],
                            [
                                'name' => '商品管理',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/goods/index',
                                'sub' => [
                                    [
                                        'name' => '商品编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/miaosha/goods/edit',
                                    ],
                                ],
                            ],
                            [

                                'name' => '商品设置',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/goods',
                                'sub' => [
                                    [
                                        'name' => '商品编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/miaosha/goods-edit',
                                    ],
                                    [
                                        'name' => '商品详情',
                                        'is_menu' => false,
                                        'route' => 'mch/miaosha/goods-detail',
                                    ],
                                    [
                                        'name' => '日期',
                                        'is_menu' => false,
                                        'route' => 'mch/miaosha/calendar',
                                    ],
                                ],
                            ],
                            [
                                'name' => '订单列表',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/order/index',
                            ],
                            [
                                'name' => '自提订单',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/order/offline',
                            ],
                            [
                                'name' => '批量发货',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/order/batch-ship',
                            ],
                            [
                                'name' => '售后订单',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/order/refund',
                            ],
                            [
                                'name' => '评价管理',
                                'is_menu' => true,
                                'route' => 'mch/miaosha/comment/index',
                            ],
                        ],
                    ],
                    /*[
                        'key' => 'pintuan',
                        'name' => '拼团管理',
                        'is_menu' => true,
                        'route' => 'mch/group/goods/index',
                        'children' => [
                            [
                                'name' => '拼团设置',
                                'is_menu' => true,
                                'route' => 'mch/group/setting/index',
                            ],
                            [
                                'name' => '商品管理',
                                'is_menu' => true,
                                'route' => 'mch/group/goods/index',
                                'sub' => [
                                    [
                                        'name' => '商品编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/group/goods/goods-edit',
                                    ],
                                    [
                                        'name' => '商品规格',
                                        'is_menu' => false,
                                        'route' => 'mch/group/goods/goods-attr',
                                    ],
                                    [
                                        'name' => '商品标准',
                                        'is_menu' => false,
                                        'route' => 'mch/group/goods/standard',
                                    ],
                                    [
                                        'name' => '商品标准编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/group/goods/standard-edit',
                                    ],
                                ],
                            ],
                            [
                                'name' => '商品分类',
                                'is_menu' => true,
                                'route' => 'mch/group/goods/cat',
                                'sub' => [
                                    [
                                        'name' => '商品分类编辑',
                                        'is_menu' => true,
                                        'route' => 'mch/group/goods/cat-edit'
                                    ],
                                ]
                            ],
                            [
                                'name' => '订单管理',
                                'is_menu' => true,
                                'route' => 'mch/group/order/index',
                            ],
                            [
                                'name' => '售后订单',
                                'is_menu' => true,
                                'route' => 'mch/group/order/refund',
                            ],
                            [
                                'name' => '批量发货',
                                'is_menu' => true,
                                'route' => 'mch/group/order/batch-ship',
                            ],
                            [
                                'name' => '拼团管理',
                                'is_menu' => true,
                                'route' => 'mch/group/order/group',
                                'sub' => [
                                    [
                                        'name' => '拼团列表',
                                        'is_menu' => false,
                                        'route' => 'mch/group/order/group-list'
                                    ],
                                ],
                            ],
                            [
                                'name' => '机器人管理',
                                'is_menu' => true,
                                'route' => 'mch/group/robot/index',
                                'sub' => [
                                    [
                                        'name' => '机器人编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/group/robot/edit'
                                    ],
                                ]
                            ],
                            [
                                'name' => '轮播图',
                                'is_menu' => true,
                                'route' => 'mch/group/pt/banner',
                                'sub' => [
                                    [
                                        'name' => '轮播图编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/group/pt/slide-edit'
                                    ],
                                ]
                            ],
                            [
                                'name' => '模板消息',
                                'is_menu' => true,
                                'route' => 'mch/group/notice/setting',
                            ],
                            [
                                'name' => '拼团规则',
                                'is_menu' => true,
                                'route' => 'mch/group/article/edit',
                            ],
                            [
                                'name' => '评论管理',
                                'is_menu' => true,
                                'route' => 'mch/group/comment/index',
                            ],
                            [
                                'name' => '广告设置',
                                'is_menu' => true,
                                'route' => 'mch/group/ad/setting',
                            ],
                            [
                                'name' => '数据统计',
                                'is_menu' => true,
                                'route' => 'mch/group/data/goods',
                                'sub' => [
                                    [
                                        'name' => '用户列表',
                                        'is_menu' => false,
                                        'route' => 'mch/group/data/user'
                                    ],
                                ]
                            ],
                        ],
                    ],
                    [
                        'key' => 'book',
                        'name' => '预约',
                        'is_menu' => true,
                        'route' => 'mch/book/goods/index',
                        'children' => [
                            [
                                'name' => '商品管理',
                                'is_menu' => true,
                                'route' => 'mch/book/goods/index',
                                'sub' => [
                                    [
                                        'name' => '商品编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/book/goods/goods-edit'
                                    ],
                                ]
                            ],
                            [
                                'name' => '商品分类',
                                'is_menu' => true,
                                'route' => 'mch/book/goods/cat',
                                'sub' => [
                                    [
                                        'name' => '商品分类编辑',
                                        'is_menu' => false,
                                        'route' => 'mch/book/goods/cat-edit'
                                    ]
                                ]
                            ],
                            [
                                'name' => '订单管理',
                                'is_menu' => true,
                                'route' => 'mch/book/order/index',
                            ],
                            [
                                'name' => '基础设置',
                                'is_menu' => true,
                                'route' => 'mch/book/index/setting',
                            ],
                            [
                                'name' => '模板消息',
                                'is_menu' => true,
                                'route' => 'mch/book/notice/setting',
                            ],
                            [
                                'name' => '评论管理',
                                'is_menu' => true,
                                'route' => 'mch/book/comment/index',
                            ],
                        ],
                    ],
                    [
                        'key' => 'fxhb',
                        'name' => '裂变拆红包',
                        'is_menu' => true,
                        'route' => 'mch/fxhb/index/setting',
                        'children' => [
                            [
                                'name' => '红包设置',
                                'is_menu' => true,
                                'route' => 'mch/fxhb/index/setting',
                            ],
                            [
                                'name' => '红包记录',
                                'is_menu' => true,
                                'route' => 'mch/fxhb/index/list',
                            ],
                        ],
                    ],

                  ],*/

                    [
                        'name' => '卡券',
                        'is_menu' => true,
                        'route' => 'mch/card/index',
                        'sub' => [
                            [
                                'name' => '卡券编辑',
                                'is_menu' => false,
                                'route' => 'mch/card/edit',
                            ],
                        ],
                    ],
                    [
                        'name' => '充值',
                        'is_menu' => true,
                        'route' => 'mch/recharge/index',
                        'sub' => [
                            [
                                'name' => '充值编辑',
                                'is_menu' => false,
                                'route' => 'mch/recharge/edit',
                            ],
                            [
                                'name' => '充值设置',
                                'is_menu' => false,
                                'route' => 'mch/recharge/setting',
                            ],
                        ],
                    ],

                ],
            ],
            [
                'key' => 'pintuan',
                'name' => '拼团',
                'is_menu' => true,
                'route' => 'mch/group/setting/index',
                'icon' => 'iconfont icon-pintuanguanli',
                'children' => [
                    [
                        'name' => '拼团设置',
                        'is_menu' => true,
                        'route' => 'mch/group/setting/index',
                    ],
                    [
                        'name' => '商品管理',
                        'is_menu' => true,
                        'route' => 'mch/group/goods/index',
                        'sub' => [
                            [
                                'name' => '商品编辑',
                                'is_menu' => false,
                                'route' => 'mch/group/goods/goods-edit',
                            ],
                            [
                                'name' => '商品规格',
                                'is_menu' => false,
                                'route' => 'mch/group/goods/goods-attr',
                            ],
                            [
                                'name' => '商品标准',
                                'is_menu' => false,
                                'route' => 'mch/group/goods/standard',
                            ],
                            [
                                'name' => '商品标准编辑',
                                'is_menu' => false,
                                'route' => 'mch/group/goods/standard-edit',
                            ],
                        ],
                    ],
                    [
                        'name' => '商品分类',
                        'is_menu' => true,
                        'route' => 'mch/group/goods/cat',
                        'sub' => [
                            [
                                'name' => '商品分类编辑',
                                'is_menu' => true,
                                'route' => 'mch/group/goods/cat-edit'
                            ],
                        ]
                    ],
                    [
                        'name' => '订单管理',
                        'is_menu' => true,
                        'route' => 'mch/group/order/index',
                    ],
                    [
                        'name' => '售后订单',
                        'is_menu' => true,
                        'route' => 'mch/group/order/refund',
                    ],
                    [
                        'name' => '批量发货',
                        'is_menu' => true,
                        'route' => 'mch/group/order/batch-ship',
                    ],
                    [
                        'name' => '拼团管理',
                        'is_menu' => true,
                        'route' => 'mch/group/order/group',
                        'sub' => [
                            [
                                'name' => '拼团列表',
                                'is_menu' => false,
                                'route' => 'mch/group/order/group-list'
                            ],
                        ],
                    ],
                    [
                        'name' => '机器人管理',
                        'is_menu' => true,
                        'route' => 'mch/group/robot/index',
                        'sub' => [
                            [
                                'name' => '机器人编辑',
                                'is_menu' => false,
                                'route' => 'mch/group/robot/edit'
                            ],
                        ]
                    ],
                    [
                        'name' => '轮播图',
                        'is_menu' => true,
                        'route' => 'mch/group/pt/banner',
                        'sub' => [
                            [
                                'name' => '轮播图编辑',
                                'is_menu' => false,
                                'route' => 'mch/group/pt/slide-edit'
                            ],
                        ]
                    ],
                    [
                        'name' => '模板消息',
                        'is_menu' => true,
                        'route' => 'mch/group/notice/setting',
                    ],
                    [
                        'name' => '拼团规则',
                        'is_menu' => true,
                        'route' => 'mch/group/article/edit',
                    ],
                    [
                        'name' => '评论管理',
                        'is_menu' => true,
                        'route' => 'mch/group/comment/index',
                    ],
                    [
                        'name' => '广告设置',
                        'is_menu' => true,
                        'route' => 'mch/group/ad/setting',
                    ],
                    [
                        'name' => '数据统计',
                        'is_menu' => true,
                        'route' => 'mch/group/data/goods',
                        'sub' => [
                            [
                                'name' => '用户列表',
                                'is_menu' => false,
                                'route' => 'mch/group/data/user'
                            ],
                        ]
                    ],
                ],
            ],
            [
                'key' => 'miaosha',
                'name' => '秒杀',
                'is_menu' => true,
                'route' => 'mch/miaosha/index',
                'icon' => 'iconfont icon-miaosha',
                'children' => [
                    [
                        'name' => '开放时间',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/index',
                    ],
                    [
                        'name' => '秒杀设置',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/setting',

                    ],
                    [
                        'name' => '商品管理',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/goods/index',
                        'sub' => [
                            [
                                'name' => '商品编辑',
                                'is_menu' => false,
                                'route' => 'mch/miaosha/goods/edit',
                            ],
                        ],
                    ],
                    [

                        'name' => '商品设置',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/goods',
                        'sub' => [
                            [
                                'name' => '商品编辑',
                                'is_menu' => false,
                                'route' => 'mch/miaosha/goods-edit',
                            ],
                            [
                                'name' => '商品详情',
                                'is_menu' => false,
                                'route' => 'mch/miaosha/goods-detail',
                            ],
                            [
                                'name' => '日期',
                                'is_menu' => false,
                                'route' => 'mch/miaosha/calendar',
                            ],
                        ],
                    ],
                    [
                        'name' => '订单列表',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/order/index',
                    ],
                    [
                        'name' => '自提订单',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/order/offline',
                    ],
                    [
                        'name' => '批量发货',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/order/batch-ship',
                    ],
                    [
                        'name' => '售后订单',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/order/refund',
                    ],
                    [
                        'name' => '评价管理',
                        'is_menu' => true,
                        'route' => 'mch/miaosha/comment/index',
                    ],
                ],
            ],
            /*[
                'key' => 'fxhb',
                'name' => '红包管理',
                'is_menu' => true,
                'route' => 'mch/fxhb/index/setting',
                'children' => [
                    [
                        'name' => '红包设置',
                        'is_menu' => true,
                        'route' => 'mch/fxhb/index/setting',
                    ],
                    [
                        'name' => '红包记录',
                        'is_menu' => true,
                        'route' => 'mch/fxhb/index/list',
                    ],
                ],
            ],*/


            [
                'key' => 'integralmall',
                'name' => '积分',
                'is_menu' => true,
                'icon' => 'iconfont iconjifen',
                'route' => 'mch/integralmall/integralmall/setting',
                'children' => [
                    [
                        'name' => '积分商城设置',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/setting',
                    ],
                    [
                        'name' => '轮播图',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/slide',
                        'sub' => [
                            [
                                'name' => '轮播图编辑',
                                'is_menu' => false,
                                'route' => 'mch/integralmall/integralmall/slide-edit',
                            ],
                        ],
                    ],
                    [
                        'name' => '商品管理',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/goods',
                        'sub' => [
                            [
                                'name' => '商品编辑',
                                'is_menu' => false,
                                'route' => 'mch/integralmall/integralmall/goods-edit',
                            ],
                            [
                                'name' => '商品列表',
                                'is_menu' => false,
                                'mch/integralmall/integralmall/goods-list'
                            ],
                        ],
                    ],
                    [
                        'name' => '商品分类',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/cat',
                        'sub' => [
                            [
                                'name' => '商品分类编辑',
                                'is_menu' => false,
                                'route' => 'mch/integralmall/integralmall/cat-edit',
                            ],
                        ],
                    ],
                    [
                        'name' => '优惠券管理',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/coupon',
                        'sub' => [
                            [
                                'name' => '优惠券管理编辑',
                                'is_menu' => false,
                                'route' => 'mch/integralmall/integralmall/coupon-list',
                            ],
                        ],
                    ],
                    [
                        'name' => '用户兑换劵',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/user-coupon',
                    ],
                    [
                        'name' => '订单列表',
                        'is_menu' => true,
                        'route' => 'mch/integralmall/integralmall/order',
                        'sub' => [
                            [
                                'name' => '订单详情',
                                'is_menu' => false,
                                'route' => 'mch/integralmall/integralmall/detail',
                            ],
                        ],
                    ],

                ]
            ],

                [
                'name' => '内容',
                'is_menu' => true,
                'route' => 'mch/article/index',
                'icon' => 'iconfont icon-navicon-wzgl',
                'children' => [
                    [
                        'name' => '文章',
                        'is_menu' => true,
                        'route' => 'mch/article/index',
                        'sub' => [
                            [
                                'name' => '文章编辑',
                                'is_menu' => false,
                                'route' => 'mch/article/edit',
                            ]
                        ],
                    ],
                    [
                        'key' => 'topic',
                        'name' => '专题分类',
                        'is_menu' => true,
                        'route' => 'mch/topic-type/index',
                        'sub' => [
                            [
                                'name' => '专题分类编辑',
                                'is_menu' => false,
                                'route' => 'mch/topic-type/edit',
                            ]
                        ],
                    ],
                    [
                        'key' => 'topic',
                        'name' => '专题',
                        'is_menu' => true,
                        'route' => 'mch/topic/index',
                        'sub' => [
                            [
                                'name' => '专题编辑',
                                'is_menu' => false,
                                'route' => 'mch/topic/edit',
                            ]
                        ],
                    ],
                    [
                        'key' => 'video',
                        'name' => '视频',
                        'is_menu' => true,
                        'route' => 'mch/store/video',
                        'sub' => [
                            [
                                'name' => '视频编辑',
                                'is_menu' => false,
                                'route' => 'mch/store/video-edit',
                            ],
                        ],
                    ],
                    [
                        'name' => '门店',
                        'is_menu' => true,
                        'route' => 'mch/store/shop',
                        'sub' => [
                            [
                                'name' => '门店编辑',
                                'is_menu' => false,
                                'route' => 'mch/store/shop-edit',
                            ]
                        ],
                    ],
                    [
                        'name' => '装修师傅',
                        'is_menu' => true,
                        'route' => 'mch/master/index',
                        'sub' => [
                            [
                                'name' => '师傅编辑',
                                'is_menu' => false,
                                'route' => 'mch/master/edit',
                            ]
                        ],
                    ],
                ],
            ],


            [
                'name' => '财务',
                'is_menu' => true,
                'route' => 'mch/cash/mch-cash-out',
                'icon' => 'iconfont icon-caiwu',
                'children' => [
                    [
                        'name' => '商家提现',
                        'is_menu' => true,
                        'route' => 'mch/cash/mch-cash-out',
                        'sub' => [
                            [
                                'name' => '提现申请列表',
                                'is_menu' => false,
                                'route' => 'mch/cash/mch-cash-out',
                            ]
                        ],
                    ],
                    [
                        'name' => '保证金',
                        'is_menu' => true,
                        'route' => 'mch/cash/mch-deposit',
                        'sub' => [
                            [
                                'name' => '保证金申请列表',
                                'is_menu' => false,
                                'route' => 'mch/cash/mch-deposit',
                            ]
                        ],
                    ],
                ],
            ],




//
//            [
//                'admin' => true,
//                'name' => '安装应用',
//                'is_menu' => true,
//                'route' => 'mch/plugin/index',
//                'icon' => 'icon-manage',
//                'sub' => [
//                    [
//                        'name' => '应用详情',
//                        'is_menu' => false,
//                        'route' => 'mch/plugin/detail',
//                    ]
//                ],
//            ],
//            [
//                'admin' => true,
//                'name' => '教程管理',
//                'is_menu' => true,
//                'icon' => 'icon-iconxuexi',
//                'route' => 'mch/handle/index',
//                'children' => [
//                    [
//                        'name' => '操作教程',
//                        'is_menu' => true,
//                        'route' => 'mch/handle/index',
//                    ],
//                    [
//                        'admin' => true,
//                        'name' => '教程设置',
//                        'is_menu' => true,
//                        'route' => 'mch/handle/setting',
//                    ],
//                ]
//            ],


            [
                'key' => 'permission',
                'name' => '权限',
                'is_menu' => true,
                'icon' => 'iconfont icon-quanxianguanli',
                'route' => '',
                'children' => [
                    [
                        'name' => '角色列表',
                        'is_menu' => true,
                        'icon' => 'icon-manage',
                        'route' => 'mch/permission/role/index',
                        'sub' => [
                            [
                                'is_menu' => false,
                                'name' => '添加角色',
                                'route' => 'mch/permission/role/create',
                            ],
                            [
                                'is_menu' => false,
                                'name' => '编辑角色',
                                'route' => 'mch/permission/role/edit',
                            ],
                            [
                                'is_menu' => false,
                                'name' => '更新角色',
                                'route' => 'mch/permission/role/update',
                            ],
                        ]
                    ],
                    [
                        'is_menu' => true,
                        'name' => '用户管理',
                        'route' => 'mch/permission/user/index',
                        'sub' => [
                            [
                                'is_menu' => false,
                                'name' => '添加用户',
                                'route' => 'mch/permission/user/create',
                            ],
                            [
                                'is_menu' => false,
                                'name' => '编辑用户',
                                'route' => 'mch/permission/user/edit',
                            ],
                            [
                                'is_menu' => false,
                                'name' => '更新用户',
                                'route' => 'mch/permission/user/update',
                            ],
                        ],
                    ],
                ]
            ],

            //Agent

            [
                'key' => 'agent',
                'name' => '代理',
                'is_menu' => true,
                'icon' => 'iconfont icon-dailishang',
                'route' => 'mch/agent/index',
                'children' => [
                    [
                        'name' => '代理列表',
                        'is_menu' => true,
                        'icon' => 'icon-manage',
                        'route' => 'mch/agent/index',
                        'sub' => [
                            [
                                'is_menu' => false,
                                'name' => '新增代理',
                                'route' => 'mch/agent/create',
                            ],
                            [
                                'is_menu' => false,
                                'name' => '编辑代理',
                                'route' => 'mch/agent/update',
                            ],
                            [
                                'is_menu' => false,
                                'name' => '删除代理',
                                'route' => 'mch/agent/destroy',
                            ],
                        ]
                    ]
                ]
            ],

            [
                'name' => '设置',
                'is_menu' => true,
                'route' => 'mch/store/wechat-setting',
                'icon' => 'iconfont icon-icon_shezhi',
                'children' => [
                        [
                            'name' => '微信配置',
                            'is_menu' => true,
                            'route' => 'mch/store/wechat-setting',
                        ],
                        [
                            'name' => '商城设置',
                            'is_menu' => true,
                            'route' => 'mch/store/setting',
                        ],
                        [
                            'name' => '模板消息',
                            'is_menu' => true,
                            'route' => 'mch/store/tpl-msg',
                        ],
                        [
                            'name' => '短信通知',
                            'is_menu' => true,
                            'route' => 'mch/store/sms',
                        ],
                        [
                            'name' => '邮件通知',
                            'is_menu' => true,
                            'route' => 'mch/store/mail',
                        ],
                        [
                            'name' => '运费规则',
                            'is_menu' => true,
                            'route' => 'mch/store/postage-rules',
                            'sub' => [
                                [
                                    'name' => '运费规则编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/postage-rules-edit'
                                ]
                            ],
                        ],
                        [
                            'name' => '包邮规则',
                            'is_menu' => true,
                            'route' => 'mch/store/free-delivery-rules',
                            'sub' => [
                                [
                                    'name' => '包邮规则编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/free-delivery-rules-edit'
                                ],
                            ],
                        ],
                        [
                            'name' => '快递单打印',
                            'is_menu' => true,
                            'route' => 'mch/store/express',
                            'sub' => [
                                [
                                    'name' => '快递单打印编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/express-edit',
                                ]
                            ],
                        ],
                        [
                            'name' => '小票打印',
                            'is_menu' => true,
                            'route' => 'mch/printer/list',
                            'sub' => [
                                [
                                    'name' => '小票打印设置',
                                    'is_menu' => false,
                                    'route' => 'mch/printer/setting',
                                ],
                                [
                                    'name' => '小票打印编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/printer/edit',
                                ]
                            ],
                        ],
                        [
                            'name' => '区域限制',
                            'is_menu' => true,
                            'route' => 'mch/store/territorial-limitation',
                            'sub' => [
                                [
                                    'name' => '区域限制',
                                    'is_menu' => false,
                                    'route' => 'mch/store/territorial-limitation'
                                ],
                            ],
                        ],
                        [
                            'name' => '起送规则',
                            'is_menu' => true,
                            'route' => 'mch/store/offer-price-edit',
                            'sub' => [
                                [
                                    'name' => '起送规则编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/offer-price-edit',
                                ],
                            ],
                        ],

                        [
                            'admin' => true,
                            'name' => '上传设置',
                            'is_menu' => true,
                            'route' => 'mch/store/upload',
                        ],
                        [
                            'admin' => true,
                            'we7' => true,
                            'name' => '权限管理',
                            'is_menu' => true,
                            'route' => 'mch/we7/auth',
                        ],
                        [
                            'admin' => true,
                            'name' => '版权管理',
                            'is_menu' => true,
                            'route' => 'mch/we7/copyright-list',
                        ],
                        [
                            'key' => 'copyright',
                            'name' => '版权设置',
                            'is_menu' => true,
                            'route' => 'mch/we7/copyright',
                        ],
                        [
                            'name' => '消息提醒',
                            'is_menu' => true,
                            'route' => 'mch/store/order-message',
                        ],
                        [
                            'name' => '缓存',
                            'is_menu' => true,
                            'route' => 'mch/cache/index',
                        ],
                        [
                            'admin' => true,
                            'offline' => true,
                            'name' => '更新',
                            'is_menu' => true,
                            'route' => 'mch/update/index',
                        ],
                        [
                            'name' => '数据库优化',
                            'is_menu' => true,
                            'route' => 'mch/system/db-optimize',
                        ],
                ],
            ],


            [
                'name' => '小程序',
                'is_menu' => true,
                'route' => '',
                'icon' => 'iconfont icon-xiaochengxu',
                'children' => [
                        [
                            'name' => '轮播图',
                            'is_menu' => true,
                            'route' => 'mch/store/slide',
                            'sub' => [
                                [
                                    'name' => '轮播图编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/slide-edit',
                                ],
                            ],
                        ],
                        [
                            'name' => '品牌轮播图',
                            'is_menu' => true,
                            'route' => 'mch/store/goods-slide',
                            'sub' => [
                                [
                                    'name' => '轮播图编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/goods-slide-edit',
                                ],
                            ],
                        ],
                        [
                            'name' => '导航图标',
                            'is_menu' => true,
                            'route' => 'mch/store/home-nav',
                            'sub' => [
                                [
                                    'name' => '导航图标编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/home-nav-edit',
                                ],
                            ],
                        ],
                        [
                            'name' => '图片魔方',
                            'is_menu' => true,
                            'route' => 'mch/store/home-block',
                            'sub' => [
                                [
                                    'name' => '图片魔方编辑',
                                    'is_menu' => false,
                                    'route' => 'mch/store/home-block-edit',
                                ]
                            ],
                        ],
                        [
                            'name' => '导航栏',
                            'is_menu' => true,
                            'route' => 'mch/store/navbar',
                            'sub' => [
                                [
                                    'name' => '恢复默认设置',
                                    'is_mune' => false,
                                    'route' => '/mch/store/navbar-reset'
                                ]
                            ]
                        ],
                        [
                            'name' => '首页布局',
                            'is_menu' => true,
                            'route' => 'mch/store/home-page',
                        ],
                        [
                            'name' => '用户中心',
                            'is_menu' => true,
                            'route' => 'mch/store/user-center',
                        ],
                        [
                            'name' => '下单表单',
                            'is_menu' => true,
                            'route' => 'mch/store/form',
                        ],
                        [
                            'offline' => true,
                            'name' => '小程序发布',
                            'is_menu' => true,
                            'route' => 'mch/store/wxapp',
                        ],
                        [
                            'name' => '小程序页面',
                            'is_menu' => true,
                            'route' => 'mch/store/wxapp-pages',
                        ],
                ]

            ]


        ];
    }
}
