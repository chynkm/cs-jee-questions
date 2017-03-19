$(function() {
    APP.main.init();
});

var APP = APP || {};

APP.main = {
    editors: {},

    init: function () {
        this.errorBlock();
        this.questionRequired();
        this.deleteQuestion();
        this.deleteImage();
        this.numOfQuestions();
    },

    errorBlock: function () {
        // Highlight error fields if error is present
        if($(".error-block").length) {
            $(".error-block").closest(".form-group").addClass("has-error");
        }
    },

    flashMessage: function(status, message) {
        if(status == "success") {
            $('#success_alert').html(message).removeClass('hidden');
        } else {
            $('#danger_alert').html(message).removeClass('hidden');
        }
    },

    questionRequired: function() {
        var self = this;
        $(document).on('click', '.saveForm', function(e){
            $('#danger_alert').addClass('hidden').empty();
            var html = '';
            if($('#exam_type').val() == '') {
                html += "The <strong>Exam</strong> type field is required.<br/>";
            }
            if($('#complexity').val() == '') {
                html += "The <strong>Complexity</strong> field is required.<br/>";
            }
            if($('#subject').val() == '') {
                html += "The <strong>Subject</strong> field is required.<br/>";
            }
            if($('#type_of_question').val() == '') {
                html += "The <strong>Type of Question</strong> field is required.<br/>";
            }
            if($('#question_image').val() == '' && self.editors['question'] != null && self.editors['question'].getData() == '' && $('#question_image_url').length == 0) {
                html += "The <strong>Question</strong> field is required. </br/>";
            }
            if($('#answer_a_image').val() == '' && self.editors['answer_a'] != null && self.editors['answer_a'].getData() == '' && $('#answer_a_image_url').length == 0) {
                html += "The <strong>option A</strong> field is required. </br/>";
            }
            if($('#answer_b_image').val() == '' && self.editors['answer_b'] != null && self.editors['answer_b'].getData() == '' && $('#answer_b_image_url').length == 0) {
                html += "The <strong>option B</strong> field is required. </br/>";
            }
            if($('#answer_c_image').val() == '' && self.editors['answer_c'] != null && self.editors['answer_c'].getData() == '' && $('#answer_c_image_url').length == 0) {
                html += "The <strong>option C</strong> field is required. </br/>";
            }
            if($('#answer_d_image').val() == '' && self.editors['answer_d'] != null && self.editors['answer_d'].getData() == '' && $('#answer_d_image_url').length == 0) {
                html += "The <strong>option D</strong> field is required. </br/>";
            }
            if($('#answer').val() == '') {
                html += "The <strong>Key</strong> field is required.<br/>";
            }
            if($('#type_of_question').val() == 1 && ['A', 'B', 'C', 'D'].indexOf($('#answer').val().toUpperCase()) == -1){
                html += "The <strong>Key</strong> field value should be A, B, C or D.<br/>";
            }
            if(html != '') {
                $('#danger_alert').html(html).removeClass('hidden');
                $('html, body').scrollTop(50);
                e.preventDefault();
                return false;
            }
        });
    },

    initializeEditor: function() {
        var self = this;
        ['question', 'answer_a',  'answer_b',  'answer_c',  'answer_d', 'comments'].forEach(function(item){
            self.editors[item] = self.createEditor(item);
        });

        if ( CKEDITOR.env.ie && CKEDITOR.env.version == 8 ) {
            document.getElementById( 'ie8-warning' ).className = 'tip alert';
        }
    },

    createEditor: function(id) {
        CKEDITOR.plugins.addExternal( 'kekule', '/js/kekule/', 'plugin.js' );
        var html = '';
        return CKEDITOR.replace( id, { customConfig: '/js/config.js' }, html );
    },

    removeEditor: function(id) {
        this.editors[id].destroy();
        this.editors[id] = null;
    },

    deleteQuestion: function(id) {
        $('.delete_question').click(function() {
            if(confirm('Do you want to delete the question?')) {
                $target = $(this).closest('tr');
                $.get( 'delete_question.php?id=' + $(this).data('id'), function( data ) {
                    if(data) {
                        $target.addClass('danger').slideUp('slow', function () {
                            $target.remove();
                        });
                    }
                });
            }
        });
    },

    deleteImage: function() {
        $('.delete_image').click(function() {
            if(confirm('Do you want to delete the image?')) {
                $target = $(this).closest('.image_blk');
                $.get( 'delete_image.php?id=' + $('#question_id').val() + '&column=' + $(this).data('column'), function( data ) {
                    if(data) {
                        $target.remove();
                    }
                });
            }
        });
    },

    numOfQuestions: function() {
        $('#num_of_questions').on('keyup, change', function() {
            if (isNaN($(this).val())) {
                $(this).val('');
            }
        });
    },

}