$(document).ready(function() {

    /* Search Records */
    $('#form-search-record').submit(function(e) {
        
        var form = $(this);
        var searchTerm = $('#srch-term');
        
        if (searchTerm.val() == "") {
            searchTerm.addClass('invalid');
            return false;            
        } else {
            return true;
        }        
    });
    
    $('#srch-term').on('keyup', function() {
        $(this).removeClass('invalid');        
    });
    
    /*start search results*/
    $('.enter_access_code').on('click', function() {
        
        var dPersonId = $(this).data('id');
        var dPersonFullName = $(this).data('fullname');
        var dPersonAddress = $(this).data('address');
        var dPersonDateOfBirth = $(this).data('dateofbirth');
        var dPersonDateOfDeath = $(this).data('dateofdeath');
        var searchTerm = $(this).data('searchterm');
        var completDetaisModal = $('#complete_details_modal');
        
        completDetaisModal.modal('show');
        
        //set Data
        $('#inputDPersonId').val(dPersonId);
        $('#inputSearchTermRef').val(searchTerm);
        
        $('#access-code-label-name').empty().text(dPersonFullName);
        $('#access-code-label-address').empty().text(dPersonAddress);
        $('#access-code-label-dateofbirth').empty().text(dPersonDateOfBirth);
        $('#access-code-label-dateofdeath').empty().text(dPersonDateOfDeath);
        $('#inputSearchTermRef').empty();
    });
    
    $('#form-enter-access-code').submit(function(e) {
        
        e.preventDefault();
        
        var code = $('#inputFormNumber').val();
        var dPersonId = $('#inputDPersonId').val();
        var searchTerm = $('#inputSearchTermRef').val();
        
        $.ajax({
            url: "/?page=ajax-check-access-code&code=" + code + "&id=" + dPersonId,
            //data: data,
            method : "GET",
            dataType: "json",

            error: function(response) {

            },

            beforeSend: function() {
               // $('#map-loader').css('display', 'block');                    
            },

            complete: function(){                    

            },

            success: function(response) {
                
                if (response.hasOwnProperty('status') && response.status == 'success') {
                    window.location = "?page=map&id=" + dPersonId + "&srch-term=" + searchTerm;                    
                } else {
                    $('#access-code-error').css({display: 'block'});
                }                
            }     
        });
    });
    /*end search results*/

});