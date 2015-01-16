/*
	tb_rozmir.js last update 21.05.2014 11:40
*/
//-------------------------------------------------------------------[rozmir]---
var tb_rozmir = {
	_data : Array(),
	count : 0,
	getRozmir: function (inRID){
   		var data = new Array();
   		n = 0;
		for (var i = 0; i < this._data.length-1; i++) {
			if (this._data[i].RID == inRID) data[n++] = this._data[i];
		};
		return data;
	},
	load : function (){
 		if (!get_cookie('rr')) {
	 		//alert('rr load from file');
	 		$.getJSON('../data/rozmir.txt',function(json){
				tb_rozmir._data = json;
				s = JSON.stringify(json);
   				s = s.replace(/Rozmir/g, 'f1');
    			s = s.replace(/RID/g, 'f2');
    			s = s.replace(/"([^"]*)"/g, '$1');
    			s = s.replace(/},{/g, '}.{');
				set_cookie('rr',s);
			});
		} else {
			//alert('rr load cookies');
			s = get_cookie('rr');
			s = s.replace(/f1/gi, 'Rozmir');
    		s = s.replace(/f2/gi, 'RID');
    		s = s.replace(/{/g, '{"');
    		s = s.replace(/}/g, '"}');
    		s = s.replace(/:/g, '":"');
    		s = s.replace(/,/g, '","');
    		s = s.replace(/}.{/g, '},{');
			tb_rozmir._data = JSON.parse(s);
		}
	}
};
//----------------------------------------------------------------[Data load]---tb_rozmir.load();