jQuery(function(){


    /**
     * Sliders on search page
     */
    jQuery("#score_range").editRangeSlider({step: 0.5, defaultValues:{min: 0, max: 10}, bounds:{min: 0, max: 10}, 
                                        formatter:function(val){
                                            var decimal = val - Math.round(val);
                                            return decimal == 0 ? val.toString() + ".0" : val.toString();
                                        }
    });
    jQuery("#strength_range").editRangeSlider({step: 1, defaultValues:{min: 1, max: 100}, bounds:{min: 1, max: 100}});
    jQuery("#age_range").editRangeSlider({step: 1, defaultValues:{min: 1, max: 70}, bounds:{min: 1, max: 70}});



    /**
     * Ajax triggering when input elements are chenged
     */
    jQuery('#search_whisky_form').change(function(e) {
        triggerResult(e)
    }); // End

    /**
     * Ajax triggering when sliders are changed
     */
    jQuery('.ui-rangeSlider-bar, .ui-rangeSlider-handle').mouseup(function(e) {
        triggerResult(e);
    }); // End

    /**
     * Function that triggers ajax
     */
    function triggerResult(e)
    {
        e.preventDefault();
        jQuery.ajax({
            type:"GET",
            async:false,
            url:"search.php",
            data: jQuery("#search_whisky_form").serialize(),
            success: function(response){
                console.log(jQuery("#searchResultContent").html(response));
            }
        });
    }











});