(function(global,$){
	function ajaxForm(selector) {
		this.options = {};
		this.selector = selector;
		this.api;
		this.event;
		this.clickCount = 0;
	}
	
	function init(selector){
		var form = new ajaxForm(selector);
		form.getSelectorType();
	}
	
	global.$Form = global.ajaxForm = init;
	
	ajaxForm.prototype = {
		getSelectorType: function(){
			var self = this;
			self.selector.each(function(){
				var sendAjax = $(this).attr('data-ajax');
				var api = $(this).attr('data-api') || null;
				var resultsContainer = $('#'+$(this).attr('data-results-container')) || null;
				var layout = $(this).attr('data-layout') || null;
				var other= $('#'+$(this).attr('data-other')) || null;

				if($(this).is("select")){
                    console.log('select');
					if(sendAjax === "true"){
						var selectedValue = $(this).val();
						if(selectedValue !== null){
							var params = {
								id:selectedValue
							};
							self.fireAjaxCall(api,resultsContainer,layout,params);
						}
						self.fireSelectorEvent($(this),'change',true,api,resultsContainer,layout,other);
					}else{
						self.fireSelectorEvent($(this),'change',false);
					}
					
				}else if($(this).is('input[type="button"]')){
					if(sendAjax === "true"){
						self.fireSelectorEvent($(this),'click',true,api,resultsContainer,layout,other);
					}else{
						self.fireSelectorEvent($(this),'click',false);
					}
				}
			});
		},
		initiateSelect: function(selector){
			//return $(selector+' option:selected').val();
			return selector;
		},
		fireSelectorEvent: function(selector,event,ifAjax,api,resultsContainer,layout,other){
			var self = this;
						
			selector.on(event,function(e){
				if(event === 'click'){
					self.clickCount++;
                    //console.log(other);
					e.preventDefault();
					if(ifAjax === true){
						var params = {};
						if(other !== null){
							var id = other.val();
							params.id = id;
						}
						self.fireAjaxCall(api,resultsContainer,layout,params);
					}else{
						self.eventHandler();
					}
					
				}else if(event === 'change'){
					//console.log('change');
					if(ifAjax === true){
                        var params = {};
                        var trigger = $(this).attr('id');
                        if(trigger === "chooseProvider"){
                            var CPID = $(this).val();
                            params.CPID = CPID;
                            if(other !== null){
                                var OccId  = other.val();
                                params.OccId  = OccId ;
                            }

                        }else{
                            var id = $(this).val();

                            params.id = id;
                        }

						if($('.error')){
							$('.error').remove();
						}
							
						self.fireAjaxCall(api,resultsContainer,layout,params);
					}else{
						self.eventHandler();
					}
					
				}
			});
		},
		getDefaultSelection: function(selector){
			
		},
		eventHandler: function(){
			
		},
		fireAjaxCall:function(api,resultsContainer,layout,params){
			var self = this;
            resultsContainer.empty();
            $('#chooseAudio').empty();
			$.ajax({
				method:'GET',
				url: api,
				cache: false,
				data: params,
				beforeSend:function(){
					$('.pageLoader').show();
				},
				success: function(data){
$('.pageLoader').hide();
                    var result = JSON.parse(data);
					if(layout === 'drop'){
                        var options;
						if(resultsContainer.hasClass('image-picker')){
                            for(var i=0; i<result.length;i++){
                                options += '<option value="'+result[i].id+'" data-img-src="'+result[i].path+'"></option>';
                            }
							resultsContainer.html(options);
							resultsContainer.imagepicker();
							if($('.error')){
								$('.error').remove();
							}
							
						}else{
                            for(var i=0; i<result.length;i++){
                                options += '<option value="'+result[i].id+'">'+result[i].title+'</option>';
                            }

							resultsContainer.html(options);
							$('#chooseProvider option').first().attr('selected',true);
							var CPID = $('#chooseProvider').val();
							var OccId = $('#chooseOccasion').val();
							var params = {
								CPID:CPID,
								OccId:OccId
							};
							
							//default selected content provider
							$.ajax({
								method:'GET',
								url:resultsContainer.attr('data-api'),
								cache: false,
								data: params,
								beforeSend:function(){
									$('.pageLoader').show();
								},
								success:function(data){
									$('.pageLoader').hide();
									var result = JSON.parse(data);
									var container = $('<div id="audioResult"></div>');
									var chooseSong = $('<h2>اختر النغمة</h2>');
									var table = $('<table></table>');
									var tableHeader = $('<tr><td>اختر</td><td>استمع</td><td>اسم النغمة</td></tr>');
			                        var tableBody;
			                        for(var i=0; i<result.length;i++){
			                            //tableBody += '<option value="'+result[i].id+'" data-img-src="'+result[i].path+'"></option>';
			                            tableBody += '<tr>'+'<td>'+
			                            '<input  type="radio" class="radio" name="track" value="'+result[i].id+'" />'+
			                            '</td>'+
			                            '<td class="np-play" data-src="'+result[i].path+'"></td>'+
			                            '<td>'+result[i].name+'</td>'+
			                            '</tr>';
			                        }
									table.append(tableHeader).append(tableBody);
									container.append(chooseSong).append(table);
									$('#chooseAudio').html(container);
									
								}
							});
							
						}
						
						//for chooseProvider default selection
						//find a better logic in next version
						//console.log(self.clickCount);
						var selectedValue = resultsContainer.val();
						
						if(selectedValue !== null && self.clickCount ==1){
							/*var CPID = $('#chooseProvider').val();
							var OccId = $('#chooseOccasion').val();
							var params = {
								CPID:CPID,
								OccId:OccId
							};
							
							//default selected content provider
							$.ajax({
								method:'GET',
								url:resultsContainer.attr('data-api'),
								data: params,
								success:function(data){
									var result = JSON.parse(data);
									var container = $('<div id="audioResult"></div>');
									var chooseSong = $('<h2>اختر النغمة</h2>');
									var table = $('<table></table>');
									var tableHeader = $('<tr><td>اختر</td><td>استمع</td><td>اسم النغمة</td></tr>');
			                        var tableBody;
			                        for(var i=0; i<result.length;i++){
			                            //tableBody += '<option value="'+result[i].id+'" data-img-src="'+result[i].path+'"></option>';
			                            tableBody += '<tr>'+'<td>'+
			                            '<input  type="radio" class="radio" name="track" value="'+result[i].id+'" />'+
			                            '</td>'+
			                            '<td class="np-play" data-src="'+result[i].path+'"></td>'+
			                            '<td>'+result[i].name+'</td>'+
			                            '</tr>';
			                        }
									table.append(tableHeader).append(tableBody);
									container.append(chooseSong).append(table);
									$('#chooseAudio').html(container);
									
								}
							});*/
						}
					}else if(layout === 'table'){
						var container = $('<div id="audioResult"></div>');
						var chooseSong = $('<h2>اختر النغمة</h2>');
						var table = $('<table></table>');
						var tableHeader = $('<tr><td>اختر</td><td>استمع</td><td>اسم النغمة</td></tr>');
                        var tableBody;
                        for(var i=0; i<result.length;i++){
                            //tableBody += '<option value="'+result[i].id+'" data-img-src="'+result[i].path+'"></option>';
                            tableBody += '<tr>'+'<td>'+
                            '<input class="radio" type="radio" name="track" value="'+result[i].id+'" />'+
                            '</td>'+
                            '<td class="np-play" data-src="'+result[i].path+'"></td>'+
                            '<td>'+result[i].name+'</td>'+
                            '</tr>';
                        }
						table.append(tableHeader).append(tableBody);
						container.append(chooseSong).append(table);
						resultsContainer.html(container);
						
					}
				}
			});
		}
	};
})(window,$);