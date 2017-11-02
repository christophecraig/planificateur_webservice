define(['dojo/rpc/JsonService', 'dojo/topic', 'dojo/_base/declare', 'dojo/_base/lang'], function(JsonService, topic, declare, lang) {
	return declare(null, {
		constructor: function() {
			this.horloge = new JsonService('http://192.168.0.166/~mbeacco/macro_planning/draft/test/ws.php');
			this.horloge.setFormatDate('d m y H i s').then(lang.hitch(this, this.getDate));
			setInterval(lang.hitch(this, this.getDate), 1000);
		},
		gotDate: function(date) {
			topic.publish('gotDate', date);
		},
		getDate: function() {
			this.horloge.getDate().then(lang.hitch(this, this.gotDate))
		}
	})
})