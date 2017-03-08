 function alertConfirmation(form, message) {
    if (confirm(message)) {
        form.submit();          
    } else {
        return false;
    }
}

$(document).ready(function() {
    
    var colorRed = '#e72f2f';
    var colorGreen = '#8D6E63';
    var colorYellow = '#fbfe14';
    
    setTimeout(function() {
        $('.alert-box').hide();    
    }, 3100);
     
    
    var mapAction = {};
    var mapEditAction = {};
    
    mapAction.openModalAndGetDetails = function(element) {
        
        var elId = $(element).attr('id');
        var modaDetails = $('#grave_all_details_modal');
        
        modaDetails.modal('show');
        modaDetails.find('h4.modal-title').empty().text(elId);
        
        //add grave code for reference on creating new record in modal
        $('#btn-new-record').attr('data-code', '').attr('data-code', elId);       
        
        $.ajax({
            url: "/?page=ajax-get-grave-details&code="+ elId +"",
            //data: data,
            method : "GET",
            dataType: "json",

            beforeSend: function() {
                $('#big-loader').css('display', 'block');                    
            },

            success: function(response) {
                
                var table = $('table#grave-d-person');
                                
                table.empty();
                
                if (response['noRecords'] <= 0) {
                    
                    for(var idx in response['data']) {
                        
                        var person = response['data'][idx];
                        var backgroundColor = '';
                        var moveToBoneChamberBtn = 'none';
                        
                        if (person.status == 'expired') {
                            
                            backgroundColor = '#f4e602';
                            moveToBoneChamberBtn = 'block';
                            
                        } else if (person.status == 'occupied') {
                            
                            backgroundColor = '#e72f2f'; 
                            moveToBoneChamberBtn = 'none';
                            
                        } else {
                            
                            backgroundColor = '';
                            moveToBoneChamberBtn = 'none';
                        }
                        
                        var display = 'block';
                        
                        if (person.type == 'private') {
                            display = 'none';                                    
                        } else {
                            display = 'block';                            
                        }
                        
                        table.append('<tr>\n\
                            <td>\n\
                                <div class="list"> <div class="circle-label" style="background-color:'+ backgroundColor +';"></div> </div>\n\
                                <div class="list"> <label>Name:</label> <b>' + person.lastName + ',' + person.firstName + '</b> </div>\n\
                                <div class="list"> <label>Gender:</label> <b>' + person.gender + '</b> </div>\n\
                                <div class="list" style="display: '+ display +' "> <label>Date Of Birth:</label> <b>' + person.dateOfBirth + '</b> </div>\n\
                                <div class="list" style="display: '+ display +' "> <label>Date Of Death:</label> <b>' + person.dateOfDeath + '</b> </div>\n\
                                <div class="list" style="display: '+ display +' "> <label>Caused Of Death:</label> <b>' + person.causedOfDeath + '</b> </div>\n\
                                <div class="list"> <label>Expiration:</label> <b>' + person.graveExpirationDate + '</b> </div>\n\
                                <div class="list"> <label>Status:</label> <b>' + person.status + '</b> </div>\n\
                                \n\
                                <div class="list"> <button id="move-to-bone-chamber" data-graveid="' + person.id + '" style="display: '+ moveToBoneChamberBtn +'" type="button" class="btn btn-sm btn-danger pull-right"> Move to Bone Chamber </button> </div>\n\
                            </td></tr>');                        
                    }                    
                }
                
                //Hide New Record if o slot available
                if (response.showAddRecordBtn == 1 && response.type != 'bonechamber') {
                    $('#btn-new-record').show();                    
                } else {
                    $('#btn-new-record').hide();                    
                }
                
                //Hide Loader
                $('#big-loader').css('display', 'none'); 
            }     
        });
        
    };
    
    mapAction.openNewRecordModal = function(element) {
        
        var elId = $(element).attr('data-code');
        var newRecordForm = $('#form-add-record');
		var newRecordModal = $('#add_record');
		var lotNumberLabel = $('#lot-number-label').find('span');
        
        $('#label-grave-id')
            .empty()
            .text(elId)
            .css('color', '#8D6E63');
        newRecordForm
            .find('#input-grave-id-label')
            .val(elId);       
        
        //get available grave level and open modal
        
        if (elId.indexOf('private') >= 0) {
            
            $('#add_record').modal('show');
            var selectLevelBox = $('#new-record-available-level');
            selectLevelBox.empty().append('<option value="1"> 1 </option>'); 
			
            
                    $('.field-private-only').each(function(i, elem){
                        
                        $(elem).removeAttr('required');
                        $(elem).hide();
                        console.log(i);
                        
                    });
                        
                        
			newRecordModal.find('.modal-header h4').empty().text("New Record : " + "Lot Owner");
			
			lotNumberLabel.empty().text("Lot No:");
                                    
        } else {
            //get all available grave level and set to select box
            this.getAvailableGraveLevel(elId);      
			lotNumberLabel.empty().text("Grave No:");	
			newRecordModal.find('.modal-header h4').empty().text("New Record");
                        
                    $('.field-private-only').each(function(i, elem){                        
                        
                        $(elem).show();
                        $(elem).attr('required', 'true');
                        console.log(i);
                        
                    });
                        
                        
        }
         
    };
    
    mapAction.setColorOnLoad = function() {        
        //$('rect').attr('fill', colorGreen).attr('class', 'available'); 
        //$('polygon').attr('fill', colorGreen).attr('class', 'available'); 
    };
        
    mapAction.getGraveStatusAndSetColor = function() {
        
        $.ajax({
            url: "/?page=ajax-get-all-grave-status",
            //data: data,
            method : "GET",
            dataType: "json",

            error: function(response) {
            },

            beforeSend: function() {
                $('#big-loader').css('display', 'block');                    
            },

            complete: function(){
            },

            success: function(response) {
                
                for(var idx in response['graves']) {
                    
                    var data = response['graves'][idx];
                    var code = data['code'];
                    var status = data['status'];
                    
                    if (status == 'green') {                      
                        $('#' + code).attr('fill', colorGreen);                        
                    } else {
                        $('#' + code).attr('fill', colorRed).attr('class', 'not-available');                          
                    }                
                }
                
                
                
                //expired private graves
                for(var idxExpGraves in response['expiredPrivateGraves']) {
                    
                    var data = response['expiredPrivateGraves'][idxExpGraves];
                    var code = data['code'];
                    var status = data['status'];
                    
                    $('#' + code).attr('fill', colorYellow);                    
                }
                
                //expired public graves
                for(var idxExpGraves in response['expiredPublicGraves']) {
                    
                    var publicGdata = response['expiredPublicGraves'][idxExpGraves];
                    var codePubGrave = publicGdata['code'];
                    var statusPubGrave = publicGdata['status'];
                    var statusPubGraveEl = $('#' + codePubGrave);
                    var spgElPosition = statusPubGraveEl.offset();  
                    
                    statusPubGraveEl.attr('stroke', '#effe03');
                }
                
                //Hide Loader
                $('#big-loader').css('display', 'none'); 
            }     
        });        
    };
    
    mapAction.getAvailableGraveLevel = function(graveCode) {
        
        $.ajax({
            url: "/?page=ajax-get-all-grave-available-level&code="+ graveCode +"",
            //data: data,
            method : "GET",
            dataType: "json",

            error: function(response) {
            },

            beforeSend: function() {
                $('#big-loader').css('display', 'block');                    
            },

            complete: function(){
            },

            success: function(response) {
                
                $('#add_record').modal('show');
                $('#big-loader').css('display', 'none');  
                
                //set select box level
                var selectLevelBox = $('#new-record-available-level');
                selectLevelBox.empty().append('<option value=""> Select Level </option>');                
                for (var idx in response) {                    
                    selectLevelBox.append(response[idx]);                                        
                }                
                
            }     
        });        
    };
    
    mapEditAction.selectedGrave = function(element) {
        
        var elId = $(element).attr('id');
        
        if (elId.indexOf('private') >= 0) {
            
            var selectLevelBox = $('#edit-record-available-level');
            selectLevelBox.empty().append('<option value="1"> 1 </option>');  
            
            $('#change-grave-modal').modal('hide');
            
            $("#label-grave-id").empty().text(elId);
            $('#input-grave-id-label').val(elId);
            
        } else {          

            $.ajax({
                url: "/?page=ajax-get-all-grave-available-level&code="+ elId +"",
                //data: data,
                method : "GET",
                dataType: "json",

                error: function(response) {
                },

                beforeSend: function() {
                    $('#big-loader').css('display', 'block');                    
                },

                complete: function(){
                },

                success: function(response) {

                    $('#change-grave-modal').modal('hide');
                    $('#big-loader').css('display', 'none');

                    $("#label-grave-id").empty().text(elId);
                    $('#input-grave-id-label').val(elId);

                    //set select box level
                    var selectLevelBox = $('#edit-record-available-level');
                    selectLevelBox.empty().append('<option value=""> Select Level </option>');                
                    for (var idx in response) {                    
                        selectLevelBox.append(response[idx]);                                        
                    }              

                }     
            });
        
        }
        
    };
    
    mapAction.setColorOnLoad();
    mapAction.getGraveStatusAndSetColor();

    /* start will trigger on view grave details */
    $('rect').on('click', function() {
        
        
        var type =  $('#grave-js-action-flag').val();
        if (type == 'newRecord') {            
           mapAction.openModalAndGetDetails(this);            
        } else if (type == 'editRecord') {            
            mapEditAction.selectedGrave(this);             
        }
        
    });    
    $('polygon').on('click', function() {        
        var type =  $('#grave-js-action-flag').val();
        if (type == 'newRecord') {            
           mapAction.openModalAndGetDetails(this);            
        } else if (type == 'editRecord') {            
            mapEditAction.selectedGrave(this);             
        }
    });
    
    
    $('path#block1-grave1-bonechamber').on('click', function() {        
        var type =  $('#grave-js-action-flag').val();
        if (type == 'newRecord') {            
           mapAction.openModalAndGetDetails(this);            
        } else if (type == 'editRecord') {            
            mapEditAction.selectedGrave(this);             
        }
    });
    /* end will trigger on view grave details */
    
    /* */
    $('#btn-new-record').on('click', function() {
        
        //hide grave details modal
        $('#grave_all_details_modal').modal('hide');
        
        var type =  $('#grave-js-action-flag').val();
        if (type == 'newRecord') {
            
            mapAction.openNewRecordModal(this);             
        } else if (type == 'editRecord') {
            
            mapEditAction.selectedGrave(this);             
        }             
    });   
    /* end*/    
    
    
    
    //Edit Record
    $('#show-change-grave-modal').on('click', function() {
        
        $('#change-grave-modal').modal('show');
        
    });
    
    
    //Move to Bone Chamber
    $(document).on('click', '#move-to-bone-chamber', function() {
        
       var thisGraveId = $(this).attr('data-graveid');
       
        $.ajax({
            url: "/?page=ajax-move-to-bone-chamber&graveId="+ thisGraveId +"",
            //data: data,
            method : "GET",
            dataType: "json",

            error: function(response) {
            },

            beforeSend: function() {
                $('#big-loader').css('display', 'block');                    
            },

            complete: function(){
            },

            success: function(response) {

                $('#change-grave-modal').modal('hide');
                $('#big-loader').css('display', 'none');
				location.reload();
          

            }     
        });
       
    });
    
    
    //Attach Another Image
    
    $('#attach-another-image').on('click', function() {
        
        var attachmentsWrapper = $('#images-wrapper');        
        var count = $("input[name$='attachmentCounter']");
        var currentCount = parseInt(count.val());
        var prevAttachment = $("input[id$='attachment_"+ currentCount +"']").val();        
        var countMax = parseInt(5);
                        
        if (currentCount < countMax && prevAttachment !== "") {
            
            var newCount = currentCount + 1;                       
            count.val(newCount);
            
            $("#attachment_1").clone().appendTo(attachmentsWrapper);  
            
            $("input[id$='attachment_1']:last")
               .attr('name', 'attachment_' + newCount)
               .attr('id','attachment_' + newCount)
               .val('');
        }    
        
    });
    
    
    $('#close-expired-grave-notification').on('click', function() {
        $('#expired-grave-notification').hide();
    });
    
    //visit expired grave
    $('#expired-grave-notf').on('click', function() {
        
        
        
        var thisCode = $(this).attr('data-code');
        var grave =  $('#' + thisCode);
        var graveElOffset = grave.offset();
        var svgPointerEl = $('#svg_pointer');
        var mapWrapper = $('.content-admin-map');
                
        var leftVal = graveElOffset.left - 450 + 'px';
        var topVal = graveElOffset.top - 220 + 'px';
       
    });
	
	//Select Box
	$('#type_rent_or_tit').on('change', function() {
		
		var thisValTrt = $(this);
		
		
		var monthly_or_yearly_selectbox = $('#monthly_or_yearly_selectbox');
		var expiration_data_nr = $("#field-exp-date");
		
		
		if (thisValTrt.val() == 'rental') {
		
			monthly_or_yearly_selectbox.show().attr('required', false);
			expiration_data_nr.show();
		
		} else {
			monthly_or_yearly_selectbox.hide();
			expiration_data_nr.hide();
		}
	
		
	});

});