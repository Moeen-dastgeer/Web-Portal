<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 id="head"></h1>
    <form>
        <input type="text" name="name" id="name" placeholder="Enter your name">
        <input type="email" name="email" id="email" placeholder="Enter your email">
        <button type="button" id="btn">Submit</button>
    </form>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $("#btn").on("click",function(){
            var name = $("#name").val();
            var email = $("#email").val();
            $.ajax({
                url:"ajax_back.php",
                type:"POST",
                data:{name:name, email:email},
                success:function(response){
                   $("#head").text(response);
                   setTimeout(function(){
                     $("#head").text("");
                   },5000);
                }
            });
        });
    });
</script>

</body>
</html>