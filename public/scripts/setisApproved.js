function setisApproved(requestID, isApproved) {
    window.location.href = "changeRequestStatus.php?isApproved=" + isApproved + "&requestID=" + requestID;
}