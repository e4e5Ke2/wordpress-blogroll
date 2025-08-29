const data = window.blogroll_js_vars;
const showMoreLabel = data.show_more;
const showLessLabel = data.show_less;

var content = document.querySelector('.mod_blogroll_showall_container');
var images = document.querySelectorAll('.mod_blogroll_img');
var firstClick = true;

const showAll = (event) => {
    if (firstClick) {
        images.forEach((img) => {
            if (!img.hasAttribute('src')) img.src = img.dataset.src
        });
        firstClick = false;
    }

    if (content.style.display === "block") {
        content.style.display = "none";
        event.target.innerHTML = showMoreLabel;
    } else {
        content.style.display = "block";
        event.target.innerHTML = showLessLabel;
    }
};

document.querySelector('.mod_blogroll_showall_button').addEventListener('click', showAll);