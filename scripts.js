function del_message (message_id){
    let answer = confirm ("Are you sure you want to delete the messasge?");
    if (answer) {
        window.location = "center.php?del=" + message_id;
    } 
}
function bg_image_shift () {
    var images = [
        "./fp_images/meditating_couple_1.webp",
        "./fp_images/meditating_couple_2.webp",
        "./fp_images/meditating_couple_3.webp",
        "https://www.surfertoday.com/images/stories/sunrisesunsettime.jpg"
      ];
      
      // var imageHead = document.getElementById("image-head");
      var i = 0;
      
      setInterval(function() {
            document.body.style.backgroundImage = "url(" + images[i] + ")";
            i = i + 1;
            if (i == images.length) {
                i =  0;
            }
      }, 5000);
}

