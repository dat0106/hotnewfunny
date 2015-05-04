var Better_Framework = (function($) {
    "use strict";

    // module
    return {

        init: function(){

            // Setup General fields
            this.setup_fields();


            switch( bf.type ){

                // Setup Widgets
                case 'widgets':

                    // Setup fields after ajax request on widgets page
                    this.setup_widget_fields();
                    break;

                // Setup Panel
                case 'panel':

                    this.setup_panel_tabs();
                    this.panel_save_action();
                    this.panel_reset_action();
                    this.panel_sticky_header();
                    this.panel_sticky_menu();
                    this.panel_import_export();
                    break;

                // Setup Metaboxes
                case 'metabox':
                    // Metabox Filter For Post Format
                    this.metabox_filter_postformat();

                    // Metabox Fields Filter For Post Format
                    this.metabox_field_filter_postformat();

                    this.setup_fields_for_vc();
                    break;

                // Setup Menus
                case 'menus':

                    this.menus_advanced_fields_button();
                    break;

            }

        },


        /**
         * Panel
         ******************************************/

        // Setup panel tabs
        setup_panel_tabs: function(){

            $(".bf-header .logo").fitText(1.2);

            // TODO: Vahid shit! Refactor this

            var panelID = $('#bf-panel-id').val();

            var _bf_current_tab = $.cookie( 'bf_current_tab_of_' + panelID  );

            function bf_show_first_tab(){
                $('#bf-nav').find('li:first').find('a:first').addClass("active_tab");

                $('#bf_options_form').find( '#bf-group-' + $('#bf-nav').find('li:first').data("go") ).show(function(){
                    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                    elems.forEach(function(html) {
                        var switchery = new Switchery(html);
                    });
                } );
            }

            if( typeof _bf_current_tab == 'undefined' ){
                bf_show_first_tab();
            }
            else
            {
                var _curret_ = $.cookie( 'bf_current_tab_of_' + panelID  );

                if( !$('#bf_options_form').find( '#bf-group-' + _curret_ ).exist() || !$('#bf-nav').find("a[data-go='"+_curret_+"']").exist() ){
                    bf_show_first_tab();
                    $.removeCookie('bf_current_tab_of_' + panelID);
                }

                $('#bf_options_form').find( '#bf-group-' + _curret_ ).show();
                $('#bf-nav').find("a[data-go='"+_curret_+"']").addClass("active_tab");
                if( $('#bf-nav').find("a[data-go='"+_curret_+"']").is(".bf-tab-subitem-a") ){
                    $('#bf-nav').find("a[data-go='"+_curret_+"']").closest(".has-children").addClass("child_active");
                }

            }

            $('#bf-nav').find('a').click( function(){

                var _this = $(this);
                var _hasNotGroup = ( ( _this.parent().hasClass('has-children') ) && ( ! $('#bf_options_form').find( '#bf-group-' + _this.data("go") ).find(">*").exist() ) );
                var _isChild = ! _this.parent().hasClass('has-children');

                if( _hasNotGroup ){
                    var _clicked = _this.siblings('ul.sub-nav').find('a:first');
                    var _target = $('#bf_options_form').find( '#bf-group-' + _clicked.data("go") );
                } else {
                    var _clicked = _this;
                    var _target = $('#bf_options_form').find( '#bf-group-' + _clicked.data("go") );
                }

                $('#bf-nav').find('a').removeClass("active_tab");
                $('#bf-nav').find('ul.sub-nav').find('a').removeClass("active_tab");
                $('#bf-nav').find('li').removeClass("child_active");

                $('#bf_options_form').find('>div').hide();
                _target.show();

                $.cookie( 'bf_current_tab_of_' + panelID, _clicked.data("go"), { expires: 7 });

                _clicked.addClass("active_tab");

                if( _this.parent().hasClass('has-children') || _this.parent().parent().hasClass('sub-nav') ){
                    _clicked.closest('.has-children').addClass("child_active");
                }

                $('body,html').animate({
                    scrollTop: 0
                }, 400);

                return false;
            });


        },

        // Panel save ajax action
        panel_save_action: function(){

            $(document).on( 'click', '.bf-save-button', function(e){

                e.preventDefault();

                var _serialized = $('#bf-content').bf_serialize();
                _serialized += '&' + $('#bf_options_form :radio').serialize();

                Better_Framework.panel_loader('loading');

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: bf.bf_ajax_url,
                    data:{
                        action   : 'bf_ajax',
                        reqID    : 'save_admin_panel_options',
                        type     : bf.type,
                        panelID  : $('#bf-panel-id').val(),
                        nonce    : bf.nonce,
                        data   	 : _serialized
                    },
                    success: function(data, textStatus, XMLHttpRequest){
                        if( data.status == 'succeed' ) {
                            Better_Framework.panel_loader('succeed',data);
                        } else {
                            Better_Framework.panel_loader('error',data);
                        }

                        if( typeof data.refresh != 'undefined' && data.refresh ){

                            location.reload();

                        }
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){
                        Better_Framework.panel_loader('error');
                    }
                });

            });
        },


        // Panel Options Import & Export
        panel_import_export: function(){

            // Export Button
            $(document).on( 'click', '#bf-download-export-btn', function(){

                var _go = $(this).attr('href');

                var _file_name =  $(this).data('file_name');
                var _panel_id =  $(this).data('panel_id');

                $().redirect(_go,{
                    'bf-export':    1,
                    'nonce':        bf.nonce,
                    'file_name':    _file_name,
                    'panel_id':    _panel_id
                });

                return false;

            });

            // Import
            var bf_import_submit;
            $('.bf-import-file-input').fileupload({
                limitMultiFileUploads: 1,
                url: bf.bf_ajax_url,
                autoUpload: false,
                replaceFileInput: false,
                formData: {
                    nonce  : bf.nonce,
                    action : 'bf_ajax',
                    type   : bf.type,
                    reqID  : 'import'
                },
                add: function (e, data) {
                    bf_import_submit = function () {
                        return data.submit();
                    };
                },
                fail: function (e, data) {
                    Better_Framework.panel_loader('error');
                },
                start: function (e) {
                    Better_Framework.panel_loader('loading');
                },
                done: function (e, data) {
                    Better_Framework.panel_loader('success');
                    setTimeout( function(){

                        location.reload();

                    }, 1000);
                },
                progressall: function (e, data) {
                    var progress = parseInt( data.loaded / data.total * 100, 10);
                },
                drop: function (e, data) {
                    return false;
                }
            });

            $('.bf-import-upload-btn').click( function(){

                if( typeof bf_import_submit != "undefined" ){

                    if( confirm( bf.text_import_prompt ) == true ){
                        bf_import_submit();
                    }

                }

                return false;
            });

        },


        // Ajax Action Field
        setup_ajax_action: function(){

            $(document).on( 'click', '.bf-ajax_action-field-container .bf-action-button', function(e){

                e.preventDefault();

                Better_Framework.panel_loader('loading');

                var _confirm_msg =  $(this).data('confirm');

                if( typeof  _confirm_msg  != "undefined" )
                    if( ! confirm( _confirm_msg ) ){
                        Better_Framework.panel_loader( 'hide' );
                        return false;
                    }

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: bf.bf_ajax_url,
                    data:{
                        action   : 'bf_ajax',
                        reqID    : 'ajax_action',
                        type     : bf.type,
                        panelID  : $('#bf-panel-id').val(),
                        nonce    : bf.nonce,
                        callback: $(this).data('callback')
                    },
                    success: function(data, textStatus, XMLHttpRequest){

                        if( data.status == 'succeed' ) {
                            Better_Framework.panel_loader('succeed', data );
                        } else {
                            Better_Framework.panel_loader('error',data);
                        }

                        if( typeof data.refresh != 'undefined' && data.refresh ){

                            location.reload();

                        }
                    },
                    error: function(MLHttpRequest, textStatus, errorThrown){
                        Better_Framework.panel_loader('error');
                    }
                });

            });


        },


        // Panel Ajax Reset Action
        panel_reset_action: function(){

            // TODO  remove bf_admin_notice after refresh page

            $(document).on( 'click', '.bf-reset-button', function(){

                if( confirm( 'Are you sure?' ) ){
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: bf.bf_ajax_url,
                        data:{
                            action 	 : 'bf_ajax',
                            reqID  	 : 'reset_options_panel',
                            panelID  : $('#bf-panel-id').val(),
                            type	 : 'panel',
                            nonce    : bf.nonce,
                            to_reset : $('.bf-reset-options-frame-tabs').bf_serialize()
                        },
                        success: function(data, textStatus, XMLHttpRequest){
                            if( data.status == 'succeed' ) {
                                if( typeof data.refresh != 'undefined' && data.refresh ){
                                    location.reload();
                                }
                            } else {
                                alert( data.msg );
                            }
                        },
                        error: function(MLHttpRequest, textStatus, errorThrown){
                            alert( 'An error occurred!' );
                        }
                    });
                }

                return false;

            });

        },


        // Panel loader
        // status: loading, succeed, error
        // TODO: add message to loader
        panel_loader: function( status ){
            if( status == 'loading'){
                $('.bf-loading').removeClass().addClass('bf-loading in-loading');
            }
            else if(status == 'error'){
                $('.bf-loading').removeClass().addClass('bf-loading not-loaded');
                setTimeout(function(){
                    $('.bf-loading').removeClass('not-loaded');
                },1000)
            }else if(status == 'succeed'){
                $('.bf-loading').removeClass().addClass('bf-loading loaded');
                setTimeout(function(){
                    $('.bf-loading').removeClass('loaded');
                },500)
            }else if( status == 'hide' ){
                setTimeout(function(){
                    $('.bf-loading').removeClass(' in-loading');
                },50)
            }
        },


        // Setup sticky header
        panel_sticky_header: function(){

            var $main_menu = $('#bf-panel .bf-header');

            var main_menu_offset_top = $main_menu.offset().top - 32;

            var sticky_func = function(){

                if( $(window).scrollTop() > main_menu_offset_top )
                    $main_menu.addClass('sticky');
                else
                    $main_menu.removeClass('sticky');

            };

            sticky_func();

            $( window ).scroll( function(){
                sticky_func();
            } );
        },


        // Setup sticky menu
        panel_sticky_menu: function(){

            var $main_menu = $('#bf-nav');

            var main_menu_offset_top = $main_menu.offset().top - 105;

            var sticky_func = function(){

                if( $(window).scrollTop() > main_menu_offset_top )
                    $main_menu.addClass('sticky');
                else
                    $main_menu.removeClass('sticky');

            };

            sticky_func();

            $( window ).scroll( function(){
                sticky_func();
            } );
        },


        /**
         * Meta Box
         ******************************************/

        // Advanced filter for filter metaboxes for post format's
        metabox_filter_postformat: function(){

            var _current_format = $('#post-formats-select input[type=radio][name=post_format]:checked').attr('value');
            if(parseInt(_current_format)==0)
                _current_format='standard';

            $('.bf-metabox-wrap').each(function(){
                if(typeof  $(this).data('bf_pf_filter') == 'undefined' || $(this).data('bf_pf_filter') == '')
                    return 1;

                var _metabox_id = '#bf_'+$(this).data('id'),
                    __metabox_id = 'bf_'+$(this).data('id'),

                    _formats = $(this).data('bf_pf_filter').split(',');

                if($.inArray(_current_format,_formats)== -1)
                    $(_metabox_id).hide();
                else
                    $(_metabox_id).show();
            });

            $('#post-formats-select input[type=radio][name=post_format]').change(function(){
                Better_Framework.metabox_filter_postformat();
            });

        },


        // Advanced filter for filter metabox fields for post format's
        metabox_field_filter_postformat: function(){

            var _current_format = $('#post-formats-select input[type=radio][name=post_format]:checked').attr('value');
            if(parseInt(_current_format)==0)
                _current_format='standard';

            $('.bf-field-post-format-filter').each(function(){

                if(typeof  $(this).data('bf_pf_filter') == 'undefined' || $(this).data('bf_pf_filter') == '')
                    return 1;

                var _formats = $(this).data('bf_pf_filter').split(',');

                if( $.inArray( _current_format, _formats ) == -1 )
                    $(this).hide();
                else
                    $(this).show();
            });


            $('#post-formats-select input[type=radio][name=post_format]').change(function(){
                Better_Framework.metabox_field_filter_postformat();
            });

        },


        /**
         * Visual Composer
         ******************************************/

        // Setup fields when VC create new popup window
        setup_fields_for_vc: function(){

            jQuery(document).ajaxSuccess(function(e, xhr, settings) {

                var _data = $.unserialize(settings.data);

                if( _data.action == "wpb_show_edit_form" ){
                    // TODO do this for just new elements

                    Better_Framework.setup_field_color_picker();
                    Better_Framework.setup_vc_field_switchery();
                    Better_Framework.setup_field_slider();
                    Better_Framework.setup_field_ajax_select();
                    Better_Framework.setup_vc_field_sorter();

                }

            });

            Better_Framework.set_up_vc_field_image_radio();
        },

        // Setup Sorter field
        setup_vc_field_sorter: function(){

            $( ".bf-vc-sorter-list" ).sortable({
                placeholder: "placeholder-item",
                cancel: "li.disable-item"
            });

            $('.bf-section-container.vc-input .bf-vc-sorter-list li input').on('change', function(evt, params) {

                if( typeof $(this).attr('checked') != "undefined" ){
                    $(this).closest('li').addClass('checked-item');
                }else{
                    $(this).closest('li').removeClass('checked-item');
                }

            });

            $('.bf-section-container.vc-input .bf-vc-sorter-checkbox-list li input, .bf-vc-sorter-list').on('change', function(evt, params) {

                var $parent = $(this).closest('.bf-section-container.vc-input'),
                $input = $parent.find('input.wpb_vc_param_value');

                rearrange_bf_vc_sorter_checkbox( $parent, $input );

            });

            $('.bf-vc-sorter-list').on('sortupdate', function(evt, params) {
                var $parent = $(this).closest('.bf-section-container.vc-input'),
                    $input = $parent.find('input.wpb_vc_param_value');

                rearrange_bf_vc_sorter_checkbox( $parent, $input );

            });

            function rearrange_bf_vc_sorter_checkbox( $parent, $input ){
                var _val = '';
                $('.bf-section-container.vc-input .bf-vc-sorter-checkbox-list li input[type=checkbox]:checked').each( function(){
                    if( _val.length == 0 ){
                        _val = $(this).attr( 'name' );
                    }else{
                        _val = _val + ',' + $(this).attr( 'name' );
                    }
                });
                $input.attr( 'value', _val );
            }
        },


        /**
         * Setup Visual Composer Image Radio Field
         */
        set_up_vc_field_image_radio: function(){

            $(document).on( 'click', '.vc-bf-image-radio-option', function(e){

                $(this).parent().find('input[type=hidden]').val( $(this).data( 'id' ) );

                // Remove checked class from field options and add checked class to clicked option
                $(this).siblings().removeClass('checked').end().addClass('checked');

                // Prevent Browser Default Behavior
                e.preventDefault();
            });

        },

        // Setup Switchery check box field
        setup_vc_field_switchery: function(){

            $('.bf-section-container.vc-input .js-switch').each( function(){

                if( $(this).prop( 'checked' ) ){
                    $(this).val( 1 );
                }else{
                    $(this).val( 0 );
                }

                new Switchery( this );

                $(this).on('change', function() {

                    if( $(this).prop( 'checked' ) ){
                        $(this).val( 1 );
                    }else{
                        $(this).val( 0 );
                    }

                });

            });
        },


        /**
         * Widgets
         ******************************************/

        // Setup widgets fields after ajax submit
        setup_widget_fields: function(){

            jQuery(document).ajaxSuccess(function(e, xhr, settings) {

                var _data = $.unserialize(settings.data);

                if( _data.action == "save-widget" ){
                    // TODO do this for just new elements
                    Better_Framework.setup_fields();
                    Better_Framework.setup_field_icon_select();
                }

            });

            // Clone Repeater Item by click
            // TODO refactor this
            $(document).on( 'click', '.bf-widget-clone-repeater-item', function(e){
                e.preventDefault();
                var name_format = undefined === $(this).data( 'name-format' ) ? '$1[$2][$3][$4][$5]' : $(this).data( 'name-format'), _html = $(this).siblings('script').html();

                var _new = $(this).siblings('.bf-repeater-items-container').find('>*').size();
                var new_num = _new + 1;
//                new_num = '[' + new_num + ']';
                $(this).siblings('.bf-repeater-items-container').append(
                    _html
                       .replace( /([\"\'])(\|)(_to_clone_)(.+)?-num-(.+)?(\|)(\1)/g, '$1$2$3$4-num-'+new_num+'-$5$6$7$8')
                       .replace( /[\"\']\|_to_clone_(.+)?-(\d+)-(.+)?-num-(\d+)-(.+)\|[\"\']/g, '"'+name_format+'"' )
                );
                bf_color_picker_plugin( $(this).siblings('.bf-repeater-items-container').find('.bf-color-picker') );
                bf_date_picker_plugin( $(this).siblings('.bf-repeater-items-container').find('.bf-date-picker-input') );
                bf_image_upload_plugin( $(this).siblings('.bf-repeater-items-container').find('.bf-image-upload-choose-file') );
            });

        },



        /**
         * Menus
         ******************************************/

        menus_advanced_fields_button: function(){

            $(document).on('click', '.better-menu-box-title a' ,function(e){

                var $field_form = $(this).closest('.better-menu-container');

                if( $field_form.hasClass('active-form') ){
                    $(this).text( bf.show_advanced_fields );
                }else{
                    $(this).text( bf.hide_advanced_fields );
                }

                $field_form.toggleClass('active-form')

                $field_form.find('.better-menu-fields').slideToggle();

            });
        },

        /**
         * General Fields For All Sections
         ******************************************/

        // Setup General Fields
        setup_fields: function() {

            Better_Framework.setup_field_with_prefix_or_postfix();

            Better_Framework.setup_field_switchery();

            Better_Framework.setup_field_slider();
            Better_Framework.setup_field_sorter();

            Better_Framework.setup_field_color_picker();

            Better_Framework.setup_field_image_radio();
            Better_Framework.setup_field_image_checkbox();
            Better_Framework.setup_field_image_select();

            Better_Framework.setup_field_date_picker();

            Better_Framework.setup_field_media_uploader();
            Better_Framework.setup_field_media_image();
            Better_Framework.setup_field_background_image();

            Better_Framework.setup_field_ajax_select();

            Better_Framework.setup_field_icon_select();

            Better_Framework.setup_field_typography();

            Better_Framework.setup_field_border();

            Better_Framework.setup_field_repeater();

            Better_Framework.setup_ajax_action();


        },

        // TODO Refactor This
        setup_field_repeater: function(){

            // Add jQuery UI Sortable to Repeater Items
            $('.bf-repeater-items-container').sortable({
                revert: true,
                cursor: 'move',
                delay: 150,
                handle: ".bf-repeater-item-title",
                start: function( event, ui ) {
                    ui.item.addClass('drag-start');
                },
                beforeStop: function( event, ui ) {
                    ui.item.removeClass('drag-start');
                }
            });

            // Remove Repeater Item
            $(document).on( 'click', '.bf-remove-repeater-item-btn', function( e ){

                var $section =  $(this).closest('.bf-section');
                if( confirm( 'Are you sure?' ) ){
                    $(this).closest('.bf-repeater-item').slideUp( function(){
                        $(this).remove();

                        // Event for when item removed
                        $section.trigger( 'after_repeater_item_removed' );
                    });
                }


                e.preventDefault();

            });

            // Collapse
            $(document).on( 'click', '.handle-repeater-item', function(){
                $(this).toggleClass('closed').closest('.bf-repeater-item').find('.repeater-item-container').toggle();
            });

            // Clone Repeater Item by click
            $(document).on( 'click', '.bf-clone-repeater-item', function(e){
                e.preventDefault();
                var neme_format = undefined === $(this).data( 'name-format' ) ? '$1[$2][$3]' : $(this).data( 'name-format'), _html = $(this).siblings('script').html();

                var _new = $(this).siblings('.bf-repeater-items-container').find('>*').size();
                var new_num = _new + 1;
                $(this).siblings('.bf-repeater-items-container').append(
                    _html
                        .replace( /([\"\'])(\|)(_to_clone_)(.+)?(-)(num)(-)(.+)?(\|)(\1)/g, '$1$2$3$4$5'+new_num+'$7$8$9$10')
                        .replace( /[\"\']\|_to_clone_(.+)?-child-(.+)?-(\d+)-(.+)\|[\"\']/g, '"'+neme_format+'"' )
                );

                // Event for when new item added
                $(this).closest('.bf-section').trigger('repeater_item_added');
            });

        },

        setup_field_typography: function(){

            $('.bf-section-container select.font-family').chosen({
                width: "200px"
            });

            // Init preview in page load
            $('.bf-section-typography-option').each(function(){
                refresh_typography( $(this).closest(".bf-section-container"), 'first-time');
            });

            // Prepare active field in page load
            $('.bf-section-typography-option .typo-enable-container input[type=checkbox]').each(function(){

                $(this).closest(".bf-section-typography-option").addClass('have-enable-field');

                if( $(this).attr("checked") ){
                    $(this).closest(".bf-section-typography-option").addClass('enable-field');
                }else{
                    $(this).closest(".bf-section-typography-option").addClass('disable-field');
                }

            });

            // Active field on change
            $('.bf-section-typography-option .typo-enable-container input[type=checkbox]').on('change', function(){

                if( $(this).attr("checked") ){
                    $(this).closest(".bf-section-typography-option").addClass('enable-field').removeClass('disable-field');
                }else{
                    $(this).closest(".bf-section-typography-option").addClass('disable-field').removeClass('enable-field');
                }

            });


            // When Font Family Changes
            $('.bf-section-container select.font-family').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'family');
            });

            // When Font Variant Changes
            $('.bf-section-container .font-variants').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'variant' );
            });

            // When Font Size Changes
            $('.bf-section-container .font-size').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'size' );
            });

            // When Line Height Changes
            $('.bf-section-container .line-height').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'height' );
            });

            // When Align Changes
            $(' .bf-section-container .text-align-container select').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'align' );
            });

            // When Color Changes
            $(' .bf-section-container .text-color-container .bf-color-picker').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'color' );
            });

            // When Transform Changes
            $(' .bf-section-container .text-transform').on('change', function(evt, params) {
                refresh_typography( $(this).closest(".bf-section-container"), 'transform' );
            });

            // Used for refreshing all styles of typography field
            function refresh_typography( $parent, type ){
                type = typeof type !== 'undefined' ? type : 'all';

                var $preview = $parent.find('.typography-preview .preview-text');

                var _css = $preview.css([
                    "fontSize", "lineHeight", "textAlign", "fontFamily", "fontStyle", "fontWeight", "textTransform", "color"
                ]);

                switch ( type ){

                    case 'size':
                        _css = refresh_typography_field( $parent, 'size', _css);
                        break;

                    case 'height':
                        _css = refresh_typography_field( $parent, 'height', _css);
                        break;

                    case 'transform':
                        _css = refresh_typography_field( $parent, 'transform', _css);
                        break;

                    case 'align':
                        _css = refresh_typography_field( $parent, 'align', _css);
                        break;

                    case 'color':
                        _css = refresh_typography_field( $parent, 'color', _css);
                        break;

                    case 'variant':

                        _css = refresh_typography_field( $parent, 'variant', _css);

                        var variant = $parent.find('.font-variants option:selected').val();

                        if( typeof variant == 'undefined' )
                            break;

                        // load new font
                        var new_font = $parent.find('select.font-family option:selected').val();
                        WebFont.load({
                            google: {
                                families: [ new_font + ':' + variant ]
                            }
                        });

                        _css.fontFamily = new_font + ", sans-serif";

                        break;

                    case 'family':

                        var new_font = $parent.find('select.font-family option:selected').val();

                        // load and adds variants
                        $parent.find('.font-variants option').remove();
                        var selected = ' selected="selected" ';
                        bf.google_fonts[new_font].variants.forEach(function( element, index){

                            $parent.find('.font-variants').append('<option value="' + element['id'] +'" ' + selected + '>'+ element['name'] +'</option>');

                            if( selected )
                                selected = false;
                        });

                        // load and adds subsets
                        $parent.find('.font-subsets option').remove();
                        bf.google_fonts[new_font].subsets.forEach(function( element, index){
                            $parent.find('.font-subsets').append('<option value="' + element['id'] +'">'+ element['name'] +'</option>');
                        });


                        _css = refresh_typography_field( $parent, 'load-font', _css);

                        _css = refresh_typography_field( $parent, 'variant', _css);

                        _css = refresh_typography_field( $parent, 'family', _css);

                        break;


                    case 'first-time':

                        $parent.find('.load-preview-texts').remove();

                        _css = refresh_typography_field( $parent, 'load-font', _css);

                        _css = refresh_typography_field( $parent, 'family', _css);

                        _css = refresh_typography_field( $parent, 'size', _css);

                        _css = refresh_typography_field( $parent, 'height', _css);

                        _css = refresh_typography_field( $parent, 'transform', _css);

                        _css = refresh_typography_field( $parent, 'align', _css);

                        _css = refresh_typography_field( $parent, 'variant', _css);

                        $parent.find('.typography-preview').css('display', 'block');

                }

                $preview.attr('style', '');
                $preview.css( _css );
            }

            // Used for refreshing typography preview
            function refresh_typography_field( $parent, type, _css ){

                switch ( type ){
                    case  'size':
                        _css.fontSize = $parent.find('.font-size').val() + 'px';
                        break;

                    case 'height':
                        if( $parent.find('.line-height').val() != '' )
                            _css.lineHeight = $parent.find('.line-height').val() + 'px';
                        else
                            delete _css.lineHeight;
                        break;

                    case 'align':
                        _css.textAlign = $parent.find('.text-align-container select option:selected').val();
                        break;

                    case 'color':
                        _css.color = $parent.find('.text-color-container .bf-color-picker').val();
                        break;

                    case 'transform':
                        _css.textTransform = $parent.find('.text-transform').val();
                        break;

                    case 'family':
                        _css.fontFamily = $parent.find('select.font-family option:selected').val() + ", sans-serif";
                        break;

                    case 'variant':
                        var variant = $parent.find('.font-variants option:selected').val();

                        if( typeof variant == 'undefined' )
                            break;

                        if( variant.match(/([a-zA-Z].*)/i) != null ){
                            var style = variant.match(/([a-zA-Z].*)/i);
                            if( style[0] == 'regular' )
                                _css.fontStyle = 'normal';
                            else
                                _css.fontStyle = style[0];
                        }else{
                            delete _css.fontStyle;
                        }

                        if( variant.match(/\d*(\s*)/i) != null ){
                            var size = variant.match(/\d*(\s*)/i);
                            _css.fontWeight = size[0];
                        }else{
                            delete _css.fontWeight;
                        }

                        break;

                    case 'load-font':
                        var new_font = $parent.find('select.font-family option:selected').val();
                        var variant = $parent.find('.font-variants option:selected').val();
                        WebFont.load({
                            google: {
                                families: [ new_font + ':' + variant]
                            }
                        });
                        break;

                }
                return _css;

            }

            // Preview Tab
            $('.typography-preview .preview-tab .tab').on('click', function() {

                if( $(this).hasClass('current') ){
                    return false;
                }else{

                    $(this).closest('.preview-tab').find('.current').removeClass('current');
                    $(this).closest('.typography-preview').find('.preview-text.current').removeClass('current');

                    $(this).addClass('current');

                    $(this).closest('.typography-preview').find('.preview-text.'+$(this).data('tab')).addClass('current');
                }

            });

            // Preview Button
            $('.bf-section-container .load-preview-texts').on('click', function() {

                refresh_typography( $(this).closest(".bf-section-container"), 'first-time');

                $(this).remove();
            });

        },


        setup_field_border: function(){

            $('.bf-section-border-option').each(function(){
                refresh_border( $(this).closest(".bf-section-container"), 'first-time');
            });


            // When all changed
            $('.bf-section-container .single-border.border-all select, .bf-section-container .single-border.border-all input').on('change', function(evt, params) {
                refresh_border( $(this).closest(".bf-section-container"), 'all');
            });
            $('.bf-section-container .single-border.border-all input.bf-color-picker').on('change', function() {
                refresh_border( $(this).closest(".bf-section-container"), 'all');
            });

            // When top border changed
            $('.bf-section-container .single-border.border-top select, .bf-section-container .single-border.border-top input').on('change', function(evt, params) {
                refresh_border( $(this).closest(".bf-section-container"), 'top');
            });

            // When right border changed
            $('.bf-section-container .single-border.border-right select, .bf-section-container .single-border.border-right input').on('change', function(evt, params) {
                refresh_border( $(this).closest(".bf-section-container"), 'right');
            });

            // When bottom border changed
            $('.bf-section-container .single-border.border-bottom select, .bf-section-container .single-border.border-bottom input').on('change', function(evt, params) {
                refresh_border( $(this).closest(".bf-section-container"), 'bottom');
            });

            // When left border changed
            $('.bf-section-container .single-border.border-left select, .bf-section-container .single-border.border-left input').on('change', function(evt, params) {
                refresh_border( $(this).closest(".bf-section-container"), 'left');
            });


            // Used for refreshing all styles of border field
            function refresh_border( $parent, type ){
                type = typeof type !== 'undefined' ? type : 'all';

                var $preview = $parent.find('.border-preview .preview-box');

                var _css = $preview.css([]);

                switch ( type ){

                    case 'top':
                        _css = refresh_border_field( $parent, 'top', _css);
                        break;

                    case 'right':
                        _css = refresh_border_field( $parent, 'right', _css);
                        break;

                    case 'bottom':
                        _css = refresh_border_field( $parent, 'bottom', _css);
                        break;

                    case 'left':
                        _css = refresh_border_field( $parent, 'left', _css);
                        break;

                    case 'all':
                        _css = refresh_border_field( $parent, 'all', _css);
                        break;

                    case 'first-time':

                        if( $parent.find('.single-border.border-all').length ){
                            _css = refresh_border_field( $parent, 'all', _css);
                        }else{

                            if( $parent.find('.single-border.border-top').length ){
                                _css = refresh_border_field( $parent, 'top', _css);
                            }

                            if( $parent.find('.single-border.border-right').length ){
                                _css = refresh_border_field( $parent, 'right', _css);
                            }

                            if( $parent.find('.single-border.border-bottom').length ){
                                _css = refresh_border_field( $parent, 'bottom', _css);
                            }

                            if( $parent.find('.single-border.border-left').length ){
                                _css = refresh_border_field( $parent, 'left', _css);
                            }

                        }

                }

//                $preview.attr('style', '');
                $preview.css( _css );
            }

            // Used for refreshing border preview
            function refresh_border_field( $parent, type, _css ){

                switch ( type ){

                    case  'top':
                        _css.borderTopWidth = $parent.find('.single-border.border-top .border-width input').val() +'px';
                        _css.borderTopStyle = $parent.find('.single-border.border-top select option:selected').val();
                        _css.borderTopColor = $parent.find('.single-border.border-top .bf-color-picker').val();
                        break;

                    case  'right':
                        _css.borderRightWidth = $parent.find('.single-border.border-right .border-width input').val() +'px';
                        _css.borderRightStyle = $parent.find('.single-border.border-right select option:selected').val();
                        _css.borderRightColor = $parent.find('.single-border.border-right .bf-color-picker').val();
                        break;

                    case  'bottom':
                        _css.borderBottomWidth = $parent.find('.single-border.border-bottom .border-width input').val() +'px';
                        _css.borderBottomStyle = $parent.find('.single-border.border-bottom select option:selected').val();
                        _css.borderBottomColor = $parent.find('.single-border.border-bottom .bf-color-picker').val();
                        break;

                    case  'left':
                        _css.borderLeftWidth = $parent.find('.single-border.border-left .border-width input').val() +'px';
                        _css.borderLeftStyle = $parent.find('.single-border.border-left select option:selected').val();
                        _css.borderLeftColor = $parent.find('.single-border.border-left .bf-color-picker').val();
                        break;

                    case 'all':
                        _css.borderWidth = $parent.find('.single-border.border-all .border-width input').val() +'px';
                        _css.borderStyle = $parent.find('.single-border.border-all select option:selected').val();
                        _css.borderColor = $parent.find('.single-border.border-all .bf-color-picker').val();
                        console.log(_css);
                        break;

                }

                return _css;

            }


        },
        // Setup Icon Select Field
        setup_field_icon_select: function(){

            // Open/Close Select Options Box
            $(document).on('click', '.bf-select-icon' ,function(e){
                var $_target = $(e.target);

                if ( $_target.hasClass('selected-option')  ) {
                    $(this).toggleClass('opened');
                    $(this).find('.better-icons-search-input').focus();
                    return;
                }
                if( $_target.hasClass('select-options') ){
                    $(this).toggleClass('opened');
                    return;
                }

                if( $_target.hasClass('icon-select-option') ){
                    return;
                }

            });

            // Close Everywhere clicked
            $(document).on('click',function( e ){
                if (e.target.class !== 'bf-select-icon' && $(e.target).parents('.bf-select-icon').length === 0) {
                    $('.bf-select-icon').each(function(){
                        if($(this).hasClass('opened')){
                            $(this).removeClass('opened');
                        }
                    });
                }
            });

            // Select
            $(document).on('click', '.bf-select-icon .icon-select-option' ,function(e){
                var $this = $(this);
                var $parent = $this.closest('.bf-select-icon');
                var $input = $parent.find('input[type=hidden]');
                var $selected_label = $parent.find('.selected-option');

                if($this.hasClass('selected')){
                    e.preventDefault();
                    $paren.toggleClass('opened');
                }
                else{
                    $input.val($this.data('value'));
                    $parent.find('.icon-select-option.selected').removeClass('selected');
                    $this.addClass('selected');
                    $selected_label.html( '<i class="fa '+ $this.data('value') +'"></i>' + $this.data('label'));
                    $parent.toggleClass('opened');
                    betterResetIconBoxAllFilters($parent);
                }
            });

            // Search
            $(document).on('keyup', '.bf-select-icon .better-icons-search-input' ,function(){
                var $this = $(this);
                var $search_text = $(this).val();
                var $parent = $this.closest('.bf-select-icon');
                var $options_list = $parent.find('.options-list');

                betterResetIconBoxCatFilters($parent);

                filterIconsList( $search_text , $options_list );
                return false;

            });

            // filters emelent with one text
            function filterIconsList( $search_text , $options_list ){
                if($search_text) {
                    $options_list.find("p:not(:Contains(" + $search_text + "))").parent().hide();
                    $options_list.find("p:Contains(" + $search_text + ")").parent().show();
                } else {
                    $options_list.find("li").show();
                }
            }

            // Category Filter
            $(document).on('click', '.better-icons-category-list li a' ,function(){
                var $this = $(this).parent();
                var $parent = $this.closest('.bf-select-icon');
                var $options_list = $parent.find('.options-list');

                // clear search input
                $parent.find('.better-icons-search-input').val('');

                if( $this.hasClass('selected') ){
                    return;
                }

                $parent.find('.better-icons-category-list li.selected').removeClass('selected');

                $this.addClass('selected');

                if( $this.attr('id') === 'cat-all' ){

                    $options_list.find('li').show();
                    $(this).closest('.bf-select-icon').find('.better-icons-search-input').val('');

                }else{

                    $options_list.find('li').each(function(){

                        if($(this).hasClass('default-option'))
                            return true;

                        var _cats = $(this).data('categories').split(' ');

                        if( _cats.indexOf($this.attr('id')) < 0){
                            $(this).hide();
                        }else{
                            $(this).show();
                        }

                    });

                }
                return false;

            });

            // used for clearing all filters
            function betterResetIconBoxAllFilters( $field ){
                $field.find('.better-icons-search-input').val('');
                filterIconsList( '' , $field );
                betterResetIconBoxCatFilters( $field );
            }

            // used for clearing just category filter
            function betterResetIconBoxCatFilters( $field ){
                $field.find('.better-icons-category-list li').removeClass('selected');
                $field.find('.better-icons-category-list li#cat-all').addClass('selected');
            }

            // Adds Custom scrollbar
            $('.bf-section-container .bf-select-icon .options-container').mCustomScrollbar({
                theme: 'dark',
                live: true
            });
        },


        // Setup Image Select Field
        setup_field_image_select: function(){

            // Open Close Select Options Box
            $(document).on('click', '.better-select-image' ,function(e){
                var $_target = $(e.target);

                if ( $_target.hasClass('selected-option')  ) {
                    // close All Other open boxes
                    $(this).toggleClass('opened');
                    return;
                }
                if( $_target.hasClass('select-options') ){
                    $(this).toggleClass('opened');
                    return;
                }

                if( $_target.hasClass('image-select-option') ){
                    return;
                }

            });

            // Close Everywhere clicked
            $(document).on('click',function( e ){
                if (e.target.class !== 'better-select-image' && $(e.target).parents('.better-select-image').length === 0) {
                    $('.better-select-image').each(function(){
                        if($(this).hasClass('opened')){
                            $(this).removeClass('opened');
                        }
                    });
                }
            });
            // Select when clicked
            $(document).on('click', '.better-select-image .image-select-option' ,function(e){
                var $this = $(this);
                var $parent = $this.closest('.better-select-image');
                var $input = $parent.find('input[type=hidden]');
                var $selected_label = $parent.find('.selected-option');

                if($this.hasClass('selected')){
                    e.preventDefault();
                    $parent.find('.select-options').toggleClass('opened');
                }
                else{
                    $input.val($this.data('value'));
                    $parent.find('.image-select-option.selected').removeClass('selected');
                    $this.addClass('selected');
                    $selected_label.html($this.data('label'));
                    $parent.toggleClass('opened');
                }
            });


        },


        // Setup input fields prefix and postfix
        setup_field_with_prefix_or_postfix: function(){

            $(document).on('click', '.bf-prefix-suffix', function(){
                $(this).siblings(':input').focus();
            })


            $('.bf-field-with-prefix-or-suffix').each(function(){
                if( $(this).find('.bf-prefix').exist() )
                    $(this).find(':input').css( 'padding-left', ( $(this).find('.bf-prefix').width() + 15 ) );
                if( $(this).find('.bf-suffix').exist() )
                    $(this).find(':input').css( 'padding-right', ( $(this).find('.bf-suffix').width() + 15 ) );
            });
        },

        // Setup Switchery check box field
        setup_field_switchery: function(){

            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            elems.forEach(function(html) {
                var switchery = new Switchery( html, {
                    secondaryColor : '#FF9090'
                });
            });

        },

        // Set up Slider filed
        setup_field_slider: function(){

            var selector = '';

            // prepare selector
            if( bf.type == 'widgets' ){
                selector = '#widgets-right .bf-slider-slider';
            }
            else{
                selector = '.bf-slider-slider';
            }

            $(selector).each( function(){

                var _min = $(this).data('min');
                var _max = $(this).data('max');
                var _step = $(this).data('step');
                var _animate = $(this).data('animation') == 'enable' ? true : false;
                var _dimension = ' ' + $(this).data('dimension');
                var _val = $(this).data('val');
                var _this = $(this);

                $(this).slider({
                    range: 'min',
                    animate: _animate,
                    value: _val,
                    step: _step,
                    min: _min,
                    max: _max,
                    slide: function( event, ui ) {
                        _this.find(".ui-slider-handle").html( '<span>'+ui.value+_dimension+'</span>' );
                        _this.siblings('.bf-slider-input').val( ui.value );
                    },
                    create: function( event, ui ) {
                        _this.find(".ui-slider-handle").html( '<span>'+_val+_dimension+'</span>' );
                    }
                });

                $(this).removeClass('not-prepared');

            });
        },

        // Setup color picker fields
        setup_field_color_picker: function(){

            $( '.bf-color-picker' ).each( function(){
                var _this = $(this);
                _this.ColorPicker({
                    color: _this.val(),
                    onShow: function (colpkr) {
                        $(colpkr).fadeIn();
                        return false;
                    },
                    onHide: function (colpkr) {
                        $(colpkr).fadeOut();
                        return false;
                    },
                    onChange: function (hsb, hex, rgb) {
                        _this.val('#' + hex);
                        _this.css({borderColor:'#'+hex});
                        _this.siblings().css({backgroundColor:'#'+hex});
                        _this.trigger('change');
                    }
                });
                _this.css({borderColor:_this.val()});
            });

            // Chnage on paste
            // TODO change form picker color value when new value pasted
            // TODO not trigers change when value changes
            $( '.bf-color-picker').on("change keyup paste click", function(){
                var _this = $(this);
                _this.css({borderColor:_this.val()});
                _this.siblings().css({backgroundColor:_this.val()});
                _this.trigger('change');
            })
        },

        // Setup Sorter field
        setup_field_sorter: function(){

            // Sorters in Widgets Page
            if( bf.type == 'widgets' ){
                $( "#widgets-right .bf-sorter-list" ).sortable({
                    placeholder: "placeholder-item",
                    cancel: "li.disable-item"
                });
            }
            // Sorters Everywhere
            else{
                $( ".bf-sorter-list" ).sortable({
                    placeholder: "placeholder-item",
                    cancel: "li.disable-item"
                });
            }

            $('.bf-section-container li input').on('change', function(evt, params) {

                if( typeof $(this).attr('checked') != "undefined" ){
                    $(this).closest('li').addClass('checked-item');
                }else{
                    $(this).closest('li').removeClass('checked-item');
                }

            });
        },

        // Setup image radio
        setup_field_image_radio: function(){

            $(document).on( 'click', '.bf-image-radio-option', function(e){

                // Uncheck all radio button for this field
                $(this).parent().find(':radio').prop("checked", false);

                // Checked the clicked radio button
                // Fires change for third party code usage
                $(this).find(':radio').prop("checked", true).change();

                // Remove checked class from field options and add checked class to clicked option
                $(this).siblings().removeClass('checked').end().addClass('checked');

                // Prevent Browser Default Bahavior
                e.preventDefault();
            });

        },

        // Setup Background Field
        setup_field_background_image: function(){

            $('body').on( 'click', '.bf-background-image-upload-btn' ,function() {

                var _this = $(this);

                var media_title = _this.attr('data-mediaTitle');
                var media_button = _this.attr('data-mediaButton');

                // prepare uploader
                var custom_uploader;

                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }

                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: media_title,
                    button: {
                        text: media_button
                    },
                    multiple: false,
                    library: { type : 'image'}
                });

                // when select pressed in uploader popup
                custom_uploader.on('select', function() {


                    var attachment = custom_uploader.state().get('selection').first().toJSON();

                    _this.siblings('.bf-background-image-preview').find("img").attr( "src", attachment.url );

                    _this.siblings('.bf-background-image-input').val( attachment.url );

                    _this.siblings('.bf-background-image-preview').show(200);
                    _this.siblings('.bf-background-image-uploader-select').show(200);
                    _this.siblings('.bf-background-image-remove-btn').show(200);


                });

                // open media poup
                custom_uploader.open();

                return false;
            });
            $('body').on( 'click', '.bf-background-image-remove-btn' ,function() {
                var _this = $(this);


                _this.siblings('.bf-background-image-input').val( '' );

                // hide remove button, select and preview
                _this.hide( 200 );
                _this.siblings('.bf-background-image-uploader-select').hide( 200 );
                _this.siblings('.bf-background-image-preview').hide( 200 );

            });
        },

        // Setup Date Picker Field
        setup_field_date_picker: function(){

            $('.bf-date-picker-input').each( function(){

                var _date_format = $(this).data('date-format');
                $(this).datepicker({ dateFormat: _date_format });

            });


        },

        // Setup Image Checkbox field
        setup_field_image_checkbox: function(){

            // Image Checkbox Codes
            $(document).on( 'click', '.bf-image-checkbox-option', function(e){
                var _this = $(this);
                var _checkbox = _this.find(':checkbox');

                // If checkbox is check uncheck it and remove checked class from it

                if ( _checkbox.is(':checked') ) {
                    _checkbox.prop( 'checked', false );
                    _this.removeClass('checked');
                }
                else {
                    _checkbox.prop( 'checked', true );
                    _this.addClass('checked');
                }

                // Prevent Browser Default Bahavior
                e.preventDefault();
            });

            $('.is-sortable .bf-controls-image_checkbox-option').sortable({
                helper: 'clone',
                revert: true,
                forcePlaceholderSize: true,
                opacity: 0.5
            });

        },

        // Setup Media Uploader Field
        setup_field_media_uploader: function(){

            $('body').on( 'click', '.bf-media-upload-btn' ,function() {
                var _this = $(this);
                var custom_uploader;
                var media_title = _this.attr('data-mediaTitle');
                var media_button = _this.attr('data-mediaButton');
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: _this.data('mediatitle'),
                    button: {
                        text: _this.data('buttontext')
                    },
                    multiple: false
                });
                custom_uploader.on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    _this.siblings(':input').val( attachment.url );
                    custom_uploader.state().get('selection').each( function(i,o){
                    });
                });
                custom_uploader.open();
                return false;
            });

        },

        // Setup Media Image upload field
        setup_field_media_image: function(){

            $('body').on( 'click', '.bf-media-image-upload-btn' ,function() {
                var _this = $(this);

                var custom_uploader;

                var media_title = _this.attr('data-mediaTitle');
                var media_button = _this.attr('data-mediaButton');

                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }

                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: _this.data('mediatitle'),
                    button: {
                        text: _this.data('buttontext')
                    },
                    multiple: false,
                    library: { type : 'image'}
                });

                custom_uploader.on('select', function() {

                    var attachment = custom_uploader.state().get('selection').first().toJSON();

                    _this.siblings(':input').val( attachment.url );

                    _this.siblings('.bf-media-image-remove-btn').show();
                    _this.siblings('.bf-media-image-preview').find('img').attr( 'src', attachment.url );
                    _this.siblings('.bf-media-image-preview').show();

                });

                custom_uploader.open();

                return false;
            });

            $('body').on( 'click', '.bf-media-image-remove-btn' ,function() {
                var _this = $(this);

                _this.siblings('.bf-media-image-input').val( '' );

                // hide remove button, select and preview
                _this.hide();
                _this.siblings('.bf-media-image-preview').hide();

            });

        },

        // Setup Ajax Select Field
        setup_field_ajax_select: function(){

            // TODO : Vahid Shit! Refactor this

            function bf_ajax_generate_options_object( _that ){
                var _object_ = {};
                _object_.preloader 	    = _that.siblings('.preloader');
                _object_.static_parent  = _that.closest('.bf-ajax_select-field-container');
                _object_.field_controls = _that.closest('.bf-ajax_select-field-container');
                _object_.controls_box   = _that.siblings('.bf-ajax-suggest-controls');
                _object_.hidden_field   = _that.siblings('input[type=hidden]');
                _object_.result_box	    = _that.siblings('.bf-ajax-suggest-search-results');
                _object_._this	    	= _that;
                return _object_;
            };

            var bf_ajax_input_timeOut  = null;

            var bf_ajax_input_interval = 850;

            $(document).on( 'keyup', '.bf-ajax-suggest-input', function(e){

                var _this   =   $(e.target),
                    _s      =   bf_ajax_generate_options_object( _this );

                _this.appendHTML = function( html ){
                    _s.result_box.append(html);
                };

                _this.removeResults = function(){
                    _s.result_box.find('li').remove();
                };

                _this.generateResultItems = function( json ){

                    var result = '';

                    $.each( $.parseJSON(json), function(i,o){
                        result += '<li class="ui-state-default" data-id="'+i+'">'+o+'<span class="del">x</span></li>';
                    });

                    return result;
                };

                _this.get = function( key, callback ){

                    var is_repeater = _this.parent().is('.bf-repeater-controls-option'),
                        form_data   = {
                            action 		: 'bf_ajax',
                            reqID  	 	: 'ajax_field',
                            type	 	: bf.type,
                            field_ID 	: _s.hidden_field.attr('name'),
                            nonce 	 	: bf.nonce,
                            key   	    : key,
                            is_repeater : is_repeater ? 1 : 0,
                            callback    : _s.hidden_field.data('callback'),
                            exclude     : _s.hidden_field.val()
                        },
                        result;

                    if( is_repeater )
                        form_data.repeater_id = _this.closest('.bf-nonrepeater-section').data('id');

                    $.ajax({
                        type	 : 'POST',
                        dataType : 'html',
                        url		 : bf.bf_ajax_url,
                        data	 : form_data,
                        success  : function(data, textStatus, XMLHttpRequest){
                            callback(data);
                        },
                        error: function(MLHttpRequest, textStatus, errorThrown){
                            callback(false);
                        }
                    });
                };

                clearTimeout( bf_ajax_input_timeOut );

                bf_ajax_input_timeOut = setTimeout(function() {

                    _s.preloader.fadeIn();

                    _this.get( _this[0].value, function(data){

                        _s.preloader.fadeOut();

                        if( data === false ){
                            alert( 'Something Wrong Happend!' );
                            return;
                        }

                        _s.controls_box.sortable({

                            update: function(event, ui){
                                var _this = ui.item, value = '', _s_ = bf_ajax_generate_options_object( _this.parent().siblings('.bf-ajax-suggest-input') );

                                _s_.controls_box.find('li:not(".ui-sortable-placeholder")').each( function(){
                                    value += $(this).data('id') + ','
                                });

                                _s_.hidden_field.val( value.replace( ',,', ',' ).replace( /^,+/ ,'' ).replace( /,+$/, '' ) );
                            }

                        });

                        if( data == -1 ){
                            return;
                        }

                        _this.removeResults(); // Remove Current Results

                        var HTML = _this.generateResultItems( data ); // Generate HTML tags from JSON

                        _this.appendHTML( HTML ); // Append The HTMLs

                        _s.result_box.fadeIn();

                    })

                }, bf_ajax_input_interval);
            });

            $(document).on( 'blur', '.bf-ajax-suggest-input', function(){

                var _s = bf_ajax_generate_options_object($(this));

                _s.result_box.fadeOut();

            });

            $(document).on( 'focus', '.bf-ajax-suggest-input', function(){

                var _s = bf_ajax_generate_options_object($(this));

                if( _s.result_box.find('li').size() > 0 )
                    _s.result_box.fadeIn();

            });

            $(document).on( 'click', '.bf-ajax-suggest-search-results li', function(e){
                var _this   = $( e.target ),
                    _s      = bf_ajax_generate_options_object( _this.parent().siblings('.bf-ajax-suggest-input') );

                _s.result_box.fadeOut();

                if( _s.controls_box.find('li[data-id="'+_this.data('id')+'"]').exist() )
                    return true;

                var value = _s.hidden_field.val() === undefined ? [] : _s.hidden_field.val().split(',');

                value.push( _this.data('id') );

                _s.controls_box.append( e.target.outerHTML );

                _s.hidden_field.val($.array_unique( value ).join(',').replace(',,',',').replace(/^,+/,'').replace(/,+$/,''));

                $(this).remove();

                return false;

            });

            $(document).on( 'click', '.bf-ajax-suggest-controls li .del', function(e){

                if( confirm('Are You Sure?') ){
                    var _new,
                        _this = $(e.target).parent(),
                        _array,
                        ID = _this.data('id'),
                        _s = bf_ajax_generate_options_object( _this.parent().siblings('.bf-ajax-suggest-input') );

                    _this.remove();

                    _array = _s.hidden_field.val().split(',');

                    _new = $.grep( _array, function(value) {
                        return value != ID;
                    });

                    _s.hidden_field.val( _new.join( ',' ).replace( ',,', ',' ).replace( /^,+/, '' ).replace( /,+$/, '' ) );
                }
            });

            $('.bf-ajax-suggest-controls').sortable({
                update: function(event, ui){
                    var _this   =   ui.item,
                        value   =   '',
                        _s_     =   bf_ajax_generate_options_object( _this.parent().siblings('.bf-ajax-suggest-input') );

                    _s_.controls_box.find('li:not(".ui-sortable-placeholder")').each( function(){
                        value += $(this).data('id') + ','
                    });

                    _s_.hidden_field.val( value.replace( ',,', ',' ).replace( /^,+/ ,'' ).replace( /,+$/, '' ) );

                }
            });

        }





    };

})(jQuery);

// load when ready
jQuery(function($) {

    Better_Framework.init();

});


/**
 * Plugins and 3rd Party Libraries
 */

jQuery(function($) {
    $.unserialize = function(serializedString){
        var str = decodeURI(serializedString);
        var pairs = str.split('&');
        var obj = {}, p, idx, val;
        for (var i=0, n=pairs.length; i < n; i++) {
            p = pairs[i].split('=');
            idx = p[0];

            if (idx.indexOf("[]") == (idx.length - 2)) {
                // Eh um vetor
                var ind = idx.substring(0, idx.length-2)
                if (obj[ind] === undefined) {
                    obj[ind] = [];
                }
                obj[ind].push(p[1]);
            }
            else {
                obj[idx] = p[1];
            }
        }
        return obj;
    };
});


(function(d){d.fn.redirect=function(a,b,c){void 0!==c?(c=c.toUpperCase(),"GET"!=c&&(c="POST")):c="POST";if(void 0===b||!1==b)b=d().parse_url(a),a=b.url,b=b.params;var e=d("<form></form");e.attr("method",c);e.attr("action",a);for(var f in b)a=d("<input />"),a.attr("type","hidden"),a.attr("name",f),a.attr("value",b[f]),a.appendTo(e);d("body").append(e);e.submit()};d.fn.parse_url=function(a){if(-1==a.indexOf("?"))return{url:a,params:{}};var b=a.split("?"),a=b[0],c={},b=b[1].split("&"),e={},d;for(d in b){var g= b[d].split("=");e[g[0]]=g[1]}c.url=a;c.params=e;return c}})(jQuery);

(function($) {
    String.prototype.sprintf = function(format){
        var formatted = this;
        for (var i = 0; i < arguments.length; i++) {
            var regexp = new RegExp('%'+i, 'gi');
            formatted = formatted.replace(regexp, arguments[i]);
        }
        return formatted;
    };
})(jQuery);// Custom Plugins

(function($) {
    $.array_unique = function (inputArr) {
        // Removes duplicate values from array
        var key = '',
            tmp_arr2 = [],
            val = '';

        var __array_search = function (needle, haystack) {
            var fkey = '';
            for (fkey in haystack) {
                if (haystack.hasOwnProperty(fkey)) {
                    if ((haystack[fkey] + '') === (needle + '')) {
                        return fkey;
                    }
                }
            }
            return false;
        };

        for (key in inputArr) {
            if (inputArr.hasOwnProperty(key)) {
                val = inputArr[key];
                if (false === __array_search(val, tmp_arr2)) {
                    tmp_arr2[key] = val;
                }
            }
        }

        return tmp_arr2;
    };

    $.removeFromArray = function(arr) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax= arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }

    // Custom Serializer
    $.fn.bf_serialize = function() {
        var toReturn	= [];
        var els		 = $(this).find(':input').get();
        $.each(els, function() {
            if (
                this.name &&
                    !this.disabled &&
                    (
                        $(this).is(':checkbox') ||
                            /select|textarea/i.test( this.nodeName ) ||
                            /text|hidden|password/i.test( this.type ))
                )
            {
                var val = $(this).val();
                if( $(this).is(':checkbox') ){
                    if( $(this).is(':checked') ) {
                        val = '1';
                    } else{
                        val = '0';
                    }
                }
                toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
            }

        });
        return toReturn.join("&").replace(/%20/g, "+");
    }

    // Elemnt Exist Check Plugin
    $.fn.exist = function() {
        return this.size() > 0;
    }
})(jQuery);

// Update query string : http://stackoverflow.com/questions/5999118/add-or-update-query-string-parameter
function UpdateQueryString(key, value, url) {
    if (!url) url = window.location.href;
    var re = new RegExp("([?|&])" + key + "=.*?(&|#|$)(.*)", "gi");

    if (re.test(url)) {
        if (typeof value !== 'undefined' && value !== null)
            return url.replace(re, '$1' + key + "=" + value + '$2$3');
        else {
            var hash = url.split('#');
            url = hash[0].replace(re, '$1$3').replace(/(&|\?)$/, '');
            if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                url += '#' + hash[1];
            return url;
        }
    }
    else {
        if (typeof value !== 'undefined' && value !== null) {
            var separator = url.indexOf('?') !== -1 ? '&' : '?',
                hash = url.split('#');
            url = hash[0] + separator + key + '=' + value;
            if (typeof hash[1] !== 'undefined' && hash[1] !== null)
                url += '#' + hash[1];
            return url;
        }
        else
            return url;
    }
}


// res : http://stackoverflow.com/questions/1766299/make-search-input-to-filter-through-list-jquery
// custom css expression for a case-insensitive contains()
(function($) {
    jQuery.expr[':'].Contains = function(a,i,m){
        return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
    };
})(jQuery);
