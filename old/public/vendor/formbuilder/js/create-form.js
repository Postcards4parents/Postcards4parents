jQuery(function() {
    $('#visibility').change(function(e) {
        e.preventDefault()
        var ref = $(this)

        if (ref.val() == "" || ref.val() == 'PUBLIC') {
            $('#allows_edit_DIV').hide()
        } else {
            $('#allows_edit_DIV').slideDown()
            $('#allows_edit').val('0')
        }
    });

    // create the form editor
    var fbEditor = $(document.getElementById('fb-editor'))
    var formBuilder
    var fbOptions = {
        dataType: 'json',
        formData: window._form_builder_content ? window._form_builder_content : '',
        controlOrder: [
            'header',
            'paragraph',
            'text',
            'textarea',
            'select',
            'number',
            'date',
            'autocomplete',
            'file',
        ],
        disableFields: [
            'button', 'autocomplete', 'file', 'header', 'radio-group'
            // buttons are not needed since we are the one handling the submission
        ], // field types that should not be shown
        disabledAttrs: [
            // 'access',
        ],
        typeUserDisabledAttrs: {
            'file': [
                'multiple',
                'subtype',
            ],
            'checkbox-group': [
                'other',
            ],
        },
        showActionButtons: false, // show the actions buttons at the bottom
        disabledActionButtons: ['data'], // get rid of the 'getData' button
        sortableControls: false, // allow users to re-order the controls to their liking
        editOnAdd: false,
        fieldRemoveWarn: false,
        roles: window.FormBuilder.form_roles || {},
        notify: {
            error: function(message) {
                return swal('Error', message, 'error')
            },
            success: function(message) {
                return swal('Success', message, 'success')
            },
            warning: function(message) {
                return swal('Warning', message, 'warning');
            }
        },
        layoutTemplates: {
            help: function(helpText) {
                return $('<div/>')
                    .addClass('help')
                    .append(helpText);
            },
            label: function(label, data) {

                // cheeky styling
                return $('<label class="bright" style="margin-top:15px;"/>')
                    .attr('for', data.id)
                    .append(label);
            }
        },


        onSave: function() {
            // var formData = formBuilder.formData
            // console.log(formData)
        },
    }

    formBuilder = fbEditor.formBuilder(fbOptions)

    var fbClearBtn = $('.fb-clear-btn')
    var fbShowDataBtn = $('.fb-showdata-btn')
    var fbSaveBtn = $('.fb-save-btn')

    // setup the buttons to respond to save and clear
    fbClearBtn.click(function(e) {
        e.preventDefault()

        if (!formBuilder.actions.getData().length) return

        sConfirm("Are you sure you want to clear all fields from the form?", function() {
            formBuilder.actions.clearFields()
        })
    });

    fbShowDataBtn.click(function(e) {
        e.preventDefault()
        formBuilder.actions.showData()
    });

    fbSaveBtn.click(function(e) {
        e.preventDefault()

        var form = $('#createFormForm')

        // make sure the form is valid
        if (!form.parsley().validate()) return

        // make sure the form builder is not empty
        if (!formBuilder.actions.getData().length) {
            swal({
                title: "Error",
                text: "The form builder cannot be empty",
                icon: 'error',
            })
            return
        }

        // ask for confirmation
        sConfirm("Save this form definition?", function() {
            fbSaveBtn.attr('disabled', 'disabled');
            fbClearBtn.attr('disabled', 'disabled');

            var formBuilderJSONData = formBuilder.actions.getData('json')
                // console.log(formBuilderJSONData)
                // var formBuilderArrayData = formBuilder.actions.getData()
                // console.log(formBuilderArrayData)

            var postData = {
                name: $('#name').val(),
                visibility: $('#visibility').val(),
                allows_edit: $('#allows_edit').val(),
                form_builder_json: formBuilderJSONData,
                _token: window.FormBuilder.csrfToken
            }

            var method = form.data('formMethod') ? 'PUT' : 'POST'
            jQuery.ajax({
                    url: form.attr('action'),
                    processData: true,
                    data: postData,
                    method: method,
                    cache: false,
                })
                .then(function(response) {
                    fbSaveBtn.removeAttr('disabled')
                    fbClearBtn.removeAttr('disabled')

                    if (response.success) {
                        // the form has been created 
                        // send the user to the form index page
                        swal({
                            title: "Form Saved!",
                            text: response.details || '',
                            icon: 'success',
                        })

                        setTimeout(function() {
                            //window.location = response.dest

                        }, 1500);

                        // clear out the form
                        // $('#name').val('')
                        // $('#visibility').val('')
                        // $('#allows_edit').val('0')
                    } else {
                        swal({
                            title: "Error",
                            text: response.details || 'Error',
                            icon: 'error',
                        })
                    }
                }, function(error) {
                    handleAjaxError(error)

                    fbSaveBtn.removeAttr('disabled')
                    fbClearBtn.removeAttr('disabled')
                })
        })

    })

    // show the clear and save buttons
    $('#fb-editor-footer').slideDown();

    //disabled fields

    setTimeout(function() {
        var str = $('.form-wrap')[0].id;
        var for_id = str.split("-");
        var form_idd = for_id[1];

        var wh_str1 = 'del_frmb' + '-' + form_idd + '-' + 'fld' + '-' + '1';
        var wh_str2 = 'del_frmb' + '-' + form_idd + '-' + 'fld' + '-' + '2';
        var wh_str3 = 'del_frmb' + '-' + form_idd + '-' + 'fld' + '-' + '3';
        var wh_str4 = 'del_frmb' + '-' + form_idd + '-' + 'fld' + '-' + '9';
        document.getElementById(wh_str1).disabled = true;
        document.getElementById(wh_str2).disabled = true;
        document.getElementById(wh_str3).disabled = true;
        document.getElementById(wh_str4).disabled = true;
        //document.getElementsByClassName("icon-file")[0].disabled = true;


        //del_frmb - 1569506390535 - fld - 1
        //document.getElementById("del_frmb-1569504976726-fld-1").disabled = true;
    }, 1000);



});