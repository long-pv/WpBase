jQuery(function($) {
    let smartCookiePopup = $('.sticky-banner');
    let closeButton      = $('.close');
    let acceptAllButton  = $('#acceptAllButton');
    let rejectAllButton  = $('#rejectAllButton');
    let overlay          = $('.overlay');
    let timeNow          = new Date().getTime();
    let cookieValue      = $.cookie('smartCookieCL'); 
    let expirationTime   = new Date();

    // Check smart cookie does not exist
    if (!cookieValue) {
        modalContentShow();
    }

    function modalContentHide() {
        overlay.hide();
        smartCookiePopup.hide();
    }

    function modalContentShow() {
        overlay.show();
        smartCookiePopup.show();
    }

    function modalClickButton() {
        modalContentHide();
        setTimeout(modalContentShow, 60 * 1000); // 1 minute
    }

    // When click button close
    closeButton.on('click', modalClickButton);

    // When click button reject all
    rejectAllButton.on('click', modalClickButton);

    // When click button accept all
    acceptAllButton.on('click', function() {
        modalContentHide();

        // Add cookie
        expirationTime.setTime(expirationTime.getTime() + (60 * 24 * 60 * 60 * 1000)); // 60 days
        $.cookie('smartCookieCL', timeNow, { expires: expirationTime, path: '/' }); 
    });
});