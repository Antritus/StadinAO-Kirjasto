function animateText(id, interval, ...texts) {
    const docElement = document.getElementById(id);
    docElement.innerHTML = texts[0];
    animateTextInternal(docElement, interval, 1, texts);
}

function animateTextInternal(element, interval, current, texts) {
    if (current >= texts.length) {
        current = 0;
    }
    element.innerHTML = texts[current];
    setTimeout(() => {
        animateTextInternal(element, interval, current + 1, texts);
    }, interval);
}