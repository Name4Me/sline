/*
	tb_gg.js last update 21.05.2014 11:40
*/
//-----------------------------------------------------------------------[gg]---
var tb_gg = {
	_data : Array(),
 	count : 0,
 	getByID : function (inID){
 		var result = {};
		for (var i = 0; i < this._data.length-1; i++) {
			if (this._data[i].ID == inID) {
				result = tb_gg._data[i];
				break;
			};
		};
		return result;
	},
	load : function (){
 		if (!get_cookie('gg')) {
	 		//alert('gg load from file');
	 		$.getJSON('../data/gg.txt',function(json){
				tb_gg._data = json;
				set_cookie ( 'gg', JSON.stringify(json));
			});
		} else {			//alert('gg load cookies');
			this._data = JSON.parse(get_cookie('gg'));
		}
	}
};
//----------------------------------------------------------------[Data load]---
tb_gg.load();
