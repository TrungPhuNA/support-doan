<?php
return [
	[
        'name' => 'QL tài liệu',
        'list-check' => ['document','category','combo-document'],
        'icon' => 'fa fa-book',
        'sub'  => [
			[
				'name'  => 'Danh mục',
				'namespace' => 'category',
				'route' => 'admin.category.index',
				'icon'  => 'fa fa-edit'
			],
            [
                'name'  => 'Tài liệu',
                'namespace' => 'document',
                'route' => 'admin.document.index',
                'icon'  => 'fa fa-file-excel-o'
            ],
			[
                'name'  => 'Gói Combo',
                'namespace' => 'combo-document',
                'route' => 'admin.combo_document.index',
                'icon'  => 'fa fa-file-excel-o'
            ]
        ]
    ],
    [
        'name' => 'Tin tức',
        'list-check' => ['menu','article','tag'],
        'icon' => 'fa fa-edit',
        'sub'  => [
            [
                'name'  => 'Menu',
                'namespace' => 'menu',
                'route' => 'admin.menu.index',
                'icon'  => 'fa fa-key'
            ],
			[
                'name'  => 'Từ khoá',
                'namespace' => 'tag',
                'route' => 'admin.tag.index',
                'icon'  => 'fa fa-key'
            ],
            [
                'name'  => 'Bài viết',
                'namespace' => 'article',
                'route' => 'admin.article.index',
                'icon'  => 'fa fa-key'
            ],
        ]
    ],
    [
        'name' => 'Tài khoản',
        'list-check' => ['user','rating','comment','contact'],
        'icon' => 'fa fa-users',
        'sub'  => [
            [
                'name'  => 'Thành viên',
                'route' => 'admin.user.index',
                'namespace' => 'user',
                'icon'  => 'fa fa-user-o'
            ],
//            [
//                'name'  => 'Rating',
//                'namespace' => 'rating',
//                'route' => 'admin.rating.index',
//                'icon'  => 'fa fa-star'
//            ],
//            [
//                'name'  => 'Comment',
//                'namespace' => 'comment',
//                'route' => 'admin.comment.index',
//                'icon'  => 'fa fa-star'
//            ],
//            [
//                'name'  => 'Contact',
//                'namespace' => 'contact',
//                'route' => 'admin.contact',
//                'icon'  => 'fa fa-star'
//            ],
        ]
    ],
    [
        'name' => 'Đơn hàng',
        'list-check' => ['transaction','transaction-temporarily'],
        'icon' => 'fa-shopping-cart',
        'sub'  => [
            [
                'name'  => 'Danh sách',
                'namespace' => 'transaction',
                'route' => 'admin.transaction.index',
                'icon'  => 'fa-opencart'
            ],
			[
                'name'  => 'Đơn hàng mua nhanh',
                'namespace' => 'transaction-temporarily',
                'route' => 'admin.transaction_temporarily.index',
                'icon'  => 'fa-opencart'
            ]
        ]
    ],
    [
        'name' => 'Ql Nạp tiền',
        'list-check' => ['pay-in'],
        'icon' => 'fa  fa-usd',
        'sub'  => [
            [
                'name'  => 'Nạp tiền',
                'route' => 'admin.system_pay_in.index',
                'namespace' => 'pay-in',
                'icon'  => 'fa fa-money'
            ]
        ]
    ],
//	[
//        'name' => 'Chiến dịch',
//        'list-check' => ['campaign'],
//        'icon' => 'fa  fa-usd',
//        'sub'  => [
//            [
//                'name'  => 'Danh sách',
//                'route' => 'admin.campaign.index',
//                'namespace' => 'campaign',
//                'icon'  => 'fa fa-money'
//            ]
//        ]
//    ],
//	[
//		'name' => 'Admin manage',
//		'list-check' => ['permission','role','admin'],
//		'icon' => 'fa fa-user-md',
//		'sub'  => [
//			[
//				'name'  => 'Permission',
//				'route' => 'admin.permission.list',
//				'namespace' => 'permission',
//				'icon'  => 'fa fa-money'
//			],
//			[
//				'name'  => 'Role',
//				'route' => 'admin.role.list',
//				'namespace' => 'role',
//				'icon'  => 'fa fa-money'
//			],
//			[
//				'name'  => 'Admin',
//				'route' => 'admin.admin.list',
//				'namespace' => 'admin',
//				'icon'  => 'fa fa-money'
//			],
//		]
//	],
    [
        'name'  => 'Hệ thống',
        'label' => 'true'
    ],
	[
		'name' => 'Ql hệ thống',
		'list-check' => ['queue','api-drive','event','statistical','setting'],
		'icon' => 'fa fa-user-md',
		'sub'  => [
			[
				'name'  => 'Hàng đợi',
				'route' => 'admin.queue.index',
				'namespace' => 'queue',
				'icon'  => 'fa fa-money'
			],
			[
				'name'  => 'Thông báo',
				'route' => 'admin.notification',
				'namespace' => 'thong-bao',
				'icon'  => 'fa fa-bell-o'
			],
			[
				'name'  => 'Sự kiện',
				'route' => 'admin.event.index',
				'namespace' => 'event',
				'icon'  => 'fa fa-money'
			],
			[
				'name'  => 'Api Convert tài liệu',
				'route' => 'admin.api_drive.index',
				'namespace' => 'api-drive',
				'icon'  => 'fa fa-money'
			],
			[
				'name'  => 'Cấu hình',
				'route' => 'admin.setting',
				'namespace' => 'setting',
				'icon'  => 'fa fa-money'
			],
			[
				'name'  => 'Thống kê',
				'route' => 'admin.statistical',
				'namespace' => 'statistical',
				'icon'  => 'fa fa-money'
			],
		]
	],
];
