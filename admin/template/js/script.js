
	$(document).ready(function() {
		$('[title]').tooltip({
			offset: [-5, 0],
			opacity: 0.9
		});
		
		$('.sel_all').change(function() {
			var _cb = $('.cb');
			if (this.checked) {
				_cb.attr('checked', 'checked');
			} else {
				_cb.removeAttr('checked');
			}
		});
		
		/* tables settings */
		$(document).keydown(function(event) {
			if (event.which == 	119) {
				event.preventDefault();
				$('#tables-settings').animate({ height:'toggle' }, 'fast');
			}
		});
	});
	
	function addTinyMCEEl(id) {
		tinyMCE.init({
			mode : "exact",
			elements : id,
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,print,help",
			theme_advanced_buttons3 : "sub,sup,|,charmap,emotions,iespell,advhr|,ltr,rtl,|,fullscreen,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,link,unlink,anchor,image,media,cleanup",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,code,",
			theme_advanced_buttons5 : "tablecontrols,|,hr,removeformat,visualaid",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
			theme_advanced_styles : "Left=alignleft;Right=alignright;Center=aligncenter",
			accessibility_warnings : false,
			width : "300",
			height: "350",
			valid_children : "+body[style|meta]",
			convert_urls : false,
			
			content_css: adminURL + 'template/css/default.css',

			// Drop lists for link/image/media/template dialogs
			//template_external_list_url : "lists/template_list.js",
			//external_link_list_url : "lists/link_list.js",
			//external_image_list_url : "lists/image_list.js",
			//media_external_list_url : "lists/media_list.js",

			// Style formats
			style_formats : [
				{title : 'Bold text', inline : 'b'},
				{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
				{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
				{title : 'Example 1', inline : 'span', classes : 'example1'},
				{title : 'Example 2', inline : 'span', classes : 'example2'},
				{title : 'Table styles'},
				{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
			],

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			},
			file_browser_callback : 'myFileBrowser'

		});
	}
	
	function myFileBrowser(field_name, url, type, win) {

		// alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing
		
		/* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
		   the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
		   These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

		/* Here goes the URL to your server-side script which manages all file browser things. */
		var cmsURL = adminURL + 'include/tinymce/ajaxfilemanager/ajaxfilemanager.php';     // your URL could look like "/scripts/my_file_browser.php"
		var searchString = window.location.search; // possible parameters
		if (searchString.length < 1) {
			// add "?" to the URL to include parameters (in other words: create a search string because there wasn't one before)
			searchString = "?";
		}

		// newer writing style of the TinyMCE developers for tinyMCE.openWindow

		tinyMCE.activeEditor.windowManager.open({
			file : cmsURL,
			title : 'File Browser',
			width : 850,  // Your dimensions may differ - toy around with them!
			height : 490,
			resizable : "yes",
			inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
			close_previous : "no"
		}, {
			window : win,
			input : field_name
		});

		return false;
	}