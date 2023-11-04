//$('.video').parent().click(function () {
  //  if($(this).children(".video").get(0).paused){
    //    $(this).children(".video").get(0).play();
      //  $(this).children(".playpause").fadeOut();
        //console.log("playing");
    //}else{
      // $(this).children(".video").get(0).pause();
        //$(this).children(".playpause").fadeIn();
        //console.log("pausing");
    //}
//});

const EL_video = document.querySelector("#vid");
EL_video.addEventListener("play", () => {
    EL_video.dataset.start = Date.now();
  });
  
  EL_video.addEventListener("pause", () => {
    EL_video.dataset.pausedat=EL_video.currentTime;
    console.log(EL_video.dataset.pausedat);
    const diff = Date.now() - EL_video.dataset.start;
    EL_video.dataset.viewtime = (+EL_video.dataset.viewtime || 0) + diff;
    console.log(`Total view time: ${EL_video.dataset.viewtime} ms`);
  });
