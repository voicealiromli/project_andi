$(function(){
	
	$('#dp1,#dp2,#dp3').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true
	});
	$('#bdate,#edate, #dates').datepicker({
        format: "yyyy",
		viewMode: "years",
		minViewMode: "years",
        autoclose: true
	});
	
	/* hide links */
	$('[id="hidelink"]').click(function() {
		var txt = $(this).attr('rel');
		location.href=txt;
		return false;
	});
	
	$('[id="deletelink"]').click(function(event) {
		xconfirm = confirm("Anda yakin akan menghapus data?");
		if(xconfirm)
		{
			var txt = $(this).attr('rel');
			location.href=txt;
		}
		event.preventDefault();
		return false;	
	});
	
	$('#xtable').on("click", '[id="hidelink"]', function(event) {
		var txt = $(this).attr('rel');
		location.href=txt;
		event.preventDefault();
		
	});
	
	$('#xtable').on("click", '[id="deletelink"]', function(event) {
		xconfirm = confirm("Anda yakin akan menghapus data?");
		if(xconfirm)
		{
			var txt = $(this).attr('rel');
			location.href=txt;
		}
		event.preventDefault();
		return false;		
	});
	
	$(".collapse").collapse({
		toggle: false
	});
	
	/* jumpmenus */
	$("#jumpmenu").change(function() {
    $("option:selected").each(function() {
			var url = $(this).val();
			location.href=url;
    });
	});
	
	/* checkboxes */	
	$("input[id=checkall]").each(function() {
		var trigger = $(this);
		trigger.click(function() {
			var checked_status = this.checked;	
			$("input:checkbox").each(function() {
				this.checked = checked_status;
			});
		});
	});	
	
	$("input:checkbox").click(function(){
		if($("input:checked").length > 0) {
			$("#delete_all").removeAttr("disabled");
		} else {
			$("#delete_all").attr("disabled", "disabled");
		}	
	});

	/* multiple delete */
	$("[id=delete_all]").click(function() {
		return confirm('Yakin akan menghapus data yang dipilih?');
	});	
	
	/* autocomplete */
	/* $( "#kepada,#tembusan" )
		.bind( "keydown", function( event ) {
			if ( event.keyCode === $.ui.keyCode.TAB &&
					$( this ).data( "autocomplete" ).menu.active ) {
				event.preventDefault();
			}
		})
		.autocomplete({
			minLength: 2,
			source: function( request, response ) {
				$.getJSON( 'http://'+location.hostname+"/polhukam/ajax/get_data", {
					term: extractLast( request.term )
				}, response );
			},
			focus: function() {
				return false;
			},
			select: function( event, ui ) {
				var terms = split( this.value );
				terms.pop();
				terms.push( ui.item.value );
				terms.push( "" );
				this.value = terms.join( "; " );
				return false;
			}
		}); */
		
	/* func */
	function split( val ) {
		return val.split( /;\s*/ );
	}
	
	function extractLast( term ) {
		return split( term ).pop();
	}
	
	// UPLOAD & VIEWER PARAMS
	var widthArray = 1000;
	var heightArray = 830;

	$("#scan-btn").click(function(event){
		var windowUrl = $(this).attr("rel");
		var windowLeft = parseInt((screen.availWidth/2) - (widthArray/2));
		var windowTop = parseInt((screen.availHeight/2) - (heightArray/2));
		var windowSize = "width=" + widthArray + ",height=" + heightArray + ",left=" + windowLeft + ",top=" + windowTop + ",screenX=" + windowLeft + ",screenY=" + windowTop + ",scrollbars=yes, location=no";		  
		window.open(windowUrl, "Media Scanner", windowSize);
		event.preventDefault();
	});	
	
	/* $("#aboutBtn").each(function(){
		var trigger = $(this);
		var dialog = $('<div id="modal-window"></div>').dialog({
									autoOpen: false,
									title: "Tentang Aplikasi",
									modal: true,
									width:400,
									height:400,
									closeOnEscape: true
							})
							.load(trigger.attr("rel"));	
	
		trigger.click(function() {
			dialog.dialog('open');
			return false;
		});  
		
	});	 */
		

});