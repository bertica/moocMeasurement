jQuery(document).ready(function ($) {
    //Esta variable es necesaria por problemas con las comillas más adelante
    var ind = "Percentage of participants who didn't start the course";

    $("#newmooc a").click(function () {
        $("div#moocmeasurement_comparation").removeClass("muestra");
        $("div#moocmeasurement_comparation").addClass("oculto");
        $("div#moocmeasurement_newmooc").removeClass("oculto");
        $("div#moocmeasurement_newmooc").addClass("muestra");
    });

    $("#button_home button").click(function () {
        $("div#moocmeasurement_newmooc").removeClass("muestra");
        $("div#moocmeasurement_newmooc").addClass("oculto");
        $("div#moocmeasurement_comparation").removeClass("oculto");
        $("div#moocmeasurement_comparation").addClass("muestra");
        document.getElementById('mooc_measurement_form').reset();
        $('div#moocmeasurement_newmooc form input').removeClass("errorClass");
        $('div#moocmeasurement_newmooc form select').removeClass("errorClass");
        validator.resetForm();
        
    });
    
    $("button[type='reset']").click(function(){
        $('div#moocmeasurement_newmooc form input').removeClass("errorClass");
        $('div#moocmeasurement_newmooc form select').removeClass("errorClass");
        document.getElementById('mooc_measurement_form').reset();
        validator.resetForm();
    });

    $("div#moocmeasurement_newmooc form input#no_date").change(function () {
        if ($(this).prop('checked')) {
            $("div#moocmeasurement_newmooc form input#start_date").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#end_date").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#start_date").prop('value', '');
            $("div#moocmeasurement_newmooc form input#end_date").prop('value', '');
        }
        if (!$(this).prop('checked')) {
            $("div#moocmeasurement_newmooc form input#start_date").prop('disabled', false);
            $("div#moocmeasurement_newmooc form input#end_date").prop('disabled', false);
        }
    });

    $("div#moocmeasurement_newmooc form input#license_none").change(function () {
        if ($(this).prop('checked')) {
            $("div#moocmeasurement_newmooc form input#license_download").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#license_copy").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#license_distribute").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#license_display").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#license_perform").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#license_derivative").prop('disabled', true);
        }
        if (!$(this).prop('checked')) {
            $("div#moocmeasurement_newmooc form input#license_download").prop('disabled', false);
            $("div#moocmeasurement_newmooc form input#license_copy").prop('disabled', false);
            $("div#moocmeasurement_newmooc form input#license_distribute").prop('disabled', false);
            $("div#moocmeasurement_newmooc form input#license_display").prop('disabled', false);
            $("div#moocmeasurement_newmooc form input#license_perform").prop('disabled', false);
            $("div#moocmeasurement_newmooc form input#license_derivative").prop('disabled', false);
        }
    });

    $("div#moocmeasurement_newmooc form input#final_certificate").change(function () {
        /*if( $(this).val()=="yes" ){
         $("div#moocmeasurement_newmooc form input#number_certificates").prop('disabled',false);
         }*/
        if ($(this).val() === "no") {
            $("div#moocmeasurement_newmooc form input#number_certificates").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#number_certificates").val('');
        } else {
            $("div#moocmeasurement_newmooc form input#number_certificates").prop('disabled', false);
        }
    });

    $("div#moocmeasurement_newmooc form input#official_final_certificate").change(function () {
        /*if( $(this).val()=="yes" ){
         $("div#moocmeasurement_newmooc form input#number_certificates").prop('disabled',false);
         }*/
        if ($(this).val() === "no") {
            $("div#moocmeasurement_newmooc form input#number_official_certificates").prop('disabled', true);
            $("div#moocmeasurement_newmooc form input#number_official_certificates").val('');
        } else {
            $("div#moocmeasurement_newmooc form input#number_official_certificates").prop('disabled', false);
        }
    });

    $("div#moocmeasurement_newmooc form input#start_date").change(function () {
        if ($("div#moocmeasurement_newmooc form input#end_date").val() !== '') {
            var ONE_WEEK = 1000 * 60 * 60 * 24 * 7;
            // Convert both dates to milliseconds
            var date1_ms = $("div#moocmeasurement_newmooc form input#end_date").val();
            var date2_ms = $("div#moocmeasurement_newmooc form input#start_date").val();
            // Calculate the difference in milliseconds
            var difference_ms = Math.abs(date1_ms - date2_ms);
            // Convert back to weeks and return hole weeks
            var weeks = Math.floor(difference_ms / ONE_WEEK);
            $("div#moocmeasurement_newmooc form input#duration").val(weeks);
        }
    });
    $("div#moocmeasurement_newmooc form input#end_date").change(function () {
        if ($("div#moocmeasurement_newmooc form input#start_date").val() !== '') {
            var ONE_WEEK = 1000 * 60 * 60 * 24 * 7;
            // Convert both dates to milliseconds
            var date1_ms = new Date($("div#moocmeasurement_newmooc form input#end_date").val());
            var date2_ms = new Date($("div#moocmeasurement_newmooc form input#start_date").val());
            // Calculate the difference in milliseconds
            var difference_ms = Math.abs(date1_ms - date2_ms);
            // Convert back to weeks and return hole weeks
            var weeks = Math.round(difference_ms / ONE_WEEK * 100) / 100;
            $("div#moocmeasurement_newmooc form input#duration").val(weeks);
        }
    });

    $("#course input[type='checkbox']").change(function () {
        if ($(this).prop('checked')) {
            $("input[name='total_course']").val(parseInt($("input[name='total_course']").val()) + 1);
        } else {
            $("input[name='total_course']").val(parseInt($("input[name='total_course']").val()) - 1);
        }
    });

    $("#online input[type='checkbox']").change(function () {
        if ($(this).prop('checked')) {
            $("input[name='total_online']").val(parseInt($("input[name='total_online']").val()) + 1);
        } else {
            $("input[name='total_online']").val(parseInt($("input[name='total_online']").val()) - 1);
        }
    });

    $("#open input[type='checkbox']").change(function () {
        if ($(this).prop('checked')) {
            $("input[name='total_open']").val(parseInt($("input[name='total_open']").val()) + 1);
        } else {
            $("input[name='total_open']").val(parseInt($("input[name='total_open']").val()) - 1);
        }
    });

    $("#massive input[type='checkbox']").change(function () {
        if ($(this).prop('checked')) {
            $("input[name='total_massive']").val(parseInt($("input[name='total_massive']").val()) + 1);
        } else {
            $("input[name='total_massive']").val(parseInt($("input[name='total_massive']").val()) - 1);
        }
    });

    $("#comparation_form input[name='type']").change(function () {
        var type = $(this).val();
        if (type === "basic") {
            $("#send_comparation input:checkbox[name='Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants who completed the course']").prop("checked", true);
            $('#send_comparation input:checkbox[name="' + ind + '"]').prop("checked", true);
            $("#send_comparation input:checkbox[name='Certificates issued/Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='License of resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Is the MOOC free?']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online tasks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Length of the course']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of tasks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of resources']").prop("checked", true);
            /**************/
            $("#send_comparation input:checkbox[name='Percentage of participants registered at the beginning']").prop("checked", false);
            $('#send_comparation input:checkbox[name="Percentage of participants registered from the second week"]').prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants with mandatory tasks completed']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Official certificates issued/Total participants']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants with all the tasks completed']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants with mark>=8.5']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of tasks without deadline']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Number videos by week']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of required tasks']").prop("checked", false);
            /***************/
            $("#send_comparation input:checkbox[name='Percentage of certificates by apprentice track']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of certificates by studio track']").prop("checked", false);
            $('#send_comparation input:checkbox[name="Percentage of certificates by studio practicum"]').prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active the entire course']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active the first week']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active the first and second week']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active first three weeks']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants who accessed to less than a half of the resources']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants who accessed to more than a half of the resources']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Posts published by participants']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Is the official certificate free?']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Average length of videos']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Type of assesments']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Has the MOOC a guide?']").prop("checked", false);
        }
        if (type === "intermediate") {
            $("#send_comparation input:checkbox[name='Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants who completed the course']").prop("checked", true);
            $('#send_comparation input:checkbox[name="' + ind + '"]').prop("checked", true);
            $("#send_comparation input:checkbox[name='Certificates issued/Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='License of resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Is the MOOC free?']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online tasks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Length of the course']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of tasks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of resources']").prop("checked", true);
            /**************/
            $("#send_comparation input:checkbox[name='Percentage of participants registered at the beginning']").prop("checked", true);
            $('#send_comparation input:checkbox[name="Percentage of participants registered from the second week"]').prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants with mandatory tasks completed']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Official certificates issued/Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants with all the tasks completed']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants with mark>=8.5']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of tasks without deadline']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number videos by week']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of required tasks']").prop("checked", true);
            /***************/
            $("#send_comparation input:checkbox[name='Percentage of certificates by apprentice track']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of certificates by studio track']").prop("checked", false);
            $('#send_comparation input:checkbox[name="Percentage of certificates by studio practicum"]').prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active the entire course']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active the first week']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active the first and second week']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants active first three weeks']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants who accessed to less than a half of the resources']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Percentage of participants who accessed to more than a half of the resources']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Posts published by participants']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Is the official certificate free?']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Average length of videos']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Type of assesments']").prop("checked", false);
            $("#send_comparation input:checkbox[name='Has the MOOC a guide?']").prop("checked", false);
        }
        if (type === "high") {
            $("#send_comparation input:checkbox[name='Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants who completed the course']").prop("checked", true);
            $('#send_comparation input:checkbox[name="' + ind + '"]').prop("checked", true);
            $("#send_comparation input:checkbox[name='Certificates issued/Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='License of resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Is the MOOC free?']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of online tasks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Length of the course']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of tasks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number of resources']").prop("checked", true);
            /**************/
            $("#send_comparation input:checkbox[name='Percentage of participants registered at the beginning']").prop("checked", true);
            $('#send_comparation input:checkbox[name="Percentage of participants registered from the second week"]').prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants with mandatory tasks completed']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Official certificates issued/Total participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants with all the tasks completed']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants with mark>=8.5']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of tasks without deadline']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Number videos by week']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of required tasks']").prop("checked", true);
            /***************/
            $("#send_comparation input:checkbox[name='Percentage of certificates by apprentice track']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of certificates by studio track']").prop("checked", true);
            $('#send_comparation input:checkbox[name="Percentage of certificates by studio practicum"]').prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants active the entire course']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants active the first week']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants active the first and second week']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants active first three weeks']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants who accessed to less than a half of the resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Percentage of participants who accessed to more than a half of the resources']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Posts published by participants']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Is the official certificate free?']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Average length of videos']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Type of assesments']").prop("checked", true);
            $("#send_comparation input:checkbox[name='Has the MOOC a guide?']").prop("checked", true);

        }

    });

    $("#institution").change(function () {
        if ($(this).val() === "include") {
            $("#div_new_institution").addClass("muestra").removeClass("oculto");
        } else {
            $("#div_new_institution").addClass("oculto").removeClass("muestra");
        }
    });
    $("#platform").change(function () {
        if ($(this).val() === "include") {
            $("#div_new_platform").addClass("muestra").removeClass("oculto");
        } else {
            $("#div_new_platform").addClass("oculto").removeClass("muestra");
        }
    });

    $.validator.addMethod('lessThan', function (value, element, param) {
        if (this.optional(element))
            return true;
        var i = parseInt(value);
        var j = parseInt($(param).val());
        return i <= j;
    }, "The value must be less or equal than {0}");

    $.validator.addMethod('formatLength', function (value, element) {
        if (this.optional(element))
            return true;
        var expresion = /^\d{2}:[0-5]\d:[0-5]\d$/;
        return expresion.test(value);
    });

    $.validator.addMethod('validValue', function (value) {
        return value !== 'Select one...';
    }, "Fill in the year, platform and insitution");

    var validator = $("div#moocmeasurement_newmooc form").validate({
        errorLabelContainer: "#errorBox",
        wrapper: "li",
        errorClass: "errorClass",
        onkeyup: false,
        onfocusout: false,
        onclick: false,
        rules: {
            name: "required",
            year: {
                validValue: true
            },
            platform: {
                validValue: true
            },
            institution: {
                validValue: true
            },
            total_p: {
                required: true,
                digits: true
            },
            total_completed: {
                required: true,
                digits: true,
                lessThan: '#total_p'
            },
            not_started: {
                required: true,
                digits: true,
                lessThan: '#total_p'
            },
            license_platform: {
                required: true
            },
            duration: {
                required: true,
                number: true
            },
            total_tasks: {
                required: true
            },
            required_tasks: {
                required: true,
                digits: true,
                lessThan: '#total_tasks'
            },
            final_certificate: {
                required: true
            },
            number_certificates: {
                required: function () {
                    return ($("input[name=final_certificate]:checked").val() === 'yes' && $("input#number_certificates").val() === "");
                },
                digits: true,
                lessThan: '#total_p'
            },
            official_final_certificate: {
                required: true
            },
            number_official_certificates: {
                required: function () {
                    return ($("input[name=official_final_certificate]:checked").val() === 'yes' && $("input#number_official_certificates").val() === "");
                },
                digits: true,
                lessThan: '#total_p'
            },
            number_videos_week: {
                required: true,
                digits: true
            },
            video_online: {
                required: true,
                digits: true,
                lessThan: '#video_total'
            },
            video_total: {
                required: true,
                digits: true
            },
            material_online: {
                required: true,
                digits: true,
                lessThan: '#reference_material_total'
            },
            reference_material_total: {
                required: true,
                digits: true
            }, /*
             social_assesment : {
             require_from_group: [1,".assesment_group"]
             },
             automatic_assesment : {
             require_from_group: [1,".assesment_group"]
             },
             authority_assesment : {
             require_from_group: [1,".assesment_group"]
             },*/
            license_download: {
                require_from_group: [1, ".license_group"]
            },
            license_copy: {
                require_from_group: [1, ".license_group"]
            },
            license_distribute: {
                require_from_group: [1, ".license_group"]
            },
            license_display: {
                require_from_group: [1, ".license_group"]
            },
            license_perform: {
                require_from_group: [1, ".license_group"]
            },
            license_derivative: {
                require_from_group: [1, ".license_group"]
            },
            license_none: {
                require_from_group: [1, ".license_group"]
            },
            start_date: {
                required: function () {
                    return !$("input:checkbox[name=no_date]").checked;
                }
            },
            end_date: {
                required: function () {
                    return !$("input:checkbox[name=no_date]").checked;
                }
            },
            no_date: {
                required: function () {
                    return ($("input#start_date").val() === '' && $("input#end_date").val() === '');
                }
            },
            participants_beginning: {
                lessThan: '#total_p'
            },
            participants_second_week: {
                lessThan: '#total_p'
            },
            participants_tasks_mandatory: {
                lessThan: '#total_p'
            },
            total_last_task: {
                lessThan: '#total_p'
            },
            participants_all_tasks: {
                lessThan: '#total_p'
            },
            participants_good_marks: {
                lessThan: '#total_p'
            },
            certificates_apprentice: {
                lessThan: '#number_certificates'
            },
            certificates_studio_track: {
                lessThan: '#number_certificates'
            },
            certificates_practicum: {
                lessThan: '#number_certificates'
            },
            participants_active_entire_course: {
                lessThan: '#total_p'
            },
            participants_active_first_week: {
                lessThan: '#total_p'
            },
            participants_active_first_second: {
                lessThan: '#total_p'
            },
            participants_active_three_weeks: {
                lessThan: '#total_p'
            },
            participants_less_materials: {
                lessThan: '#total_p'
            },
            participants_more_materials: {
                lessThan: '#total_p'
            },
            deadline_tasks: {
                lessThan: '#total_tasks',
                required: true
            },
            online_tasks: {
                lessThan: '#total_tasks',
                required: true
            },
            average_length_videos: {
                formatLength: true
            },
            new_platform: {
                required: function () {
                    return $("select[name=platform]").val() === 'include';
                }
            },
            new_institution: {
                required: function () {
                    return $("select[name=institution]").val() === 'include';
                }
            }
        },
        messages: {
            name: "Please fill in the name",
            total_p: {
                required: "Please fill in total number of participants"
            },
            total_completed: {
                required: "Please fill in number of participants who have completed it",
                lessThan: "The number of participants who completed must be less or equal than total participants"
            },
            not_started: {
                required: "Please fill in number of participants who haven't started it",
                lessThan: "The number of participants who didn't start must be less or equal than total participants"
            },
            platform: "Please fill in the platform",
            institution: "Please fill in the institution",
            license_platform: "Please fill in if platform is free license",
            required_tasks: {
                required: "Please fill in number of required tasks",
                digits: "Number of required tasks must be a number",
                lessThan: "The number of required tasks must be less or equal than total tasks"
            },
            total_tasks: {
                required: "Please fill in the number of tasks"
            },
            final_certificate: {
                required: "Please select if there is a certificate at the end of the MOOC"
            },
            official_final_certificate: {
                required: "Please select if there is an official certificate at the end of the MOOC"
            },
            number_videos_week: {
                required: "Please fill in the number of videos by week",
                digits: "Number of videos/week must be a number"
            },
            video_online: {
                required: "Please fill in total number of videos which are online",
                digits: "Number of videos online must be a number",
                lessThan: "The number of online videos must be less or equal than total videos"
            },
            video_total: {
                required: "Please fill in total number of videos in the MOOC",
                digits: "Number of videos in the MOOC must be a number"
            },
            material_online: {
                required: "Please fill in number of online materials in the MOOC",
                digits: "Number of online materials in the MOOC must be a number",
                lessThan: "The number of online resources must be less or equal than total resources"
            },
            reference_material_total: {
                required: "Please fill in total number of materials in the MOOC",
                digits: "Number of materials in the MOOC must be a number"
            }/*,
             social_assesment : {
             require_from_group: "At least one of type of assesment must be selected"
             },
             automatic_assesment : {
             require_from_group: "At least one of type of assesment must be selected"
             },
             authority_assesment : {
             require_from_group: "At least one of type of assesment must be selected"
             }*/,
            license_download: {
                require_from_group: "At least one of type of license must be selected"
            },
            license_copy: {
                require_from_group: "At least one of type of license must be selected"
            },
            license_distribute: {
                require_from_group: "At least one of type of license must be selected"
            },
            license_display: {
                require_from_group: "At least one of type of license must be selected"
            },
            license_perform: {
                require_from_group: "At least one of type of license must be selected"
            },
            license_derivative: {
                require_from_group: "At least one of type of license must be selected"
            },
            license_none: {
                require_from_group: "At least one of type of license must be selected"
            },
            start_date: {
                required: "If MOOC has no date select 'It has no date', in other case fill in the date"
            },
            end_date: {
                required: "If MOOC has no date select 'It has no date', in other case fill in the date"
            },
            no_date: {
                required: "If MOOC has no date select 'It has no date', in other case fill in the date"
            },
            duration: {
                required: "The duration of the MOOC is required"
            },
            number_certificates: {
                lessThan: "The number of certificates issued must be less or equal than total participants"
            },
            number_official_certificates: {
                lessThan: "The number of official certificates issued must be less or equal than total participants"
            },
            participants_beginning: {
                lessThan: "The number of participants registered from the beggining must be less or equal than total participants"
            },
            participants_second_week: {
                lessThan: "The number of participants registered from the second week must be less or equal than total participants"
            },
            participants_tasks_mandatory: {
                lessThan: "The number of participants with mandatory tasks must be less or equal than total participants"
            },
            total_last_task: {
                lessThan: "The number of participants who did the last task/exam must be less or equal than total participants"
            },
            participants_all_tasks: {
                lessThan: "The number of participants with all the tasks must be less or equal than total participants"
            },
            participants_good_marks: {
                lessThan: "The number of participants with good mark must be less or equal than total participants"
            },
            certificates_apprentice: {
                lessThan: "The number of certificates by apprentice track must be less or equal than total certificates"
            },
            certificates_studio_track: {
                lessThan: "The number of certificates by studio track must be less or equal than total certificates"
            },
            certificates_practicum: {
                lessThan: "The number of certificates by studio practicum must be less or equal than total certificates"
            },
            participants_active_entire_course: {
                lessThan: "The number of participants active the entire course must be less or equal than total participants"
            },
            participants_active_first_week: {
                lessThan: "The number of participants active the first week must be less or equal than total participants"
            },
            participants_active_first_second: {
                lessThan: "The number of participants active the first and second week must be less or equal than total participants"
            },
            participants_active_three_weeks: {
                lessThan: "The number of participants active the the three first week must be less or equal than total participants"
            },
            participants_less_materials: {
                lessThan: "The number of participants who accessed to less than half of the resources must be less or equal than total participants"
            },
            participants_more_materials: {
                lessThan: "The number of participants who accessed to more than half of the resources must be less or equal than total participants"
            },
            deadline_tasks: {
                lessThan: "The number of tasks with deadline must be less or equal than total tasks",
                required: "Please fill in the number of tasks with deadline"
            },
            online_tasks: {
                lessThan: "The number of online tasks must be less or equal than total tasks",
                required: "Please fill in the number of online tasks"
            },
            average_length_videos: {
                formatLength: "Average length of videos has an incorrect format"
            },
            new_platform: {
                required: "Please fill in the name of the new platform"
            },
            new_institution: {
                required: "Please fill in the name of the new institution"
            }
        },
        //perform an AJAX post to ajax.php
        submitHandler: function (form) {
            var $form = $(this);
            var $postData = {
                'name': $("form input[id=name]").val(),
                'description': $("form textarea[id=description]").val(),
                'topic': $("form select#topic").val(),
                'month': $("form select#month").val(),
                'year': $("form select#year").val(),
                'total_p': $("form input[id=total_p]").val(),
                'duration': $("form input[id=duration]").val(),
                'total_completed': $("form input[id=total_completed]").val(),
                'not_started': $("form input[id=not_started]").val(),
                'start_date': $("form input[id=start_date]").val(),
                'end_date': $("form input[id=end_date]").val(),
                'no_date': $("form input[id=no_date]").prop('checked'),
                'platform': $("form select#platform").val(),
                'new_platform': $("form input[id=new_platform]").val(),
                'institution': $("form select#institution").val(),
                'new_institution': $("form input[id=new_institution]").val(),
                'required_tasks': $("form input[id=required_tasks]").val(),
                'total_tasks': $("form input[id=total_tasks]").val(),
                'automatic_assesment': $("form input[id=automatic_assesment]").prop('checked'),
                'social_assesment': $("form input[id=social_assesment]").prop('checked'),
                'authority_assesment': $("form input[id=authority_assesment]").prop('checked'),
                'final_certificate': $("form input[id=final_certificate]").val(),
                'official_final_certificate': $("form input[id=official_final_certificate]").val(),
                'video_online': $("form input[id=video_online]").val(),
                'video_total': $("form input[id=video_total]").val(),
                'material_online': $("form input[id=material_online]").val(),
                'open_material': $("form input[id=open_material]").val(),
                'reference_material_total': $("form input[id=reference_material_total]").val(),
                'license_download': $("form input[id=license_download]").prop('checked'),
                'license_copy': $("form input[id=license_copy]").prop('checked'),
                'license_distribute': $("form input[id=license_distribute]").prop('checked'),
                'license_display': $("form input[id=license_display]").prop('checked'),
                'license_perform': $("form input[id=license_perform]").prop('checked'),
                'license_derivative': $("form input[id=license_derivative]").prop('checked'),
                'license_none': $("form input[id=license_none]").prop('checked'),
                'level_course': $("form input[id=level_course]").val(),
                'participants_beginning': $("form input[id=participants_beginning]").val(),
                'participants_second_week': $("form input[id=participants_second_week]").val(),
                'participants_tasks_mandatory': $("form input[id=participants_tasks_mandatory]").val(),
                'participants_all_tasks': $("form input[id=participants_all_tasks]").val(),
                'participants_good_marks': $("form input[id=participants_good_marks]").val(),
                'number_certificates': $("form input[id=number_certificates]").val(),
                "number_official_certificates": $("form input[id=number_official_certificates]").val(),
                'certificates_apprentice': $("form input[id=certificates_apprentice]").val(),
                'certificates_studio_track': $("form input[id=certificates_studio_track]").val(),
                'certificates_practicum': $("form input[id=certificates_practicum]").val(),
                'participants_active_entire_course': $("form input[id=participants_active_entire_course]").val(),
                'active_first_week': $("form input[id=active_first_week]").val(),
                'participants_active_first_second': $("form input[id=participants_active_first_second]").val(),
                'active_three_weeks': $("form input[id=active_three_weeks]").val(),
                'participants_less_materials': $("form input[id=participants_less_materials]").val(),
                'participants_more_materials': $("form input[id=participants_more_materials]").val(),
                'posts_published': $("form input[id=posts_published]").val(),
                'pl_secondary': $("form input[id=pl_secondary]").prop('checked'),
                'pl_preuniversity': $("form input[id=pl_preuniversity]").prop('checked'),
                'pl_university': $("form input[id=pl_university]").prop('checked'),
                'pl_master': $("form input[id=pl_master]").prop('checked'),
                'pl_doctoral': $("form input[id=pl_doctoral]").prop('checked'),
                'pl_none': $("form input[id=pl_none]").prop('checked'),
                'number_videos_week': $("form input[id=number_videos_week]").val(),
                'average_length_videos': $("form input[id=average_length_videos]").val(),
                'social': $("form input[id=social]").prop('checked'),
                'forum': $("form input[id=forum]").prop('checked'),
                'blog': $("form input[id=blog]").prop('checked'),
                'rss': $("form input[id=rss]").prop('checked'),
                'official_certificate_price': $("form input[name=official_certificate_price]").val(),
                'guide': $("form input[name=guide]").val(),
                'gratis': $("form input[name=gratis]").val(),
                'deadline': $("form input[name=deadline]").val(),
                'online_tasks': $("form input[id=online_tasks]").val(),
                'deadline_tasks': $("form input[id=deadline_tasks]").val(),
                'license_platform': $("form input[id=license_platform]").val()
            };
            request = $.ajax({
                url: '../wp-content/plugins/mooc-measurement/php/procesa_formulario.php',
                type: 'POST',
                data: $postData,
                success: function (data) {
                    console.log("MOOC saved");
                    $("#error").html("The MOOC has been saved").addClass("muestra").removeClass('oculto');
                    $('html, body').animate({
                        scrollTop: $("#error").offset().top
                    }, 1000);
                },
                error: function (data) {
                    console.log("ERROR");
                    $("#error").html("The following error occured: " + data).addClass("muestra").removeClass('oculto');
                    $('html, body').animate({
                        scrollTop: $("#error").offset().top
                    }, 1000);
                }
            });

            request.done(function (response, textStatus, jqXHR) {
                console.log("SUCCESS");
            });

            request.fail(function (jqXHR, textStatus, errorThrown) {
                // log the error to the console
                console.error(
                        "The following error occured: " + textStatus, errorThrown);
                $("#error").append("<br> The following error occured: " + textStatus).addClass("muestra");
                $('html, body').animate({
                    scrollTop: $("#error").offset().top
                }, 1000);
            });

            // callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {

            });
        }
    });

    $("div#moocmeasurement_newmooc button[name='send']").click(function () {
        $("div#moocmeasurement_newmooc form").submit();
    });

    /*
     $("div#moocmeasurement_comparation button[name='compare']").click(function(){
     $("div#moocmeasurement_comparation form").submit();
     });*/
});