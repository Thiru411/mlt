  /*The MIT License (MIT)
Copyright (c) 2016 by Showvhick Nath

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.*/

$.fn.rating = function(options) {
    if(options=="refresh"){
       $(this).find('.simple-rater-holder').attr('data-selected',0).attr('data-ratestate',0);
       $(this).find('.simple-rater-overflow').css('width',0);
        
    }
    else if(options=="val"){
       var a = parseFloat($(this).find('.simple-rater-holder').attr('data-selected')).toFixed(1);
       return a;
    }
    else if(options=="disable"){
       $(this).find('.simple-rater-holder').attr('data-readonly','true');
    }
    else if(options=="enable"){
       $(this).find('.simple-rater-holder').attr('data-readonly','false');
    }
    else{
    var opts = jQuery.extend({}, jQuery.fn.rating.defaults, options);
   
    var counts = opts.count;
    var size = opts.size+'px';
    var totaloverlaywidth = parseFloat(opts.size)*parseInt(opts.count); 
   
    $(this).append('<div class="simple-rater-holder" data-scale="'+ opts.scale +'" data-ratestate=0 data-readonly="'+opts.readonly+'" style="float:left; width:auto; position:relative; "><div class="simple-rater-wrapper"></div><div class="simple-rater-overflow" style="position:absolute; left:0; top:0; width:0; overflow-x:hidden"><div class="simple-rater-overflow-variant" style="float:left; width:'+totaloverlaywidth+'"></div></div></div>');
 
    for(i=0; i<opts.count; i++){
       $(this).find('.simple-rater-wrapper').append('<div class="simple-rater-box" style="float:left; width:auto; "><div class="simple-rater-f"><svg width="40" height="40" viewBox="0 0 43 40" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999xlink"><rect width="42" height="40" transform="matrix(-1 0 0 1 43 0)" fill="url(#pattern0)"/><defs><pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1"><use xlink:href="#image0" transform="translate(-0.0255127) scale(0.00183105 0.00195312)"/></pattern><image id="image0" width="574" height="512" xlink:href="data:image/png;base64,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"/></defs></svg></div></div>');

       $(this).find('.simple-rater-overflow-variant').append('<div class="simple-rater-overlay-holder" style="float:left; width:auto;"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="simple-rater" viewBox="0 12.705 512 486.59" x="0px" y="0px" xml:space="preserve" width="'+size+'" height="'+size+'" fill="'+ opts.hoverColor +'" data-id="'+i+'" data-defaultfill="'+opts.primaryColor+'" data-hoverfill="'+opts.hoverColor+'" data-selected="false"><polygon points="256.814,12.705 317.205,198.566 512.631,198.566 354.529,313.435 414.918,499.295 256.814,384.427 98.713,499.295 159.102,313.435 1,198.566 196.426,198.566 "></polygon></svg></div>');
      
       $(this).addClass('raters');
    }
     var as = $(this).find('.simple-rater-holder').width();
     var totsize = parseInt(opts.count)*parseFloat(opts.size);
    $(this).find('.simple-rater-holder').css('width',totsize);
    if(opts.rate != 0){
     if(opts.rate > opts.count){
         console.log('ALERT! Count is lesser than rate. Can not be initialized');
       }
     else{
        var a = opts.rate;
        $(this).find('.simple-rater-holder').attr('data-selected',opts.rate);
        var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
        var c = parseFloat(b)*parseFloat(a);
       var d = c+'%';
       $(this).find('.simple-rater-overflow').css('width',d);
     }
    }
 }
 }
jQuery.fn.rating.defaults = {
    rate:0,  
    size:20,
    primaryColor:"#F4F4F4",
    hoverColor:"#fdb300",
    scale:10,
    readonly:"false",
    count:5
};


$(document).on('mousemove','.simple-rater-holder',function(e){
if($(this).attr('data-readonly') == 'false'){  
if($(this).attr('data-scale') == 10){
var a = parseInt($(this).position().left);
var overflowsize = parseInt(e.pageX)-parseInt(a);
$('.simple-rater-overflow').css('width',overflowsize+'px');
}
else if($(this).attr('data-scale') == 2){
var a = parseInt($(this).position().left);
var overflowsize = parseInt(e.pageX)-parseInt(a);
$('.simple-rater-overflow').css('width',overflowsize+'px');

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b);
var d = parseFloat(100)*parseFloat($(this).find('.simple-rater-overflow').width());
var f = parseFloat(d)/parseFloat($(this).width());
var g = parseFloat(f)/parseFloat(b);
if(g.toFixed(2).toString().split('.')[1] > 50){
 var h = parseFloat(g.toFixed(2).toString().split('.')[0])+parseInt(1);
 

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b)*parseFloat(h);
var d = c+'%';
$(this).find('.simple-rater-overflow').css('width',d);

}
else{
 var h = parseFloat(g.toFixed(2).toString().split('.')[0])+parseFloat(0.5);
 var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
 var c = parseFloat(b)*parseFloat(h);
 var d = c+'%';
 $(this).find('.simple-rater-overflow').css('width',d);
}

}
else{

var a = parseInt($(this).position().left);
var overflowsize = parseInt(e.pageX)-parseInt(a);
$('.simple-rater-overflow').css('width',overflowsize+'px');

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b);
var d = parseFloat(100)*parseFloat($(this).find('.simple-rater-overflow').width());
var f = parseFloat(d)/parseFloat($(this).width());
var g = parseFloat(f)/parseFloat(b);

 var h = parseFloat(g.toFixed(2).toString().split('.')[0])+parseInt(1);
 

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b)*parseFloat(h);
var d = c+'%';
$(this).find('.simple-rater-overflow').css('width',d);
}
}
})


$(document).on('click','.simple-rater-holder',function(e){
/*   $(this).attr('data-ratestate',1);
var a = $(this).find('.simple-rater-overflow').width();
var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b);
var d = parseFloat(100)*parseFloat($(this).find('.simple-rater-overflow').width());
var f = parseFloat(d)/parseFloat($(this).width());
var g = parseFloat(f)/parseFloat(b);
$(this).attr('data-selected',g);*/

if($(this).attr('data-readonly') == 'false'){  

if($(this).attr('data-scale') == 10){
var a = parseInt($(this).position().left);
var overflowsize = parseInt(e.pageX)-parseInt(a);
$('.simple-rater-overflow').css('width',overflowsize+'px');
var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b);
var d = parseFloat(100)*parseFloat(overflowsize);
var f = parseFloat(d)/parseFloat($(this).width());
var g = parseFloat(f)/parseFloat(b);
$(this).attr('data-selected',g);

}
else if($(this).attr('data-scale') == 2){
var a = parseInt($(this).position().left);
var overflowsize = parseInt(e.pageX)-parseInt(a);
// $('.simple-rater-overflow').css('width',overflowsize+'px');

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b);
var d = parseFloat(100)*parseFloat(overflowsize);
var f = parseFloat(d)/parseFloat($(this).width());
var g = parseFloat(f)/parseFloat(b);

if(g.toFixed(2).toString().split('.')[1] > 50){
 var h = parseFloat(g.toFixed(2).toString().split('.')[0])+parseInt(1);
     $(this).attr('data-selected',h);

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b)*parseFloat(h);
var d = c+'%';
$(this).find('.simple-rater-overflow').css('width',d);

}
else{
 var h = parseFloat(g.toFixed(2).toString().split('.')[0])+parseFloat(0.5);
     $(this).attr('data-selected',h);
 var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
 var c = parseFloat(b)*parseFloat(h);
 var d = c+'%';
 console.log(d);
 $(this).find('.simple-rater-overflow').css('width',d);
}

}
else{

var a = parseInt($(this).position().left);
var overflowsize = parseInt(e.pageX)-parseInt(a);
$('.simple-rater-overflow').css('width',overflowsize+'px');

var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b);
var d = parseFloat(100)*parseFloat($(this).find('.simple-rater-overflow').width());
var f = parseFloat(d)/parseFloat($(this).width());
var g = parseFloat(f)/parseFloat(b);


 var h = parseFloat(g.toFixed(2).toString().split('.')[0])+parseInt(1);
 
$(this).attr('data-selected',h);
var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b)*parseFloat(h);
var d = c+'%';
$(this).find('.simple-rater-overflow').css('width',d);
}
}



})


$(document).on('mouseleave','.simple-rater-holder',function(){
if($(this).attr('data-readonly')=="false"){

if($(this).attr('data-ratestate') == 0 || $(this).attr('data-ratestate')== undefined){

if($(this).attr('data-selected') == undefined || $(this).attr('data-selected') == 0) 
{   
$(this).find('.simple-rater-overflow').css('width',0);
}
else{
var a = parseFloat($(this).attr('data-selected'));
var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b)*parseFloat(a);
var d = c+'%';
$(this).find('.simple-rater-overflow').css('width',d);
}
}
else{

var a = parseFloat($(this).attr('data-selected'));
var b = parseInt(100)/parseInt($(this).find('.simple-rater-box').length);
var c = parseFloat(b)*parseFloat(a);
var d = c+'%';
$(this).find('.simple-rater-overflow').css('width',d);
}
}
})

