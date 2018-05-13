$(document).ready(function()
{
  $('.dropdown-item').click(function(e) {
    e.stopImmediatePropagation();
});


  $(document).on('click', '#deleteNotif', function(e){
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "notifications/"+$(this).data('id'),
            type: "PUT",
            data: ""
         });

    });

  function loadNotifications()
  {
    $.ajax({
      headers:
      {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "/notifications",
      type: "POST",
      data: ""
   });


   console.log("NOTIFS");
  }

  function loadlink()
  {
    console.log("refreshed");
    //$("#content").load(location.href + " #content");
    $(".notifs").load(location.href + " .notifs*");
    $(".list-notificacao").load(location.href + " .list-notificacao>*");

  }

    loadNotifications();
    loadlink();
    setInterval(function(){
    loadNotifications();
    loadlink();
  }, 1000);
});
