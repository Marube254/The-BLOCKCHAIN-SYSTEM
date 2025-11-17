document.getElementById('scanBtn').addEventListener('click', function() {
    FingerprintSDK.capture().then(template => {
        document.getElementById('fingerprint_data').value = template;
        document.querySelector('form').submit();
    });
});
