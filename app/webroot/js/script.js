function facebook_share(encoded_url) {
    if (encoded_url === undefined) {
        encoded_url = encodeURIComponent(document.URL);
    }
    window.open(
        'https://www.facebook.com/sharer/sharer.php?u='+encoded_url, 
        'facebook-share-dialog', 
        'width=626,height=436'
    ); 
    return false;
}

function googleplus_share(encoded_url) {
    if (encoded_url === undefined) {
        encoded_url = encodeURIComponent(document.URL);
    }
    window.open(
        'https://plus.google.com/share?url='+encoded_url,
        '',
        'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600'
    );
    return false;
}

function twitter_share(encoded_url) {
    if (encoded_url === undefined) {
        encoded_url = encodeURIComponent(document.URL);
    }
    window.open(
        'https://twitter.com/intent/tweet?url='+encoded_url, 
        'facebook-share-dialog', 
        'width=550,height=450'
    );
    return false;
}