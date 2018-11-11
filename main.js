sec = 0;

window.onload = function() {
    var c = 0
    if (typeof fallen !== 'undefined')
        ver()
    if (typeof move !== 'undefined')
        setTimeout('gor()', sec * 200 + 200)
}
function ver() {
    for (var i = 1; i <= height; i++) {
        if (fallen[i] instanceof Object == true) {
            var count = Object.keys(fallen[i]).length;
            cnt = count;
            var elems = document.getElementsByClassName('cell' + i);
            var s = 0;
            for (var j = 0; j < count; j++) {
                var keys = Object.keys(fallen[i]);
                elems[j].style.webkitTransition = 'all ' + 0.2 * (fallen[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.MozTransition = 'all ' + 0.2 * (fallen[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.OTransition = 'all ' + 0.2 * (fallen[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.msTransition = 'all ' + 0.2 * (fallen[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.Transition = 'all ' + 0.2 * (fallen[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.webkitTransform = 'translate(0,' + 36 * (fallen[i][keys[j]] - keys[j]) + 'px)';
                elems[j].style.MozTransform = 'translate(0,' + 36 * (fallen[i][keys[j]] - keys[j]) + 'px)';
                elems[j].style.OTransform = 'translate(0,' + 36 * (fallen[i][keys[j]] - keys[j]) + 'px)';
                elems[j].style.msTransform = 'translate(0,' + 36 * (fallen[i][keys[j]] - keys[j]) + 'px)';
                elems[j].style.transform = 'translate(0,' + 36 * (fallen[i][keys[j]] - keys[j]) + 'px)';
                elems[j].href = '?i=' + (fallen[i][keys[j]]) + '&j=' + i + '';
                if (sec < fallen[i][keys[j]] - keys[j])
                    sec = fallen[i][keys[j]] - keys[j];
            }
        }
    }

}
function gor() {
    for (var i = 1; i <= height; i++) {
        if (move[i] instanceof Object == true) {
            var count = Object.keys(move[i]).length;
            var elems = document.getElementsByClassName('cell' + i);
            for (var j = 0; j < count; j++) {
                var keys = Object.keys(move[i]);
                elems[j].style.webkitTransition = 'all ' + 0.2 * (move[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.MozTransition = 'all ' + 0.2 * (move[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.OTransition = 'all ' + 0.2 * (move[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.msTransition = 'all ' + 0.2 * (move[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.Transition = 'all ' + 0.2 * (move[i][keys[j]] - keys[j]) + 's linear';
                elems[j].style.webkitTransform = 'translate(' + 36 * (move[i][keys[j]] - keys[j]) + 'px,' + gettransform(elems[j]) + 'px)';
                elems[j].style.MozTransform = 'translate(' + 36 * (move[i][keys[j]] - keys[j]) + 'px,' + gettransform(elems[j]) + 'px)';
                elems[j].style.OTransform = 'translate(' + 36 * (move[i][keys[j]] - keys[j]) + 'px,' + gettransform(elems[j]) + 'px)';
                elems[j].style.msTransform = 'translate(' + 36 * (move[i][keys[j]] - keys[j]) + 'px,' + gettransform(elems[j]) + 'px)';
                elems[j].style.transform = 'translate(' + 36 * (move[i][keys[j]] - keys[j]) + 'px,' + gettransform(elems[j]) + 'px)';
                elems[j].href = '?i=' + keys[j] + '&j=' + (i + move[i][keys[j]] - keys[j]) + '';
            }
        }
    }
}
function gettransform(elem) {
    var st = window.getComputedStyle(elem, null);
    var tr = st.getPropertyValue("-webkit-transform") ||
            st.getPropertyValue("-moz-transform") ||
            st.getPropertyValue("-ms-transform") ||
            st.getPropertyValue("-o-transform") ||
            st.getPropertyValue("transform");
    if (tr !== "none") {
        var values = tr.split('(')[1];
        values = values.split(')')[0];
        values = values.split(',');
        var px = values[5];
    }
    else {
        var px = 0
    }
    return px
}