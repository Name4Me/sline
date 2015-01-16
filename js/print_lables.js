//---print_lables.js-------------------------------------------[Global var's]---
	var curent_g = {};
	var ggid = '';
	var gtip = '';
	var gid = '';
	var grid = '';
	var grtid = '';


	var tb_rozmir = {		_data : Array(),
		count : 0,
		getRozmir: function (inRID){    		var data = new Array();
    		n = 0;
			for (var i = 0; i < this.count-1; i++) {
				if (this._data[i].RID == inRID) data[n++] = this._data[i];
			};
			return data;		}	};

    var tb_gg = {
    	_data : Array(),
    	count : 0,
    	getByID: function (inID){
    		var result = {};
			for (var i = 0; i < this.count-1; i++) {
				if (this._data[i].ID == inID) {					result = this._data[i];
					break;
				};
			};
			return result;
		}
    };
//---------------------------------------------------------------------[my_s]---
	my_s = function(_key,_p1,_p2) {
		source =
			{
			    datatype: "json",
			    datafields: [
			        { name: 'f1' },
			        { name: 'id' }
			    ],
			    id: 'id',
			    data : {'key' : _key, 'p1' : _p1, 'p2' : _p2},
			    url: 'get_data_lb.php'
			};
		return source;
	}
//------------------------------------------------------------[rozmir_source]---
	rozmir_source = function(_p1) {
		source = {
			localdata: tb_rozmir.getRozmir(_p1),
   			datatype: "array"
   		};
		return source;
	}
//---------------------------------------------------------------------[my_f]---
	my_f = function(_obj_name,_dataAdapter,_fname) {
		_obj_name.jqxListBox({
			source: _dataAdapter,
			displayMember: _fname,
			valueMember: "id",
			});
	}

//------------------------------------------------------------------------------
	$(document).ready(function () {
		pr_Button = $("#pr_Button");
		lp_Button = $("#lp_Button");
        t_Button = $("#t_Button");
        plus_Button = $("#plus_Button");
        minus_Button = $("#minus_Button");

        k_text = $("#myKilkist");

		ListBox1 = $("#ListBox1");
		ListBox2 = $("#ListBox2");
		ListBox3 = $("#ListBox3");
		ListBox4 = $("#ListBox4");
		ListBox5 = $("#ListBox5");

		log = $("#log");

		var my_length = "";

		// prepare the data
		//---------------------------------------------------------------[gg]---
		source1 = {
			datatype: "json",
			datafields: [
		 		{ name: 'Nazva' },
		 		{ name: 'RID' },
		 		{ name: 'RtID' },
		        { name: 'ID' }],
		    id: 'ID',
		    url: '../data/gg.txt'
		    };

		dataAdapter1 = new $.jqx.dataAdapter(source1, {
                loadComplete: function () {
                    records = dataAdapter1.records;
                    length = records.length;
                    tb_gg.count = length;
                    for (var i = 0; i < length; i++)
                        tb_gg._data[i] = records[i];

                }
		});

		//-----------------------------------------------------------[rozmir]---
		source3 = {
			datatype: "json",
			datafields: [
		 		{ name: 'Rozmir', type : "number"},
		        { name: 'RID', type : "number"}],
		    id: 'id',
		    url: '../data/rozmir.txt'
		    };
		//var dataAdapter3 = new $.jqx.dataAdapter(source3);
		dataAdapter3 = new $.jqx.dataAdapter(source3, {
                loadComplete: function () {
                    records = dataAdapter3.records;
                    length = records.length;
                    tb_rozmir.count = length;
                    for (var i = 0; i < length; i++)                    	tb_rozmir._data[i] = records[i];
                }
		});
        dataAdapter3.dataBind();

        _height = $(window).height() - 50;

        $("#myKilkist").jqxNumberInput({ width: '70px', height: '22px', inputMode: 'simple',decimal:1,min: 1,spinButtonsStep: 1,decimalDigits:0, spinButtons: true,  theme: 'summer' });

		ListBox1.jqxListBox({ source: dataAdapter1,displayMember: "Nazva",
			valueMember: "ID",width: 170,height: _height,theme: 'summer'});

		ListBox2.jqxListBox({width: 40,height: _height,theme: 'summer'});
		ListBox3.jqxListBox({width: 180,height: _height,theme: 'summer'});
		ListBox4.jqxListBox({width: 50,height: _height,theme: 'summer'});
		ListBox5.jqxListBox({width: 40,height: _height,theme: 'summer'});

		pr_Button.jqxButton({ width: '120px', height: '35px', theme: 'summer', disabled: true});
		lp_Button.jqxButton({ width: '120px', height: '120px', theme: 'summer', disabled: true});
		plus_Button.jqxButton({ width: '15px', height: '15px', theme: 'summer'});
		minus_Button.jqxButton({ width: '15px', height: '15px', theme: 'summer'});

	//--------------------------------------------------[k_text.valuechanged]---
		k_text.bind('valuechanged', function (event) {
                curent_g.Kilkist = event.args.value;
  		});
/*		k_text.keypress(function(event) {
   			keyCode=event.keyCode;
			if (!((keyCode>47&&keyCode<58)||keyCode===8||keyCode===37||keyCode===39||keyCode==46))
				event.preventDefault? event.preventDefault() : event.returnValue = false;
		});*/

	//------------------------------------------------------[pr_Button.click]---
	    pr_Button.click(function(){	    	$.get("get_data_lb.php", { key: "9"}, function(data){
  				 alert("Данные загружены: "  );
			});

	    });
	//-------------------------------------------------------[t_Button.click]---
	    t_Button.click(function(){
        log.text(Number(k_text.val()));
	    });
    //--------------------------------------------------[window.bind(resize)]---
    	$(window).bind('load resize',function() {
			_height = $(window).height() - 50;
			ListBox1.jqxListBox({height: _height});
			ListBox2.jqxListBox({height: _height});
			ListBox3.jqxListBox({height: _height});
			ListBox4.jqxListBox({height: _height});
			ListBox5.jqxListBox({height: _height});
		});
	//------------------------------------------------------[lp_Button.click]---
	    lp_Button.click(function(){
	    	$.get("../func/lable_print.php", { p1 : curent_g.Nazva, p2 : curent_g.Tip,
	    		p3 : curent_g.Rozmir, p4 : curent_g.Rist, p5 : curent_g.Kilkist,
	    		p6 : curent_g.ID + curent_g.TipID});
	    });
    //--------------------------------------------------------[ListBox1.bind]---
		ListBox1.bind('select', function (event) {
			pr_Button.jqxButton({disabled: true});
		  	lp_Button.jqxButton({disabled: true});
		    if (event.args) {
		        var item = event.args.item;
		        if (item) {
					ggid = item.value;
					curent_g = tb_gg.getByID(ggid);
					curent_g.Kilkist = 1;
					$("#selection1").text(item.label);
					$("#selection2").text('');
					$("#selection3").text('');
					$("#selection4").text('');
					$("#selection5").text('');

					dataAdapter2 = new $.jqx.dataAdapter(my_s(1,ggid,0));
					my_f(ListBox2,dataAdapter2,'f1');

					ListBox3.jqxListBox('clear');
					ListBox4.jqxListBox('clear');
					ListBox5.jqxListBox('clear');

		        }
		    }
		});
	//--------------------------------------------------------[ListBox2.bind]---
        ListBox2.bind('select', function (event) {
        	pr_Button.jqxButton({disabled: true});
          	lp_Button.jqxButton({disabled: true});
            if (event.args) {
				ft = event.args.item.label;
				$("#selection2").text(ft);
				$("#selection3").text('');
				$("#selection4").text('');
				$("#selection5").text('');
				dataAdapter2 = new $.jqx.dataAdapter(my_s(3,ggid,ft));
				my_f(ListBox3,dataAdapter2,'f1');
				ListBox4.jqxListBox('clear');
				ListBox5.jqxListBox('clear');
            }
        });
	//--------------------------------------------------------[ListBox3.bind]---
		ListBox3.bind('select', function (event) {
	     	pr_Button.jqxButton({disabled: true});
	       	lp_Button.jqxButton({disabled: true});

	        if (event.args) {
	         	item = event.args.item;
	         	curent_g.Tip = item.label;
	         	curent_g.TipID = item.value;

	          	$("#selection3").text(curent_g.Tip);
	     		$("#selection4").text('');
	       		$("#selection5").text('');

	            if (curent_g.RID == 0) {
					pr_Button.jqxButton({disabled: false});
	       			lp_Button.jqxButton({disabled: false});
	       			ListBox4.jqxListBox('clear');
				} else {		         	dataAdapter2 = new $.jqx.dataAdapter(rozmir_source(curent_g.RID));
				    my_f(ListBox4,dataAdapter2,'Rozmir');				};

				ListBox5.jqxListBox('clear');
	    	}
		});
	//--------------------------------------------------------[ListBox4.bind]---
		ListBox4.bind('select', function (event) {
			pr_Button.jqxButton({disabled: true});
			lp_Button.jqxButton({disabled: true});
			if (event.args) {
			    curent_g.Rozmir = event.args.item.label;
			    $("#selection4").text(curent_g.Rozmir);
			    $("#selection5").text('');

				if (curent_g.RtID == 0) {
					pr_Button.jqxButton({disabled: false});
	       			lp_Button.jqxButton({disabled: false});
	       			ListBox5.jqxListBox('clear');
				} else {		         	dataAdapter2 = new $.jqx.dataAdapter(rozmir_source(0));
				    my_f(ListBox5,dataAdapter2,'Rozmir');				};

	    	}


		});
	//--------------------------------------------------------[ListBox5.bind]---
        ListBox5.bind('select', function (event) {
            if (event.args) {
                curent_g.Rist = event.args.item.label;
                $("#selection5").text(curent_g.Rist);
                pr_Button.jqxButton({disabled: false});
          		lp_Button.jqxButton({disabled: false});
            }
        });
	//--------------------------------------------------------------------------


	});
//------------------------------------------------------------------------------