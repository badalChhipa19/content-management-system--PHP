$(document).ready(function () {
  $("#summernote").summernote({
    height: 200,
  });
});
$(document).ready(function () {
  $("#selectAllBoxes").click(function (event) {
    if (this.checked) {
      $(".checkBoxes").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkBoxes").each(function () {
        this.checked = false;
      });
    }
  });
});

function loadUserOnline() {
  $.get("functions.php?onlineusers=result", function (date) {
    $(".usersOnline").text(data);
  });
}
setInterval(function () {
  loadUserOnline();
}, 500);
