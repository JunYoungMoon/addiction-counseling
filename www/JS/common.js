var doubleSubmitFlag = false;

doubleSubmitCheck = function() {
    if (doubleSubmitFlag) {
        return doubleSubmitFlag
    } else {
        doubleSubmitFlag = true;
        return false
    }
}

grecaptcha.ready(function() {
    grecaptcha.execute('6LfBiWwaAAAAAP5S0Dz3VYaVPd_nDv-nLnG4XLvw', {
        action: 'homepage'
    }).then(function(token) {
        document.getElementById('g-recaptcha').value = token
    })
});