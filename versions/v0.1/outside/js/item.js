(function (){
    // var TS = 450;

    $(document).ready(function () {
        $("#measurement_brand, #measurement_own").click(function(){
            var buttonContainerId = $(this).val();
            var buttonContainer = $("#"+buttonContainerId)[0];
            var isDisplayed = $(buttonContainer).css("display") == "block";
            if (!isDisplayed) {
                var buttonWrapper = buttonContainer.parentNode;
                var buttonContainers = buttonWrapper.getElementsByClassName("customize_choice-button-container");
                var nbContainer = buttonContainers.length;
                for(var i = 0; i < nbContainer; i++){
                    if($(buttonContainers[i]).css("display") == "block"){
                        $(buttonContainers[i]).fadeOut(TS, function(){
                            $(buttonContainer).fadeIn(TS);
                        });
                    }
                }
            }
        })
    });
}).call(this);