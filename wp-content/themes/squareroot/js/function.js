/** load more **/
(function($) {
    /** jQuery Document Ready */
    jQuery(document).ready(function($){
        var loadding = false;

        $( '.moreblog' ).off( 'click' ).on( 'click', function( e ) { 
        if (!loadding) {
            $(".loadname").html('Loading<span class="one">.</span><span class="two">.</span><span class="three">.</span>');

            loadding = true;

            /** Prevent Default Behaviour */
            e.preventDefault();
 
            /** Get Post ID */
            var os = $(this).attr( 'id' );
            var me = $(this);
            var step = 1;
            /** Ajax Call */
            $.ajax({
 
                cache: false,
                timeout: 8000,
                url: php_array.admin_ajax,
                type: "POST",
                data: ({ action:'blog_init', os:os }),
 
                beforeSend: function() {  

                },
 
                success: function( data, textStatus, jqXHR ){
                    $(".loadname").html('Load more');

                    if (data['haspost']) {
                        me.attr("id",parseInt(me.attr( 'id' )) +step);
                        $("#fblog").append(data['data']);
                    }else {
                        var end_data =  '<div class="end-box clearfix">'+
                                        '<span class="title end-of-box"><strong>End</strong></span>'+
                                        '</div>';
                        var parent = $('#more-box').parent();

                        $('#more-box').remove();
                        parent.append(end_data);
                    }                                                       
                    loadding = false;
                },
 
                error: function( jqXHR, textStatus, errorThrown ){
                    loadding = false;
                    console.log( 'The following error occured: ' + textStatus, errorThrown );    
                },
 
                complete: function( jqXHR, textStatus ){
                    loadding = false;
                }
 
            });
        }
        });
        

        $( '.portfolio-image' ).off( 'click' ).on( 'click', function( e ) { 
        if (!loadding) {

            loadding = true;

            $( "#loader" ).empty();
            $(".port-ajax-loader").show();
            $('html, body').animate({
                scrollTop: $(".port-ajax-loader").offset().top -70
            }, 1000);

            var classList =$(this).attr('class').split(/\s+/);
            $.each( classList, function(index, item){
                if (item != "portfolio-image") {
                   os = item;
                }
            });
            
            $.ajax({
            
                cache: false,
                timeout: 8000,
                url: php_array.admin_ajax,
                type: "POST",
                data: ({ action:'portfolio_init', os:os }),
 
                beforeSend: function() {                    

                },
 
                success: function( data, textStatus, jqXHR ){
                   $("#loader").css( "display", "block");
                   $("#loader").append(data);
                    
                   $(".port-ajax-loader").hide();


                   $('.flexslider').flexslider({
                        animation: "slide",
                        controlNav: false
                    });

                   $( '#closeProject' ).off( 'click' ).on( 'click', function( e ) { 
                        $( "#loader" ).empty();
                        $( "#loader" ).css('display', 'none');

                        $('html, body').animate({
                            scrollTop: $(".port-ajax-loader").offset().top -70
                        }, 1000);
                   });
                   loadding = false;
                },
 
                error: function( jqXHR, textStatus, errorThrown ){
                    loadding = false;
                    console.log( 'The following error occured: ' + textStatus, errorThrown );    
                },
 
                complete: function( jqXHR, textStatus ){
                    loadding = false;
                }
 
            });
        }
        });
    });
 
})(jQuery);