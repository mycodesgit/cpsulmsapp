$(function () {
    $('#adtopic').validate({
        rules: {
            topicname: {
                required: true,
            },
            filedocs: {
                required: true,
            },
        },
        messages: {
            topicname: {
                required: "Please enter topic",
            },
            filedocs: {
                required: "Upload File",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-12, .form-group').append(error);        
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});