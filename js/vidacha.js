//---vidacha.js------------------------------------------------[Global var's]---
	var curent_g = {};
	$.ajaxSetup({async: false});
	$.getScript("../js/cookies.js");
    $.getScript("../js/tb_gg.js");
	$.getScript("../js/tb_rozmir.js");
    $.ajaxSetup({async: true});



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

//---------------------------------------------------------------------[my_f]---
	my_f = function(_obj_name,_dataAdapter,_fname) {
		_obj_name.jqxListBox({
			source: _dataAdapter,
			displayMember: _fname,
			valueMember: "id",
			});
	}
//-----------------------------------------------------------------[trefresh]---
	trefresh = function(iip) {
            $("#tbl2")[0].innerHTML="<tr id=first_tr><td>Nazva</td><td>Tip</td><td>Rozmir</td><td>Rist</td><td>Kilkist</td><td>ID</td><td>Cod</td></tr>";
  			$.ajaxSetup({async: false});
  			$.getJSON("get_data_lb.php", {'key' : 18, 'p1' : get_cookie('misce'), 'p2' : iip}, function(json){
  				$.each(json, function(key, val) {
    				$("#tbl2")[0].innerHTML += "<tr><td style =\"padding-left:5; padding-right:5\">"+
    				val.Nazva+"</td><td style =\"padding-left:5; padding-right:5\">"+
    				val.Tip+"</td><td style =\"padding-left:5; padding-right:5\">"+
    				val.Rozmir+"</td><td style =\"padding-left:5; padding-right:5\">"+
    				val.Rist+"</td><td style =\"padding-left:5; padding-right:5\">"+
    				val.Kilkist+"</td><td style =\"padding-left:5; padding-right:5\">"+
    				val.ID+"</td><td style =\"padding-left:5; padding-right:5\">"+
    				val.Cod+"</td></tr>\n";
  				});
			});

        	$.ajaxSetup({async: true});
	}
//------------------------------------------------------------------------------
$(document).ready(function () {
	Button1 = $("#Button1");
	Button2 = $("#Button2");

	k_text = $("#myKilkist");
	v_ip = $("#ip");

	ListBox1 = $("#ListBox1");
	ListBox2 = $("#ListBox2");
	ListBox3 = $("#ListBox3");
	ListBox4 = $("#ListBox4");
	ListBox5 = $("#ListBox5");

	log = $("#log");
	log.text(get_cookie('misce'));

	var my_length = "";

	_height = $(window).height() - 100;

 	k_text.jqxNumberInput({ width: '70px', height: '22px', inputMode: 'simple',
 		decimal:1,min: 1,spinButtonsStep: 1,decimalDigits:0, spinButtons: true,
 		theme: 'summer' });
 	v_ip.jqxNumberInput({ width: '70px', height: '22px', inputMode: 'simple',
 		decimal:0,min: 0,spinButtonsStep: 1,decimalDigits:0, spinButtons: true,
 		theme: 'summer' });

	ListBox1.jqxListBox({ source: tb_gg._data,displayMember: "Nazva",
		valueMember: "ID",width: 170,height: _height,theme: 'summer'});

	ListBox2.jqxListBox({width: 60,height: _height,theme: 'summer'});
	ListBox3.jqxListBox({width: 220,height: _height,theme: 'summer'});
	ListBox4.jqxListBox({width: 50,height: _height,theme: 'summer'});
	ListBox5.jqxListBox({width: 40,height: _height,theme: 'summer'});

	Button1.jqxButton({ width: '120px', height: '35px', theme: 'summer', disabled: true});
	Button2.jqxButton({ width: '120px', height: '35px', theme: 'summer'});


	//--------------------------------------------------[k_text.valuechanged]---
		k_text.bind('valuechanged', function (event) {
                curent_g.Kilkist = event.args.value;
  		});

		v_ip.bind('valuechanged', function (event) {
        	trefresh(v_ip.val());
  		});
/*		k_text.keypress(function(event) {
   			keyCode=event.keyCode;
			if (!((keyCode>47&&keyCode<58)||keyCode===8||keyCode===37||keyCode===39||keyCode==46))
				event.preventDefault? event.preventDefault() : event.returnValue = false;
		});*/

	//---------------------------------------------[Провести]-[Button1.click]---
	    Button1.click(function(){  			s = curent_g.GGID+curent_g.TipID;
  			if (curent_g.Rozmir) s=s+curent_g.Rozmir;
  			if (curent_g.Rist) s=s+curent_g.Rist;
  			$.post("get_data_lb.php",{'key' : 16, 'p1' : s, 'p2' : curent_g.Kilkist, 'p3' : v_ip.val()});
  			//log.text(s+'/'+curent_g.Kilkist+'/'+v_ip.val());
  			trefresh(v_ip.val());
	    });
	//--------------------------------------------------------[Button2.click]---
	    Button2.click(function(){
	        //$('title').text('Видача');
			//alert();

	    });
    //--------------------------------------------------[window.bind(resize)]---
    	$(window).bind('load resize',function() {
			_height = $(window).height() - 100;
			ListBox1.jqxListBox({height: _height});
			ListBox2.jqxListBox({height: _height});
			ListBox3.jqxListBox({height: _height});
			ListBox4.jqxListBox({height: _height});
			ListBox5.jqxListBox({height: _height});
			$("title").text('Видача ['+get_cookie('misce')+']');
		});
    //--------------------------------------------------------[ListBox1.bind]---
		ListBox1.bind('select', function (event) {
			Button1.jqxButton({disabled: true});
		    if (event.args) {
		        var item = event.args.item;
		        if (item) {
					curent_g = tb_gg.getByID(item.value);
					curent_g.GGID = item.value;
					curent_g.Kilkist = 1;
					$("#selection1").text(item.label);
					$("#selection2").text('');
					$("#selection3").text('');
					$("#selection4").text('');
					$("#selection5").text('');

					dataAdapter2 = new $.jqx.dataAdapter(my_s(1,curent_g.GGID,0));
					my_f(ListBox2,dataAdapter2,'f1');

					ListBox3.jqxListBox('clear');
					ListBox4.jqxListBox('clear');
					ListBox5.jqxListBox('clear');

		        }
		    }
		});
	//--------------------------------------------------------[ListBox2.bind]---
        ListBox2.bind('select', function (event) {
        	Button1.jqxButton({disabled: true});
            if (event.args) {
				ft = event.args.item.label;
				$("#selection2").text(ft);
				$("#selection3").text('');
				$("#selection4").text('');
				$("#selection5").text('');
				dataAdapter2 = new $.jqx.dataAdapter(my_s(3,curent_g.GGID,ft));
				my_f(ListBox3,dataAdapter2,'f1');
				ListBox4.jqxListBox('clear');
				ListBox5.jqxListBox('clear');
            }
        });
	//--------------------------------------------------------[ListBox3.bind]---
		ListBox3.bind('select', function (event) {
	     	Button1.jqxButton({disabled: true});

	        if (event.args) {
	         	item = event.args.item;
	         	curent_g.Tip = item.label;
	         	curent_g.TipID = item.value;

	          	$("#selection3").text(curent_g.Tip);
	     		$("#selection4").text('');
	       		$("#selection5").text('');
	            if (curent_g.RID == 0) {
					Button1.jqxButton({disabled: false});
	       			ListBox4.jqxListBox('clear');
				} else {				    ListBox4.jqxListBox({ source: tb_rozmir.getRozmir(curent_g.RID),displayMember: "Rozmir"});				};

				ListBox5.jqxListBox('clear');
	    	}
		});
	//--------------------------------------------------------[ListBox4.bind]---
		ListBox4.bind('select', function (event) {
			Button1.jqxButton({disabled: true});
			if (event.args) {
			    curent_g.Rozmir = event.args.item.label;
			    $("#selection4").text(curent_g.Rozmir);
			    $("#selection5").text('');

				if (curent_g.RtID == 0) {
					Button1.jqxButton({disabled: false});
	       			ListBox5.jqxListBox('clear');
				} else {				    ListBox5.jqxListBox({ source: tb_rozmir.getRozmir(0),displayMember: "Rozmir"});				};

	    	}


		});
	//--------------------------------------------------------[ListBox5.bind]---
        ListBox5.bind('select', function (event) {
            if (event.args) {
                curent_g.Rist = event.args.item.label;
                $("#selection5").text(curent_g.Rist);
                Button1.jqxButton({disabled: false});
            }
        });
	//--------------------------------------------------------------------------


	});
//------------------------------------------------------------------------------