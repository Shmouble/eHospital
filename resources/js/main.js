var isRoot = false;
var FullCalendar = require('@fullcalendar/core');
var FullCalendarDayGrid = require('@fullcalendar/daygrid');

require('./fullCalendarExtension');
require('jquery-timepicker/jquery.timepicker.js');

window.FullCalendar = FullCalendar;
window.FullCalendarDayGrid = FullCalendarDayGrid;
        
var path = $(location).attr('pathname');
var x = $(location).attr('hostname');

var calendarEl = document.getElementById('calendar');
if (calendarEl){
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'dayGrid' ],
        defaultView: 'dayGridMonth',
    });

    calendar.render();
    
    var eventsUrl = '';
    
    if(isRoot){
       eventsUrl = 'http://' + x + '/api' + path + '/schedule'; 
    } else {
       eventsUrl = 'http://' + x + '/api' + path + '/numberoffreetickets';  
    }

    $('#calendar').fullCalendarExtension({
        eventsUrl: eventsUrl,
    });
}

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
    // Передача даты и названия шапки в форму создания расписания
    $(document).on('click', '.editBtn', function(e) {
        var date = $(this).attr('data-date');
        $('#addEventModal h4').text('Добавить расписание');
        $('#date').val(date);
        $('#event-update').attr('data-action', 'create');
        $('#addEventForm').trigger("reset");
        if ($('.btn.delete')){
            $('.btn.delete').remove();
        }
    });
    //Отображение талонов доктора за конкретный день
    $(document).on('click', '#openTickets', function(e) {
        var date = $(this).attr('data-date');
        var id = $(this).attr('data-id');
        $('tbody.tickets').empty();
        $('#classModalLabel').text(date);
        $.ajax({
            url: '/api/schedule/' + id + '/doctorstickets',
            method: 'get',
            success: function (data) {
                debugger;
                for (var param in data) { 
                    $('tbody.tickets').append('<tr><td>' + data[param].number + '</td><td>' + data[param].time.substr(0,5) + '</td><td>' + data[param].name + ' ' + data[param].surname + '</td></tr>' ); 
                }
            }
        });
    });
    // Заполнение формы редатирования расписания
    $(document).on('click', '.fc-day-grid-event[data-target="#addEventModal"]', function(e) {
        var date = $(this).parent().attr('data-date');
        var id = $(this).attr('id');
        $('#addEventModal h4').text('Изменить расписание');
        $('#event-update').attr('data-action', 'update');
        $('#event-update').after('<button type="button" class="btn btn-danger delete" data-date="' + date + '"data-id="' + id + '">Удалить</button>');
        $('#date').val(date);
        $('#schedule_id').val(id);
        
        $.ajax({
            url: '/api' + path + '/schedule/' + id + '/edit',
            method: 'get',
            success: function (data) {
                var startArray = data.start.split(' ');
                var endArray = data.end.split(' ');
                var startDate = startArray[0];
                data.startTime = startArray[1].substr(0, 5);
                data.endTime = endArray[1].substr(0, 5);
                    $('[name="start"]').val(data.startTime);     
                    $('[name="end"]').val(data.endTime);     
                    $('[name="num_tickets"]').val(data.num_tickets);        
            }
        }); 
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
    // Добавление нового доктора
    $('#addDocForm').on('submit', function (e) {
        e.preventDefault();
        
        $.ajax({
            url: 'http://' + x + '/doctor',
            method: 'post',
            data:  $('#addDocForm').serialize(),
            success: function (data) {
                $(".row").append('<div class="col-sm-3" data-id="' + data.id + '"><div class="card"><img class="card-img-top" src="http://' + x + '/storage/storage/avatar.jpg" alt="Doctor image"><div class="card-body"><h5 class="card-title">' + data.name + '</h5><p class="card-text">' + data.education + '</p><p class="card-text">' + data.experience + '</p><a href="/doctor/' + data.id + '" class="btn btn-secondary">Подробнее</a><button type="button" id="deleteBtn" data-id="' + data.id + '" class="close deleteBtn" data-toggle="modal" data-target="#deleteModal">Удалить</button></div></div></div>');
                
                $('#addDocModal').modal('hide');
                $('#addDocForm').trigger("reset");
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
        var action = $('#event-update').attr('data-action');
        var id = $('#schedule_id').val();
        if (action == "create"){
            var url = '/api' + path + '/schedule';
            var method = 'post';
        } else if (action == "update"){
            url = '/api' + path + '/schedule/' + id;
            method = 'put';
        }
        $.ajax({
            url: url,
            method: method,
            data: formData ,
            success: function (data) {
                $('[data-date="' + formData[3].value + '"] a').replaceWith('<a id="' + data.id + '" class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable" data-toggle="modal" data-target="#addEventModal">' +
                    '<div class="fc-content">' +
                    '<span class="fc-time">' + formData[1].value + '-' + formData[2].value + '</span>' +
                    '<span class="fc-title">' + '  Приемов:' + data.num_tickets +'</span>' +
                    '</div>' +
                    '</a>');
                $('#addEventModal').modal('hide');
                $('#addEventForm').trigger("reset");
            }
        });      
    });
    // Подтверждение удаления доктора
    $(document).on('click', '#deleteBtn', function(e) {
        var id = $(this).data('id');
        $('.confirm').attr('data-id', id);
    });
    // Удаления заказанного талона
    $(document).on('click', '#deleteTickets', function(e) {
        var id = $(this).data('id');
        bootbox.confirm("Вы уверены что хотите отказаться от талона?", function(result){ 
            if (result) {
               $.ajax({
                    url: 'http://' + x + 'api/ticket/' + id,
                    type: 'delete',
                    success: function (data) {
                        if(data){
                            $('tr#' + id).remove();
                        }
                    }
                });   
            }
        });
    });
    // Вывод талонов для заказа
    $(document).on('click', '.freeTick', function(e) {
        var id = $(this).data('id');
        var date = $(this).parent().data('date');
        $('#freetickets').empty();
        $.ajax({
            url: 'http://' + x + '/api/schedule/' + id + '/freetickets',
            type: 'get',
            success: function (tickData) {
                for (var number in tickData) {
                    $('#freeTickModal .modal-title').text(date);
                    $('#freetickets').append('<tr><td>' + number + '</td><td>' + tickData[number] + '</td><td>' + '<a class="btn btn-outline-dark orderTick" href="#" data-scheduleid=' + id + ' role="button">Заказать</a></td></tr>' ); 
                }      
            }
        });
    });
    // Заказ талонов
    $(document).on('click', '.orderTick', function(e) {
        e.preventDefault();
        var time = $(this).parent().prev().text();
        var number = $(this).parent().prev().prev().text();
        var id = $(this).data('scheduleid');
        var date = $('#freeTickModal .modal-title').text();
        var freeTickets = $('[data-date="' + date +'"].fc-widget-content .fc-time').text();
        $.ajax({
            url: 'http://' + x + '/api/schedule/' + id + '/store',
            type: 'post',
            data: { number: number,
                    time: time
                  },
            success: function (data) {
                $('#freeTickModal').modal('hide');
                $('[data-date="' + date +'"].fc-widget-content .fc-time').text(freeTickets-1);
                bootbox.alert({
                    message: "Талон успешно заказан!",
                    backdrop: true
                });
            }
        });   
    });
    //Удаление доктора
    $(document).on('click', '.confirm', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        $.ajax({
            url: 'http://' + x + '/doctor/' + id,
            type: 'delete',
            success: function (data) {
                $('.col-sm-3[data-id="' + id + '"]').remove();
                $('#deleteModal').modal('hide');
            }
        });   
    });
    // Удаление расписания
    $(document).on('click', '.delete.btn', function(e) {
    
        e.preventDefault();

        var id = $(this).data('id');
        var date = $(this).data('date');
        var button = $(this);
        if ( confirm('Вы уверены, что хотите удалить расписание?') ) {
            $.ajax({
                url: '/api' + path + '/schedule/' + id,
                type: 'delete',
                success: function (data) {
                    $('#addEventModal').modal('hide');
                    $('[data-date="' + date + '"] a').replaceWith('<a class="btn btn-outline-dark editBtn" href="#" role="button" data-toggle="modal" data-target="#addEventModal" data-date="' + date + '">Edit</a>'
                    );
                }
            });
        }
    });
    
    //Добавление новости
    $('#addNewsForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: 'news/add',
            method: 'post',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#newsHolder").prepend('<div class="oneNews" data-id="' + data.id + '">' +
                    '<h4 class="newsTitle">' + data.news_title + '</h4>' +
                    '<p class="newsDate">' + makeDate(data.date) + '</p>' +
                    '<p class="newsDescription">' + data.news_description + '</p>' +
                    '<div class="newsImage">' +
                    '<img src="' + 'storage/' + data.news_image + '" alt="News image">' +
                    '</div>' +
                    '<p class="newsText">' + data.news_text.substring(0, 300) + '...' +  '</p>' +
                    '<a href="' + 'news/read/' + data.id + '" class="btn btn-secondary newsButton">Подробнее</a>' +
                    '</div>'
                );

                $('#addNewsModal').modal('hide');
            }
        })
    });

    function makeDate(currentDate){
        currentDate = currentDate.substr(0, 10);
        let arrayDate = currentDate.split('-');
        currentDate = arrayDate[2] + '.' + arrayDate[1] + '.' + arrayDate[0];

        return currentDate;
    }
});