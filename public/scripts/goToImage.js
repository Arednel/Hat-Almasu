function goToImage(requestID) {
    document.cookie = "requestID =" + requestID;

    window.open("goToImage.php").focus();
}