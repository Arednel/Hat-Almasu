function pagePrevious(page, urlWithoutQuery, statusType) {
    newPage = page - 1;

    window.location.href = urlWithoutQuery + "?status=" + statusType + "&page=" + newPage;
}
function pageNext(page, urlWithoutQuery, statusType) {
    newPage = page + 1;

    window.location.href = urlWithoutQuery + "?status=" + statusType + "&page=" + newPage;
}
