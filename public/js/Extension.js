var add = document.getElementById("add");
var myModal = document.getElementById("myModal");

add.addEventListener("click", function() {
    console.log("add");
    $("#myModal").css("display", "block");
});
document.getElementById("close").addEventListener("click", function() {
    $("#myModal").css("display", "none");
});
