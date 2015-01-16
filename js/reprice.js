//reprice.php last update 16.05.2014 13:20
//---reprice.js------------------------------------------------[Global var's]---
	var curent_g = {};
	var prule = {};
	var swf = 1;
	var last_prid = -1;
	var tr_clr=$(".colors:last").css("background-color");

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


//-----------------------------------------------------------------[changeID]---
	changeID = function(iid) {
		if ((iid == '') || (iid == '_')) return;
		$("#input12").val(iid);
	    $.getJSON("get_data_lb.php",
	    	{
	    		'key' : 15,
	    		'p1' : curent_g.GGID,
	    		'p2' : curent_g.TipID,
	    		'p3' : iid
	    	},
	    	function(json){
  				irefresh(iid);
				});
		if (last_prid != iid) {			$("#Button_t4").val($("#Button_t3").val());
			$("#Button_t3").val($("#Button_t2").val());
			$("#Button_t2").val($("#Button_t1").val());
			$("#Button_t1").val(iid);
			last_prid = iid;		}
	}
//-----------------------------------------------------------------[irefresh]---
	trefresh = function() {	            var ttext = "<tr id=first_tr><td>PR</td><td>Rozmir</td><td>"
    					+"Rozmir1</td><td>Cina</td><td>BCina</td><td>BCina1"
    					+"</td><td>OCina</td><td>BOCina</td><td>BOCina1</td><td>"
    					+"ZCina</td><td>BZCina</td><td>BZCina1</td><td>Count</td></tr>\n";
        	$.getJSON("get_data_lb.php", {'key' : 19, 'p1' : curent_g.GGID}, function(json){
  				var i = 1;

  				$.each(json, function(key, val) {
    				ttext += "<tr><th>"
    					+val.ID+"</th><td>"+val.Rozmir+"</td><td>"
    					+val.Rozmir1+"</td><th>"+val.Cina+"</th><td>"
    					+val.BCina+"</td><td>"+val.BCina1+"</td><th>"
    					+val.OCina+"</th><td>"+val.BOCina+"</td><td>"
    					+val.BOCina1+"</td><th>"+val.ZCina+"</th><td>"
    					+val.BZCina+"</td><td>"+val.BZCina1+"</td><td>"
    					+val.Сnt+"</td></tr>\n";
    				i++;
  				});
  				$("#tbl2")[0].innerHTML = ttext;
  				$(".color_table tr:not(#first_tr)").addClass("colors");
  				$(".colors").css("background-color", "#90ee90");
				$(".colors").css("background-color", "white");
				tr_clr = $(".colors:last").css("background-color");
                $(".colors").hover(mouseOver, mouseOut);
                $(".colors").click(mouseClick);
			});
	}

	irefresh = function(iid) {
		//log.html('checked: ' + checked);
		if (!swf) return;
		$.ajaxSetup({async: false});
		$.getJSON("get_data_lb.php", {'key' : 11, 'p1' : iid}, function(json){
			prule = json[0];
		});
		$("#input1").val(prule.Rozmir);
		$("#input2").val(prule.Rozmir1);
		$("#input3").val(prule.Cina);
		$("#input4").val(prule.BCina);
		$("#input5").val(prule.BCina1);
		$("#input6").val(prule.OCina);
		$("#input7").val(prule.BOCina);
		$("#input8").val(prule.BOCina1);
		$("#input9").val(prule.ZCina);
		$("#input10").val(prule.BZCina);
  		$("#input11").val(prule.BZCina1);
  		$("#tbl2")[0].innerHTML = '';
        $.getJSON("get_data_lb.php", {'key' : 12, 'p1' : iid}, function(json){
  			var i = 1;
  			$.each(json, function(key, val) {
    			$("#tbl2")[0].innerHTML += "<tr><td>"+val.GGID+"</td><td colspan = 2>"+val.Tip+"</td></tr>\n";
    			i++;
  			});
  			$("#tbl2")[0].innerHTML = "<tr id=first_tr><td width = 10%>GGID</td><td>Tip</td><td width = 20%>Summ: "+(i-1)+"</td></tr>" + $("#tbl2")[0].innerHTML;
		});
        $.ajaxSetup({async: true});
	}
//------------------------------------------------------------------------------
	$(document).ready(function () {


		Button1 = $("#Button1");
        Button2 = $("#Button2");
        Button3 = $("#Button3");
        Button4 = $("#Button4");
        Button5 = $("#Button5");
        Button6 = $("#Button6");
		Button_t1 = $("#Button_t1");
		Button_t2 = $("#Button_t2");
		Button_t3 = $("#Button_t3");
		Button_t4 = $("#Button_t4");

        Сheckbox1 = $("#Сheckbox1");

        k_text = $("#myKilkist");

		ListBox1 = $("#ListBox1");
		ListBox2 = $("#ListBox2");
		ListBox3 = $("#ListBox3");

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

		dataAdapter1 = new $.jqx.dataAdapter(source1);


        _height = $(window).height() - 100;

        ListBox1.jqxListBox({ source: dataAdapter1,displayMember: "Nazva",
			valueMember: "ID",width: 170,height: _height,theme: 'summer'});
		ListBox2.jqxListBox({width: 40,height: _height,theme: 'summer'});
		ListBox3.jqxListBox({width: 220,height: _height,theme: 'summer'});
        _iwidth = 50

        var i;
        var input = new Array(13);
		for (i=1; i<13; i++) {
			input[i]=$("#input"+i);
			$("#input"+i).jqxInput({ width: _iwidth, height: '25px'});
		}

        Сheckbox1.jqxCheckBox({ width: 50, height: '25px', checked:true});

		Button1.jqxButton({ width: '120px', height: '25px', theme: 'summer', disabled: true});
        Button2.jqxButton({ width: '120px', height: '25px', theme: 'summer'});
        Button3.jqxButton({ width: '120px', height: '25px', theme: 'summer', disabled: true});
        Button4.jqxButton({ width: '120px', height: '25px', theme: 'summer'});
        Button_t1.jqxButton({ width: 35, height: 25, theme: 'summer'});
        Button_t2.jqxButton({ width: 35, height: 25, theme: 'summer'});
        Button_t3.jqxButton({ width: 35, height: 25, theme: 'summer'});
        Button_t4.jqxButton({ width: 35, height: 25, theme: 'summer'});
        Button5.jqxButton({ width: 120, height: 25, theme: 'summer'});
        Button6.jqxButton({ width: 120, height: 25, theme: 'summer'});
	//------------------------------------------------[Show]-[Сheckbox1.bind]---
		Сheckbox1.bind('change', function (event) {
			swf = event.args.checked;
			if (swf) irefresh(input[12].val());;
  		});
	//-----------------------------------------------[Додати]-[Button1.click]---
	    Button1.click(function(){
	    	$.ajaxSetup({async: false});
	    	$.getJSON("get_data_lb.php",
	    		{	    			'key' : 13,
	    			'p1' : input[1].val(),
	    			'p2' : input[2].val(),
	    			'p3' : input[3].val(),
	    			'p4' : input[4].val(),
	    			'p5' : input[5].val(),
	    			'p6' : input[6].val(),
	    			'p7' : input[7].val(),
	    			'p8' : input[8].val(),
	    			'p9' : input[9].val(),
	    			'p10' : input[10].val(),
	    			'p11' : input[11].val()
	    		},
	    		function(json){
  					if (json.f1==0) alert("Таке правило існує ID: " + json.ID);
  					if (json.f1==1)	alert("Правило створене ID: " + json.ID);
			});
			$.ajaxSetup({async: true});

	    });
	//----------------------------------------------[Змінити]-[Button2.click]---
	    Button2.click(function(){
	        if (!curent_g.GGID) return;
            if (curent_g.GGID =='' || input[12].val() == '') return;
	    	$.getJSON("get_data_lb.php",
	    		{
	    			'key' : 14,
	    			'p1' : input[1].val(),
	    			'p2' : input[2].val(),
	    			'p3' : input[3].val(),
	    			'p4' : input[4].val(),
	    			'p5' : input[5].val(),
	    			'p6' : input[6].val(),
	    			'p7' : input[7].val(),
	    			'p8' : input[8].val(),
	    			'p9' : input[9].val(),
	    			'p10' : input[10].val(),
	    			'p11' : input[11].val(),
	    			'p12' : input[12].val()
	    		},
	    		function(json){
  					//curent_g.PR = json[0].f1;
					});

	    });
	//-------------------------------------------[Змінити ID]-[Button3.click]---
	    Button3.click(function(){
	    	changeID(input[12].val());
	    });
	//-----------------------------------------[Змінити ID]-[Button_t1.click]---
	    Button_t1.click(function(){
	    	changeID(Button_t1.val());
	    });
	//-----------------------------------------[Змінити ID]-[Button_t2.click]---
	    Button_t2.click(function(){
	    	changeID(Button_t2.val());
	    });
	//-----------------------------------------[Змінити ID]-[Button_t3.click]---
	    Button_t3.click(function(){
	    	changeID(Button_t3.val());
	    });
	//-----------------------------------------[Змінити ID]-[Button_t4.click]---
	    Button_t4.click(function(){
	    	changeID(Button_t4.val());
	    });
	//-------------------------------------------------[DNUR]-[Button4.click]---
	    Button4.click(function(){
	    	$.post("get_data_lb.php",{'key' : 17});
	    });
	//------------------------------------------------[АвтоП]-[Button5.click]---
	    Button5.click(function(){
            if (!curent_g.GGID) return;
	    	$.ajaxSetup({async: false});
	    	log.html('Result: ---');
	    	$.getJSON("get_data_lb.php",{'key' : 20, 'p1' : curent_g.GGID},
	    		function(json){
  					log.html('Result: ' + json[0].Result);
					});
			$.ajaxSetup({async: true});
	    	//;
	    });
	//------------------------------------------------[АвтоП]-[Button6.click]---
	    Button6.click(function(){
            if (!curent_g.GGID) return;
            if (curent_g.GGID =='' || input[12].val() == '') return;
	    	$.ajaxSetup({async: false});
	    	log.html('Result: ---');
	    	$.getJSON("get_data_lb.php",
	    		{	    			'key' : 21,
	    			'p1' : curent_g.GGID,
	    			'p2' : input[12].val()
	    		},
	    		function(json){
  					log.html('Result: ' + json[0].Result);
					});
			$.ajaxSetup({async: true});
	    	//;
	    });
    //--------------------------------------------------[window.bind(resize)]---
    	$(window).bind('load resize',function() {
			_height = $(window).height() - 100;
			ListBox1.jqxListBox({height: _height});
			ListBox2.jqxListBox({height: _height});
			ListBox3.jqxListBox({height: _height});
		});
    //--------------------------------------------------------[ListBox1.bind]---
		ListBox1.bind('click', function (event) {			trefresh();		});
    //--------------------------------------------------------[ListBox1.bind]---
		ListBox1.bind('select', function (event) {
			Button1.jqxButton({disabled: true});
          	Button3.jqxButton({disabled: true});
		    if (event.args) {
		        var item = event.args.item;
		        if (item) {
					curent_g.Kilkist = 1;
                    curent_g.GGID = item.value;
					dataAdapter2 = new $.jqx.dataAdapter(my_s(1,curent_g.GGID,0));
					my_f(ListBox2,dataAdapter2,'f1');
					ListBox3.jqxListBox('clear');
		        }
		    }
            trefresh();

		});
	//--------------------------------------------------------[ListBox2.bind]---
        ListBox2.bind('select', function (event) {
        	Button1.jqxButton({disabled: true});
          	Button3.jqxButton({disabled: true});
            if (event.args) {
				ft = event.args.item.label;
				dataAdapter2 = new $.jqx.dataAdapter(my_s(3,curent_g.GGID,ft));
				my_f(ListBox3,dataAdapter2,'f1');
            }
        });
	//--------------------------------------------------------[input12.change]---
        $('#input12').on('change',function(){
			var value = $('#input12').val();
			irefresh(value);
		});

	//--------------------------------------------------------[ListBox3.bind]---
		ListBox3.bind('select', function (event) {
	     	Button1.jqxButton({disabled: true});

	        if (event.args) {
	         	item = event.args.item;
	         	curent_g.Tip = item.label;
	         	curent_g.TipID = item.value;
	         	$.ajaxSetup({async: false});
        		$.getJSON("get_data_lb.php", {'key' : 10, 'p1' : curent_g.GGID, 'p2' : curent_g.TipID}, function(json){
  					curent_g.PR = json[0].f1;
					});
				$.ajaxSetup({async: true});
				$('#input12').val(curent_g.PR);
				irefresh(curent_g.PR);

                Button1.jqxButton({disabled: false});
                Button3.jqxButton({disabled: false});
	    	}
		});
	//--------------------------------------------------------------------------










});
//------------------------------------------------------------------------------
//------------------------------------------------------------------------------
function mouseClick() {
 	if ($(this).css("background-color")!=tr_clr)
  		$(this).css("background-color",tr_clr)
 	else $(this).css("background-color","yellow")
 	$("#input12").val($(this).children().first().html());
 	irefresh($("#input12").val());
 	}

function mouseOver() {
	$(this).css("background-color", "yellow");
}

function mouseOut() {
    $(this).css("background-color", "white");
}