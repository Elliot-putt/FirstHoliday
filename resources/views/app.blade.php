<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet"/>
    <link href="{{ mix('/css/main.css') }}" rel="stylesheet"/>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script src="{{ mix('/js/manifest.js') }}" defer></script>
    <script src="{{ mix('/js/vendor.js') }}" defer></script>
    <script>

        var botmanWidget = {
            aboutText: "",
            title: 'First Holiday',
            introMessage: "Hi I'm from First Holiday, say hello to get started!",
            mainColor: "#5d5d98",
            textColor: "#fff",
            bubbleBackground: "#332d71",
            bubbleAvatarUrl: "images/chatbot.png",

        };

    </script>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
            integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).on('click', '.desktop-closed-message-avatar img', function () {
            var iframe = document.getElementById("chatBotManFrame");
            iframe.addEventListener('load', function () {
                var htmlFrame = this.contentWindow.document.getElementsByTagName("html")[0];
                var bodyFrame = this.contentWindow.document.getElementsByTagName("body")[0];
                var headFrame = this.contentWindow.document.getElementsByTagName("head")[0];

                var image = "https://images.unsplash.com/photo-1604147706283-d7119b5b822c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80"
                // var image = "https://images.unsplash.com/photo-1501597301489-8b75b675ba0a?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1349&q=80"


                htmlFrame.style.backgroundImage = "url(" + image + ")";
                bodyFrame.style.backgroundImage = "url(" + image + ")";
            });
        });
    </script>
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
