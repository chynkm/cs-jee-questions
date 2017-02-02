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

    questionRequired: function() {
        $(document).on('click', '.saveForm', function(e){
            if($('#question_image').val() == '' && $('#question').val() == '') {
                alert('The Question field is required.');
                e.preventDefault();
                return false;
            }
            if($('#subject').val() == '') {
                alert('The Subject field is required.');
                e.preventDefault();
                return false;
            }
        });
    },
}