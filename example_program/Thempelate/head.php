<?
    //반응형 추가 메타
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
    //echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=Edge">'.PHP_EOL;


	if(!defined('G5_IS_ADMIN')){

	/* react And Babel JS ES6 */
	//add_javascript('<script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>',0);
	//add_javascript('<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>',0);
	//add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>',0);

	/*vue And Babel JS ES6*/
	add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.js"></script>', 0);
	add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>', 0); //개발모드
	//add_javascript('<script src="https://cdn.jsdelivr.net/npm/vue"></script>', 0); //유통모드
	add_javascript('<script src="'.G5_JS_URL.'/extend.js?ver=1.0.0"></script>', 0);
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/scss/jmodule.css?ver=1.0.0"> ',0);

	//use Mobile AND PC
	/*
	if(G5_IS_MOBILE) {

	}else{
	add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/scss/jmodule.css">', 0);
	}
	*/
	}
?>




