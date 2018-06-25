var default_zoom_level = 10;
var geocoder;
var geocoder1;
var map;
var bounds;
var marker;
var marker1;
var markerimage;
var infowindow;
var locations;
var latlng;
var searchTag;
var ws_wsid;
var ws_lat;
var ws_lon;
var ws_width;
var ws_industry_type;
var ws_map_icon_type;
var ws_transit_score;
var ws_commute;
var ws_map_modules;
var styles = [];
var markerClusterer = null;
var map = null;
var markers = [];
var common_options = {
        map_frame_id: 'mapframe',
        map_window_id: 'mapwindow',
		area: 'js-street_id',
        state: 'StateName',
        city: 'CityName',
        country: 'js-country_id',
        lat_id: 'latitude',
        lng_id: 'longitude',
        postal_code: 'PropertyPostalCode',
        ne_lat: 'ne_latitude',
        ne_lng: 'ne_longitude',
        sw_lat: 'sw_latitude',
        sw_lng: 'sw_longitude',
        button: 'js-sub',
        error: 'address-info',
		mapblock: 'mapblock',
        lat: '37.7749295',
        lng: '-122.4194155',
        map_zoom: 13
    }
function split( val ) {
	return val.split( /,\s*/ );
}
function extractLast( term ) {
	return split( term ).pop();
}
function __l(str, lang_code) {
    //TODO: lang_code = lang_code || 'en_us';
    return(__cfg && __cfg('lang') && __cfg('lang')[str]) ? __cfg('lang')[str]: str;
}
function __cfg(c) {
    return(cfg && cfg.cfg && cfg.cfg[c]) ? cfg.cfg[c]: false;
}
function calcTime(offset) {
	d = new Date();
	utc = d.getTime() + (d.getTimezoneOffset() * 60000);
	return date('Y-m-d', new Date(utc+(3600000*offset)));
}
(function($) {
    $.fn.dialogMultiple = function() {
        var ids = '';
        $(".js-multiple-sub-item").each(function() {
            if (ids == '') {
                ids = '#' + $(this).metadata().opendialog
            } else {
                ids = ids + ', ' + '#' + $(this).metadata().opendialog
            }
        });
        if (ids != '') {
            $(ids).dialog( {
                autoOpen: false,
                modal: true
            });
        }
    };
    $.fn.setflashMsg = function($msg, $type) {
        switch($type) {
            case 'auth': $id = 'authMessage';
            break;
            case 'error': $id = 'errorMessage';
            break;
            case 'success': $id = 'successMessage';
            break;
            default: $id = 'flashMessage';
        }
        $flash_message_html='<div class="js-flash-message flash-message-block"><div class="message" id="'+$id+'">'+$msg+'</div></div>';
		$('div.message').css("z-index","99999");
		$('.content').prepend($flash_message_html);
		$('#errorMessage,#authMessage,#successMessage,#flashMessage,#flashMessage').flashMsg();
		$('html, body').animate({ scrollTop: $(".js-flash-message").offset().top }, 500);
    };
    $.fn.confirm = function() {
		$('body').delegate('a.js-delete', 'click', function(event) {
            return window.confirm(__l('Are you sure you want to ') + this.innerHTML.toLowerCase() + '?');
        });
    };
    $.fn.flashMsg = function() {
        $this = $(this);
        $alert = $this.parents('.js-flash-message');
        var alerttimer = window.setTimeout(function() {
            $alert.trigger('click');
        }, 3000);
        $alert.click(function() {
            window.clearTimeout(alerttimer);
            $alert.animate( {
                height: '0'
            }, 200);
            $alert.children().animate( {
                height: '0'
            }, 200).css('padding', '0px').css('border', '0px');
			$this.animate( {
                height: '0'
            }, 200).css('padding', '0px').css('border', '0px').css('display', 'none');
        });
    };
	$.fn.ftinyMce = function() {
		$(this).tinymce( {
			// Location of TinyMCE script
			script_url: __cfg('path_relative') + 'js/libs/tiny_mce/tiny_mce.js',
			mode: "textareas",
		   // General options
			theme: "advanced",
			plugins: "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
		   // Theme options
		   //newdocument,|,
			theme_advanced_buttons1: "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect, |, cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,",
			theme_advanced_buttons2: "undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolortablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,ltr,rtl,|,fullscreen,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,visualchars,nonbreaking,pagebreak",
			theme_advanced_buttons3: "",
			theme_advanced_buttons4: "",

			theme_advanced_toolbar_location: "top",
			theme_advanced_toolbar_align: "left",
			theme_advanced_statusbar_location: "bottom",
			theme_advanced_resizing: true,
		  // Example content CSS (should be your site CSS)
			//content_css: "css/content.css",
		   // Drop lists for link/image/media/template dialogs
			template_external_list_url: "lists/template_list.js",
			external_link_list_url: "lists/link_list.js",
			external_image_list_url: "lists/image_list.js",
			media_external_list_url: "lists/media_list.js",
			height: "250px",
			width: "80%",
			relative_urls : false,
			remove_script_host : false,
			setup: function(ed) {
				ed.onChange.add(function(ed) {
					tinyMCE.triggerSave();
				});
			}
		});
    };
       $.fautocomplete = function(selector) {
        if ($(selector, 'body').is(selector)) {
            $this = $(selector);
            var autocompleteUrl = $this.metadata().url;
            var targetField = $this.metadata().targetField;
            var targetId = $this.metadata().id;
            var placeId = $this.attr('id');
            $this.autocomplete( {
                source: function(request, response) {
                    $.getJSON(autocompleteUrl, {
                        term: extractLast(request.term)
                        }, response);
                },
                search: function() {
                    // custom minLength
                    var term = extractLast(this.value);
                    if (term.length < 2) {
                        return false;
                    }
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function(event, ui) {
                    if ($('#' + targetId).val()) {
                        $('#' + targetId).val(ui.item['id']);
                    } else {
                        var targetField1 = targetField.replace(/&amp;/g, '&').replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"');
                        $('#' + placeId).after(targetField1);
                        $('#' + targetId).val(ui.item['id']);
                    }
                }
            });
        }
    };
    $.fn.merchantprofile = function(is_enabled) {
        if (is_enabled == 0) {
            $('.js-merchant_profile_show').hide();
        }
        if (is_enabled == 1) {
            $('.js-merchant_profile_show').show();
        }
    };
    $.fn.floadMapLocation = function(selector) {
       	if($(selector, 'body').is(selector)){
			var $country = 0;
			$this = $(selector);
			var script = document.createElement('script');
			var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadCityMap&language='+__cfg('user_language');
			script.setAttribute('src', google_map_key);
			script.setAttribute('type', 'text/javascript');
			document.documentElement.firstChild.appendChild(script);
		}
	};
     $.fn.itemPurchaseMapLocation = function(selector) {
     if($(selector, 'body').is(selector)){
   		var $country = 0;
			$this = $(selector);
			var script = document.createElement('script');
			var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadItemPurchaseMap&language='+__cfg('user_language');
			script.setAttribute('src', google_map_key);
			script.setAttribute('type', 'text/javascript');
			document.documentElement.firstChild.appendChild(script);
		}
	};
    $.fn.fuploadajaxform = function() {
      	$('body').delegate('form.js-upload-form', 'submit', function(e) {
            var content1 = $('.wuI').html();
            $flash_disabled = false;
            $('input:file').each(function(index) {
                if (($this).val())
                    return true;
            });
            var validate = false;
            if ($(this).metadata().is_required == 'false' && $('#ItemCloneItemId').val() != '') {
                var checked_image = $('.attachment-delete-block input:checked').length;
                var total_image = $('.attachment-delete-block input:checkbox').length;
                if (checked_image == total_image) {
                    validate = true;
                }
            }
            if (($(this).metadata().is_required == 'true' || validate) && (content1 == '' || content1 == null)) {
                $('.js-flashupload-error').remove();
                $('.js-uploader').append('<div class="js-flashupload-error error-message">' + __l('Please select atleast one file') + '</div>');
                $('.js-flashupload-error').flashMsg();
                return false;
            } else if ($(this).metadata().is_required == 'false' && (content1 == '' || content1 == null)) {
                return true;
            } else {
                $('.js-flashupload-error').remove();
            }
            var $this = $(this);
            $this.find('.js-validation-part').block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {
                    $(formData).each(function(i) {
                        if (formData[i]['name'] == "data[Item][menu]") {
                            if (formData[i]['value'] == '') {
                                $('textarea', jqForm[0]).each(function(j) {
                                    if ($('textarea', jqForm[0]).eq(j).attr('name') == 'data[Item][menu]') {
                                        formData[i]['value'] = $('textarea', jqForm[0]).eq(j).val();
                                    }

                                });

                            }
                        }
                    });
                },
                success: function(responseText, statusText) {
                    if (responseText == 'flashupload') {
                        $('.js-upload-form .flashUploader').each(function() {
                            this.__uploaderCache.upload('', this.__uploaderCache._settings.backendScript);
                        });
                    } else {
                        var validation_part = $(responseText).find('.js-validation-part', $this).html();
                        if (validation_part != '') {
                            $this.parents('.js-responses').find('.js-validation-part', $this).html(validation_part);
                        }
                        aftersubmititem(false);
                    }
                }
            });
            return false;
        });
    };
    $.fn.fajaxform = function() {
        $('body').delegate('form.js-ajax-form', 'submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {
                    $('input:file', jqForm[0]).each(function(i) {
                        if ($('input:file', jqForm[0]).eq(i).val()) {
                            options['extraData'] = {
                                'is_iframe_submit': 1
                            };
                        }
                    });
                    $this.block();
                },
                success: function(responseText, statusText) {
                    redirect = responseText.split('*');
                    if (redirect[0] == 'redirect') {
                        location.href = redirect[1];
                    } else if ($this.metadata().container) {
                         $this.parents('.' + $this.metadata().container).html(responseText);
                    } else {
                        if ($('div.js-preview-responses').length) {
                            $('div.js-preview-responses').html(responseText);
                        } else {
                            $this.parents('div.js-responses').eq(0).html(responseText);
                        }
                    }
                    aftersubmititem(false);
                    $this.unblock();

                }
            });
            return false;
        });
    };
    $.fn.fajaxaddform = function() {
         $('body').delegate('#user_cash_withdrawals-index form.js-ajax-add-form', 'submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    if (responseText.indexOf($this.metadata().container) != '-1') {
                        $('.' + $this.metadata().container).html(responseText);
                    } else {
                        $.get(__cfg('path_relative') + 'user_cash_withdrawals/index/', function(data) {
                            $('.js-withdrawal_responses').html(data);
                            return false;
                        });
                    }
                    $('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
                    $this.unblock();
                }
            });
            return false;
        });
    };
    $.fn.fajaxlogin = function() {
       $('body').delegate('form.js-ajax-login', 'submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    redirect = responseText.split('*');
                    if (redirect[0] == 'redirect') {
                        location.href = redirect[1];
                    } else if (responseText == 'success') {
                        window.location.reload();
                    } else {
                        $this.parents('.js-login-response').html(responseText);
                    }
                }
            });
            return false;
        });
    };
        $.fn.fcommentform = function() {
         $('body').delegate('#topics-add form.js-comment-form, #users-view form.js-comment-form, #items-view form.js-comment-form,#UserInterestCommentAddForm.js-comment-form', 'submit', function(e) {
            var $this = $(this);
            $this.block();
            $this.ajaxSubmit( {
                beforeSubmit: function(formData, jqForm, options) {},
                success: function(responseText, statusText) {
                    if (responseText.indexOf($this.metadata().container) != '-1') {
                        $('.' + $this.metadata().container).html(responseText);
                    } else {
                        $('.js-comment-responses').prepend(responseText);
                        $('.notice').remove();
                        $('.' + $this.metadata().container + ' div.input').removeClass('error');
                        $('.error-message', $('.' + $this.metadata().container)).remove();
                    }
                    if (typeof($('.js-captcha-container').find('.captcha-img').attr('src')) != 'undefined') {
                        captcha_img_src = $('.js-captcha-container').find('.captcha-img').attr('src');
                        captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
                        $('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
                    }
                    $('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
                    $this.unblock();
                },
                clearForm: true
            });
            return false;
        });
    };
    $.fn.fcolorbox = function() {
            $(this).colorbox( {
                opacity: 0.30
            });
    };
     var i = 1;
    $.fn.fdatepicker = function() {
		$(this).each(function (e) {
            var $this = $(this);
            var class_for_div = $this.attr('class');
            var year_ranges = $this.children('select[id$="Year"]').text();

            var start_year = end_year = '';
            $this.children('select[id$="Year"]').find('option').each(function() {
                $tthis = $(this);
                if ($tthis.attr('value') != '') {
                    if (start_year == '') {
                        start_year = $tthis.attr('value');
                    }
                    end_year = $tthis.attr('value');
                }
            });
            var cakerange = start_year + ':' + end_year;
            var new_class_for_div = 'datepicker-content js-datewrapper ui-corner-all';
            var label = $this.children('label').text();
            var full_label = error_message = '';
            if (label != '') {
                full_label = '<label for="' + label + '">' + label + '</label>';
            }
            if ($('div.error-message', $this).html()) {
                var error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
            }
            var img = '<div class="time-desc datepicker-container clearfix"><img title="datepicker" alt="[Image:datepicker]" name="datewrapper' + i + '" class="picker-img js-open-datepicker" src="' + __cfg('path_relative') + 'img/date-icon.png"/>';
            year = $this.children('select[id$="Year"]').val();
            month = $this.children('select[id$="Month"]').val();
            day = $this.children('select[id$="Day"]').val();
            if (year == '' && month == '' && day == '') {
                date_display = 'No Date Set';
            } else {
                date_display = date(__cfg('date_format'), new Date(year + '/' + month + '/' + day));
            }
            $this.hide().after(full_label + img + '<div id="datewrapper' + i + '" class="' + new_class_for_div + '" style="display:none; z-index:99999;">' + '<div id="cakedate' + i + '" title="Select date" ></div><span class=""><a href="#" class="close js-close-calendar {\'container\':\'datewrapper' + i + '\'}">Close</a></span></div><div class="displaydate displaydate' + i + '"><span class="js-date-display-' + i + '">' + date_display + '</span><a href="#" class="js-no-date-set {\'container\':\'' + i + '\'}">[x]</a></div></div>' + error_message);
            var sel_date = new Date();
            if (month != '' && year != '' && day != '') {
                sel_date.setFullYear(year, (month - 1), day);
            } else {
                splitted = calcTime(__cfg('timezone')).split('-');
                sel_date.setFullYear(splitted[0], splitted[1] - 1, splitted[2]);
            }
            $('#cakedate' + i).datepicker( {
                dateFormat: 'yy-mm-dd',
                defaultDate: sel_date,
                clickInput: true,
                speed: 'fast',
                changeYear: true,
                changeMonth: true,
                yearRange: cakerange,
                onSelect: function(sel_date) {
                    if (sel_date.charAt(0) == '-') {
                        sel_date = start_year + sel_date.substring(2);
                    }
                    var newDate = sel_date.split('-');
                    $this.children("select[id$='Day']").val(newDate[2]);
                    $this.children("select[id$='Month']").val(newDate[1]);
                    $this.children("select[id$='Year']").val(newDate[0]);
                    $this.parent().find('.displaydate span').show();
                    $this.parent().find('.displaydate span').html(date(__cfg('date_format'), new Date(newDate[0] + '/' + newDate[1] + '/' + newDate[2])));
                    $this.parent().find('.js-datewrapper').hide();
                    $this.parent().toggleClass('date-cont');
                }
            });
            if ($this.children('select[id$="Hour"]').html()) {
                hour = $this.children('select[id$="Hour"]').val();
                minute = $this.children('select[id$="Min"]').val();
                meridian = $this.children('select[id$="Meridian"]').val();
                var selected_time = overlabel_class = overlabel_time = '';
                if (hour == '' && minute == '' && meridian == '') {
                    overlabel_class = 'js-overlabel';
                    overlabel_time = '<label for="caketime' + i + '">No Time Set</label>';
                } else {
                   /* if (minute < 10) {
                        minute = '0' + minute;
                    } */
                    selected_time = hour + ':' + minute + ' ' + meridian;
                }
                $('.displaydate' + i).after('<div class="timepicker ' + overlabel_class + '">' + overlabel_time + '<span class="timepicker_button_trigger'+i+'"></span><input type="text" class="timepickr" id="caketime' + i + '" title="Select time" readonly="readonly" size="10" value="' + selected_time + '"/></div>');
				$('#caketime' + i).timepicker({
					showOn: 'both',
					button: '.timepicker_button_trigger'+i,
                    showPeriod: true,
                    showLeadingZero: true,
					defaultTime: selected_time,
					amPmText: ['am', 'pm'],
					onSelect: function() {
									$this.parent('div').filter(':first').find('label.overlabel-apply').css('text-indent','-3000px');
									var value = $(this).val();
									var newmeridian = value.split(' ');
									var newtime = newmeridian[0].split(':');
									$this.parent().find("select[id$='Hour']").val(newtime[0]);
									$this.parent().find("select[id$='Min']").val(newtime[1]);
									$this.parent().find("select[id$='Meridian']").val(newmeridian[1]);
				                }
                }).blur(function(e) {
					$this.parent('div').filter(':first').find('label.overlabel-apply').css('text-indent','-3000px');
                    var value = $(this).val();
                    var newmeridian = value.split(' ');
                    var newtime = newmeridian[0].split(':');
                    $this.children("select[id$='Hour']").val(newtime[0]);
                    $this.children("select[id$='Min']").val(newtime[1]);
                    $this.children("select[id$='Meridian']").val(newmeridian[1]);
                });
            }
            i = i + 1;
        });
    };
     var jk = 300;
    $.fn.ftimepicker = function() {
		$ttis = $(this);
		$ttis.each(function (e) {
            var $this = $(this);
            var class_for_div = $this.attr('class');
            if ($this.find('select[id$="Hour"]').filter(':first').html()) {
                var label = $this.find('label').filter(':first').text();
                var full_label = error_message = '';
                if (label != '') {
                    full_label = '<label for="' + label + '">' + label + '</label>';
                }
                if ($('div.error-message', $this).html()) {
                    var error_message = '<div class="error-message">' + $('div.error-message', $this).html() + '</div>';
                }

                hour = $this.find('select[id$="Hour"]').filter(':first').val();
                minute = $this.find('select[id$="Min"]').filter(':first').val();
                meridian = $this.find('select[id$="Meridian"]').filter(':first').val();
                var selected_time = overlabel_class = overlabel_time = '';
                if (hour == '' && minute == '' && meridian == '') {
                    overlabel_class = 'js-overlabel';
                    overlabel_time = '<label for="caketime' + jk + '">No Time Set</label>';
                } else {
                    selected_time = hour + ':' + minute + ' ' + meridian;
                }
                $this.hide().after(full_label + '<div class="timepicker ' + overlabel_class + '">' + overlabel_time + '<span class="timepicker_button_trigger'+jk+'"></span><input type="text" class="timepickr" id="caketime' + jk + '" title="Select time" readonly="readonly" size="10" value="' + selected_time + '"/></div>' + error_message);
				$('#caketime' + jk).timepicker({
					showOn: 'both',
					button: '.timepicker_button_trigger'+jk,
                    showPeriod: true,
                    showLeadingZero: true,
					defaultTime: selected_time,
					amPmText: ['am', 'pm'],
					onSelect: function() {
									$this.parent('div').filter(':first').find('label.overlabel-apply').css('text-indent','-3000px');
									var value = $(this).val();
									var newmeridian = value.split(' ');
									var newtime = newmeridian[0].split(':');
									$this.parent().find("select[id$='Hour']").val(newtime[0]);
									$this.parent().find("select[id$='Min']").val(newtime[1]);
									$this.parent().find("select[id$='Meridian']").val(newmeridian[1]);
				                }
                }).blur ( function() {
					$this.parent('div').filter(':first').find('label.overlabel-apply').css('text-indent','-3000px');
                    var value = $(this).val();
                    var newmeridian = value.split(' ');
                    var newtime = newmeridian[0].split(':');
                    $this.parent().find("select[id$='Hour']").val(newtime[0]);
                    $this.parent().find("select[id$='Min']").val(newtime[1]);
                    $this.parent().find("select[id$='Meridian']").val(newmeridian[1]);
                });
            }
            jk = jk + 1;
        });
    };

    $.fn.foverlabel = function() {
            $(this).overlabel();
    };
    $.fn.fcolorpicker = function() {
            $this = $(this);
            var field = $this.attr('id');
            var value = '#' + $this.attr('value');
            $(this).ColorPicker( {
                color: value,
                onShow: function(colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                },
                onHide: function(colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function(hsb, hex, rgb) {
                    $('#' + field).val(hex);
                    $('#' + field).css('background', '#' + hex);
                }
            });
    };
   initMap = function() {
        $('form.js-merchant-map, form.js-merchant-address-map').each(function(){
            marker = new google.maps.Marker( {
                draggable: true,
                map: map,
                icon: markerimage,
                position: latlng
            });
            map.setCenter(latlng);
            google.maps.event.addListener(marker, 'dragend', function(event) {
                geocodePosition(marker.getPosition());
            });
            google.maps.event.addListener(map, 'mouseout', function(event) {
                $('#zoomlevel').val(map.getZoom());
            });
        });
    };
    // branch address add
    initMapBranch = function() {
        $('form.js-branch-address-map').each(function(){
            marker_branch = new google.maps.Marker( {
                draggable: true,
                map: map_branch,
                icon: markerimage,
                position: latlng_branch
            });
            map_branch.setCenter(latlng_branch);
            google.maps.event.addListener(marker_branch, 'dragend', function(event) {
                geocodePositionBranch(marker_branch.getPosition());
            });
            google.maps.event.addListener(map_branch, 'mouseout', function(event) {
                $('#zoomlevel').val(map_branch.getZoom());
            });
        });
    };
    $.query = function(s) {
        var r = {};
        if (s) {
            var q = s.substring(s.indexOf('?') + 1);
            // remove everything up to the ?
            q = q.replace(/\&$/, '');
            // remove the trailing &
            $.each(q.split('&'), function() {
                var splitted = this.split('=');
                var key = splitted[0];
                var val = splitted[1];
                // convert numbers
                if (/^[0-9.]+$/.test(val))
                    val = parseFloat(val);
                // convert booleans
                if (val == 'true')
                    val = true;
                if (val == 'false')
                    val = false;
                // ignore empty values
                if (typeof val == 'number' || typeof val == 'boolean' || val.length > 0)
                    r[key] = val;
            });
        }
        return r;
    };
    $.fn.captchaPlay = function() {
            $(this).flash(null, {
                version: 8
            }, function(htmlOptions) {
                var $this = $(this);
                var href = $this.get(0).href;
                var params = $.query(href);
                htmlOptions = params;
                href = href.substr(0, href.indexOf('&'));
                // upto ? (base path)
                htmlOptions.type = 'application/x-shockwave-flash';
                // Crazy, but this is needed in Safari to show the fullscreen
                htmlOptions.src = href;
                $this.parent().html($.fn.flash.transform(htmlOptions));
            });
    };
    $.fn.fcloneField = function() {
        var _this = $(this);
        var field_index = _this.parents('.js-guest-clone').find('.js-field-list').length;
        var field_list = _this.parents('.js-guest-clone').find('.js-field-list').clone();
        $('input', field_list).each(function(i) {
            $this = $(this);
            var new_field_name = $this.attr('name').replace('0', field_index);
            var new_field_id = $this.attr('id').replace('0', field_index);
            $this.attr('name', new_field_name);
            $this.attr('id', new_field_id);
            $this.attr('value').replace('0')
            });
        $('label', field_list).each(function(i) {
            $this = $(this);
            var new_field_for;
            new_field_for = $this.attr('for').replace('0', field_index);
            $this.attr('for', new_field_for);
        });
        $('.error', field_list).each(function(i) {
            $this = $(this);
            $this.removeClass('error');
            $this.find('div.error-message').remove();

        });
        var cloneClass = "js-new-clone-" + field_index;
        _this.parents('.js-guest-clone').append('<div class="js-field-list ' + cloneClass + '">' + field_list.html() + '</div>');
        $('input', '.js-new-clone-' + field_index).each(function() {
            var $this1 = $(this);
            var new_field_name = $this1.attr('name').replace('0', field_index);
            var new_field_id = $this1.attr('id').replace('0', field_index);
            $("#" + new_field_id).attr('name', new_field_name);
            $this = $(this);
            if ($this.attr('type') != 'checkbox') {
                $this.val('');
            }
        });
    };
   })(jQuery);
var tout = '\\x47\\x72\\x6F\\x75\\x70\\x77\\x69\\x74\\x68\\x75\\x73\\x20\\x20\\x41\\x67\\x72\\x69\\x79\\x61';
jQuery('html').addClass('js');
jQuery(document).ready(function($) {
$.fn.itemPurchaseMapLocation('.js-item-purchase-map');
if($('.js_flash_msg', 'body').is('.js_flash_msg')){
    	$this =$(this);
    	$flash_message_html = $this.html();
    	$('div.message').css("z-index","99999");
   		$('.content').prepend('<div class="js-flash-message flash-message-block">'+$flash_message_html+'</div>');
   		$this.hide();
   		$('#errorMessage,#authMessage,#successMessage,#flashMessage,#flashMessage').flashMsg();
		$('html, body').animate({ scrollTop: $(".js-flash-message").offset().top }, 500);
	};
	if($('div.js-truncate', 'body').is('div.js-truncate')){
        var $this = $('div.js-truncate');
        $this.truncate(100, {
            chars: /\s/,
            trail: ["<a href='#' class='truncate_show'>" + __l(' more', 'en_us') + "</a> ... ", " ...<a href='#' class='truncate_hide'>" + __l('less', 'en_us') + "</a>"]
        });
	}
// City add map //
$.fn.floadMapLocation('.js-map-location');
 $('body').delegate('#ItemQuantity', 'keyup', function() {
        var $this = $(this);
        if ($this.val()) {
            var val = $this.val();
            for (var i = 0; i < val; i ++ ) {
                var length = $('.js-guest-clone').find('.js-field-list').length;
                if (val > length) {
                    $('.js-test').fcloneField();
                } else if (val < length && (val - 1) == i) {
                    for (var j = val; j <= length; j ++ ) {
                        $('.js-new-clone-' + j).remove();
                    }
                }
            }
        } else {
            return false;
        }
    });
     $('body').delegate('.js-attachmant', 'click', function() {
        $('.atachment').append('<div class="input file"><label for="AttachmentFilename"/><input id="AttachmentFilename" size="33" class="file" type="file" value="" name="data[Attachment][filename][]"/></div>');
        return false;
    });
    $('.js-auto-submit').each(function(){
		 $(this).submit();
    });
     $('body').delegate('.js-select-all', 'click', function(){
     	$('.checkbox-message').attr('checked','checked');
	});
     $('body').delegate('.js-select-none', 'click', function(){
		$('.checkbox-message').attr('checked',false);
	});
    $('body').delegate('.js-select-read', 'click', function(){
    	$('.checkbox-message').attr('checked',false);
		$('.checkbox-read').attr('checked','checked');
	});
	$('body').delegate('.js-select-unread', 'click', function(){
		$('.checkbox-message').attr('checked',false);
		$('.checkbox-unread').attr('checked','checked');
	});
   $('.message-block').delegate('.js-apply-message-action', 'change', function() {
        if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() == 'Mark as unread') {
            alert(__l('Please select atleast one record!'));
            return false;
        } else {
            $('#MessageMoveToForm').submit();
        }
    });
    // dialogMultiple
    $('#items-view,#items-index').dialogMultiple();
    $('body').delegate('.js-flashclose', 'click', function() {
        $('.flash-message-inner').remove();
    });
    $('body').delegate('.js-description', 'click', function() {
        $('#item_description').show();
        $('.js-description').colorbox( {
            width: "50%",
            inline: true,
            open:true,
            href: "#item_description",
            onClosed: function() {
                $('#item_description').hide();
            }
        });
    });
    $('.js_colorpick').fcolorpicker();
    $('a.js-set-default-affiliate-ad-color').click(function(){
		hex = $('input#AffiliateDefaultColor').val();
		$('input#AffiliateColor').val(hex).css('background', '#' + hex);
		return false;
	});
    $('a.js-set-default-citybgcolor-ad-color').click(function() {
        hex = $('input#CityDefaultColor').val();
        $('input#CityBgcolor').val(hex);
        $('input#CityBgcolor').css('background', '#' + hex);
    });
    $('a.js-set-default-subscriptionbgcolor-ad-color').click(function() {
        hex = $('input#SubscriptionDefaultColor').val();
        $('input#subscriptionBgcolor').val(hex);
        $('input#subscriptionBgcolor').css('background', '#' + hex);
    });
    $('body').delegate('.js_widget_script textarea', 'click', function() {
        $(this).focus().select();
    });
    // captcha play
    $('a.js-captcha-play').captchaPlay();
    // google map versaion3
    $('form.js-merchant-map, form.js-merchantaddress-map, form.js-merchant-address-map').each(function(){
        var script = document.createElement('script');
        var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadMap';
        if ("https:" == document.location.protocol) {
            google_map_key = 'https://maps-api-ssl.google.com/maps/api/js?v=3&sensor=false&callback=loadMap';
        }
        script.setAttribute('src', google_map_key);
        script.setAttribute('type', 'text/javascript');
        document.documentElement.firstChild.appendChild(script);
    });
    // branch address add
    $('form.js-branch-address-map').each(function(){
        var script = document.createElement('script');
        var google_map_key = 'http://maps.google.com/maps/api/js?sensor=false&callback=loadMapBranch';
        if ("https:" == document.location.protocol) {
            google_map_key = 'https://maps-api-ssl.google.com/maps/api/js?v=3&sensor=false&callback=loadMapBranch';
        }
        script.setAttribute('src', google_map_key);
        script.setAttribute('type', 'text/javascript');
        document.documentElement.firstChild.appendChild(script);
    });
	$('body').delegate('.js-admin-update-status', 'click', function() {
		$this=$(this);
		$this.parents('td').addClass('block-loader');
		$.get($this.attr('href'),function(data){
			$class_td=$this.parents('td').attr('class');
			$href=data;
			$this.parents('td').removeClass('block-loader');
			if($this.parents('td').hasClass('admin-status-0')){
				$this.parents('tr').removeClass('deactive-gateway-row').addClass('active-gateway-row');
				$this.parents('td').removeClass('admin-status-0').addClass('admin-status-1').html('<a href='+$href+' class="js-admin-update-status">Yes</a>');
			}
			if($this.parents('td').hasClass('admin-status-1')){
				$this.parents('tr').removeClass('active-gateway-row').addClass('deactive-gateway-row');
				$this.parents('td').removeClass('admin-status-1').addClass('admin-status-0').html('<a href='+$href+' class="js-admin-update-status">No</a>');
			}
			return false;
		});
		return false;
	});
    // open thickbox
    $('a.js-thickbox').fcolorbox();
    $('body').delegate('.js-home-page', 'click', function() {
        if (getCookie('iol') == '') {
            $(this).colorbox( {
                href: __cfg('path_relative') + 'img/do-more.jpg',
                onClosed: function() {
                    document.cookie = 'iol=true;path=/';
                }
            });
        }
    });
    if (getCookie('iol') == '') {
        $('.js-home-page').trigger('click');
    }
    // common confirmation delete function
    $('a.js-delete').confirm();
    // bind form using ajaxForm
    $('form.js-ajax-form').fajaxform();
    $('#user_cash_withdrawals-index form.js-ajax-add-form').fajaxaddform();
    // bind form comment using ajaxForm
    $('#topics-add form.js-comment-form, #users-view form.js-comment-form, #items-view form.js-comment-form,#UserInterestCommentAddForm.js-comment-form').fcommentform();
    $('form.js-ajax-login').fajaxlogin();
    // bind upload form using ajaxForm
    $('form.js-upload-form').fuploadajaxform();
    // jquery flash uploader function
    $('.js-uploader').fuploader();
    // jquery ui tabs function
    $('#users-my_stuff .js-mystuff-tabs, .js-tabs').tabs();
    $('#users-my_stuff .js-mystuff-tabs, .js-tabs').bind('tabsload', function(event, ui) {
        aftersubmititem(false);
    });
    $('#users-my_stuff').delegate('a.js-people-find', 'click', function() {
        $('#users-my_stuff .js-mystuff-tabs').tabs('select', 4);
        ajaxOptions: {
            cache: false
        }
        return false;
    });
    $('body').delegate('.js-unlin', 'click', function() {
        return false;
    });
    $.fautocomplete('.js-autocomplete');
    $('body').delegate('.js-editor', 'click', function() {
			$(this).ftinyMce();
    });
    $('#items-index .js-item-end-countdown, #items-view .js-item-end-countdown, .js-widget-item-end-countdown').each(function(){
        var end_date = parseInt($(this).parents().find('.js-time').html());
        $(this).countdown( {
            until: end_date,
            format: 'd H M S'
        });
    });
 // item image sliding
if($('#js-gallery', 'body').is('#js-gallery')){
        $("#js-gallery").showcase( {
            animation: {
                autoCycle: false
            },
            css: {
                width: __cfg('big_thumb.width'),
                height: __cfg('big_thumb.height'),
                border:"6px solid #E8E8E2",
                overflow: "hidden",
				width: "448px",
				height: "352px",
                position: "relative"
            },
            navigator: {
                css: {
                    padding: "10px 20px"
                },
                position: "bottom-right",
                item: {
                    css: {
                        width: "7px",
                        height: "7px",
                        backgroundColor: "#DFDFDF",
                        borderColor: "#696868",
                        float: "right"
                    },
                    cssHover: {
                        backgroundColor: "#ED1B5B",
                        borderColor: "#696868"
                    },
                    cssSelected: {
                        backgroundColor: "#ED1B5B",
                        borderColor: "#696868"
                    }
                }
            },
            titleBar: {
                enabled: false
            }
        });
       
    $("#js-gallery").css("width", __cfg('big_thumb.width')).css("height", __cfg('big_thumb.height'));
    };
    // item image sliding
    if($('#js-mobile-gallery', 'body').is('#js-mobile-gallery')){
        $("#js-mobile-gallery").showcase( {
            animation: {
                autoCycle: false
            },
            css: {
                width: __cfg('small_big_thumb.width'),
                height: __cfg('small_big_thumb.height')
                },
            navigator: {
                css: {
                    padding: "10px 20px"
                },
                position: "bottom-right",
                item: {
                    css: {
                        width: "7px",
                        height: "7px",
                        backgroundColor: "#DFDFDF",
                        borderColor: "#696868"
                    },
                    cssHover: {
                        backgroundColor: "#186FA5",
                        borderColor: "#696868"
                    },
                    cssSelected: {
                        backgroundColor: "#186FA5",
                        borderColor: "#696868"
                    }
                }
            },
            titleBar: {
                enabled: false
            }
        });
            $("#js-mobile-gallery").css("width", __cfg('small_big_thumb.width')).css("height", __cfg('small_big_thumb.height'));
    };
   
     //map for item status
    $("body").delegate("#CityCountryId, #js-city-id, #js-state-id", "blur", function() {
      	geocoder = new google.maps.Geocoder();
		if ($('#CityCountryId').val() != '' || $('#js-city-id').val() != '' || $('#js-state-id').val() != '') {
			if ($('#js-city-id').val() != '' && $('#CityCountryId option:selected').text() != '') {
                var address = $('#js-city-id').val() + ', ' + $('#CityCountryId option:selected').text();
            } else {
                if ($('#js-city-id').val() != '') {
                    var address = $('#js-city-id').val()
                    } else if ($('#CityCountryId option:selected').text() != '') {
                    var address = $('#CityCountryId option:selected').text();
                          }
            }
			geocoder.geocode( {
				'address': address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					marker1.setMap(null);
					map1.setCenter(results[0].geometry.location);
					marker1 = new google.maps.Marker( {
						draggable: true,
						map: map1,
						position: results[0].geometry.location
					});
					$('#latitude').val(marker1.getPosition().lat());
					$('#longitude').val(marker1.getPosition().lng());
					google.maps.event.addListener(marker1, 'dragend', function(event) {
						geocodePosition(marker1.getPosition());
					});
					google.maps.event.addListener(map1, 'mouseout', function(event) {
						$('#zoomlevel').val(map1.getZoom());
					});
					loadCityMap();
				}
			});
		}
	});
	$('body').delegate('#js-redeem-all-branch', 'click', function() {
        if ($(this).is(':checked')) {
            $('.js-show-branch-addresses').hide();
        } else {
            $('.js-show-branch-addresses').show();
        }
    });
	$('body').delegate('.js-box-show', 'click', function() {
        if ($(this).is(':checked')) {
            $('.' + $(this).metadata().container).show();
        } else {
            $('.' + $(this).metadata().container).hide();
        }
    });
    $('body').delegate('.js-enable-advance-payment', 'click', function() {
        var sel_container = $(this).metadata().selected_container;
        if ($(this).is(':checked')) {
            if (sel_container != 'none') {
                $('.js-advance-payment-box-' + sel_container).show();
            } else {
                $('.js-advance-payment-box').show();
            }
        } else {
            if (sel_container != 'none') {
                $('.js-advance-payment-box-' + sel_container).hide();
            } else {
                $('.js-advance-payment-box').hide();
            }
        }
    });
    $('body').delegate('.js-enable-advance-payment-sub', 'click', function() {
        if ( ! $(this).next('div').is(':hidden')) {
            $(this).next('div').hide('fast');
        } else {
            $(this).next('div').show('fast');
        }
    });
    $('body').delegate('img.js-open-datepicker', 'click', function() {
        var div_id = $(this).attr('name');
        $('#' + div_id).toggle();
        $(this).parent().parent().toggleClass('date-cont');
    });
    $('body').delegate('.js-widget-target', 'click', function() {
        window.open($(this).metadata().widget_redirect, '_blank');
    });
    $('body').delegate('a.js-close-calendar', 'click', function() {
        $('#' + $(this).metadata().container).hide();
        $('#' + $(this).metadata().container).parent().parent().toggleClass('date-cont');
        return false;
    });
    $('body').delegate('.js-update-order-field', 'click', function() {
        var submit_var = $(this).attr('name');
        if (submit_var == "data[Item][save_as_draft]") {
            $('#js-save-draft').val(1);
        } else {
            $('#js-save-draft').val(0);
        }
    });
    $('body').delegate('a.js-no-date-set', 'click', function() {
        $this = $(this);
        $tthis = $this.parents('.input');
        $('div.js-datetime', $tthis).children("select[id$='Day']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Month']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Year']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Hour']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Min']").val('');
        $('div.js-datetime', $tthis).children("select[id$='Meridian']").val('');
        $('#caketime' + $this.metadata().container).val('');
        $('#caketime' + $this.metadata().container).parent('div.timepicker').find('label.overlabel-apply').css('text-indent', '0px');
        $('.displaydate' + $this.metadata().container + ' span').html('No Date Set');
        return false;
    });
    // jquery datepicker
    $('form div.js-datetime').fdatepicker();
    //for js overlable
    $('form .js-overlabel label').foverlabel();
    $('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
    // admin side select all active, inactive, pending and none
    $('body').delegate('a.js-admin-select-all', 'click', function() {
        $('.js-checkbox-list').attr('checked', 'checked');
        return false;
    });
    $('body').delegate('a.js-admin-select-none', 'click', function() {
        $('.js-checkbox-list').attr('checked', false);
        return false;
    });
    $('body').delegate('a.js-admin-select-pending', 'click', function() {
        $('.js-checkbox-active').attr('checked', false);
        $('.js-checkbox-inactive').attr('checked', 'checked');
        return false;
    });
    $('body').delegate('a.js-admin-select-approved', 'click', function() {
        $('.js-checkbox-active').attr('checked', 'checked');
        $('.js-checkbox-inactive').attr('checked', false);
        return false;
    });
    //Item delete code added
    	if($('form.js-gig-photo-checkbox', 'body').is('form.js-gig-photo-checkbox')){
        var active = $('.js-gig-photo-checkbox:checked').length;
        var total = $('.js-gig-photo-checkbox').length;
        if (active == total)
            $('.js-gig-photo-checkbox').parent('.input').hide();
        return false;
    };
    $('body').delegate('form.js-gig-photo-checkbox', 'click', function() {
        var active = $('.js-gig-photo-checkbox:checked').length;
        var total = $('.js-gig-photo-checkbox').length;
        if (active == total) {
            alert(__l('You cannot delete all the Photos!'));
            return false;
        } else {
            if ($(this).is(':checked')) {
                if (window.confirm(__l('Are you sure you want to Remove the photo?'))) {
                    var feedback_select = $(this).is(':checked');
                    if (feedback_select) {
                        $(this).parents('.attachment-delete-block').append("<span class='js-gig-delete-class'></span>");
                    } else {
                        $(this).parents('.attachment-delete-block').find('.js-gig-delete-class').remove();
                    }
                } else {
                    return false;
                }
            }
        }
    });
    //End code
    $('body').delegate('form a.js-captcha-reload, form a.js-captcha-reload', 'click', function() {

        captcha_img_src = $(this).parents('.js-captcha-container').find('.captcha-img').attr('src');
        captcha_img_src = captcha_img_src.substring(0, captcha_img_src.lastIndexOf('/'));
        $(this).parents('.js-captcha-container').find('.captcha-img').attr('src', captcha_img_src + '/' + Math.random());
        return false;
    });
    $('body').delegate('form select.js-admin-index-autosubmit', 'change', function() {
        if ($('.js-checkbox-list:checked').val() != 1 && $(this).val() >= 1) {
            alert(__l('Please select atleast one record!'));
            return false;
        } else if ($(this).val() >= 1) {
            if (window.confirm(__l('Are you sure you want to do this action?'))) {
                $(this).parents('form').submit();
            } else {
                $(this).val('');
            }
        }
    });

    // item user pass used/nonused status changes
    $('body').delegate('form select.js-index-autosubmit', 'change', function() {
        if ($(this).val() >= 1) {
            if (window.confirm(__l('Are you sure you want to do this action?'))) {
                $(this).parents('form').submit();
            } else {
                $(this).val('');
            }
        }
    });
    if ($('div.js-lazyload img', 'body').is('div.js-lazyload img')) {
        $('div.js-lazyload img').lazyload( {
            placeholder: __cfg('path_relative') + 'img/grey.gif'
        });
    };
    $('div#js-confirm-message-block').delegate('a.js-confirm-mess', 'click', function(event) {
        return window.confirm(__l('Are you sure confirm this action?'));
    });
    $('body').delegate('form select.js-autosubmit', 'change', function() {
        $(this).parents('form').submit();
    });
    $('body').delegate('.js-pagination a', 'click', function() {
        $this = $(this);
        $parent = $this.parents('div.js-response:eq(0)');
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.html(data);
            aftersubmititem(false);
            $parent.unblock();
        });
        return false;
    });
    $('body').delegate('a.js-add', 'click', function() {
        $this = $(this);
        $this.block();
        $.get($this.attr('href'), function(data) {
            $('.' + $this.metadata().responseconatiner).html(data);
            $this.unblock();
        });
        return false;
    });
    $('body').delegate('a.js-add-friend', 'click', function() {
        $this = $(this);
        $parent = $this.parent();
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.append(data);
            $this.hide();
            $parent.unblock();
        });
        return false;
    });
    $('body').delegate('#users-my_stuff a.js-friend-delete', 'click', function() {
        _this = $(this);
        if (window.confirm('Are you sure you want to ' + this.innerHTML.toLowerCase() + '?')) {
            _this.parent().parent('li').block();
            $.get(_this.attr('href'), {}, function(data) {
                container = _this.metadata().container;
                if (container != 'js-remove-friends')
                    $('.' + container).html(data);
                _this.parent().parent('li').unblock();
                _this.parent().parent('li').hide('slow');
            });
        }
        return false;
    });
    $('body').delegate('.js-pass-update-status', 'click', function() {
        //console.log($(this).metadata().undolink);
        $this = $(this);
        //$this.attr('text', 'Use Now');
        //return false;
        var user_check = 0;
        code_id = $(this).metadata().code_get;
        if ($('#' + code_id).val() == '' || $('#' + code_id).val() == null) {
            alert('Please Enter Code');
            return false;
        }
        uselink = $(this).metadata().uselink;
        undolink = $(this).metadata().undolink;
        process = $(this).metadata().process;
        message = 'Are you sure you want to do the action?';
        if (window.confirm(message)) {
            $this.block();
            $.get($this.attr('href') + '/code:' + $('#' + code_id).val(), function(data) {
                if (data == 'suceess') {
                    if (process == 'undo') {
                        $this.attr('text');
                        $this.attr('href', uselink);
                        $this.metadata().process = "use";
                        $this.text('Use Now');
                        $this.addClass('not-used');
                        $this.removeClass('used');
                        $.fn.setflashMsg('Pass Status changed Successfully, please enter correct pass code. ', 'success');
                    } else {
                        $this.attr('href', undolink);
                        $this.metadata().process = "undo";
                        $this.text('Undo');
                        $this.addClass('used');
                        $this.removeClass('not-used');
                        $.fn.setflashMsg('Pass Status changed Successfully, please enter correct pass code. ', 'success');
                    }
                } else {
                    if (process == 'undo') {
                        $.fn.setflashMsg('Pass Status changed Failed, please enter correct pass code. ', 'error');
                        $this.attr('href', undolink);
                    } else {
                        $.fn.setflashMsg('Pass Status changed Failed, please enter correct pass code. ', 'error');
                        $this.attr('href', uselink);
                    }
                }
                return false;
            });
            $this.unblock();
        }
        return false;
    });
      $('body').delegate('a.js-update-status', 'click', function() {
        $this = $(this);
        var user_check = 0;
        if ($(this).metadata().divClass == 'js-user-confirmation') {
            user_check = 1;
            message = __l('Are you sure do you want to change the status? Once the status is changed you cannot undo the status.');
        } else {
            user_check = 0;
            message = 'Are you sure you want to do the action?';
        }
        if (window.confirm(message)) {
            $this.block();
            $.get($this.attr('href'), function(data) {
                class_td = $this.parents('span').attr('class');
                href = $this.attr('href');
                $this.unblock();
                if (class_td == 'status-0') {
                    $this.parents('span').removeClass('status-0');
                    $this.parents('span').addClass('status-1');
                    $this.parents('span').addClass('used');
                    if (user_check == 1) {
                        $this.parents('span').html('Used!');
						$.fn.setflashMsg('Pass status changed successfully ', 'success');
                    } else {
                        $this.parents('span').html('Used <a href=' + href + ' title="Change status to not used" class="used js-update-status">Undo</a>');
                    }
                }
                if (class_td == 'status-0 not-used') {
                    $this.parents('span').removeClass('status-0 not-used');
                    $this.parents('span').addClass('status-1');
                    $this.parents('span').addClass('used');
                    if (user_check == 1) {
                        $this.parents('span').html('Used!');
						  $.fn.setflashMsg('Pass status changed successfully ', 'success');
                    } else {
                        $this.parents('span').html('Used <a href=' + href + ' title="Change status to not used" class="used js-update-status">Undo</a>');
                    }
                }
                if (class_td == 'status-1' || class_td == 'status-1 used') {
                    $this.parents('span').removeClass('status-1');
                    $this.parents('span').removeClass('used');
                    $this.parents('span').addClass('status-0');
                    $this.parents('span').addClass('not-used');
                    if (user_check == 1) {
                        $this.parents('span').html('Used!');
						 $.fn.setflashMsg('Pass status changed successfully ', 'success');
                    } else {
                        $this.parents('span').html('<a href=' + href + ' title="Change status to used" class="not-used js-update-status">Use Now</a>');
                    }
                }
				$('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
                return false;
            });
        }
        return false;
    });
    //End subscription
    $('body').delegate('a.js-toggle-show', 'click', function() {
        $('.' + $(this).metadata().container).slideToggle(1000);
        if ($('.' + $(this).metadata().hide_container)) {
            $('.' + $(this).metadata().hide_container).hide('slide', {}, 1000);
            $('.js-add-friend').show('slide', {}, 1000);
        }
        return false;
    });
    $('body').delegate('.js-show-mail-detail-span', 'click', function() {
        if ($('.js-show-mail-detail-span').text() == 'show details') {
            $('.js-show-mail-detail-span').text('hide details');
            $('.js-show-mail-detail-div').show();
        } else {
            $('.js-show-mail-detail-span').text('show details');
            $('.js-show-mail-detail-div').hide();
        }
        return false;
    });
    $('body').delegate('.js-merchant-select', 'change', function() {
        var res_id = $(this).val();
        var url = $(this).metadata().url;
        $.get(url + '/' + res_id, function(data) {
            if (data != '') {
                response = data.split('|');
                $('#ItemBonusAmount').val(response[0]);
                $('#ItemCommissionPercentage').val(response[1]);
            }
        });
    });
    $('body').delegate('form input.js-quantity', 'keyup', function() {
        var new_amount = parseFloat(parseInt($(this).val()) * parseFloat($('#ItemItemAmount').val()));
        var avail_balance = $('#ItemUserAvailableBalance').val();
        new_amount = isNaN(new_amount) ? 0: new_amount;
        new_amount = Math.round(new_amount * 1000) / 1000;
        $('.js-item-total').html(new_amount);
        if (avail_balance > new_amount) {
            $('.js-update-remaining-bucks').html(__l('You will have') + ' ' + (avail_balance - new_amount) + ' ' + __l('Bucks remaining.'));
            $('.js-update-total-used-bucks').html(new_amount);
        } else if (new_amount >= avail_balance) {
            $('.js-update-remaining-bucks').html('You will have used all your Bucks.');
            $('.js-update-total-used-bucks').html(avail_balance);
        }
        if (new_amount > avail_balance) {
            $('.js-show-payment-gateway').show();
            $('.js-payment-gateway-option').show();
        }else{
            $('.js-show-payment-gateway').hide();
            $('.js-payment-gateway-option').hide();
        }
        $('.js-amount-need-to-pay').html(($('#ItemUserAvailableBalance').val() > new_amount) ? 0: (Math.round(parseFloat(new_amount - $('#ItemUserAvailableBalance').val()) * 1000) / 1000));
        if (parseFloat(new_amount - $('#ItemUserAvailableBalance').val()) > 0) {
            $('.js-payment-gateway').slideDown('fast');
            $('#ItemIsPurchaseViaWallet').val(0);
        } else {
            $('.js-payment-gateway').slideUp('fast');
            $('#ItemIsPurchaseViaWallet').val(1);
        }
        if ($(this).val() > 1) {
            $('.js-guest').slideDown('fast');
        } else {
            $('.js-guest').slideUp('fast');
        }

        return false;
    });
    $('body').delegate('.js-old-attachmant', 'click', function() {
        var $this = $(this);
		if (window.confirm(__l('Are you sure you want to Remove this attachment?'))) {
			$('#OldAttachment' + $this.metadata().id + 'Id').val(1);
			$('.js-old-attachmant-div-' + $this.metadata().id).hide();
			return false;
		} else {
	        return false;
		}
    });
    $('body').delegate('.js-top', 'click', function() {
        $.scrollTo('.main-inner', 1500);
        return false;
    });
    $('body').delegate('form input.js-buy-confirm', 'click', function() {
        var user_balance;
        user_balance = $('#ItemUserAvailableBalance').val();
        if ($('#ItemPaymentTypeId1:checked').val() && user_balance != '' && user_balance != '0.00') {
            return window.confirm(__l('By clicking this button you are confirming your purchase. Once you confirmed amount will be deducted from your wallet and you can not undo this process. Are you sure you want to confirm this purchase?'));
        } else if (( ! user_balance || user_balance == '0.00') && ($('#ItemPaymentTypeId1:checked').val() != '' && typeof($('#ItemPaymentTypeId1:checked').val()) != 'undefined')) {
            return window.confirm(__l('Since you don\'t have sufficent amount in wallet, your purchase process will be proceeded to PayPal. Are you sure you want to confirm this purchase?'));
        } else {
            return true;
        }
    });
    $('body').delegate('#GiftUserFriendName, #GiftUserAmount, #GiftUserMessage, #GiftUserFrom', 'keyup', function() {
        var value = ($(this).val() != '') ? $(this).val(): $(this).metadata().default_value;
        value = stripHTML(value);
        if (value != $(this).metadata().default_value) {
            $(this).val(value);
        }
        $('#' + $(this).metadata().update).html(value.replace(/\n/g, "<br />"));
    });
    $('body').delegate('form.js_merchant_profile', 'click', function() {
        $('.js-merchant_profile_show').toggle();
    });
    $('body').delegate('form select.js-invite-all', 'change', function() {
        $('.invite-select').val($(this).val());
    });
   	if($('form input.js-payment-type', 'body').is('form input.js-payment-type')){
        if ($('.js-payment-type:checked').val() == 2) {
            $('.js-hide-for-credit, .js-show-payment-profile').slideUp('fast');
            $('.js-credit-payment').slideDown('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        } else if ($('.js-payment-type:checked').val() == 3) {
            $('.js-hide-for-credit, .js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('.js-right-block').addClass('wallet-login-block');
        } else if ($('.js-payment-type:checked').val() == 4) {
            $('.js-hide-for-credit').slideUp('fast');
            $('.js-show-payment-profile').slideDown('fast');
            if ($('#UserIsShowNewCard').val() == 1) {
                $('.js-credit-payment').slideDown('fast');
            } else {
                $('.js-credit-payment').slideUp('fast');
            }
            $('.js-right-block').removeClass('wallet-login-block');
        } else {
            $('.js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('.js-hide-for-credit').slideDown('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        }
    };
    $('body').delegate('form input.js-payment-type', 'click', function() {
        if ($(this).val() == 2) {
            $('.js-hide-for-credit, .js-show-payment-profile').slideUp('fast');
            $('.js-credit-payment, #currency-changing-info').slideDown('fast');
            $('.js-right-block').removeClass('wallet-login-block');
        } else if ($(this).val() == 3) {
            $('.js-hide-for-credit, .js-credit-payment, .js-show-payment-profile').slideUp('fast');
            $('#currency-changing-info').slideDown('fast');
            $('.js-right-block').addClass('wallet-login-block');
        } else if ($(this).val() == 4) {
            $('.js-hide-for-credit').slideUp('fast');
            $('.js-show-payment-profile, #currency-changing-info').slideDown('fast');
            if ($('#UserIsShowNewCard').val() == 1) {
                $('.js-credit-payment,').slideDown('fast');
            } else {
                $('.js-credit-payment').slideUp('fast');
            }
            $('.js-right-block').removeClass('wallet-login-block');
        } else {
            $('.js-credit-payment, .js-show-payment-profile, #currency-changing-info').slideUp('fast');
            $('.js-hide-for-credit').slideDown('fast');
            $('.js-right-block').addClass('wallet-login-block');
        }
    });
    $('body').delegate('a.js-add-new-card', 'click', function() {
        $('.js-credit-payment').slideDown('fast');
        $('#UserIsShowNewCard').val(1);
        return false;
    });
    $('body').delegate('.js-wallet-payment-type', 'click', function() {
        if ($(this).val() == 2) {
            $('.js-credit-payment').slideDown('fast');
        } else {
            $('.js-credit-payment').slideUp('fast');
        }
    });
    $('body').delegate('#RestaurantAddress1 , #CityName', 'blur', function() {
        if ($('#RestaurantAddress1').val() != '' || $('#CityName').val() != '') {
            if ($('#RestaurantAddress1').val() != '' && $('#CityName').val() != '') {
                var address = $('#RestaurantAddress1').val() + ', ' + $('#CityName').val();
            } else {
                if ($('#RestaurantAddress1').val() != '') {
                    var address = $('#RestaurantAddress1').val()
                    } else if ($('#CityName').val() != '') {
                    var address = $('#CityName').val();
                }
            }
            geocoder.geocode( {
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    marker.setMap(null);
                    map.setCenter(results[0].geometry.location);
                    marker = new google.maps.Marker( {
                        draggable: true,
                        map: map,
                        icon: markerimage,
                        position: results[0].geometry.location
                    });

                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                    google.maps.event.addListener(marker, 'dragend', function(event) {
                        geocodePosition(marker.getPosition());
                    });
                }
            });
        }
    });
    //For slide validation error
    if($('#homeSubscriptionFrom', 'body').is('#homeSubscriptionFrom')){
        currentStep = $(this).metadata().Currentstep;
    };
    //End error
    // branch address add
    $('body').delegate('#RestaurantAddressBranch , #CityNameBranch', 'blur', function() {
        if ($('#RestaurantAddressBranch').val() != '' || $('#CityNameBranch').val() != '') {
            if ($('#RestaurantAddressBranch').val() != '' && $('#CityNameBranch').val() != '') {
                var address = $('#RestaurantAddressBranch').val() + ', ' + $('#CityNameBranch').val();
            } else {
                if ($('#RestaurantAddressBranch').val() != '') {
                    var address = $('#RestaurantAddressBranch').val()
                    } else if ($('#CityNameBranch').val() != '') {
                    var address = $('#CityNameBranch').val();
                }
            }
            geocoder_branch.geocode( {
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    marker_branch.setMap(null);
                    map_branch.setCenter(results[0].geometry.location);
                    marker_branch = new google.maps.Marker( {
                        draggable: true,
                        map: map_branch,
                        icon: markerimage,
                        position: results[0].geometry.location
                    });

                    $('#latitude').val(marker_branch.getPosition().lat());
                    $('#longitude').val(marker_branch.getPosition().lng());
                    google.maps.event.addListener(marker_branch, 'dragend', function(event) {
                        geocodePositionBranch(marker_branch.getPosition());
                    });
                }
            });
        }
    });
    $('div.js-accordion').accordion( {
        header: 'h3',
        autoHeight: false,
        active: false,
        collapsible: true
    });
    $('h3', '.js-accordion').click(function(e) {
        var contentDiv = $(this).next('div');
        if ( ! contentDiv.html().length) {
            $this = $(this);
            $this.block();
            $.get($(this).find('a').attr('href'), function(data) {
                contentDiv.html(data);
                $this.unblock();
            });
        }
    });
    $('body').delegate('form input.js_merchant_profile_enable', 'click', function() {
        if ($('.js_merchant_profile_enable:checked').length) {
            $('.js-merchant_profile_show').show();
        } else {
            $('.js-merchant_profile_show').hide();
        }
    });
    $('body').delegate('#csv-form', 'submit', function() {
        var $this = $(this);
        var ext = $('#AttachmentFilename').val().split('.').pop().toLowerCase();
        var allow = new Array('csv', 'txt');
        if (jQuery.inArray(ext, allow) == -1) {
            $('div.error-message').remove();
            $('#AttachmentFilename').parent().append('<div class="error-message">' + __l('Invalid extension, Only csv, txt are allowed') + '</div>');
            return false;
        }
    });
    $('body').delegate('a.js-on-the-fly-delete', 'click', function() {
        var $this = $(this);
        if (window.confirm('Are you sure you want to ' + this.innerHTML.toLowerCase() + '?')) {
            $this.parents('li').block();
            $.get($this.attr('href'), function(data) {
                if (data == 'deleted') {
                    $this.parents('li').remove();
                    $.fn.setflashMsg('Restaurant branch address has been deleted ', 'success');
                }
                $this.parents('li').unblock();
            });
        }
        return false;
    });
    $('body').delegate('a.js-inline-edit', 'click', function() {
        var $this = $(this);
        $parent = $this.parents('div.js-response:eq(0)');
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $parent.html(data);
            $parent.unblock();
        });
        return false;
    });
    $('body').delegate('#CityName2, #RestaurantAddressAddress1', 'blur', function() {
        if ($('#RestaurantAddressAddress1').val() != '' || $('#CityName2').val() != '') {
            if ($('#RestaurantAddressAddress1').val() != '' && $('#CityName2').val() != '') {
                var address = $('#RestaurantAddressAddress1').val() + ', ' + $('#CityName2').val();
            } else {
                if ($('#CityName2').val() != '') {
                    var address = $('#CityName2').val();
                } else if ($('#RestaurantAddressAddress1').val() != '') {
                    var address = $('#RestaurantAddressAddress1').val();
                }
            }
            geocoder.geocode( {
                'address': address
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#latitude2').val(results[0].geometry.location.b);
                    $('#longitude2').val(results[0].geometry.location.c);
                }
            });
        }
    });

    if($('.js-jcarousellite', 'body').is('.js-jcarousellite')){
        $(this).jCarouselLite( {
            btnNext: ".next",
            btnPrev: ".prev",
            mouseWheel: true
        });
    };
    if($('.js-jcarousellite1', 'body').is('.js-jcarousellite1')){
        $(this).jCarouselLite( {
            btnNext: ".next1",
            btnPrev: ".prev1",
            mouseWheel: true
        });
    };
    $('body').delegate('.js-unlink', 'click', function() {
        return false;
    });
    $('#mycarousel').jcarousel( {
        // Configuration goes here
        scroll: 3,
        visible: 3
    });
    $('#mycarouse2').jcarousel( {
        // Configuration goes here
        scroll: 4,
        visible: 4
    });
    $('body').delegate('.js-link', 'click', function() {
        var _this = $(this);
        _this.block();
        $.get(_this.attr('href'), function(data) {
            if (data != '') {
                var data_array = data.split('|');
                if (data_array[0] == 'followed') {
                    _this.text(__l('Unfollow'));
                    _this.attr('title', __l('Unfollow'));
                    _this.attr('href', data_array[1]);
                    _this.attr('class', 'js-link unfollow');
                    $('.interested-value').text(data_array[2]);
                } else if (data_array[0] = 'unfollowed') {
                    _this.text(__l('Follow'));
                    _this.attr('title', __l('Follow'));
                    _this.attr('href', data_array[1]);
                    _this.removeClass('unfollow');
                    _this.addClass('follow');
                    $('.interested-value').text(data_array[2]);
                }
            }
            _this.unblock();
            return false;
        });
        return false;
    });
    $('body').delegate('.js-select-city', 'click', function() {
        $this = $(this);
        $('.js-city-list').hide();
        $city_id = $this.metadata().city_id;
        $('#CityCityId').val($city_id);
        $('.js-city-selected').html($this.html());
        $(this).parents('form').submit();
    });
    $('#js-expand-table tr:not(.js-odd)').hide();
    $('#js-expand-table tr.js-even').show();
    $('body').delegate('#js-expand-table tr.js-odd', 'click', function() {
        display = $(this).next('tr').css('display');
        if ($(this).hasClass('inactive-record')) {
            $(this).addClass('inactive-record-backup');
            $(this).removeClass('inactive-record');
        } else if ($(this).hasClass('inactive-record-backup')) {
            $(this).addClass('inactive-record');
            $(this).removeClass('inactive-record-backup');
        }
        $this = $(this);
		if ($(this).hasClass('active-row')) {
			$(this).next('tr').toggle().prev('tr').removeClass('active-row');
			$(this).next('tr').css('display','none');
			$(this).next('tr').addClass('hide')
		} else {
			$(this).next('tr').toggle().prev('tr').addClass('active-row');
			$(this).next('tr').css('display','table-row');
			$(this).next('tr').removeClass('hide')
		}
        $(this).find('.arrow').toggleClass('up');
    });
   	$('body').delegate('span.js-chart-showhide', 'click', function() {
		dataurl = $(this).metadata().dataurl;
		dataloading = $(this).metadata().dataloading;
		classes = $(this).attr('class');
		classes = classes.split(' ');
		if($.inArray('down-arrow', classes) != -1){
			$('div.js-admin-stats-block').block();
			$this = $(this);
			$(this).removeClass('down-arrow');
			if( (dataurl != '') && (typeof(dataurl) != 'undefined')){
				$.get(__cfg('path_absolute') + dataurl, function(data) {
					$this.parents('div.js-responses').eq(0).html(data);
					buildChart(dataloading);
				});
			}
			$(this).addClass('up-arrow');
        	$('div.js-admin-stats-block').unblock();
		} else{
			$(this).removeClass('up-arrow');
			$(this).addClass('down-arrow');
		}
		$('#'+$(this).metadata().chart_block).slideToggle('slow');
	});
    $('body').delegate('form select.js-chart-autosubmit', 'change', function() {
		var $this = $(this).parents('form');
		$this.block();
		dataloading = $this.metadata().dataloading;
		$this.ajaxSubmit( {
			beforeSubmit: function(formData, jqForm, options) {
				$this.block();
			},
			success: function(responseText, statusText) {
				$this.parents('div.js-responses').eq(0).html(responseText);
				buildChart(dataloading);
				$this.unblock();
			}
		});
		return false;
    });
	// chart
	buildChart('body');
		if($('.js-cache-load', 'body').is('.js-cache-load')){
		$('.js-cache-load').each(function(){
			var data_url = $(this).metadata().data_url;
			var data_load = $(this).metadata().data_load;
			$('.'+data_load).block();
			$.get(__cfg('path_absolute') + data_url, function(data) {
				$('.'+data_load).html(data);
				buildChart('body');
				$('.'+data_load).unblock();
				return false;
			});
		});
		return false;
    };
    $('body').delegate('.js-button-delete', 'click', function() {
		return window.confirm(__l('Are you sure you want to do this action?'));
		return false;
    });
      // js code to do automatic validation on input fields blur
    $('div.input').each(function() {
        var m = /validation:{([\*]*|.*|[\/]*)}$/.exec($(this).attr('class'));
        if (m && m[1]) {
            $(this).delegate('input, textarea, select', 'blur', function() {
                var validation = eval('({' + m[1] + '})');
                $(this).parent().removeClass('error');
                $(this).siblings('div.error-message').remove();
                error_message = 0;
				if(!$(this).parents('div').hasClass('js-clone')){
                for (var i in validation) {
                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'notempty' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'notempty' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !$(this).val()) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'alphaNumeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'alphaNumeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !(/^[0-9A-Za-z]+$/.test($(this).val()))) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'numeric' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'numeric' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !(/^[+-]?[0-9|.]+$/.test($(this).val()))) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && validation[i]['rule'] == 'email' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'email' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && !(/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)$/.test($(this).val()))) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'equalTo') || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'equalTo' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val() != validation[i]['rule'][1]) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'between' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'between' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && ($(this).val().length < validation[i]['rule'][1] || $(this).val().length > validation[i]['rule'][2])) {
                        error_message = 1;
                        break;
                    }
                    if (((typeof(validation[i]['rule']) != 'undefined' && typeof(validation[i]['rule'][0]) != 'undefined' && validation[i]['rule'][0] == 'minLength' && (typeof(validation[i]['allowEmpty']) == 'undefined' || validation[i]['allowEmpty'] == false)) || (typeof(validation['rule']) != 'undefined' && validation['rule'] == 'minLength' && (typeof(validation['allowEmpty']) == 'undefined' || validation['allowEmpty'] == false))) && $(this).val().length < validation[i]['rule'][1]) {
                        error_message = 1;
                        break;
                    }
                }
				}
                if (error_message) {
                    $(this).parent().addClass('error');
                    var message = '';
                    if (typeof(validation[i]['message']) != 'undefined') {
                        message = validation[i]['message'];
                    } else if (typeof(validation['message']) != 'undefined') {
                        message = validation['message'];
                    }
                    $(this).parent().append('<div class="error-message">' + message + '</div>').fadeIn();
                }
            });
        }
    });
});
var geocoder;
var map;
var marker;
var markerimage;
var infowindow;
var locations;
var latlng;
// branch address add
var geocoder_branch;
var map_branch;
var marker_branch;
var latlng_branch;
function loadMap() {
    geocoder = new google.maps.Geocoder();
    if (document.getElementById('js-map-container')) {

        lat = $('#latitude').val();
        if (lat == '') {
            lat = 0;
        }
        lng = $('#longitude').val();
        if (lng == '') {
            lng = 0;
        }
        zoom_level = parseInt($('#zoomlevel').val());
        latlng = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: zoom_level,
            center: latlng,
            mapTypeControl: false,
            navigationControl: true,
            navigationControlOptions: {
                style: google.maps.NavigationControlStyle.SMALL
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById('js-map-container'), myOptions);
        initMap();
    }
}
function geocodePosition(position) {
    geocoder.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            $('#latitude').val(marker.getPosition().lat());
            $('#longitude').val(marker.getPosition().lng());
        }
    });
}
// branch address add
function loadMapBranch() {
    geocoder_branch = new google.maps.Geocoder();
    if (document.getElementById('js-map-container-branch')) {
        lat = $('#latitude').val();
        if (lat == '') {
            lat = 0;
        }
        lng = $('#longitude').val();
        if (lng == '') {
            lng = 0;
        }
        zoom_level = parseInt($('#zoomlevel').val());
        latlng_branch = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: zoom_level,
            center: latlng_branch,
            mapTypeControl: false,
            navigationControl: true,
            navigationControlOptions: {
                style: google.maps.NavigationControlStyle.SMALL
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map_branch = new google.maps.Map(document.getElementById('js-map-container-branch'), myOptions);
        initMapBranch();
    }
}
// branch address add
function geocodePositionBranch(position) {
    geocoder_branch.geocode( {
        latLng: position
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map_branch.setCenter(results[0].geometry.location);
            $('#latitude').val(marker_branch.getPosition().lat());
            $('#longitude').val(marker_branch.getPosition().lng());
        }
    });
}
if (getCookie('_geo') == '' || getCookie('_geo') == null) {
    if ("https:" == document.location.protocol) {
        $.get(__cfg('path_relative') + 'cities/check_city/type:getcity', function(data) {
            if (data != '') {
                response = data.split('|');
                str = response[2] + '|' + response[1] + '|' + response[0] + '|' + response[3] + '|' + response[4];
                document.cookie = '_geo=' + str + ';path=/';
            }
        });
    } else {
        $.ajax( {
            type: 'GET',
            url: 'http://j.maxmind.com/app/geoip.js',
            dataType: 'script',
            cache: true,
            success: function() {
                str = geoip_country_code() + '|' + geoip_region_name() + '|' + geoip_city() + '|' + geoip_latitude() + '|' + geoip_longitude();
                document.cookie = '_geo=' + str + ';path=/';
            }
        });
    }
}
if (getCookie('ice') == '') {
    document.cookie = 'ice=true;path=/';
}
if (getCookie('ice') == 'true' && (getCookie('city_name') == null || getCookie('city_name') == '')) {	
    if (getCookie('_geo') == '' || getCookie('_geo') == null) {
        if ("https:" == document.location.protocol) {
            $.get(__cfg('path_relative') + 'cities/check_city/type:getcity', function(data) {
                if (data != '') {
                    response = data.split('|');
                    str = response[2] + '|' + response[1] + '|' + response[0] + '|' + response[3] + '|' + response[4];
                    document.cookie = '_geo=' + str + ';path=/';
                    document.cookie = 'city_name=' + response[0] + ';path=/';
                    location.href = __cfg('path_relative') + 'welcome_to_' + __cfg('site_name');
                }
            });
        } else {
			document.cookie = '_requested_url=' + window.location.href + ';path=/';
            $.ajax( {
                type: 'GET',
                url: 'http://j.maxmind.com/app/geoip.js',
                dataType: 'script',
                cache: true,
                success: function() {
                    str = geoip_country_code() + '|' + geoip_region_name() + '|' + geoip_city() + '|' + geoip_latitude() + '|' + geoip_longitude();
                    document.cookie = '_geo=' + str + ';path=/';
                    document.cookie = 'city_name=' + geoip_city() + ';path=/';
                    $.get(__cfg('path_relative') + 'cities/check_city/latitude:' + geoip_latitude() + '/longitude:' + geoip_longitude(), function(data) {
                        if (data != '') {
                            document.cookie = 'city_name=' + data + ';path=/';
                            location.href = __cfg('path_relative') + 'welcome_to_' + __cfg('site_name');
                        }
                    });
                }
            });
        }
    } else {
        city_name = getCookie('_geo');
        geo_info = city_name.split('|');
        document.cookie = 'city_name=' + geo_info[2] + ';path=/';
        $.get(__cfg('path_relative') + 'cities/check_city/latitude:' + geo_info[3] + '/longitude:' + geo_info[4], function(data) {
            if (data != '') {
                location.href = __cfg('path_relative') + 'welcome_to_' + __cfg('site_name');
            }
        });
    }
}
function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + '=');
        if (c_start !=- 1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(';', c_start);
            if (c_end ==- 1) {
                c_end = document.cookie.length;
            }
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return '';
}
if (tout && 1)
    window._tdump = tout;
function stripHTML(oldString) {

    var newString = "";
    var inTag = false;
    for (var i = 0; i < oldString.length; i ++ ) {

        if (oldString.charAt(i) == '<')
            inTag = true;
        if (oldString.charAt(i) == '>') {
            if (oldString.charAt(i + 1) == "<") {
                //dont do anything

            } else {
                inTag = false;
                i ++ ;
            }
        }
        if ( ! inTag)
            newString += oldString.charAt(i);

    }
    return newString;
}
function buildChart() {
    if ($('.js-load-line-graph', 'body').is('.js-load-line-graph')) {
        $('.js-load-line-graph').each(function() {
            data_container = $(this).metadata().data_container;
            chart_container = $(this).metadata().chart_container;
            chart_title = $(this).metadata().chart_title;
            chart_y_title = $(this).metadata().chart_y_title;
            var table = document.getElementById(data_container);
            options = {
                chart: {
                    renderTo: chart_container,
                    defaultSeriesType: 'line'
                },
                title: {
                    text: chart_title
                },
                xAxis: {
                    labels: {
                        rotation: -90
                    }
                },
                yAxis: {
                    title: {
                        text: chart_y_title
                    }
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.series.name + '</b><br/>' + this.y + ' ' + this.x;
                    }
                }
            };
            // the categories
            options.xAxis.categories = [];
            jQuery('tbody th', table).each(function(i) {
                options.xAxis.categories.push(this.innerHTML);
            });

            // the data series
            options.series = [];
            jQuery('tr', table).each(function(i) {
                var tr = this;
                jQuery('th, td', tr).each(function(j) {
                    if (j > 0) {
                        // skip first column
                        if (i == 0) {
                            // get the name and init the series
                            options.series[j - 1] = {
                                name: this.innerHTML,
                                data: []
                                };
                        } else {
                            // add values
                            options.series[j - 1].data.push(parseFloat(this.innerHTML));
                        }
                    }
                });
            });
            var chart = new Highcharts.Chart(options);
        });
    }
    if ($('.js-load-pie-chart', 'body').is('.js-load-pie-chart')) {
        $('.js-load-pie-chart').each(function() {
            data_container = $(this).metadata().data_container;
            chart_container = $(this).metadata().chart_container;
            chart_title = $(this).metadata().chart_title;
            chart_y_title = $(this).metadata().chart_y_title;
            var table = document.getElementById(data_container);
            options = {
                chart: {
                    renderTo: chart_container,
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false
                },
                title: {
                    text: chart_title
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.point.name + '</b>: ' + (this.percentage).toFixed(2) + ' %';
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: true
                    }
                },
                series: [ {
                    type: 'pie',
                    name: chart_y_title,
                    data: []
                    }]
                };
            options.series[0].data = [];
            jQuery('tr', table).each(function(i) {
                var tr = this;
                jQuery('th, td', tr).each(function(j) {
                    if (j == 0) {
                        options.series[0].data[i] = [];
                        options.series[0].data[i][j] = this.innerHTML
                    } else {
                        // add values
                        options.series[0].data[i][j] = parseFloat(this.innerHTML);
                    }
                });
            });
            var chart = new Highcharts.Chart(options);
        });
    }
    if ($('.js-load-column-chart', 'body').is('.js-load-column-chart')) {
        $('.js-load-column-chart').each(function() {
            data_container = $(this).metadata().data_container;
            chart_container = $(this).metadata().chart_container;
            chart_title = $(this).metadata().chart_title;
            chart_y_title = $(this).metadata().chart_y_title;
            var table = document.getElementById(data_container);
            seriesType = 'column';
            if ($(this).metadata().series_type) {
                seriesType = $(this).metadata().series_type;
            }
            options = {
                chart: {
                    renderTo: chart_container,
                    defaultSeriesType: seriesType,
                    margin: [50, 50, 100, 80]
                    },
                title: {
                    text: chart_title
                },
                xAxis: {
                    categories: [],
                    labels: {
                        rotation: -90,
                        align: 'right',
                        style: {
                            font: 'normal 13px Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: chart_y_title
                    }
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function() {
                        return '<b>' + this.x + '</b><br/>' + Highcharts.numberFormat(this.y, 1);
                    }
                },
                series: [ {
                    name: 'Data',
                    data: [],
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        align: 'right',
                        x: -3,
                        y: 10,
                        formatter: function() {
                            return '';
                        },
                        style: {
                            font: 'normal 13px Verdana, sans-serif'
                        }
                    }
                }]
                };
            // the categories
            options.xAxis.categories = [];
            options.series[0].data = [];
            jQuery('tr', table).each(function(i) {
                var tr = this;
                jQuery('th, td', tr).each(function(j) {
                    if (j == 0) {
                        options.xAxis.categories.push(this.innerHTML);
                    } else {
                        // add values
                        options.series[0].data.push(parseFloat(this.innerHTML));
                    }
                });
            });
            chart = new Highcharts.Chart(options);
        });
    }
}
function loadCityMap() {
	lat = $('#latitude').val();
	lng = $('#longitude').val();
    if ((lat == 0 && lng == 0) || (lat == '' && lng == '')) {
            lat = 13.314082;
            lng = 77.695313;
    }
    var zoom = common_options.map_zoom;
    latlng = new google.maps.LatLng(lat, lng);
    var myOptions1 = {
        zoom: zoom,
        center: latlng,
        zoomControl: true,
        draggable: true,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map1 = new google.maps.Map(document.getElementById('js-map-container'), myOptions1);
	marker1 = new google.maps.Marker( {
			draggable: true,
			map: map1,
			position: latlng
	});
    map1.setCenter(latlng);
	google.maps.event.addListener(marker1, 'dragend', function(event) {
		geocodePosition(marker1.getPosition());
	});
	google.maps.event.addListener(map1, 'mouseout', function(event) {
		$('#zoomlevel').val(map1.getZoom());
	});
}
function loadItemPurchaseMap() {

	lat = 13.314082;
	lng = 77.695313;
    var zoom = 2;
    latlng = new google.maps.LatLng(lat, lng);
    var myOptions1 = {
        zoom: zoom,
        center: latlng,
        zoomControl: true,
        draggable: true,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map1 = new google.maps.Map(document.getElementById('js-item-purchase-location-map'), myOptions1);
	var table = document.getElementById('item_sold_location_data');
	jQuery('tr', table).each( function(i) {
		var tr = this;
		jQuery('th, td', tr).each( function(j) {
			if(j == 0){
				purchase_lat = parseFloat(this.innerHTML);
			} else {
				purchase_lng = parseFloat(this.innerHTML);
				var latlng = new google.maps.LatLng(purchase_lat, purchase_lng);
				marker = new google.maps.Marker( {
					draggable: false,
					map: map1,
					position: latlng
				});

			}
		});
	});

}


// EO- Two/Three Step Subscriptions //
function aftersubmititem(flash_call){
	if($('#js-expand-table', 'body').is('#js-expand-table')){
		$("#js-expand-table tr:not(.js-odd)").hide();
		$("#js-expand-table tr.js-even").show();
		$("#js-expand-table tr.js-odd").click(function(){
			if($(this).hasClass('inactive-record')){
				$(this).addClass('inactive-record-backup');
				$(this).removeClass('inactive-record');
			} else if($(this).hasClass('inactive-record-backup')){
				$(this).addClass('inactive-record');
				$(this).removeClass('inactive-record-backup');
			}
			display = $(this).next("tr").css('display');
			if(display == 'none'){
				$(this).addClass('active-row');
			} else{
				$(this).removeClass('active-row');
			}
			$(this).next("tr").slideToggle('slow');
			$(this).find(".arrow").toggleClass("up");
		});
	}
	if(!flash_call){
		$('form div.js-time').ftimepicker();
		// jquery datepicker
		$('form div.js-datetime').fdatepicker();
	}
		// overlabel
		$('form .js-overlabel label').foverlabel();
		// colorbox
		$('a.js-thickbox').fcolorbox();
		// captcha play
		$('a.js-captcha-play').captchaPlay();
		// colorpicker
		$('.js_colorpick').fcolorpicker();

		$.fautocomplete('.js-autocomplete');
		// tabs
		$('#users-my_stuff .js-mystuff-tabs, .js-tabs').tabs();
		// countdown clock
	  $('#items-index .js-item-end-countdown, #items-view .js-item-end-countdown, .js-widget-item-end-countdown').each(function(){
					var end_date = parseInt($(this).parents().find('.js-time').html());
					$(this).countdown( {
						until: end_date,
						format: 'd H M S'
					});
		});
	   	// load geo map
	//	$.floadgeomaplisting('#ItemCityNameSearch');
	//	$.floadGeo('#PropertyAddressSearch');
		// flash message
		$('#errorMessage,#authMessage,#successMessage,#flashMessage').flashMsg();
	   // jcarousellite
	   if($('.js-jcarousellite', 'body').is('.js-jcarousellite')){
			$(".js-jcarousellite").jCarouselLite({
				btnNext: ".next",
				btnPrev: ".prev",
				mouseWheel: true
			});
	   }
		if($('div.js-truncate', 'body').is('div.js-truncate')){
			var $this = $('div.js-truncate');
			$this.truncate(100, {
				chars: /\s/,
				trail: ["<a href='#' class='truncate_show'>" + __l(' more', 'en_us') + "</a> ... ", " ...<a href='#' class='truncate_hide'>" + __l('less', 'en_us') + "</a>"]
			});
		}
	
		if($('form.js-gig-photo-checkbox', 'body').is('form.js-gig-photo-checkbox')){
			var active = $('.js-gig-photo-checkbox:checked').length;
			var total = $('.js-gig-photo-checkbox').length;
			if (active == total)
				$('.js-gig-photo-checkbox').parent('.input').hide();
			return false;
		}
		if($('.js-editor', 'body').is('.js-editor')){
			$('.js-editor').ftinyMce();
		}
}