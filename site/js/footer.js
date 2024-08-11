$('#search a').hover(function(){
        $(this).stop().animate({'opacity':0.5},350, "easeOutSine");
        }, function(){
            $(this).stop().animate({'opacity':1},350, "easeOutSine"); 				 
    })
    $(window).load(function(){
        var curAccord = 0;
        var oldAccord = 0;

        $('._accodList').find('p').slideUp(1);
        $('._accodList').find('._plus').addClass('btnBg1');
        $('._accodList').find('h6').addClass('color1');

        setTimeout(function(){
            $('._accodList > li').eq(0).find('._plus').removeClass('btnBg1');
            $('._accodList > li').eq(0).find('._plus').addClass('btnBg2');
            $('._accodList > li').eq(0).find('p').slideDown();
            $('._accodList > li').eq(0).find('h6').addClass('color2');
        },200)

        $('._accodList').find('._plus, h6').click(
            function(){
                if(curAccord !== $(this).parent().index()){
                    oldAccord = curAccord;
                    curAccord = $(this).parent().index(); 
                    
                    $('._accodList > li').eq(curAccord).find('._plus').removeClass('btnBg1');
                    $('._accodList > li').eq(curAccord).find('._plus').addClass('btnBg2');
                    $('._accodList > li').eq(curAccord).find('h6').removeClass('color1');
                    $('._accodList > li').eq(curAccord).find('h6').addClass('color2');
                    $('._accodList > li').eq(curAccord).find('p').slideDown();
                    
                    $('._accodList > li').eq(oldAccord).find('._plus').removeClass('btnBg2');
                    $('._accodList > li').eq(oldAccord).find('._plus').addClass('btnBg1');
                    $('._accodList > li').eq(oldAccord).find('h6').removeClass('color2');
                    $('._accodList > li').eq(oldAccord).find('h6').addClass('color1');
                    $('._accodList > li').eq(oldAccord).find('p').slideUp();
                }

            }
        )
    }) 



    $('#search a').hover(function(){
        $(this).stop().animate({opacity:0.5},350, "easeOutSine");		 
            }, function(){
        $(this).stop().animate({opacity:1},350, "easeOutSine");						 
    })

     if($.browser.msie && $.browser.version == 8){ 
            $('._accodList li').css({'margin-bottom':'0'});
        }