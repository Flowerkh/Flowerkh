//copy url
function CopyUrlToClipboard() {
    var dummy   = document.createElement("input");
    var text    = location.href;

    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
}
