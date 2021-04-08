
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(".next").click(function(){
	current_fs = $(this).closest('fieldset');
	next_fs = $(this).closest('fieldset').next();

	var counter = 0;
	//Add for validation here 
	var emptyFields = current_fs.find($('input:not([type="button"]),input:not([type="radio"]),select')).filter(function(){
		/*if($(this).is('input[type="radio"]') && $(this).is(':checked')===false){
			return $(this).val()=="" || ($(this).is('input[type="radio"]') && $(this).is(':checked')===false);
		}*/
		return $(this).val()=="";
		
	});
	
	counter = emptyFields.length;
	
	var radioButtons = current_fs.find($('input[type="radio"]'));
	if(radioButtons.length > 0){
		var checkedRadio = current_fs.find($('input[type="radio"]:checked'));
		//console.log(checkedRadio);
		if(checkedRadio.length < 1){
			counter++;
			if($('#chooseAudio table').prev().is('.errors')){
				//console.log('error');
			}else{
				$('#chooseAudio table').before('<div class="errors"><p>required</p><i class="fa fa-times"></i></div>');
			}
			
		}

        radioButtons.click(function(){
            $('#chooseAudio table').prev().remove();

        });
	}
	if(counter > 0){
		//console.log(emptyFields);
		emptyFields.each(function(){
			if($(this).prev().is('.errors')){
				//console.log('error');
			}else{
				$(this).before('<div class="errors"><p>required</p><i class="fa fa-times"></i></div>');
			}

            $(this).click(function(){
                $(this).prev().remove();
            });
		});
		
	}else{
		//activate next step on progressbar using the index of next_fs
		$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
		$('.errors').remove();
		next_fs.show(); 
		current_fs.hide();
		current_fs.animate({opacity: 0}, {
			step: function(now, mx) {
				//as the opacity of current_fs reduces to 0 - stored in "now"
				//1. scale current_fs down to 80%
				//scale = 1 - (1 - now) * 0.2;
				//2. bring next_fs from the right(50%)
				left = (now * 50)+"%";
				//3. increase opacity of next_fs to 1 as it moves in
				opacity = 1 - now;
				//current_fs.css({'transform': 'scale('+scale+')'});
				next_fs.css({'left': left, 'opacity': opacity});
			}, 
			duration: 400, 
			complete: function(){
				current_fs.hide();
				animating = false;
			}, 
			//this comes from the custom easing plugin
			easing: 'easeInOutBack'
		});
		/*if(animating){
			return false;	
		} 
		animating = true;
		*/
	
	}
	
	
	
});

$(".previous").click(function(){
	if(animating) {return false;}
	animating = true;
    $('.fieldset-controls').each(function(){
        var height = $(this).parent().height();
        //$(this).css({
        //    "top":(height-40) +'px'
        //});
       // console.log(height);
    });

    $('.fieldset-controls input').css({
        "margin-bottom":"0px"
    });
    current_fs = $(this).closest('fieldset');
    previous_fs = $(this).closest('fieldset').prev();
    var height = previous_fs.height();
    console.log(height);
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show();
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			//scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'opacity': opacity});
		}, 
		duration: 300,
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});