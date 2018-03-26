(function($){

    var poll = {

        settings : {
            'poll_api'          : null
        },

        init: function (options){

            /** Loads settings */
            this.loadSettings(options);

            /** Loads events */
            this.events();
        },

        main : {
            forms : {
                mainForm : {
                    clickEvent: function(e) {
                        e.preventDefault();
                        $('.validation-text').remove();
                        $('.poll-error').removeClass('poll-error');
                        var data = {};
                        var errors = {};
                        var parent = $(this).closest('#poll-test');
                        data.name = parent.find('[name="name"]').val();
                        data.email = parent.find('[name="email"]').val();
                        data.phone = parent.find('[name="phone"]').val();
                        data.birth_year = parent.find('[name="birth_year"]').find(":selected").val();
                        data.city = parent.find('[name="city"]').val();
                        var names = data.name.split(' ');
                        if(data.name.length < 1){
                            errors.name = "Моля, попълнете полето име";
                        }else if (names.length != 2 || names[0].length < 2 || names[1].length < 2) {
                            errors.name = "Моля, въведете и двете си имена";
                        }
                        var email_regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        if(data.email.length < 1){
                            errors.email = "Моля, попълнете полето имейл";
                        } else if(!email_regex.test(data.email)){
                            errors.email = "Моля, въведете валиден имейл адрес";
                        }
                        if(data.phone.length < 1){
                            errors.phone = "Моля, попълнете полето телефон";
                        }
                        if(!$.isNumeric(data.birth_year)){
                            errors.birth_year = "Моля, изберете година на раждане";
                        }
                        if(data.city.length < 1){
                            errors.city = "Моля, попълнете полето град"
                        }
                        var error_len = $.map(errors, function(n, i) { return i; }).length;

                        if(error_len < 1) {
                            if ('#poll-step-1') {
                                $('#poll-test')
                                    .attr('hidden', true)
                                    .hide();

                                $('#poll-step-1')
                                    .removeAttr('hidden')
                                    .show();
                            }
                        }
                        else {
                            var html = '';
                            $.each(errors,function(key,value){
                                html = '<div class="validation-text">'+value+'</span>';
                                parent.find("[name="+key+"]").addClass('poll-error').closest('label').after(html);
                            });
                        }
                    }
                },
                miniForm : {
                    clickEvent: function(e) {
                        e.preventDefault();
                        var id = $(this).data('id');
                        var id_next = id + 1;
                        var html = '';
                        var answers_selected = $(this).closest('#poll-step-'+id).find('.test-form-body').find('.answer-selected');
                        $(this).closest('.test-form').find('.validation-text').remove();

                        if(answers_selected.length < 1){
                            html = '<div class="validation-text">Моля, изберете отговор</span>';
                            $(this).closest('.test-form').find('.test-form-title').append(html);
                        }
                        else if(answers_selected.length > 1){
                            html = '<div class="validation-text">Не може да изберете повече от един отговор</span>';
                            $(this).closest('.test-form').find('.test-form-title').append(html);
                        }
                        else {
                            if($('#poll-step-'+id_next).length > 0){
                                $('#poll-step-'+id)
                                    .attr('hidden', true)
                                    .hide();

                                $('#poll-step-'+id_next)
                                    .removeAttr('hidden')
                                    .show();
                            }
                        }
                    }
                },
                selectAnswer : {
                    clickEvent: function(e) {
                        e.preventDefault();
                        if($(this).hasClass('answer-selected')) $(this).removeClass('answer-selected');
                        else $(this).addClass('answer-selected');
                    }
                },
                submitPoll : {
                    clickEvent: function(e) {
                        e.preventDefault();
                        var data = {};
                        var id = $(this).data('id');

                        var parent = $('#poll-test');
                        data.zing_poll_name = parent.find('[name="name"]').val();
                        data.zing_poll_email = parent.find('[name="email"]').val();
                        data.zing_poll_phone = parent.find('[name="phone"]').val();
                        data.zing_poll_birth_year = parent.find('[name="birth_year"]').find(":selected").val();
                        data.zing_poll_city = parent.find('[name="city"]').val();
                        data.zing_poll_website = document.referrer;
                        data.zing_poll_questions = {};
                        var answers = {};
                        var temp = {};
                        var i = 0;
                        var positive_answers = 0;
                        $('.answer-selected').each(function(key,obj){
                            temp = {};
                            temp['id'] = $(obj).data('id');
                            temp['answer'] = $(obj).data('answer');
                            if($(obj).data('answer') == 'yes') positive_answers++;
                            answers[i] = temp;
                            i++;
                        });
                        data.zing_poll_positive_answers = positive_answers;
                        data.zing_poll_questions = answers;
                        $.ajax({url: '/poll/api/answer',
                            type: 'post',
                            async: true,
                            dataType: "json",
                            data: data,
                            cache: false,
                            success: function(response){
                                if(response.success != undefined && response.success == true){
                                    $('#poll-step-'+id)
                                        .attr('hidden', true)
                                        .hide();

                                    if(positive_answers > 0) {
                                        $('#poll-final-step-yes')
                                            .removeAttr('hidden')
                                            .show();
                                    }
                                    else {
                                        $('#poll-final-step-no')
                                            .removeAttr('hidden')
                                            .show();
                                    }

                                    if(document.referrer !== null) window.open('http://fonio.bg', '_blank');
                                }
                            }
                        });
                    }
                }
            }
        },

        /**Event initializer
         *
         * Here you must put all your events
         */
        events: function(){
            /** Tabs */
            $(document).on('click', '.js-begin-test', this.main.forms.mainForm.clickEvent);
            $(document).on('click', '.js-next-question', this.main.forms.miniForm.clickEvent);
            $(document).on('click', '.js-answer', this.main.forms.selectAnswer.clickEvent);
            $(document).one('click', '.js-last-question', this.main.forms.submitPoll.clickEvent);
        },

        /** Initializing file box settings */
        loadSettings : function(options) {
            this.settings = $.extend(this.settings, options);
        }
    };

    poll.init({
    });

}(jQuery));
