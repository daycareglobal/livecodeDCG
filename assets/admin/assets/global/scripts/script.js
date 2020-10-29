jQuery(function($){

    // univaersal validation class
    $(document).find('.validate-me').each(function(){
        $(this).validate();
    });
    // $('.validate-me').validate();
    $('.tooltips').tooltip({
        placement: 'top'
    });

	// validate test string with . and _.
    $.validator.addMethod("nohtmlwithdotus", function(value, element) {
        return this.optional(element) || /^([a-zA-Z0-9._ ]+)$/.test(value);
    }, "No special characters are allowed!");

    // validate test string if it have double white spaces
    $.validator.addMethod("nodblspace", function(value, element) {
        return value.indexOf("  ") < 0; 
    }, "No double white spaces are allowed!");

    // valisate pass word for digit, special character and uppercase letter.
    $.validator.addMethod("passwordcheck", function(value) {
        return /^[A-Za-z0-9\d\=\!\-\@\.\_\*\<\>\{\}\(\)\:\;\'\"\,\.\-\~\`\#\$\%\^\&\+\\\/]*$/.test(value) // consists of only these
                && /[A-Z]/.test(value) // has a uppercase letter
                && /\d/.test(value) // has a digit
    },"Please enter minimum one special character, one digit and one uppercase letter.");

    // custom phone validation
    $.validator.addMethod("phone", function(value) {
        if(value == ''){
            return true;
        }
        return /^([\+][0-9]{1,3}[\ \.\-])?([\(]{1}[0-9]{2,6}[\)])?([0-9\ \.\-\/]{3,20})((x|ext|extension)[\ ]?[0-9]{1,4})?$/.test(value); // consists of only these
    },"Please enter a valid phone number.");

    /*$.validator.addMethod("lengthofimage",function(value, element){
        if(element.files.length > max_file_uploads){
            return false;
        }
        return true;
    },"Maximum files to upload are " + max_file_uploads);*/

    $.validator.addMethod("disablescripttag", function(value) {
        if(value == ''){
            return true;
        }

        if(value.indexOf('<script') >= 0){
            return false;
        }

        if(value.indexOf('</script>') >= 0){
            return false;
        }

        if(value.indexOf('/script') >= 0){
            return false;
        }

        if(value.indexOf('type="text/javascript"') >= 0){
            return false;
        }

        if(value.indexOf("type='text/javascript'") >= 0){
            return false;
        }
        return true;
    },"You are not allowed to insert script tag here.");


    // generate popup
        $('[data-toggle="popover"]').popover({
            html : true
        });

        // hide propover if another propover requested
        $(document).on('click', '[data-toggle="popover"]', function (e) {
            $('[data-toggle="popover"]').not(this).popover('hide');
        });

        // hide propover
        $(document).on('click', '.hide-propover', function(e){
            e.preventDefault();
            $('[data-toggle="popover"]').popover('hide');
        });

    // Delete multiple table records
        $(document).on('click', '.delete_records_by_select', function(){
            var is_checked = false;
            var this_el = $(this);
            $('.delete_records_by_select').each(function(){
                if($(this).is(':checked')){
                    is_checked = true;
                }
            });

            if(is_checked){
                this_el.closest('.portlet-body').find('.delete_selected_records').removeAttr('disabled');
                this_el.closest('.portlet-body').find('.delete_selected_records').removeClass('disabled');
            }
            else{
                this_el.closest('.portlet-body').find('.delete_selected_records').attr('disabled', 'disabled');
                this_el.closest('.portlet-body').find('.delete_selected_records').addClass('disabled');
            }
        });

    // make full td clickable
        $(document).on('click', '.delete_records_by_select_wrap', function(e){

                var target = $(e.target);
                if (target.is('input:checkbox')) return;

                $(this).find('input[type="checkbox"]').trigger('click');
            
        }); 

    // delete records seleted in table
        $(document).on('click', '.delete_selected_records', function(){
            var selected_ids = '';
            var clicked_el = $(this);
            clicked_el.closest('.portlet-body').find('.delete_records_by_select').each(function(){
                if($(this).is(':checked')){
                    selected_ids += $(this).val() + ',';
                }
            });

            if(selected_ids != ''){
                bootbox.confirm("Are you sure want to delete selected records?", function(result) {
                    // alert("Confirm result: "+result);
                    if(result){
                        // run ajax to delete records
                        var controller = clicked_el.attr('data-controller');
                        var action = clicked_el.attr('data-action');
                        var cms_type = clicked_el.attr('data-cms-type');
                        if(typeof cms_type == 'undefined'){
                            cms_type = '';
                        }

                        $.ajax({
                            url: site_url + 'admin/' + controller + '/' + action + '/' + cms_type,
                            method: 'POST',
                            dataType:'html',
                            data: {ids: selected_ids},
                            success: function(r){
                                if(r == 'ok'){
                                    location.reload(true);
                                }
                            }
                        });
                    }
                }); 
            }
            else{
                bootbox.alert("Please select any records first."); 
            }

        });

    // toggle all checkboes
        $(document).on("change",'.toggle_selected_checkboxes',function(e){
            //$(".checkbox1").prop('checked', $(this).prop("checked"));

            if($(this).prop("checked"))
            {
                $(this).closest('table').find('.delete_records_by_select').each(function(){
                    $(this).attr('checked','checked');
                    $(this).closest("span").addClass('checked');
                });
                // enable/disable toggle button
                $(this).closest('.portlet-body').find('.delete_selected_records').removeAttr('disabled');
                $(this).closest('.portlet-body').find('.delete_selected_records').removeClass('disabled');
            }
            else
            {
                $(this).closest('table').find('.delete_records_by_select').each(function(){
                    $(this).attr('checked',false);
                    $(this).closest("span").removeClass('checked');
                });
                // enable/disable toggle button
                $(this).closest('.portlet-body').find('.delete_selected_records').attr('disabled', 'disabled');
                $(this).closest('.portlet-body').find('.delete_selected_records').addClass('disabled');
            }
        });
});