
// Check match password in register
let checkMatch = function() {
    if ($("#password").val() == $("#password2").val()) {
        $("#password").css("border", "2px solid white");
        $("#password2").css("border", "2px solid white");
        $("#error_text").html("");
    } else {
        $("#password").css("border", "2px solid #db8787");
        $("#password2").css("border", "2px solid #db8787");
        $("#error_text").html("Passwords do not match");

        for (let i = 1; i < 1000; i++) {
            setTimeout(function timer() {
                $("#error_text").fadeOut( "100" );
                $("#error_text").fadeIn( "100" );
                console.log(i);
            }, i * 2500);
        }
    }
};
