document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.getElementById("mainImage");
    const previewImages = document.querySelector('.carousel_images');
    const firstImg = document.querySelector('.carousel_images li:first-child img');
    firstImg.parentNode.style.cssText = `
    border: 1px solid lightgray;
    opacity: 1;`;
    const imgAll = document.querySelectorAll('.clicable_images');
    previewImages.addEventListener('click', (e) => {
        imageClickFunc(e.target)
    })
    function imageClickFunc(img) {
        if(img.getAttribute("src") === null){
            mainImage.src = mainImage.src;
        } else {
            mainImage.src = img.getAttribute("src")
        }
        imgAll.forEach(
            item => {
                console.log(item)
                if (mainImage.src === item.src) {
                    item.parentNode.style.cssText = `
                    border: 1px solid lightgray;
                    opacity: 1;`
                } else {
                    item.parentNode.style.cssText = `
                    border: none;
                    opacity: 0.6;`
                }
            }
        );
    }
})