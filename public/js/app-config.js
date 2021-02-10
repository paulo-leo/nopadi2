$(function(){

$(".btn-open-menu").click(function(){
   $('.sidebar').slideDown('fast');
   $('.btn-open-menu').hide('fast');
   $('.btn-close-menu').show('fast');
});
$(".btn-close-menu").click(function(){
   $('.sidebar').slideUp('fast');
   $('.btn-open-menu').show('fast');
   $('.btn-close-menu').hide('fast');
});

});