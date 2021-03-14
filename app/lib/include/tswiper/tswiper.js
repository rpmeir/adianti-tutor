function tswiper_start(id, ){

    
    options = Object.assign(attributes, JSON.parse( options) );
    
    $('#'+id).swiper(options);
}