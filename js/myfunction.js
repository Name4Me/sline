$(document).ready(function() {
//myfunction.js
	$.ajaxSetup({async: false});
	$.getScript("../js/cookies.js");
    $.ajaxSetup({async: true});

	// prepare the data
	//---------------------------------------------------------------[gg]---
	ComboBox1 = $("#ComboBox1");
	source1 = {
		datatype: "json",
		datafields: [
	 		{ name: 'Misce' },
	 		{ name: 'ID' }],
	    id: 'ID',
	    url: '../data/misce.txt'
	    };

    _height = $(window).height() - 100;
	dataAdapter1 = new $.jqx.dataAdapter(source1);


	ComboBox1.jqxComboBox({ source: dataAdapter1,displayMember: "Misce", width: '200px', height: '25px', theme: 'summer'});
	ComboBox1.bind('select', function (event) {
	    var args = event.args;
	    var item = ComboBox1.jqxComboBox('getItem', args.index);
	    $.post('func/myfunction.php',{ task: 'misce', misce: item.label});
	    $("title").text('DBMeneger ['+item.label+']');
	    $("li.title").text('DBMeneger ['+item.label+']');
	    set_cookie('misce',item.label);
	});

	if (get_cookie('misce')) {
		misce = get_cookie('misce');	    $("title").text('DBMeneger ['+misce+']');
	    $("li.title").text('DBMeneger ['+misce+']');
		ComboBox1.jqxComboBox({placeHolder: misce });    }

    $('input').css('margin', '5px 5px 0px');

	$("#ssave").click(function(){ // ssave
		$.post('func/ssave.php',{ task: 'ssave'});
	 });

	$('#az_sveta').click(function(){// az_sveta
		$.post('func/myfunction.php',{ task: 'az_sveta'});
	});

	$('#del_valik').click(function(){// del_valik
		jQuery.post('func/myfunction.php',{ task: 'del_valik'});
	});

	$('#del_x').click(function(){// del_x
		jQuery.post('func/myfunction.php',{ task: 'del_x'});
	});

	$('#saveSnapV').click(function(){// saveSnap
		jQuery.post('func/myfunction.php',{ task: 'SaveSnapV'});
	});
    $('#saveSnapL').click(function(){// saveSnap
		jQuery.post('func/myfunction.php',{ task: 'SaveSnapL'});
	});
    $('#saveSnapD').click(function(){// saveSnap
		jQuery.post('func/myfunction.php',{ task: 'SaveSnapD'});
	});


	$('#up_misce').click(function(){// up_misce Link
		$.post('func/myfunction.php',{ task: 'up_misce'});
	});

	$('.window .close').click(function (e) {
		e.preventDefault();
		$('#mask, .window').hide();
	});

	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});


});