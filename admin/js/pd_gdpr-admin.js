(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

    var $doc = $(document);
    $doc.ready(function () {
        // Load Selected Cookie Categories
        // ======================
        if ( typeof js_admin_vars.selected_cookie_categories !== 'undefined' ) {
            $.each( js_admin_vars.selected_cookie_categories, function( key, value ) {
                $('#puredevs_'+key+'_settings-tab').css('display','block');
            });
        }
        // end
        var bar_style = $('.bar-style');
        bar_style.change(function() {
            var bar =$(':selected').val();
            if (bar === 'banner') {
                $('.bar-position-wrap').show();
            }else{
                $('.bar-position-wrap').hide();
            }
        });

        if ( $('.geo_location-section .radio:checked').val() === 'european-union-only' ){
           $('.geo_location_api').show();
		}

        var geoip = $('.geo_location-section .radio');
        geoip.change(function() {
            var geoipVal =$(this).val();
            if (geoipVal === 'european-union-only') {
                $('.geo_location_api').show();
            }else{
                $('.geo_location_api').hide();
            }
        });

		//clone input
		var repeater_btn = $('button.input-rep-btn');
		repeater_btn.on("click", function(e) {
			e.preventDefault();
			$(this).parents('.btn-primary').prev('tr').find('.input-repeater-container div:last-child').clone().appendTo(".input-repeater-container").find("input[type='text']").val("");
		});
		//end

		//remove clone item
        $('body').on('click','.input-repeater-container div button.close',function(){
			if($(this).parents('.input-repeater-container').find('div').length > 1){
				$(this).parent('div').remove();
			}
		});
		//end
		if($('.show-cookie-bar td input[class=radio]:checked').val() == 'soe'){
			$('.bar-time-wrapper').addClass('disabled');
		}else{
			$('.bar-position-wrapper').addClass('disabled');
		}

		if($('.show-floating-button td input[class=radio]:checked').val() == 'soe'){
			$('.floating-bar-time-wrapper').addClass('disabled');
		}else{
			$('.floating-bar-position-wrapper').addClass('disabled');
		}

        $('body').on('click','.show-cookie-bar td label',function(){
			$('.show-cookie-bar-option-number').removeClass('disabled');
			$('.show-cookie-bar-option').removeClass('disabled');
			if($(this).find('input').val() == 'soe'){
				$('.bar-time-wrapper').addClass('disabled');
			}else{
				$('.bar-position-wrapper').addClass('disabled');
			}
		});

        $('body').on('click','.show-floating-button td label',function(){
			$('.show-floating-bar-option-number').removeClass('disabled');
			$('.show-floating-bar-option').removeClass('disabled');
			if($(this).find('input').val() == 'soe'){
				$('.floating-bar-time-wrapper').addClass('disabled');
			}else{
				$('.floating-bar-position-wrapper').addClass('disabled');
			}
		});

		//Export/Import Section

		if($('.export-import-section td input[class=radio]:checked').val() == 'all'){
			$('.ei-opt-wrap').addClass('d-none');
		}else{
			$('.ei-opt-wrap').removeClass('d-none');
		}

        $('body').on('click','.export-import-section td label',function(){
			if($(this).find('input').val() == 'all'){
				$('.ei-opt-wrap').addClass('d-none');
			}else{
				$('.ei-opt-wrap').removeClass('d-none');
			}
		});

        $('.acc_container').hide();
        $('.acc_trigger').click(function(){
            var $this = $(this),
                thisActive = $this.hasClass('active'),
                active;
            // If this one is active, we always just close it.
            if (thisActive) {
                $this.removeClass('active').siblings('.acc_container').slideUp("slow");
                $this.find('i').addClass('angle-down');
                $this.find('i').removeClass('angle-up');
            } else {
                // Is there just one active?
                active = $('.acc_trigger.active');
                if (active.length === 1) {
                    active.removeClass('active').siblings('.acc_container').slideUp("slow");
                    $this.find('i').addClass('angle-down');
                    $this.find('i').removeClass('angle-up');
                }
                // Open this one
                $this.addClass('active').siblings('.acc_container').slideDown( "slow" );

                $this.find('i').removeClass('angle-down');
                $this.find('i').addClass('angle-up');
            }
        });

        $('.tab-item a').click(function(){
            $('.tab-item a').removeClass('active');
            $(this).addClass('active');
            var tagid = $(this).data('tag');
            $('.list').removeClass('active').addClass('hide');
            $('#'+tagid).addClass('active').removeClass('hide');
        });

        //export ajax call;

        $('body').on('click','.export-btn', function (e) {
        	e.preventDefault();
            e.stopPropagation();
        	var export_type = $('.export-import-section td label').find('input:checked').val();
        	if(export_type == 'all'){
                var data = {
                    'action': 'pd_gdpr_export_data',
                    export_type: export_type,
                };
			}else{
                var select_opt = $(".ei-opt-wrap td select option:selected" ).val();
                var data = {
                    'action': 'pd_gdpr_export_data',
                    export_type: export_type,
                    select_opt: select_opt,
                };
			}
            $.post(js_admin_vars.ajax_url, data, function (response) {
                var blob = new Blob([response], {type: 'text/csv'});
                var downloadUrl = URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.href = downloadUrl;
                a.download = "pd_cookie_settings.csv";
                document.body.appendChild(a);
                a.click();
            });
        });

    });

    $(window).load(function() {
        if( $( ".bar-style option:selected" ).val() == 'popup' ){
            $('.bar-position-wrap').hide();
        }
    });

    //end
})( jQuery );
