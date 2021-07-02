jQuery(function() {
    var fbRenderOptions = {
        container: false,
        dataType: 'json',
        formData: window._form_builder_content ? window._form_builder_content : '',
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

    }

    $('#fb-render').formRender(fbRenderOptions)
})