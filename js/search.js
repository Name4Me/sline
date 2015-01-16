//	search.js
        var tid = '';
        var lasttid = '-1';
        var lasts = '-1';
        var ttip = '';
        var trozmir = '';
        var trist = '';
        var smisce = '';
        var grid1;

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
//---------------------------------------------------------------[my_refresh]---
		my_refresh = function(_p1) {
        	s = tid + ttip + '!' + trozmir + trist;
        	if (lasts == s) return;
        	lasts = s;
        	$.ajaxSetup({async: false});
        	if (_p1 == 0) grid1.setGridParam({'postData':{ss:s, 'sm' : smisce, 'p2' : 0}}).trigger("reloadGrid")
        		else grid1.setGridParam({'postData':{ss:s, 'sm' : smisce, 'p2' : 1}}).trigger("reloadGrid");
        	$.ajaxSetup({async: true});
        	lb2_load();
		}
//-----------------------------------------------------------------[lb2_load]---
		lb2_load = function() {
        	if ((tid != '') & (lasttid !=tid)) {
        		dataAdapter2 = new $.jqx.dataAdapter(my_s(1,tid,0));
				my_f(ListBox2,dataAdapter2,'f1');
				lasttid = tid;
        	}

		}
//------------------------------------------------------------------------------
    $(document).ready(function(){
        $('title').text('Пошук');
        _height = $(window).height()-40;
        _width = $(window).width()-20;
        search_s = $("#search_s");
    	ListBox1 = $("#ListBox1");
    	ListBox2 = $("#ListBox2");
    	Button1 = $("#Button1");
    	grid1 = $("#list");
    	spliter1 = $('#splitter1');

    	log = $('#log');
        log.text('fgfgf');
		source1 = {
			datatype: "json",
			datafields: [
		 		{ name: 'Misce' },
		        { name: 'ID' }],
		    id: 'ID',
		    url: '../data/misce.txt'
		    };

		dataAdapter1 = new $.jqx.dataAdapter(source1);


        p1_width = 130;

		spliter1.jqxSplitter({ width: _width, height: _height, theme: 'summer', resizable: false,
        	panels: [{ size: p1_width}, { size: '80%'}], splitBarSize: '15px'});  //, collapsed: true

        ListBox1.jqxListBox({ source: dataAdapter1,displayMember: "Misce",
			valueMember: "ID",width: p1_width,height: _height-35,theme: 'summer'});
		ListBox2.jqxListBox({width: 60,height: _height,theme: 'summer'});








        Button1.jqxButton({ width: p1_width, height: 35, theme: 'summer'});

        grid1.jqGrid({
            url:'getdata.php', //
            datatype: 'json',
            //height: _height - 130,
            height: 'auto',
			width: 800,
            colNames:[ 'misce','nazva', 'tip','rozmir','rist','kilkist','cina', 'id'], //
            colModel :[
                {name:'misce', index:'misce', search:false, width:150}
                ,{name:'nazva', index:'nazva', search:false, width:200}
                ,{name:'tip', index:'tip', search:false, width:250}
                ,{name:'rozmir', index:'rozmir',align:'right', search:false, width:40} //
                ,{name:'rist', index:'rist', width:20,search:false} //, width:20
                ,{name:'kilkist', index:'kilkist', width:20,search:false} //, width:20
                ,{name:'cina', index:'cina',search:false, width:45} //
                ,{name:'id', index:'id', search:false}
                ],
            rowList:[5,10,30],
            scroll:1,
            mtype: 'POST',
            viewrecords: true,
			gridview: true,
            rownumbers: true,
            rownumWidth: 40,
            pager: jQuery("#pager"),
            sortname: 'id',
            sortorder: "asc",
            //viewrecords: true,
            //imgpath: 'themes/basic/images',


            onCellSelect: function(rowid, index, contents, event) {
            	//$('title').text('Пошук'+rowid)
            	var ss = '';
             	switch (index) {
					case 1: //smisce =  contents;
					  	break;
					case 2:
						nid = rowid.substring(0, 2);

					  	break;
					case 3: ss =  contents + '!';
						ttip = contents;
					    break;
					case 4: trozmir = contents;
						break;
					case 5: trist = contents;
					    break;
					}
     			tid = rowid.substring(0, 2);
     			search_s.val(tid + ttip + '!' + trozmir + trist);
        		my_refresh(0);
                lb2_load();
            }
        });

  	//-------------------------------------------------------[search_s.keyup]---
		search_s.keyup(function() {
            s = search_s.val();
            TTovar.sanaliz(s);
            tid = TTovar._GID;
            ttip = TTovar._tip;
        	trozmir = TTovar._rozmir;
        	trist = TTovar._rist;

			my_refresh(0);
		});
  	//--------------------------------------------------------[ListBox1.bind]---
		ListBox1.bind('select', function (event) {
		    if (event.args) {
		        var item = event.args.item;
		        if (item) smisce = item.label;
		    }
		    my_refresh(0);
		});
  	//--------------------------------------------------------[ListBox1.bind]---
		ListBox2.bind('select', function (event) {
		    if (event.args) {
		        var item = event.args.item;
		        if (item) ttip = item.label;
		    }
		    search_s.val(tid + ttip + '!' + trozmir + trist);
		    my_refresh(0);
		});
	//--------------------------------------------------[window.bind(resize)]---
    	$(window).bind('load resize',function() {
			_height = $(window).height()-40;
			spliter1.jqxSplitter({height: _height});
			ListBox1.jqxListBox({height: _height-35});
			ListBox2.jqxListBox({height: _height-6});
			grid1.setGridHeight(_height - 77);
		});
	//--------------------------------------------------------[Button1.click]---
		Button1.click(function(){
	        smisce = '';
	        var index = ListBox1.jqxListBox('getSelectedIndex');
	        if (index > 0 ) ListBox1.jqxListBox('selectIndex', -1 )
	        	else my_refresh();
	    });
	//--------------------------------------------------------------------------
    });

