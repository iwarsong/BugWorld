seajs.config({
	alias: {
		'jquery': 'jquery/2.1.1/jquery-debug',
		'jquery-debug': 'jquery/2.1.1/jquery-debug',
		'$': 'jquery/2.1.1/jquery-debug',
		'$-debug': 'jquery/2.1.1/jquery-debug',
		'bootstrap': 'bootstrap.js/3.2.5/bootstrap-debug',
		'bootstrap-material': 'bootstrap-material-design/0.3.0/material',
		'bootstrap-material-ripples': 'bootstrap-material-design/0.3.0/ripples',
		'arale-validator': 'arale-validator/0.10.0/index',
		'keypress': 'keypress/2.1.3/keypress',
		'paste.js': 'paste.js/1.9.0/paste.js',
		'arale-dnd' : 'arale/1.0.0/dnd',
		'arale-base' : 'arale/1.0.0/base',
		'arale-class' : 'arale/1.0.0/class',
		'arale-events' : 'arale/1.0.0/events',
	},

	// 变量配置
	vars: {
		'locale': 'zh-cn'
	},

    base: '/jslib/dist/',

	charset: 'utf-8',

	debug: true
});
