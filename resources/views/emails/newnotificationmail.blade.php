<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .body{
        font-family:"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    }
    .card {
        position:relative;
        display:flex;
        width:50%!important;
        flex-direction:column;
        background-clip:border-box;
        border: 1px solid rgba(0,0,0,.125);
        border-radius:.25rem;

    } 
    .card-title {
        margin-bottom:0;
        margin-top:0.25rem;
        font-size:1.5rem;
        font-weight:500;
        line-height:1.2;
    }
    .card-body{
        flex:1 1 auto;
        min-height:1px;
        padding:0.25rem;
    }
    .card-footer{
        padding:.75rem 1.25rem;
        background-color:rgba(0,0,0,.03);
        border-top:1px solid rgba(0,0,0,.125);
    }
    .card-subtitle{
        margin-top:0rem;
        margin-bottom:.5rem;
        color:#6c757d!important;
    }
    .btn{
        font-size:14px;
        border: 1px solid #dee2e6;
        display:inline-block;
        font-weight:400;
        color:#212529;
        text-align:center;
        vertical-align:middle;
        line-height:1.5;
        border-radius: 1rem;
    }
    </style>
    <title>New Notification</title>
</head>
<body>
<h3>Dear {{$recipient->name}},</h3>
<h4>You have a new notification</h4>
    <div class="card w-50">
        <h6 class="card-subtitle">Sent on: {{$notification->created_at}}.</h6>
        @if($item != null)
            <strong>Regarding item:</strong> <a class="card-link" href="{{route('item.view', $item)}}">{{$item->item_name}}</a>
            <br />
        @endif
        <strong>Message:</strong>
        <p class="card-text">{{$notification->message}}</p>
        <br />
        <a href="{{route('user.notifications')}}">
            <strong>Login</strong>
        </a>
    </div>
    <br />
</body>
</html>