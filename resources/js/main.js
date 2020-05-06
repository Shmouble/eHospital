var FullCalendar = require('@fullcalendar/core');
var FullCalendarDayGrid = require('@fullcalendar/daygrid');


require('./fullCalendarExtension');
require('jquery-timepicker/jquery.timepicker.js');
window.FullCalendar = FullCalendar;
window.FullCalendarDayGrid = FullCalendarDayGrid;
        
var path = $(location).attr('pathname');
var x = $(location).attr('hostname');

var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: [ 'dayGrid' ],
    defaultView: 'dayGridMonth',
});

calendar.render();

$('#calendar').fullCalendarExtension({
    eventsUrl: 'http://' + x + '/api' + path + '/schedule',
});

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('input.timepicker').timepicker({
        timeFormat: 'HH:mm',
        minTime: '07:00',
        maxTime: '21:00',
    });
    $('#load').hide(); 
    // Заполнение формы редактирования инфо о докторе данными
    $(document).on('click', '#editPencil', function(e) {
        $.ajax({
            url: path + '/edit',
            method: 'get',
            success: function (data) {
                for (var param in data) { 
                    $('[name="' + param +'"]').val(data[param]);     
                }
            }
        });
    });
    // Передача даты в форму
    $(document).on('click', '.editBtn', function(e) {
        var date = $(this).attr('data-date');
        $('#date').val(date);
    });
    // Сохранение информации о докторе
    $('#editDocForm').on('submit', function (e) {
        e.preventDefault();
        
        $.ajax({
            url: path,
            method: 'put',
            data:  $('#editDocForm').serialize(),
            success: function (data) {
                $("#docName").replaceWith(data.name);
                $("#docEducation").text('Образование:' + data.education);
                $("#docExperience").text('Опыт работы:' + data.experience);
                $('#editDocModal').modal('hide');
                $('#editDocForm').trigger("reset");
            }
        });     
    }); 
    // Сохранение аватара
    $('#editImgForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        
        $.ajax({
            url: path + '/image',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function () {
                $('#image').hide();  
                $('[for=image]').hide();  
                $('#load').show();  
            },
            success: function(data) { 
                $('#docImg').replaceWith('<img class="img-thumbnail" id="docImg" src="http://' + x + '/storage/' + data + '">');                
                $('#editImgModal').modal('hide');
                $('#image').show();  
                $('[for=image]').show();  
                $('#load').hide();  
                $('#editImgForm').trigger("reset");
            }
        });     
    });
    // Сохранение расписания
    $('#addEventForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $('#addEventForm').serializeArray();
        
        $.ajax({
            url: '/api' + path + '/schedule',
            method: 'post',
            data: formData ,
            success: function (data) {
               $('[data-date="' + formData[3].value + '"] a').replaceWith('<a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable">' +
                    '<div class="fc-content">' +
                    '<span class="fc-time">' + formData[1].value + '-' + formData[2].value + '</span>' +
                    '<span class="fc-title">' + '  Приемов:' + formData[0].value +'</span>' +
                    '</div>' +
                    '</a>');
                $('#addEventModal').modal('hide');
                $('#addEventForm').trigger("reset");
            }
        });     
    }); 
});