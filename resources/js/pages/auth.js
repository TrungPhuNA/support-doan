import {CookieMonster} from 'cookiemonster';

var Auth = {
	init(){
		var cookies = new CookieMonster(document);
		let ref = cookies.get('ref_id');
		if (typeof ref != "undefined" && ref != null)
		{
			$("#ref").val(ref)
		}
		let utm_source = cookies.get('utm_source');
		if (typeof utm_source != "undefined" && utm_source != null)
		{
			$("#utm_source").val(utm_source)
		}
	},
};

$(function () {
	Auth.init();
})