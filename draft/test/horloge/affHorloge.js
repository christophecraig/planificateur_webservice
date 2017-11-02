define(['dojo/topic', 'dojo/_base/declare', 'dojo/dom', 'dojo/dom-construct', 'dojo/_base/lang'], function(topic, declare, dom, domConstruct, lang) {
	return declare(null, {
		constructor: function() {
			this.time = domConstruct.create("div", {}, dojo.body());
			topic.subscribe('gotDate', lang.hitch(this, this.displayDate));
		},
		displayDate: function(date) {
			this.time.innerHTML = date;
			console.log(date);
		}
	})
})