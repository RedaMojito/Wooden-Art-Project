
import $ from 'jquery';

export default $(".attachements").hover(function(){
    let attachementId = $(this).data("singleAttachement");
    let vich_path = `https://127.0.0.1:8000/media/cache/squared_thumbnail_small/images/attachements/${attachementId}`;
   $(".main-attachement").attr('src', vich_path);
 //  $(".main-attachement").css('opacity', '');
});