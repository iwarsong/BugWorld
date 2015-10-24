seajs.config({
	alias: {
		'jquery': 'jquery/2.1.1/jquery',
		'$': 'jquery/2.1.1/jquery',
		'bootstrap': 'bootstrap.js/3.2.0/bootstrap',
		'arale-validator': 'arale-validator/0.10.0/index',
	},

	// 变量配置
	vars: {
		'locale': 'zh-cn'
	},

    base: '/jslib/dist/',

	charset: 'utf-8',

	debug: true
});
