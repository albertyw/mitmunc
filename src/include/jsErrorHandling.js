function doError(msg,url,ln) {
    $.post(
        '/include/jsErrorHandling',
        {
            errMsg:msg,
            errLine:ln,
            queryString:location.search,
            url:location.pathname,
            HttpRef:document.referrer
        }
    );
}
