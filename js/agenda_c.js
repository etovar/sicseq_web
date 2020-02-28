/*$(document).ready(function() 	{
        var calendar = $("#calendar").fullCalendar({  // assign calendar
				  header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listMonth'
				  },
				  selectable: true,
				  selectHelper: true,
				  select: function(start, end, allDay) {
					$('#fc_create').click();

					started = start;
					ended = end;

					$(".antosubmit").on("click", function() {
					  var title = $("#title").val();
					  if (end) {
						ended = end;
					  }

					  categoryClass = $("#event_type").val();

					  if (title) {
						calendar.fullCalendar('renderEvent', {
							title: title,
							start: started,
							end: end,
							allDay: allDay
						  },
						  true // make the event "stick"
						);
					  }

					  $('#title').val('');

					  calendar.fullCalendar('unselect');

					  $('.antoclose').click();

					  return false;
					});
				  },
				  eventClick: function(calEvent, jsEvent, view) {
					$('#fc_edit').click();
					$('#title2').val(calEvent.title);

					categoryClass = $("#event_type").val();

					$(".antosubmit2").on("click", function() {
					  calEvent.title = $("#title2").val();

					  calendar.fullCalendar('updateEvent', calEvent);
					  $('.antoclose2').click();
					});

					calendar.fullCalendar('unselect');
				  },
				  editable: true,

            events: 
				"agenda_d.php?view=1"  // request to load current events
				
			
				eventClick:  function(event, jsEvent, view) {  // when some one click on any event

                endtime = $.fullCalendar.moment(event.end).format("h:mm");

                starttime = $.fullCalendar.moment(event.start).format("dddd, MMMM Do YYYY, h:mm");

                var mywhen = starttime + " – " + endtime;

                $("#modalTitle").html(event.title);

                $("#modalWhen").text(mywhen);

                $("#eventID").val(event.id);

                $("#calendarModal").modal();

            },

            

            select: function(start, end, jsEvent) {  // click on empty time slot

                endtime = $.fullCalendar.moment(end).format("h:mm");

                starttime = $.fullCalendar.moment(start).format("dddd, MMMM Do YYYY, h:mm");

                var mywhen = starttime + " – " + endtime;

                start = moment(start).format();

                end = moment(end).format();

                $("#createEventModal #startTime").val(start);

                $("#createEventModal #endTime").val(end);

                $("#createEventModal #when").text(mywhen);

                $("#createEventModal").modal("toggle");

           },

           eventDrop: function(event, delta){ // event drag and drop

               $.ajax({

                   url: "agenda_d.php",

                   data: "action=update&title="+event.title+"&start="+moment(event.start).format()+"&end="+moment(event.end).format()+"&id="+event.id ,

                   type: "POST",

                   success: function(json) {
                   //alert(json);
                   }

               });

           },

           eventResize: function(event) {  // resize to increase or decrease time of event

               $.ajax({

                   url: "agenda_d.php",

                   data: "action=update&title="+event.title+"&start="+moment(event.start).format()+"&end="+moment(event.end).format()+"&id="+event.id,

                   type: "POST",

                   success: function(json) {

                       //alert(json);

                   }

               });

           }

        });

               

       $("#submitButton").on("click", function(e){ // add event submit

           // We don"t want this to act as a link so cancel the link action

           e.preventDefault();

           doSubmit(); // send to form submit function

       });

       

       $("#deleteButton").on("click", function(e){ // delete event clicked

           // We don"t want this to act as a link so cancel the link action

           e.preventDefault();

           doDelete(); //send data to delete function

       });

       

       function doDelete(){  // delete event 

           $("#calendarModal").modal("hide");

           var eventID = $("#eventID").val();

           $.ajax({

               url: "agenda_d.php",

               data: "action=delete&id="+eventID,

               type: "POST",

               success: function(json) {

                   if(json == 1)

                        $("#calendar").fullCalendar("removeEvents",eventID);

                   else
                   	return false;
               }

           });

       }

       function doSubmit(){ // add event

           $("#createEventModal").modal("hide");

           var title = $("#title").val();


           var startTime = $("#startTime").val();

           var endTime = $("#endTime").val();

           

           $.ajax({

               url: "agenda_d.php",

               data: "action=add&title="+title+"&start="+startTime+"&end="+endTime,

               type: "POST",

               success: function(json) {

                   $("#calendar").fullCalendar("renderEvent",

                   {

                       id: json.id,

                       title: title,

                       start: startTime,

                       end: endTime,

                   },

                   true);

               }

           });

           

       }

    });



/*
		    function  init_calendar() {
					
				if( typeof ($.fn.fullCalendar) === 'undefined'){ return; }
				//console.log('init_calendar');
					
				var date = new Date(),
					d = date.getDate(),
					m = date.getMonth(),
					y = date.getFullYear(),
					started,
					categoryClass;

				var calendar = $('#calendar').fullCalendar({
				  header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listMonth'
				  },
				  locale: 'es',
				  selectable: true,
				  selectHelper: true,
				  select: function(start, end, allDay) {
					$('#fc_create').click();

					started = start;
					ended = end;

					$(".antosubmit").on("click", function() {
					  var title = $("#title").val();
					  if (end) {
						ended = end;
					  }

					  categoryClass = $("#event_type").val();

					  if (title) {
						calendar.fullCalendar('renderEvent', {
							title: title,
							start: started,
							end: end,
							allDay: allDay
						  },
						  true // make the event "stick"
						);
					  }

					  $('#title').val('');

					  calendar.fullCalendar('unselect');

					  $('.antoclose').click();

					  return false;
					});
				  },
				  eventClick: function(calEvent, jsEvent, view) {
					$('#fc_edit').click();
					$('#title2').val(calEvent.title);

					categoryClass = $("#event_type").val();

					$(".antosubmit2").on("click", function() {
					  calEvent.title = $("#title2").val();

					  calendar.fullCalendar('updateEvent', calEvent);
					  $('.antoclose2').click();
					});

					calendar.fullCalendar('unselect');
				  },
				  editable: true,
				  events: [
				  {
					title: 'All Day Event',
					start: new Date(y, m, 1)
				  }, {
					title: 'Long Event',
					start: new Date(y, m, d - 5),
					end: new Date(y, m, d - 2)
				  }, {
					title: 'Meeting',
					start: new Date(y, m, d, 10, 30),
					allDay: false
				  }, {
					title: 'Lunch',
					start: new Date(y, m, d + 14, 12, 0),
					end: new Date(y, m, d, 14, 0),
					allDay: false
				  }, {
					title: 'Birthday Party',
					start: new Date(y, m, d + 1, 19, 0),
					end: new Date(y, m, d + 1, 22, 30),
					allDay: false
				  }, {
					title: 'Click for Google',
					start: new Date(y, m, 28),
					end: new Date(y, m, 29),
					url: 'http://google.com.xxxxx/'
				  },
				  ]
				});
				
			};
*/


$(document).ready(function(){
        var calendar = $("#calendar").fullCalendar({  // assign calendar
				  header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay,listMonth'
				  },
				  selectable: true,
				  selectHelper: true,
				  select: function(start, end, allDay) {
					$('#fc_create').click();

					started = start;
					ended = end;

					$(".antosubmit").on("click", function() {
					  var title = $("#title").val();
					  if (end) {
						ended = end;
					  }

					  categoryClass = $("#event_type").val();

					  if (title) {
						calendar.fullCalendar('renderEvent', {
							title: title,
							start: started,
							end: end,
							allDay: allDay
						  },
						  true // make the event "stick"
						);
					  }

					  $('#title').val('');

					  calendar.fullCalendar('unselect');

					  $('.antoclose').click();

					  return false;
					});
				  },
				  eventClick: function(calEvent, jsEvent, view) {
					$('#fc_edit').click();
					$('#title2').val(calEvent.title);

					categoryClass = $("#event_type").val();

					$(".antosubmit2").on("click", function() {
					  calEvent.title = $("#title2").val();

					  calendar.fullCalendar('updateEvent', calEvent);
					  $('.antoclose2').click();
					});

					calendar.fullCalendar('unselect');
				  },
				  editable: true,

           
			events:	[
			'agenda_d.php?view=1' // request to load current events 
			],
//[{ id: '2', title: 'Titulo 2', start: '2019-08-08', end: '2019-08-09' },{ id: '3', title: 'Titulo 3', start: '2019-08-10', end: '2019-08-11' },],
   

            

            eventClick:  function(event, jsEvent, view) {  // when some one click on any event

                endtime = $.fullCalendar.moment(event.end).format('h:mm');

                starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');

                var mywhen = starttime + ' – ' + endtime;

                $('#modalTitle').html(event.title);

                $('#modalWhen').text(mywhen);

                $('#eventID').val(event.id);

                $('#calendarModal').modal();

            },

            

            select: function(start, end, jsEvent) {  // click on empty time slot

                endtime = $.fullCalendar.moment(end).format('h:mm');

                starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');

                var mywhen = starttime + ' – ' + endtime;

                start = moment(start).format();

                end = moment(end).format();

                $('#createEventModal #startTime').val(start);

                $('#createEventModal #endTime').val(end);

                $('#createEventModal #when').text(mywhen);

                $('#createEventModal').modal('toggle');

           },

           eventDrop: function(event, delta){ // event drag and drop

               $.ajax({

                   url: 'agenda_d.php',

                   data: 'action=update&title='+event.title+'&start='+moment(event.start).format()+'&end='+moment(event.end).format()+'&id='+event.id ,

                   type: 'POST',

                   success: function(json) {

                   //alert(json);

                   }

               });

           },

           eventResize: function(event) {  // resize to increase or decrease time of event

               $.ajax({

                   url: 'agenda_d.php',

                   data: 'action=update&title='+event.title+'&start='+moment(event.start).format()+'&end='+moment(event.end).format()+'&id='+event.id,

                   type: 'POST',

                   success: function(json) {

                       //alert(json);

                   }

               });

           }

        });

               

       $('#submitButton').on('click', function(e){ // add event submit

           // We don't want this to act as a link so cancel the link action

           e.preventDefault();

           doSubmit(); // send to form submit function

       });

       

       $('#deleteButton').on('click', function(e){ // delete event clicked

           // We don't want this to act as a link so cancel the link action

           e.preventDefault();

           doDelete(); //send data to delete function

       });

       

       function doDelete(){  // delete event 

           $('#calendarModal').modal('hide');

           var eventID = $('#eventID').val();

           $.ajax({

               url: 'agenda_d.php',

               data: 'action=delete&id='+eventID,

               type: 'POST',

               success: function(json) {

                   if(json == 1)

                        $('#calendar').fullCalendar('removeEvents',eventID);

                   else

                        return false;

                    

                   

               }

           });

       }

       function doSubmit(){ // add event

           $('#createEventModal').modal('hide');

           var title = $('#title').val();


           var startTime = $('#startTime').val();

           var endTime = $('#endTime').val();

           

           $.ajax({

               url: 'agenda_d.php',

               data: 'action=add&title='+title+'&start='+startTime+'&end='+endTime,

               type: 'POST',

               success: function(json) {

                   $('#calendar').fullCalendar('renderEvent',

                   {

                       id: json.id,

                       title: title,

                       start: startTime,

                       end: endTime,

                   },

                   true);

               }

           });

           

       }

    });

