jQuery(function() {
    var fbRenderOptions2 = {
        container: false,
        label: {
            noFormData: 'No form data.'
        },
        dataType: 'json',
        formData: window._form_builder_content ? window._form_builder_content : '',
        render: true,
        layoutTemplates: {
            default: function(field, label, help, data) {
                // help = $('<div/>')
                //     .addClass('helpme')
                //     .attr('id', 'row-' + data.id)
                //     .append(help);


                help = '';
                if (field.nodeName == 'DIV') {
                    label = label;
                } else if (field.nodeName == 'SELECT') {
                    console.log("field");

                    console.log(field);
                    field.childNodes[0].setAttribute('value', '');
                    // var se = field.find(":selected").text();
                    // console.log(se);
                    label = '';
                } else {
                    label = '';
                }

                //field = field.addClass('help');


                field.classList.remove("form-control");
                field.classList.add("txtInp");

                return $('<div/>').append(label, field, help);
            }
        },
        // layoutTemplates: {


        //     help: function(helpText) {
        //         return $('<div/>')
        //             .addClass('help')
        //             .append(helpText);
        //     },
        //     label: function(label, data) {

        //         // cheeky styling
        //         return '';
        //     },
        //     field: function(field) {
        //         console.log("field");
        //         console.log(field);

        //     }


        // }

    };

    var fbRenderOptions1 = {
        container: false,
        label: {
            noFormData: 'No form data.'
        },
        dataType: 'json',
        formData: window._form1_builder_content ? window._form1_builder_content : '',
        render: true,
        // layoutTemplates: {
        //     default: function(field, label, help, data) {
        //         help = $('<div/>')
        //             .addClass('helpme')
        //             .attr('id', 'row-' + data.id)
        //             .append(help);
        //         return $('<div/>').append(label, field, help);
        //     }
        // },
        // layoutTemplates: {
        //     help: function(helpText) {
        //         return $('<div/>')
        //             .addClass('help')
        //             .append(helpText);
        //     },
        //     label: function(label, data) {

        //         // cheeky styling
        //         return $('<label class="bright" style="margin-top:15px;"/>')
        //             .attr('for', data.id)
        //             .append(label);
        //     }
        // }
        layoutTemplates: {
            default: function(field, label, help, data) {

                console.log(field);

                var values = data.values;
                var value = '';
                var adInput = '';
                var adspan = '';
                var lab = '';
                field = '';

                var making = '';

                for (var i = 0; i < values.length; i++) {

                    value = values[i].label;
                    console.log(value);
                    making = "<label>" + value + "<input type='checkbox' class='cus' name='" + "checkname[]" + "' id='" + i + "'   />" + "<span class='checkmark'>" + "</span>" + "</label>";
                    // adInput = $("<input type='checkbox' />").addClass('cus');
                    // adspan = $('<span>').addClass('checkmark');
                    // field += $('<label>') + adInput + adspan + value;
                    field += making;
                    //console.log(making);
                }
                // field = $('<label>').append(adInput).append(adspan).append(value);
                console.log(field);

                //  field = $('<div>').addClass('checkmark').append(field);
                label = "";

                // help = $('<label/>')
                //     .addClass('helpme')
                //     .attr('id', 'row-' + data.id)
                //     .append(help);
                return $('<div/>').append(label, field, help);
            },

            // help: function(helpText) {
            //     return $('<div/>')
            //         .addClass('help')
            //         .append(helpText);
            // },
            // label: function(label, data) {

            //     // cheeky styling
            //     return '';
            // }
        }

    };






    $('#form2render').formRender(fbRenderOptions2);

    $('#form1render').formRender(fbRenderOptions1);




    // var checkbox = document.querySelector("input[name=checkname]");
    // checkbox.addEventListener('change', function() {
    //     if (this.checked) {
    //         alert('yes');
    //     } else {
    //         alert('no');
    //     }
    // });
    // var chk_arr =  document.getElementsByName("checkname[]");

    // $('.cus:checked').each(function() {
    //     alert($(this).val());
    // });
    // var yourArray = [];
    // $("input.cus").click(function() {
    //     // Loop all these checkboxes which are checked
    //     $("input.cus:checked").each(function(e) {
    //         var do2 = $(this);


    //         if (do2[0].checked == true) {

    //             //console.log(do2[0].id);
    //             //yourArray[] = do2[0].id;
    //             yourArray.push(do2[0].id);
    //         } else {
    //             yourArray.pop(do2[0].id);
    //         }


    //         // Use $(this).val() to get the Bike, Car etc.. value
    //     });
    //     //   var uniq = [...new Set(yourArray)];
    //     console.log(yourArray);
    // });


    // $("input:checkbox[name=checkname]:checked").each(function() {

    // });


    // $('#clickBtn2').on('click', function(e) {
    //     var chk_arr = document.getElementsByName("checkname[]");
    //     console.log(chk_arr);
    //     var selectArr = [];
    //     var allArr = [];
    //     chk_arr.forEach(function(e, index) {
    //         allArr[index] = e.id;
    //         if (e.checked == true) {
    //             selectArr[index] = e.id;
    //         }

    //     });
    //     selectArr = selectArr.filter(x => x != null);
    //     if (selectArr.length == 0) {
    //         toastr.error("Minimum selection one grade is required");

    //     } else {


    //         $('#PrevSelectData').val(JSON.stringify(selectArr));
    //         $('#PrevData').val(JSON.stringify(allArr));


    //         $('#dg3').hide();
    //         $('#dg4').show();

    //     }

    // });

    // $('#clickBtn3').on('click', function(e) {
    //     if ($('#form2')[0].checkValidity()) {

    //         var form_data = $('#form2').serializeArray();
    //         console.log(form_data);
    //         $("#form2Data").val(JSON.stringify(form_data));
    //         e.preventDefault();
    //         $('#dg4').hide();
    //         $('#dg5').show();
    //     } else {
    //         toastr.error("Please Fill All required Fields");

    //     }

    // });


    //console.log('goo');
    $('#checkbox-group-1568973475252-0').prop('checked', false);


    var checkbox = document.getElementById('checkbox-group-1568973475252-0');

    console.log(checkbox);
    if (checkbox.checked == false) {
        $('#text-1568973630291').hide();
        $('#select-1568973667002').hide();



    }

    checkbox.addEventListener('change', function() {
        $('#text-1568973630291').toggle();
        $('#select-1568973667002').toggle();

    });






});