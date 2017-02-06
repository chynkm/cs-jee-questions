$(function() {
    APP.main.init();
});

var APP = APP || {};

APP.main = {
    init: function () {
        this.errorBlock();
        this.selectType();
        this.questionRequired();
    },

    errorBlock: function () {
        // Highlight error fields if error is present
        if($(".error-block").length) {
            $(".error-block").closest(".form-group").addClass("has-error");
        }
    },

    selectType: function() {
        $(document).on('click', '.input_type', function(){
            if($(this).val() == "text") {
                $(this).parents('.form-group').find('.text_area').removeClass('hidden');
                $(this).parents('.form-group').find('.file_upload').addClass('hidden');
            } else {
                $(this).parents('.form-group').find('.file_upload').removeClass('hidden');
                $(this).parents('.form-group').find('.text_area').addClass('hidden');
            }
        });
    },

    flashMessage: function(status, message) {
        if(status == "success") {
            $('#success_alert').html(message).removeClass('hidden');
        } else {
            $('#danger_alert').html(message).removeClass('hidden');
        }
    },

    imageSelect: function(names) {
        $(function(){
            var parsedNames = JSON.parse(names);
            $.each(parsedNames, function( index, value ) {
                $(":radio[name="+value+"][value=image]").prop("checked", true).trigger("click");
            });
        });
    },

    questionRequired: function() {
        $(document).on('click', '.saveForm', function(e){
            $('#danger_alert').addClass('hidden').empty();
            var html = '';
            if($('#question_image').val() == '' && $('#question').val() == '' && $('#question_image_url').length == 0) {
                html += "The <strong>Question</strong> field is required. </br/>";
            }
            if($('#answer_a_image').val() == '' && $('#answer_a').val() == '' && $('#answer_a_image_url').length == 0) {
                html += "The <strong>option A</strong> field is required. </br/>";
            }
            if($('#answer_b_image').val() == '' && $('#answer_b').val() == '' && $('#answer_b_image_url').length == 0) {
                html += "The <strong>option B</strong> field is required. </br/>";
            }
            if($('#answer_c_image').val() == '' && $('#answer_c').val() == '' && $('#answer_c_image_url').length == 0) {
                html += "The <strong>option C</strong> field is required. </br/>";
            }
            if($('#answer_d_image').val() == '' && $('#answer_d').val() == '' && $('#answer_d_image_url').length == 0) {
                html += "The <strong>option D</strong> field is required. </br/>";
            }
            if(!$('.exam_type_radio').is(':checked')) {
                html += "The <strong>Exam</strong> type field is required.<br/>";
            }
            if(!$('.complexity_radio').is(':checked')) {
                html += "The <strong>Complexity</strong> field is required.<br/>";
            }
            if(!$('.subject').is(':checked')) {
                html += "The <strong>Subject</strong> field is required.<br/>";
            }
            if(!$('.answer_radio').is(':checked')) {
                html += "The <strong>Key</strong> field is required.<br/>";
            }
            if(html != '') {
                $('#danger_alert').html(html).removeClass('hidden');
                $('html, body').scrollTop(50);
                e.preventDefault();
                return false;
            }
        });
    },
}