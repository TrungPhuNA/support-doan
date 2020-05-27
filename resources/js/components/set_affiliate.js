import {CookieMonster} from 'cookiemonster';

var Affiliate = {

	init : function (KEY) {
		console.log('-- init Affiliate by KEY: ' + KEY)
		console.log('-- init Affiliate by REF: ' + REF)
		var cookies = new CookieMonster(document);
		let ref = this.checkRef(KEY);

		if (typeof ref == "undefined") {
			console.log('-- --  set cookies by ref: ' + REF);
			let one_month_from_now = new Date(new Date().getTime() + 24*60*60*15);
			cookies.set(KEY + DOCUMENT_ID, REF, {path: '/', expires: one_month_from_now});
		}
	},

	checkRef(KEY)
	{
		var cookies = new CookieMonster(document);
		return cookies.get(KEY+ DOCUMENT_ID)
	}
}

export default Affiliate;