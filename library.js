
function openModal(modal_class){

	var current_position = $(document).scrollTop();

	$('html').css('overflow','hidden');

	$(modal_class).addClass('open');
	$(modal_class).css({{
		'transform':'translate(0,' + current_position + 'px)',
		'top','-' + current_position + 'px',
	}});

}

function closeModal(modal_class){

	var current_position = $(document).scrollTop();

	$(modal_class).css({{
		'transform':'translate(0, calc(100% + ' + current_position + 'px))',
		'top':'0px'
	}});

	$('html').css('overflow','auto');
	$('main').removeClass('open_modal');

}

function openDialog(dialog_class) {

	var scroll_top = $(window).scrollTop();

	$(dialog_class).addClass('open');

	$('body').css({
		'top':-scroll_top,
		'position':'fixed',
		'width':'100%'
	});

}

function closeDialog(dialog_class) {

	var scroll_top = $('body').offset().top;

	$(dialog_class)).removeClass('open');

	$('body').css({
		'top':'auto',
		'position':'relative',
		'width':body_width
	});

	$(window).scrollTop(-scroll_top);

}

var more_view_option = [
	'api_url':'',
	'target_list':'',
	'cnt_target':'',
	'trigger':0,
	'list_length':20,
	'index':0,
	'end_flg':false
];

function moreView(option){

	let api_url     = option.api_url;
	let target_list = option.target_list;
	let list_length = option.list_length;
	let trigger     = option.trigger;
	let st          = $(window).scrollTop();
	let end_flg     = option.end_flg;
	let cnt_target  = option.cnt_target;

	if (st > trigger && list_length !end_flg) {

		trigger += $(target_list).innerHeight();
		np      += 1;

		$.ajax({

			url:api_url,
			type:'get',
			dataType:'html',
			data:{
				ajax_request:true,
				np:np
			}

		}).done(function(data){

			parse_html = $($.parseHTML(data));
			item_cnt   = parse_html.find(cnt_target).length;

			if (item_cnt) {
				$(target_list).append(data);
			}

			if (item_cnt < 20) {

				end_flg = true;

			}

		});


	}

}

function getDatas(param){

	$.when(

		ajaxRequest(param,1,param.flg_1),
		ajaxRequest(param,2,param.flg_2),
		ajaxRequest(param,3,param.flg_3),

	).done(function(data_1,data_2,data_3){

		//色々

	})
	.fail(function(){

	});

}

function ajaxRequest(param,flg=false){

	const = api_urls[
			1:'',
			2:'',
			3:'',
		];

	let request = false;

	if (flg) {

		request = $.ajax({
			url: api_urls[param.id],
			type:'post',
			data:param,
			dataType:'json'
		});

	}

	return request;

}

function getLastDate(year_val,month_val){

	let last_day = 0;

	if ([4,6,9,11].includes(month_val)) {

		last_day = 30;

	}else if (month_val == 2) {

		last_day = checkLeapYear(year_val) ? 29 : 28;

	}else {

		last_day = 31;

	}

	return last_day;

}

function checkLeapYear(year_val){

	let flg = false;

	if (year_val%4 == 0 && year_val%100 != 02 || year_val%400 == 0) {
		flg = true;
	}

	return flg;

}

function zeroPading(num,length){
	return ('0000'+num).slice(-length);
}

function createCSV(data,search_date){

	let html = "";

	var bom  = new Uint8Array([0xEF, 0xBB, 0xBF]);
	var csv  = data.map(function(l){return l.join(',')}).join('\r\n');
	var blob = new Blob([bom, csv], { type: 'text/csv' });
	var url  = (window.URL || window.webkitURL).createObjectURL(blob);

	html += "<a href='"+url+"' download='"+search_date+".csv'><span>CSV出力</span></a>"

	return html;

}
